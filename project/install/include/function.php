<?php
//测试链接数据库
function check_mysql()
{
	$is_connect = false;
	$db_host = url_get('db_address');
	$db_user = url_get('db_user');
	$db_pwd  = url_get('db_pwd');

	if($db_host != '' && class_exists('mysqli'))
	{
		$hostArray  = explode(":",$db_host);
		$hostPort   = isset($hostArray[1]) ? $hostArray[1] : ini_get("mysqli.default_port");
		$mysql_link = new mysqli($hostArray[0],$db_user,$db_pwd,NULL,$hostPort);
	}

	if($mysql_link->connect_errno)
	{
		die('fail');
	}
	else
	{
		die('success');
	}
}

//解析备份文件中的SQL
function parseSQL($db_pre,$fileName,$mysql_link)
{

	//执行sql query次数的计数器 默认值
	$queryTimes = 0;

	//与前端交互的频率(数值与频率成反比,0表示关闭交互)
	$waitTimes  = 5;

	$percent   = 0;
	$fhandle   = fopen($fileName,'r');
	$firstLine = fgets($fhandle);
	rewind($fhandle);

	//跨过BOM头信息
	$charset[1] = substr($firstLine,0,1);
	$charset[2] = substr($firstLine,1,1);
	$charset[3] = substr($firstLine,2,1);
	if(ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191)
	{
		fseek($fhandle,3);
	}

	//计算安装进度
	$totalSize  = filesize($fileName);
	while(!feof($fhandle))
	{
		$lstr = fgets($fhandle);     //获取指针所在的一行数据

		//判断当前行存在字符
		if(isset($lstr[0]) && $lstr[0]!='#')
		{
			$prefix = substr($lstr,0,2);  //截取前2字符判断SQL类型
			switch($prefix)
			{
				case '--' :
				case '//' :
				{
					continue;
				}

				case '/*':
				{
					if(substr($lstr,-5) == "*/;\r\n" || substr($lstr,-4) == "*/\r\n")
						continue;
					else
					{
						skipComment($fhandle);
						continue;
					}
				}

				default :
				{
					$sqlArray[] = trim($lstr);
					if(substr(trim($lstr),-1) == ";")
					{
						$rcount   = 1;
						$sqlStr   = str_ireplace("we_",$db_pre,join($sqlArray),$rcount); //更换表前缀
						$sqlArray = array();
						$result   = $mysql_link->query($sqlStr);

						$queryTimes++;
						if($waitTimes > 0 && ($queryTimes/$waitTimes == 1))
						{
							$queryTimes = 0;

							//计算安装进度百分比
							$percent    = ftell($fhandle)/($totalSize+1);
							sqlCallBack($sqlStr,$result,$percent);
							set_time_limit(1000);
						}
					}
				}
			}
		}
	}
}

//略过注释
function skipComment($fhandle)
{
	$lstr = fgets($fhandle,4096);
	if(substr($lstr,-5) == "*/;\r\n" || substr($lstr,-4) == "*/\r\n")
		return true;
	else
		skipComment($fhandle);
}

//sql回调函数
function sqlCallBack($sql,$result,$percent)
{
	//创建表
	if(preg_match('/create\s+table\s+(\S+)/i',$sql,$match))
	{
		$tableName = isset($match[1]) ? $match[1] : '';
		$message   = '创建表'.$tableName;
	}
	//插入数据
	else if(preg_match('/insert\s+into/i',$sql))
	{
		$message   = '插入数据';
	}
	//其余操作
	else
	{
		$message   = '执行SQL';
	}

	//判断sql执行结果
	if($result)
	{
		$isError  = false;
		$message .= '...';
	}
	else
	{
		$isError  = true;
		$message .= ' 失败! '.$sql.'<br />'.$mysql_link->error;
	}

	$return_info = array(
		'isError' => $isError,
		'message' => $message,
		'percent' => $percent
	);

	showProgress($return_info);
	usleep(5000);
}

