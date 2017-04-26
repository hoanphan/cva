<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\ModelSearch\DsTongKetTheoKySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-tong-ket-theo-ky-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MaNamHoc') ?>

    <?= $form->field($model, 'MaHocKy') ?>

    <?= $form->field($model, 'MaHocSinh') ?>

    <?= $form->field($model, 'TrungBinhChung') ?>

    <?= $form->field($model, 'MaHanhKiem') ?>

    <?php // echo $form->field($model, 'MaDanhHieu') ?>

    <?php // echo $form->field($model, 'MaHocLuc') ?>

    <?php // echo $form->field($model, 'MaLenLop') ?>

    <?php // echo $form->field($model, 'soBuoiNghi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
