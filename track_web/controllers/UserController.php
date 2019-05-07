<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\User;
use yii\data\ActiveDataProvider;

class UserController extends Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    
    public function actionIndex()
    {
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = \Yii::$app->getRequest()->getQueryParams();
        }

        $query = User::find()->with([
            'positions' => function ($q) {
                $q->orderBy('time DESC')->limit(3);
            }]);

        return \Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }
}
