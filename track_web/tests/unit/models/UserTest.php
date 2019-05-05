<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testCanCreateNewUser()
    {
        $guid = bin2hex(random_bytes(16));
        $telephone = "71234567890";
        $pass = '';
        $this->assertInstanceOf(
            User::class,
            $user = User::create($telephone, $pass, $guid));

        $this->assertInstanceOf(User::class, $newUser = User::findOne(['guid' => $guid]));

        $this->assertEquals($user->id, $newUser->id);
        $this->assertEquals($telephone, $newUser->telephone);
    }

    public function testCanValidateFields()
    {
        $validGuid = bin2hex(random_bytes(16));
        $validTelephone = "71234567890";

        $invalidGuid = '0000000000000000000000000000000000';
        $invalidTelephone = '00000000000';

        $user = new User();

        $user->guid = $validGuid;
        $user->telephone = $validTelephone;

        $this->assertTrue($user->validate());

        $user->guid = $invalidGuid;
        $this->assertFalse($user->validate('guid'));

        $user->telephone = $invalidTelephone;
        $this->assertFalse($user->validate('telephone'));
    }

    public function testImplementIdentityInterface()
    {
        $user = User::create('71234567890', '');
        $this->assertTrue($user->validate());
        
        $this->assertEquals($user->guid, $guid = $user->getId());

        $this->assertInstanceOf(User::class, User::findIdentity($guid));
        $this->assertEquals($user->id, User::findIdentity($guid)->id);

        $this->assertRegExp('/^[A-Za-z0-9_-]+$/', $authKey = $user->getAuthKey());
        $this->assertTrue($user->validateAuthKey($authKey));
    }

    public function testCanAuthenticateUser()
    {
        $this->assertInstanceOf(User::class, $user = User::authenticate('70000000000', 'password'));
        $this->assertEquals('00000000000000000000000000000000', $user->guid);

        $this->assertNull(User::authenticate('70000000000', 'wrong_password'));
        $this->assertNull(User::authenticate('79999999999', 'password'));
    }
}
