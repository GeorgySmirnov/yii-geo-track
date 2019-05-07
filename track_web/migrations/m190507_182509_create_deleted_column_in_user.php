<?php

use yii\db\Migration;

/**
 * Class m190507_182509_create_deleted_column_in_user
 */
class m190507_182509_create_deleted_column_in_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%user}}',
            'deleted',
            $this->boolean()->notNull()->defaultValue(false)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}','deleted');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_182509_create_deleted_column_in_user cannot be reverted.\n";

        return false;
    }
    */
}
