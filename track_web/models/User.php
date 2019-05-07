<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use app\models\Position;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function extraFields()
    {
        return ['positions'];
    }

    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['user_id' => 'id']);
    }

    public static function create(?string $telephone = null, ?string $pass = null, ?string $guid = null) :User
    {
        $user = new User();

        if ($telephone) {
            $user->telephone = $telephone;
        }

        if ($pass) {
            $user->pass = Yii::$app->getSecurity()->generatePasswordHash($pass);
        }

        if ($guid) {
            $user->guid = $guid;
        } else {
            $user->guid = bin2hex(\Yii::$app->security->generateRandomKey(16));
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

    public static function authenticate(string $telephone, string $pass): ?User
    {
        if ($user = User::findOne(['telephone' => $telephone])) {
            if (\Yii::$app->getSecurity()->validatePassword($pass, $user->pass)) {
                return $user;
            }
        }
        return null;
    }

    public static function findIdentity($guid)
    {
        return User::findOne(['guid' => $guid]);
    }

    public function getId()
    {
        return $this->guid;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public function insertPosition(float $longitude, float $latitude, string $time): bool
    {
        $position = new Position();

        $position->user_id = $this->id;
        $position->longitude = $longitude;
        $position->latitude = $latitude;
        $position->time = $time;

        return $position->save();
    }
}
