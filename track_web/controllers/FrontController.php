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
                'only' => ['login', 'logout', 'insert-position'],
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
                    [
                        'allow' => true,
                        'actions' => ['insert-position'],
                        'verbs' => ['POST'],
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

    public function actionInsertPosition()
    {
        $longitude = \Yii::$app->request->post('longitude') ?: '';
        $latitude = \Yii::$app->request->post('latitude') ?: '';
        $time = \Yii::$app->request->post('time') ?: '';

        $user = \Yii::$app->user->identity;

        $result = $user->insertPosition(floatval($longitude), floatval($latitude), $time);

        return $this->asJson(['success' => $result]);
    }
}
