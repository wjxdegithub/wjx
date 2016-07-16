<?php

namespace app\controllers;

use app\models\Admin;
use yii\data\Pagination;
use yii\db\Connection;
use app\models\words_reply;
use yii\web\Controller;

class MusicController extends Controller
{
    public $layout = 'common';
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index.html');
    }
    public function actionIndex2()
    {
        return $this->render('index2.html');
    }
}