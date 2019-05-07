<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m190507_101813_insert_positions
 */
class m190507_101813_insert_positions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user_id = User::findOne(['telephone' => '70000000000'])->id;

        $this->batchInsert(
            'position',
            ['user_id', 'longitude', 'latitude', 'time'],
            [
                [$user_id, 0, 0, '2019-05-05 12:00:00'],
                [$user_id, 1, 1, '2019-05-05 12:00:01'],
                [$user_id, 2, 2, '2019-05-05 12:00:02'],
                [$user_id, 3, 3, '2019-05-05 12:00:03'],
                [$user_id, 4, 4, '2019-05-05 12:00:04'],
                [$user_id, 5, 5, '2019-05-05 12:00:05'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $user_id = User::findOne(['telephone' => '70000000000'])->id;

        $this->delete('position', ['user_id' => $user_id]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_101813_insert_positions cannot be reverted.\n";

        return false;
    }
    */
}
