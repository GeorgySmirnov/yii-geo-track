<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public static function create(?string $telephone, ?string $pass, ?string $guid) :User
    {
        $user = new User();

        if ($telephone)
        {
            $user->telephone = $telephone;
        }

        if ($pass)
        {
            $user->pass = Yii::$app->getSecurity()->generatePasswordHash($pass);
        }

        if ($guid)
        {
            $user->guid = $guid;
        }

        $user->save();

        return $user;
    }

    public function rules()
    {
        return [
            ['guid', 'match', 'pattern' => '/^[0-9a-f]{32}$/i'],
            ['telephone', 'match', 'pattern' => '/^7\d{10}$/'],
        ];
    }
}
