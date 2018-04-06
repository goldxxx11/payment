<?php

use yii\db\Migration;

/**
 * Class m180404_173134_init
 */
class m180404_173134_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull(),
            'password' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'balance' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp(),
        ]);

        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey()->unsigned(),
            'from_id' => $this->integer()->unsigned(),
            'to_id' => $this->integer()->unsigned(),
            'amount' => $this->integer(),
            'created_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180404_173134_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180404_173134_init cannot be reverted.\n";

        return false;
    }
    */
}
