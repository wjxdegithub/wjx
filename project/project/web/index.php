<?php

//判断是否安装
if(file_exists('./install/install.lock')){
    // comment out the following two lines when deployed to production
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');

    require(__DIR__ . '/../vendor/autoload.php');
    require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

    $config = require(__DIR__ . '/../config/web.php');

    (new yii\web\Application($config))->run();
}else{
    header("location:./install/index.php");
}