//安装mysql数据库
function install_sql()
{
	global $db_pre;

	//安装配置信息
	$db_address   = url_get('db_address');
	$db_user      = url_get('db_user');
	$db_pwd       = url_get('db_pwd');
	$db_name      = url_get('db_name');
	$db_pre       = url_get('db_pre');
	$admin_user   = url_get('admin_user');
	$admin_pwd    = url_get('admin_pwd');
	$install_type = url_get('install_type');

	//链接mysql数据库
	$hostArray  = explode(":",$db_address);
	$hostPort   = isset($hostArray[1]) ? $hostArray[1] : ini_get("mysqli.default_port");
	$mysql_link = new mysqli($hostArray[0],$db_user,$db_pwd,NULL,$hostPort);

	if($mysql_link->connect_errno)
	{
		showProgress(array('isError' => true,'message' => 'mysql链接失败'.$mysql_link->connect_errno));
	}

	//检测SQL安装文件
	$sql_file = ROOT_PATH.'./install/project.sql';
	if(!file_exists($sql_file))
	{
		showProgress(array('isError' => true,'message' => '安装的SQL文件'.basename($sql_file).'不存在'));
	}

	//执行SQL,创建数据库操作
  	$DBCharset = 'utf8';
  	$mysql_link->set_charset($DBCharset);
  	$mysql_link->query("SET SESSION sql_mode = '' ");

	if($mysql_link->select_db($db_name) == false)
	{
		$DATABASESQL = '';
		if(version_compare($mysql_link->server_version, '4.1.0', '>='))
		{
	    	$DATABASESQL = "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
		}

		if(!$mysql_link->query('CREATE DATABASE `'.$db_name.'` '.$DATABASESQL))
		{
			showProgress(array('isError' => true,'message' => '用户权限受限，创建'.$db_name.'数据库失败，请手动创建数据表'));
		}
		$mysql_link->select_db($db_name);
	}

	//安装SQL
	$mysql_link->query("SET FOREIGN_KEY_CHECKS = 0;");
	parseSQL($db_pre,$sql_file,$mysql_link);
	$mysql_link->query("SET FOREIGN_KEY_CHECKS = 1;");

	//插入管理员数据
	$adminSql = 'insert into `'.$db_pre.'admin` (`email`,`pwd`,`addtime`) values ("'.$admin_user.'","'.md5($admin_pwd).'","'.date('Y-m-d H:i:s').'")';
	if(!$mysql_link->query($adminSql))
	{
		showProgress(array('isError' => true,'message' => '创建管理员失败'.$mysql_link->error,'percent' => 0.9));
	}

	//写入配置文件
	$configFile    = ROOT_PATH.'./config/db.php';
    $updateData    ="<?php
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=$db_address;dbname=$db_name',
        'username' => '$db_user',
        'password' => '$db_pwd',
        'charset' => 'utf8',
        'tablePrefix' => '$db_pre',
    ];";

	$is_success = file_put_contents($configFile,$updateData);
	if(!$is_success)
	{
		showProgress(array('isError' => true,'message' => '更新配置文件失败','percent' => 0.9));
	}

	//执行完毕
	showProgress(array('isError' => false,'message' => '安装完成','percent' => 1));
}

//输出json数据
function showProgress($return_info)
{
	echo '<script type="text/javascript">parent.update_progress('.JSON::encode($return_info).');</script>';
	flush();
	if($return_info['isError'] == true)
	{
		exit;
	}
}

//根据默认模板生成config文件
function create_config($config_file,$config_def_file,$updateData)
{
	$defaultData = file_get_contents($config_def_file);
	$configData  = str_replace(array_keys($updateData),array_values($updateData),$defaultData);
	return file_put_contents($config_file,$configData);
}

//查询解决方案
function configInfo($item)
{
	$data = array(
		'mysql'=> 'http://www.baidu.com/#wd=php%20mysql%E6%89%A9%E5%B1%95&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=4031&f=8&bs=php%20mysql%E7%BB%84%E4%BB%B6&rsv_sug3=16&rsv_sug4=653&rsv_sug1=22&rsv_sug2=0&rsv_sug=2',
		'gd'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20gd&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=1513&f=8&bs=php%20gd&rsv_sug3=23&rsv_sug4=914&rsv_sug1=34&rsv_sug2=0',
		'xml'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20xml&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=1262&f=8&bs=php%20%E5%BC%80%E5%90%AF%20gd&rsv_sug3=27&rsv_sug4=1014&rsv_sug1=36&rsv_sug2=0&rsv_sug=1',
		'session'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20session&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=7586&f=8&bs=php%20%E5%BC%80%E5%90%AF%20xml&rsv_sug3=34&rsv_sug4=1245&rsv_sug1=47&rsv_sug2=0',
		'iconv'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20iconv&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=878&f=8&bs=php%20%E5%BC%80%E5%90%AF%20session&rsv_sug3=36&rsv_sug4=1315&rsv_sug1=49&rsv_n=2&rsv_sug=1',
		'zip'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20zip&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=1823&f=8&bs=php%20%E5%BC%80%E5%90%AF%20iconv&rsv_sug3=43&rsv_sug4=1506&rsv_sug1=54&rsv_sug=2&rsv_sug2=0',
		'curl'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20curl&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=886&f=8&bs=php%20%E5%BC%80%E5%90%AF%20zip&rsv_sug3=45&rsv_sug4=1587&rsv_sug1=58&rsv_n=2',
		'OpenSSL'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20OpenSSL&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=909&f=8&bs=php%20%E5%BC%80%E5%90%AF%20curl&rsv_sug3=47&rsv_sug4=1667&rsv_sug1=61&rsv_n=2',
		'sockets'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20sockets&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=862&f=8&bs=php%20%E5%BC%80%E5%90%AF%20OpenSSL&rsv_sug3=50&rsv_sug4=1767&rsv_sug1=63&rsv_n=2&rsv_sug=1',
		'safe_mode'=> 'http://www.baidu.com/#wd=php%20safe_mode%20%E5%85%B3%E9%97%AD&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=885&f=8&bs=php%20safe_mode%20%E5%85%B3%E9%97%AD&rsv_sug=1&rsv_sug3=7&rsv_sug4=237&rsv_sug1=11&rsv_n=2',
		'allow_url_fopen'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20allow_url_fopen&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=1088&f=8&bs=php%20%E5%BC%80%E5%90%AF%20sockets&rsv_sug3=52&rsv_sug4=1844&rsv_sug1=65&rsv_n=2&rsv_sug=1',
		'memory_limit'=> 'http://www.baidu.com/#wd=php%20%E5%BC%80%E5%90%AF%20memory_limit&rsv_spt=1&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=2508&f=8&bs=php%20%E5%BC%80%E5%90%AF%20allow_url_fopen&rsv_sug3=54&rsv_sug4=1921&rsv_sug1=69&rsv_n=2&rsv_sug=1',
		'asp_tags'=> 'http://www.baidu.com/#wd=asp_tags%20%E5%85%B3%E9%97%AD&rsv_spt=3&rsv_bp=1&ie=utf-8&tn=baiduhome_pg&inputT=1244&f=8&bs=php%20asp_tags%20%E5%85%B3%E9%97%AD&rsv_sug3=69&rsv_sug4=2382&rsv_sug1=75&rsv_sug=1&rsv_sug2=0',
	);

	if(isset($data[$item]))
	{
		return "<a href='".$data[$item]."' target='_blank'>立即解决</a>";
	}
}

