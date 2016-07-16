<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Admin;
use yii\data\Pagination;
use yii\db\Connection;

class BackstageController extends Controller{

    public $layout='common';
    public $enableCsrfValidation = false;

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
    public function actionCharacter(){
        return $this->redirect(array('character/index'));
    }
    /*
     * 显示数据查询页面
     */
    public function actionData_select(){

        if(!$_POST){
            //获取用户数据
            $data = Admin::find()->asArray()->all();
            //设置总数目和每页显示数量
            $count = count($data);
            $per = 6;
            $page_num = ceil($count/$per);
            //获取当前页
            $request = \Yii::$app->request;
            $now_page = $request->get('page');
            if(empty($now_page)){
                $now_page=1;
            }
            $start = ($now_page-1)*$per;
            //获取表前缀
            $tablePrefix = \Yii::$app->db->tablePrefix;
            //获取分页后数据
            $sql = "select * from ".$tablePrefix."admin limit $start,$per";
            $list = Admin::findBySql($sql)->all();
            return $this->render('data_select',['list'=>$list,'count'=>$page_num]);
        }
        //获取用户数据
        $data = Admin::find()->asArray()->all();
        //设置总数目和每页显示数量
        $count = count($data);
        $per = 6;
        //获取当前页
        $request = \Yii::$app->request;
        $now_page = $request->post('page');
        if(empty($now_page)){
            $now_page=1;
        }
        $start = ($now_page-1)*$per;
        //获取表前缀
        $tablePrefix = \Yii::$app->db->tablePrefix;
        //判断是否存在搜索
        $search_name = $request->post('search_name');
        if(empty($search_name)){
            //获取分页后数据
            $sql = "select * from ".$tablePrefix."admin limit $start,$per";
        }else{
            //获取分页后数据
            $sql = "select * from ".$tablePrefix."admin where username like '%$search_name%' limit $start,$per";
        }
        $list = Admin::findBySql($sql)->asArray()->all();
        //返回json
        echo json_encode($list);
    }
    /*
     * 搜索用户名
     */
    public function actionUser_search(){
        //接收搜索的值
        $request = \Yii::$app->request;
        $search_name = $request->post('search_name');
        //获取用户数据
        $data = Admin::find()->where(['like','username',$search_name])->asArray()->all();
        //设置总数目和每页显示数量
        $count = count($data);
        $per = 6;
        $page_num = ceil($count/$per);
        //获取当前页
        $request = \Yii::$app->request;
        $now_page = $request->post('page');
        if(empty($now_page)){
            $now_page=1;
        }
        $start = ($now_page-1)*$per;
        //获取表前缀
        $tablePrefix = \Yii::$app->db->tablePrefix;
        //获取分页后数据
        $sql = "select * from ".$tablePrefix."admin where username like '%$search_name%' limit $start,$per";
        $list = Admin::findBySql($sql)->all();
        return $this->render('data_select',['list'=>$list,'count'=>$page_num,'search_name'=>$search_name]);
    }
    /*
     * 添加公众号
     */
    public function actionAdd_accounts()
    {
        return $this->render('add_accounts');
    }
    function actionList2()
    {
        return $this->render('list2.html');
    }
}