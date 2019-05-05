<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\User;
use yii\filters\AccessControl;

class FrontController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionLogin()
    {
        $telephone = \Yii::$app->request->post('telephone');
        $pass = \Yii::$app->request->post('pass');

        $user = User::authenticate($telephone, $pass);
        if ($user) {
            \Yii::$app->user->login($user);
            return $this->asJson([
                'success' => true,
                'guid' => $user->guid]);
        }
        return $this->asJson([
            'success' => false,
            'errmsg' => 'Authentication failure']);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->asJson(['success' => true]);
    }
}