/**
 * @brief 拦截器安装测试数据
 */
class installTestData
{
	//在创建控制时候进行拦截
	public static function onCreateController()
	{
		if(collect_facade::createInstance() == null)
		{
			showProgress(array('isError' => true,'message' => '目前只有高级企业版本才支持商品数据采集','percent' => 0.9));
			exit;
		}

		$catData = array(
			0 => array(
				array('id' => '1','name' => '家用电器','parent_id' => '0',),
					array('id' => '2','name' => '大家电','parent_id' => '1',),
						array('id' => '3','name' => '平板电视','parent_id' => '2',),
					array('id' => '13','name' => '生活电器','parent_id' => '1',),
						array('id' => '15','name' => '电风扇','parent_id' => '13',),
						array('id' => '16','name' => '冷风扇','parent_id' => '13',),
						array('id' => '17','name' => '扫地机器人','parent_id' => '13',),
					array('id' => '14','name' => '厨房电器','parent_id' => '1',),
						array('id' => '18','name' => '电饭煲','parent_id' => '14',),
						array('id' => '19','name' => '微波炉','parent_id' => '14',),
			),

			1 => array(
				array('id' => '4','name' => '食品饮料','parent_id' => '0',),
				array('id' => '5','name' => '进口食品','parent_id' => '4',),
				array('id' => '6','name' => '牛奶','parent_id' => '5',),
			),

			2 => array(
				array('id' => '7','name' => '家具','parent_id' => '0',),
				array('id' => '8','name' => '家装建材','parent_id' => '7',),
				array('id' => '9','name' => '灯饰照明','parent_id' => '8',),
			),

			3 => array(
				array('id' => '10','name' => '服装','parent_id' => '0',),
				array('id' => '11','name' => '男装','parent_id' => '10',),
				array('id' => '12','name' => '衬衫','parent_id' => '11',),
			),
		);

		$goodsUrl = array(
			0 => 'http://list.jd.com/list.html?cat=737,794,798',
			1 => 'http://list.jd.com/list.html?cat=1320,5019,12215',
			2 => 'http://list.jd.com/list.html?cat=9855,9856,9898',
			3 => 'http://list.jd.com/list.html?cat=1315,1342,1348',
		);

		//插入数据
		$catDB = new IModel('category');
		$totalNum = count($catData)+1;
		foreach($catData as $key => $val)
		{
			$percent = ($key+1/$totalNum);
			showProgress(array('isError' => false,'message' => '正在采集数据请稍候...','percent' => $percent));

			$catNew = array();
			foreach($val as $v)
			{
				$catNew[] = $v['id'];
				$catDB->setData($v);
				$catDB->add();
			}
			collect_facade::$category = $catNew;
			collect_facade::many($goodsUrl[$key]);
		}

		//执行完毕
		showProgress(array('isError' => false,'message' => '安装完成','percent' => 1));
		exit;
	}
}