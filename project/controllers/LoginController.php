<?php

namespace app\controllers;

use yii\web\Controller;

class LoginController extends Controller{

    public $layout='common';

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
        return $this->redirect(array('/backstage/index'));
    }
}