<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Payment;
use yii\grid\GridView;
/**

 * @var $model \app\models\PaymentForm
 * @var $user \app\models\User
 */

$this->title = 'Payment';
$this->params['breadcrumbs'][] = $this->title;
$outcomingDataProvider = new \yii\data\ActiveDataProvider([
    'query' => $user->getOutcomingPayments(),
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
]);

$incomingDataProvider = new \yii\data\ActiveDataProvider([
    'query' => $user->getIncomingPayments(),
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
]);
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Баланс: <?= $user->balance ?></p>
    <h2>Исходящие платежи</h2>
    <?= GridView::widget([
        'options' => ['id' => 'hostess-grid'],
        'dataProvider' => $outcomingDataProvider,
        'columns' => [
            'to' => [
                'value' => function(Payment $model) {
                    return $model->to->username;
                },
                'attribute' => 'to',
                'format' => 'raw',
            ],
            'amount',
            'commission',
            'created_at',
        ],
    ]); ?>

    <h2>Входящие платежи</h2>
    <?= GridView::widget([
        'options' => ['id' => 'hostess-grid'],
        'dataProvider' => $incomingDataProvider,
        'columns' => [
            'from' => [
                'value' => function(Payment $model) {
                    return $model->from->username;
                },
                'attribute' => 'from',
                'format' => 'raw',
            ],
            'amount',
            'commission',
            'created_at',
        ],
    ]); ?>
    <p>Для перевода заполните поля</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>