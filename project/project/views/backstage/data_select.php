<?php
use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../style/backstage/bootstrap2.3.2/css/bootstrap.min.css" rel="stylesheet" />
    <title></title>
    <link href="../style/backstage/styles/Common.css" rel="stylesheet" />
    <link href="../style/backstage/styles/Index2.css" rel="stylesheet" />
</head>
<style type="text/css" media="screen">


    .navigation {

        margin:auto auto 10px 10px;

        float:left;

    }

    .wp-paginate {

        padding:0;

        margin:0;

    }

    .wp-paginate li {

        float:left;

        list-style:none;

        margin:2px;

        padding:0;

    }

    .wp-paginate a {

        margin:0 2px;

        line-height:20px;

        text-align:center;

        text-decoration:none;

        border-radius:3px;

        -moz-border-radius:3px;

        float:left;

        min-height:20px;

        min-width:20px;

        color:#858585;

        border:2px #e3e3e3 solid;

        border-radius:13px;

        font-size:11px;

    }

    .wp-paginate a:hover {

        border:2px #858585 solid;

        color:#858585;

    }

    .wp-paginate .title {

        color:#555;

        margin:0;

        margin-right:4px;

        font-size:14px;

    }

    .wp-paginate .gap {

        color:#999;

        margin:0;

        margin-right:4px;

    }

    .wp-paginate .current {

        margin:0 2px;

        line-height:20px;

        text-align:center;

        text-decoration:none;

        border-radius:3px;

        -moz-border-radius:3px;

        float:left;

        font-weight:700;

        min-height:20px;

        min-width:20px;

        color:#262626;

        border:2px #119eda solid;

        border-radius:13px;

        font-size:11px;

        color:#119eda;

    }

    .wp-paginate .page {

        margin:0;

        padding:0;

    }

    .wp-paginate .prev {

    }

    .wp-paginate .next {

    }


</style>
<body>
<div class="container-fluid">
    <div class="row-fluid">
        <h4>用户列表</h4>
        <form action="index.php?r=backstage/user_search" method="post">
            <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken;?>"/>
            <div class="add"><input type="text" name="search_name" value="<?php if(!empty($search_name)){echo $search_name;}?>"/><input type="submit" value="搜索" style="width: 80px;height: 35px;border-radius: 10px;position: absolute;left:250px;top:38px;"/></div>
        </form>
        <div class="w">
            <div class="span12">
                <table class="table table-condensed table-bordered table-hover tab">
                    <thead>
                    <tr class="th">
                        <th>序号</th>
                        <th>用户名</th>
                        <th>注册时间</th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    <?php foreach($list as $k=>$v){?>
                        <tr>
                            <td><?php echo $v['id'];?></td>
                            <td><?php echo $v['username'];?></td>
                            <td><?php echo $v['addtime'];?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <div id="page" class="tr">
                    <div class="navigation" style="float: right;">
                        <ol class="wp-paginate">
                            <li><span class="title">Pages:</span></li>
                            <li><a href="javascript:void(0);" class="last">&lt;</a></li>
                            <li><span id="current" class="page current">1</span></li>
                            <?php for($i=2;$i<=$count;$i++){?>
                                <li><a href="javascript:void(0);" title="2" class="page"><?php echo $i;?></a></li>
                            <?php }?>
                            <li><span class="gap">...</span></li>
                            <li><a href="javascript:void(0);" class="next">&gt;</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        <div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">添加成绩</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="userName">姓名</label>
                        <div class="controls">
                            <input type="text" id="userName" placeholder="姓名">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="Chinese">语文</label>
                        <div class="controls">
                            <input type="text" id="Chinese" placeholder="语文">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="Math">数学</label>
                        <div class="controls">
                            <input type="text" id="Math" placeholder="数学">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="English">英语</label>
                        <div class="controls">
                            <input type="text" id="English" placeholder="英语">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                <button class="btn btn-primary" id="add" onclick="add();">保存</button>
                <button class="btn btn-primary" id="edt" onclick="edt();">保存</button>
            </div>
        </div>
    </div>
</div>

<script src="../style/backstage/scripts/jquery-1.9.1.min.js"></script>
<script src="../style/backstage/bootstrap2.3.2/js/bootstrap.min.js"></script>
<script src="../style/backstage/layer-v2.3/layer/layer.js"></script>
<script src="../style/backstage/laypage-v1.3/laypage/laypage.js"></script>
<script src="../style/backstage/scripts/Index2.js"></script>
</body>
</html>
<script>
    $(function(){
        $(".wp-paginate").children().click(function(){
            //获取当前页数
            var page = $(this).children('a').html();
            var obj = $("#current");
            if(typeof(page) != 'undefined'){
                if(page == '&gt;'){
                    //修改样式
                    page = obj.html()
                    if(page < $(".wp-paginate").children().length*1-4){
                        page = obj.html()*1+1;
                        obj.parent().next().html("<span id='current' class='page current'>"+page+"</span>");
                        var page2 = $("#current").html();
                        obj.parent().html("<a href='javascript:void(0);' title='2' class='page'>"+page2+"</a>");
                    }
                }else if(page == '&lt;'){
                    //修改样式
                    page = obj.html();
                    if(page > 1){
                        page = obj.html()*1-1;
                        obj.parent().prev().html("<span id='current' class='page current'>"+page+"</span>");
                        var page2 = $("#current").html()*1+1;
                        obj.parent().html("<a href='javascript:void(0);' title='2' class='page'>"+page2+"</a>");
                    }
                }else{
                    //修改样式
                    obj.parent().html("<a href='javascript:void(0);' title='2' class='page'>"+obj.html()+"</a>");
                    $(this).html("<span id='current' class='page current'>"+page+"</span>");
                }
                //判断是否存在搜索
                var search_name = $(":input[name='search_name']").val();
                if(search_name != ''){
                    //获取分页后数据
                    $.post('index.php?r=backstage/data_select',{page:page,search_name:search_name},function(msg){
                        var str='';
                        $.each(msg,function(index,item){
                            str+='<tr>';
                            str+="<td>"+item.id+"</td>"
                            str+="<td>"+item.username+"</td>"
                            str+="<td>"+item.addtime+"</td>"
                            str+='</tr>';
                        })
                        $('#tbody').html(str);

                    },'json')
                }else{
                    //获取分页后数据
                    $.post('index.php?r=backstage/data_select',{page:page},function(msg){
                        var str='';
                        $.each(msg,function(index,item){
                            str+='<tr>';
                            str+="<td>"+item.id+"</td>"
                            str+="<td>"+item.username+"</td>"
                            str+="<td>"+item.addtime+"</td>"
                            str+='</tr>';
                        })
                        $('#tbody').html(str);
                    },'json')
                }
            }
        })
    })
</script>
