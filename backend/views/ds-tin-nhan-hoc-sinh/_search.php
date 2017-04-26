<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\ModelSearch\DsTinNhanHocSinhSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-tin-nhan-hoc-sinh-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idSms') ?>

    <?= $form->field($model, 'MaHocSinh') ?>

    <?= $form->field($model, 'SddtPhuHuynh') ?>

    <?= $form->field($model, 'NoiDung') ?>

    <?php // echo $form->field($model, 'CacLanCoGangGui') ?>

    <?php // echo $form->field($model, 'Thang') ?>

    <?php // echo $form->field($model, 'TrangThai') ?>

    <?php // echo $form->field($model, 'LoiPhatSinh') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
