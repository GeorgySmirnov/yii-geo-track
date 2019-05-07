<?php

namespace tests\unit\models;

use app\models\Position;
use app\models\User;

class PositionTest extends \Codeception\Test\Unit
{
    public function testCanInsertPositions()
    {
        $pos = new Position();
        $pos->user_id = User::findOne(['telephone' => '70000000000'])->id;
        $pos->longitude = 30;
        $pos->latitude = 30;
        $pos->isoTime = $time = date(\DateTime::ISO8601);

        $this->assertTrue($pos->save());

        $new_pos = Position::findOne([
            'user_id' => $pos->user_id,
            'time' => $pos->time,
        ]);

        $this->assertInstanceOf(Position::class, $new_pos);
        $this->assertEquals($pos->id, $new_pos->id);
        $this->assertEquals($time, $new_pos->isoTime);
    }
    
    public function testCanValidateFields()
    {
        $position = new Position();

        // longitude
        $position->longitude = 45.31;
        $this->assertTrue($position->validate('longitude'));
        $position->longitude = -45.31;
        $this->assertTrue($position->validate('longitude'));
        $position->longitude = '45.31';
        $this->assertTrue($position->validate('longitude'));

        $position->longitude = 200;
        $this->assertFalse($position->validate('longitude'));
        $position->longitude = -200;
        $this->assertFalse($position->validate('longitude'));
        $position->longitude = 'asd';
        $this->assertFalse($position->validate('longitude'));

        // latitude
        $position->latitude = 45.31;
        $this->assertTrue($position->validate('latitude'));
        $position->latitude = -45.31;
        $this->assertTrue($position->validate('latitude'));
        $position->latitude = '45.31';
        $this->assertTrue($position->validate('latitude'));

        $position->latitude = 100;
        $this->assertFalse($position->validate('latitude'));
        $position->latitude = -100;
        $this->assertFalse($position->validate('latitude'));
        $position->latitude = 'asd';
        $this->assertFalse($position->validate('latitude'));

        // time
        $position->time = '2019-05-05T18:37:56+0500';
        $this->assertTrue($position->validate('time'));
        $position->time = '2019-05-05 18:37:56';
        $this->assertTrue($position->validate('time'));

        $position->time = '2019-05-05T18:37:56';
        $this->assertFalse($position->validate('time'));
        $position->time = '2019-05-05 18:37:56+0500';
        $this->assertFalse($position->validate('time'));
        $position->time = 'abc';
        $this->assertFalse($position->validate('time'));
    }

    public function testCanCalculateDistanceToYekaterinburg()
    {
        $position = new Position();

        $position->latitude = 56.8575;
        $position->longitude = 60.6125;

        $this->assertEquals(0, $position->distanceToYekaterinburg);
    }
};
