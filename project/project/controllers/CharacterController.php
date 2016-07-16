<?php

namespace app\controllers;

use app\models\Admin;
use yii\data\Pagination;
use yii\db\Connection;
use app\models\words_reply;
use yii\web\Controller;

class CharacterController extends Controller
{

    public $layout = 'common';
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index.html');
    }
    public function actionIndex2()
    {
        $arr = Words_reply::find()->asArray()->all();
        return $this->render('index2.html',['arr'=>$arr]);
    }
    function actionAdd()
    {
        $arr = \yii::$app->request->post();
        $word_reply = new Words_reply;
        $word_reply->rep_name=$arr['rep_name'];
        $word_reply->rep_keyword=$arr['rep_keyword'];
        $word_reply->rep_content=$arr['rep_content'];
        $word_reply->is_stick=$arr['is_stick'];
        if($arr['priority_id'])
        {
            $word_reply->priority_id=$arr['priority_id'];
        }
        $word_reply->status=$arr['is_open'];
        $word_reply->acc_id=1;
        $sta = $word_reply->save();
        if($sta)
        {
            return $this->redirect(array('character/index2'));
        }
    }
    function actionUpdate()
    {
        $arr = \yii::$app->request->post();
        $word_reply = Words_reply::findOne($arr['rep_id']);
        $word_reply->rep_name=$arr['rep_name'];
        $word_reply->rep_keyword=$arr['rep_keyword'];
        $word_reply->rep_content=$arr['rep_content'];
        $word_reply->is_stick=$arr['is_stick'];
        if($arr['priority_id'])
        {
            $word_reply->priority_id=$arr['priority_id'];
        }
        $word_reply->status=$arr['is_open'];
        $word_reply->acc_id=1;
        $sta = $word_reply->save();
        if($sta)
        {
            return $this->redirect(array('character/index2'));
        }
    }
    function actionDel()
    {
        $id = \yii::$app->request->get('id');
        $word_reply = Words_reply::findOne($id);
        $sta = $word_reply->delete();
        if($sta)
        {
            echo 1;
        }
    }
    function actionCutyes()
    {
        $arr = Words_reply::find()->where(['status'=>1])->asArray()->all();
//        print_r($arr);die;
        return $this->render('index2.html',['arr'=>$arr]);
    }
    function actionCutno()
    {
        $arr = Words_reply::find()->where(['status'=>0])->asArray()->all();
//        print_r($arr);die;
        return $this->render('index2.html',['arr'=>$arr]);
    }
    function actionSou()
    {
        $sou = \yii::$app->request->get('sou');
        $arr = Words_reply::find()
            ->where(['like','rep_name',$sou])
            ->asArray()
            ->all();
        $res['sou']= $sou;
        $res['arr']=$arr;
        return $this->render('index2.html',$res);
    }
    function actionAlldel()
    {
        $id = \yii::$app->request->get('id');
        $id = explode(",",$id);
        unset($id[0]);
        for($i=1;$i<=count($id);$i++)
        {
            echo $id[$i];
            $word = Words_reply::findOne($id[$i]);
            $word->delete();
        }
        $arr = Words_reply::find()->asArray()->all();
        return $this->render('index2.html',['arr'=>$arr]);
    }
}