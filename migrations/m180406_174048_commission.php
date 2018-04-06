<?php

use yii\db\Migration;

/**
 * Class m180406_174048_commission
 */
class m180406_174048_commission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('payment', 'commission', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180406_174048_commission cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180406_174048_commission cannot be reverted.\n";

        return false;
    }
    */
}
