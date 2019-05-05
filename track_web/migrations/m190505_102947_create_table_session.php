<?php

use yii\db\Migration;

/**
 * Class m190505_102947_create_table_session
 */
class m190505_102947_create_table_session extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->char(64)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary()
        ]);
        $this->addPrimaryKey('pk-id', '{{%session}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%session}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190505_102947_create_table_session cannot be reverted.\n";

        return false;
    }
    */
}
