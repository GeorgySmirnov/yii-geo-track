<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\Session;

class BackController extends Controller
{
    public function actionDropSessions()
    {
        Session::dropSessions();
        return ['success' => true];
    }
}
