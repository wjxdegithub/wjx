<?php

namespace app\controllers;
use app\models\Admin;
use yii\data\Pagination ;
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
    /*
     * 用户列表
     */
    public  function  actionAdmin_list()
    {
        $sou=\yii::$app->request->get("sou");
        if($sou)
        {

            $sql="select * from we_admin where username like '%$sou%'";
            $data=Admin::findBySql($sql);
        }
        else
        {
            $data = Admin::find();
        }
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '3']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('admin_list',[
            'arr' => $model,
            'pages' => $pages,
        ]);

    }
}