<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\User;
use app\models\Position;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

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

    public function actionIndexPositions($guid)
    {
        if (!$user = User::findIdentity($guid))
        {
            throw new NotFoundHttpException();
        }

        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = \Yii::$app->getRequest()->getQueryParams();
        }

        $query = Position::find()->where(['user_id' => $user->id])->orderBy('time DESC');

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

    public function actionLastPosition($guid)
    {
        if (!$user = User::findIdentity($guid))
        {
            throw new NotFoundHttpException();
        }

        if (!$position = $user->getLastPosition())
        {
            return $this->asJson(null);
        }

        return $this->asJson([
            'longitude' => $position->longitude,
            'latitude' => $position->latitude,
            'time' => $position->time,
            'distanceToYekaterinburg' => $position->distanceToYekaterinburg,
        ]);
    }
}
