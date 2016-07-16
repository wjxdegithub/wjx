<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Admin;
use app\models\Limit_ip;

class LoginController extends Controller{

    public $layout='common';
    public $enableCsrfValidation = false;

    /*
     * 登录页面
     */
    public function actionIndex(){
        return $this->render('login.html');
    }

    /*
     * 检测登录
     */
    function actionCheck(){
        //获取登录数据
        $request = \Yii::$app->request;
        $login_info = $request->post();
       
        //验证账号密码
        if(Admin::find()->where(['username'=>$login_info['username'],'pwd'=>md5($login_info['password'])])->one()){
            //将当前登录用户信息存入session中
            $session = \Yii::$app->session;
            $session->set('user_info', $login_info);
            echo 1;
        }else{
            echo 0;
        }
    }
}
