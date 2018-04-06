<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property string $id
 * @property string $from_id
 * @property string $to_id
 * @property int $amount
 * @property string $created_at
 * @property string $commission
 * @property User $from
 * @property User $to
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id', 'amount', 'commission'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'commission' => 'Commission',
        ];
    }

    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_id']);
    }

    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_id']);
    }
}
