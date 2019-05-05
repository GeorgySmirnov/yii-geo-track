<?php

use yii\db\Migration;

/**
 * Class m190505_124831_create_table_position
 */
class m190505_124831_create_table_position extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('position', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'longitude' => $this->double()->notNull(),
            'latitude' => $this->double()->notNull(),
            'time' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-position-user_id',
            'position',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-position-user_id',
            'position'
        );
        $this->dropTable('position');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190505_124831_create_table_position cannot be reverted.\n";

        return false;
    }
    */
}
