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
}
