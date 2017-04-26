<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\ModelSearch\PhanCongGiangDaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phan-cong-giang-day-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MaNamHoc') ?>

    <?= $form->field($model, 'MaHocKy') ?>

    <?= $form->field($model, 'MaGiaoVien') ?>

    <?= $form->field($model, 'MaMonHoc') ?>

    <?= $form->field($model, 'MaLop') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
