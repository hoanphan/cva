<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\ModelSearch\DsGvChuaNhapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-gv-chua-nhap-diem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'MaGiaoVien') ?>

    <?= $form->field($model, 'TenGiaoVien') ?>

    <?= $form->field($model, 'LopChuaNhap') ?>

    <?= $form->field($model, 'LopDaNhap') ?>

    <?php // echo $form->field($model, 'sms') ?>

    <?php // echo $form->field($model, 'TuNgay') ?>

    <?php // echo $form->field($model, 'DenNgay') ?>

    <?php // echo $form->field($model, 'SDTGV') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
