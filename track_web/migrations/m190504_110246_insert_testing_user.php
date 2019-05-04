<?php

use yii\db\Migration;

/**
 * Class m190504_110246_insert_testing_user
 */
class m190504_110246_insert_testing_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}',
                      [
                          'guid' => '00000000000000000000000000000000',
                          'telephone' => '70000000000',
                          'pass' => \Yii::$app->getSecurity()->generatePasswordHash('password'),
                          'auth_key' => \Yii::$app->security->generateRandomString(),
                      ]);
        $this->insert('{{%user}}',
                      [
                          'guid' => '00000000000000000000000000000001',
                          'telephone' => '70000000001',
                          'pass' => \Yii::$app->getSecurity()->generatePasswordHash('password'),
                          'auth_key' => \Yii::$app->security->generateRandomString(),
                      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['guid' => '00000000000000000000000000000000']); 
        $this->delete('{{%user}}', ['guid' => '00000000000000000000000000000001']);
   }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190504_110246_insert_testing_user cannot be reverted.\n";

        return false;
    }
    */
}
