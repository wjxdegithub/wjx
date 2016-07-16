<?php

namespace app\controllers;

use yii\data\Pagination;
use yii\db\Connection;
use app\models\Photo;
use yii\web\Controller;
use yii\web\UploadedFile;
class PhotoController extends Controller
{
    public $layout = 'common';
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index.html');
    }
    public function actionIndex2()
    {
        $arr=Photo::find()->asArray()->all();
        return $this->render("index2.html",["arr"=>$arr]);
    }
    public  function actionAdd()
    {
        $photo=UploadedFile::getInstanceByName('logo');
        $dir="upload/image/";
        if(!is_dir($dir))
        {
            mkdir($dir,777,true);
        }
        $name=$dir.$photo->name;
        $re=$photo->saveAs($name,true);
        if($re)
        {
            $arr=\yii::$app->request->post();
            if($arr['_csrf'])
            {
                unset($arr['_csrf']);
                $res=new Photo();
                $res->rep_name=$arr['rep_name'];
                $res->is_open=$arr['is_open'];
                $res->is_stick=$arr['is_stick'];
                $res->priority_id=$arr['priority_id'];
                $res->rep_keyword=$arr['rep_keyword'];
                $res->title=$arr['title'];
                $res->logo=$name;
                $res->desc=$arr['desc'];
                if($res->save())
                {

                    $this->redirect("index.php?r=photo/index2");
                }

            }
        }

    }
    public  function  actionDel()
    {
        $id=\yii::$app->request->get("id");
        $re=Photo::findOne($id);
        if($re->delete())
        {
            echo 1;
        }

    }
//    public  function  actionSave_list()
//    {
//        $id=\yii::$app->request->get('id');
//        $re=Photo::findOne($id);
//        return $this->render("save_list",["re"=>$re]);
//    }
    public  function  actionSave()
    {
        $photo=UploadedFile::getInstanceByName('logo');
        $dir="upload/image/";
        if(!is_dir($dir))
        {
            mkdir($dir,777,true);
        }
        $name=$dir.$photo->name;
        $re=$photo->saveAs($name,true);
        if($re)
        {
            $arr=\yii::$app->request->post();
            $res=Photo::findOne($arr['id']);
            if($arr['_csrf'])
            {
                unset($arr['_csrf']);
                $res->rep_name=$arr['rep_name'];
                $res->is_open=$arr['is_open'];
                $res->is_stick=$arr['is_stick'];
                $res->priority_id=$arr['priority_id'];
                $res->rep_keyword=$arr['rep_keyword'];
                $res->title=$arr['title'];
                $res->logo=$name;
                $res->desc=$arr['desc'];
                if($res->save())
                {

                    $this->redirect("index.php?r=photo/index2");
                }

            }

            $res= $res->save();
            if($res)
            {
                $this->redirect("index.php?r=photo/list");
            }
        }

    }
    public function actionAlldel()
    {
        $id = \yii::$app->request->get('id');
        $id = explode(",",$id);
        unset($id[0]);
        for($i=1;$i<=count($id);$i++)
        {
            echo $id[$i];
            $word = Photo::findOne($id[$i]);
            $word->delete();
        }
        $arr=Photo::find()->asArray()->all();
        return $this->render("index2.html",["arr"=>$arr]);
    }
}