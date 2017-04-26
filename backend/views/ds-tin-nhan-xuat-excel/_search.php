<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\ModelSearch\DsTinNhanXuatExcelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-tin-nhan-xuat-excel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'MaHocSinh') ?>

    <?= $form->field($model, 'TenHocSinh') ?>

    <?= $form->field($model, 'Thang') ?>

    <?= $form->field($model, 'Ky') ?>

    <?php // echo $form->field($model, 'SDT') ?>

    <?php // echo $form->field($model, 'NoiDung') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
