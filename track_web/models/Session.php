<?php

namespace app\models;

use yii\db\ActiveRecord;

class Session extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%session}}';
    }

    public static function dropSessions()
    {
        \Yii::$app->db->createCommand('delete from session')
            ->execute();
    }
}
