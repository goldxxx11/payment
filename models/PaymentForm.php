<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 04.04.2018
 * Time: 21:56
 */

namespace app\models;


use yii\base\Model;
class PaymentForm extends Model
{
    public $username;
    public $amount;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'amount'], 'required'],
            ['username', 'validateUser'],
            ['amount', 'integer'],
            ['amount', 'validateAmount'],
        ];
    }

    public function validateUser($attribute, $params)
    {
        if (!($this->username && $this->getUser())) {
            $this->addError($attribute, 'User Not Found');
        }
    }

    public function validateAmount($attribute, $params)
    {
        if ($this->getUser() && $this->getUser()->balance < $this->getTotalAmount()) {
            $this->addError($attribute, 'Недостаточно средств');
        }
    }
    
    public function transfer()
    {
        if ($this->validate()) {
           /** @var User $from */
            $from = \Yii::$app->user->identity;
            $to = $this->getUser();
            $amount = $this->getTotalAmount();
            
            $from->balance = $from->balance - $amount;
            $from->save();
            $to->balance = $to->balance + $amount;
            $to->save();
            
            $payment = new Payment();
            $payment->from_id = $from->id;
            $payment->to_id = $to->id;
            $payment->amount = $amount;
            $payment->commission = $this->getTotalCommission();
            $payment->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Сумма всех комиссий
     *
     * @return int
     */
    private function getTotalCommission()
    {
        $amount = $this->amount;
        $commission = 0;
        $commission += $this->getCommission($amount);
        $commission += $this->getProtectionCommission($amount);
        return $commission;
    }

    /**
     * Комиссия за перевод
     *
     * @param $amount
     * @return mixed
     */
    private function getCommission($amount)
    {
        return $amount * 0.01;
    }

    /**
     * Комиссия за секретность
     *
     * @param $amount
     * @return int
     */
    private function getProtectionCommission($amount)
    {
        $commission = $amount * 0.01;
        if($commission < 44){
            $commission = 44;
        }
        return $commission;
    }

    private function getTotalAmount()
    {
       return $this->amount + $this->getTotalCommission();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return User::findByUsername($this->username);
    }
}
