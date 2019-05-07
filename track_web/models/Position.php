<?php

namespace app\models;

use yii\db\ActiveRecord;

class Position extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%position}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'time', 'longitude', 'latitude'], 'required'],
            [
                'time',
                'datetime',
                'timestampAttribute' => 'time',
                'timestampAttributeFormat' => 'yyyy-MM-dd HH:mm:ss'
            ],
            ['longitude', 'double', 'min' => -180, 'max' => 180],
            ['latitude', 'double', 'min' => -90, 'max' => 90],
        ];
    }

    public function setIsoTime(string $newTime): void
    {
        $this->time = $newTime;
    }

    public function getIsoTime(): string
    {
        return \Yii::$app->formatter->asDatetime($this->time);
    }
}
