<?php

namespace app\controllers;

use yii\web\Controller;

class BackstageController extends Controller{

    public $layout='common';

    /*
     * 后台首页
     */
    public function actionIndex(){
        return $this->render('index.html');
    }
    /*
     * 首页2
     */
    public function actionIndex2(){
        return $this->render('index2.html');
    }
}