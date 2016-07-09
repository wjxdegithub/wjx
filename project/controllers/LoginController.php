<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\User;
use app\models\Limit_ip;

class LoginController extends Controller{

    public $layout='common';
    public $enableCsrfValidation = false;

    /*
     * 登录页面
     */
    public function actionIndex(){
    	echo 3;
        return $this->render('login.html');
    }

    /*
     * 检测登录
     */
    function actionCheck(){
        //获取登录数据
        $request = \Yii::$app->request;
        $login_info = $request->post();
        $ip = \Yii::$app->request->userIP;
        //判断ip是否在限制范围内
        if(Limit_ip::find()->where(['ip'=>$ip])->one()){
            //验证账号密码
            if(User::find()->where(['email'=>$login_info['email'],'pwd'=>$login_info['password']])->one()){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 2;
        }
    }
}
