<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\ModelSearch\DsDiemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dsdiem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MaHocSinh') ?>

    <?= $form->field($model, 'MaNamHoc') ?>

    <?= $form->field($model, 'MaHocKy') ?>

    <?= $form->field($model, 'MaMonHoc') ?>

    <?= $form->field($model, 'MaLoaiDiem') ?>

    <?php // echo $form->field($model, 'STTDiem') ?>

    <?php // echo $form->field($model, 'Diem') ?>

    <?php // echo $form->field($model, 'DiemCu') ?>

    <?php // echo $form->field($model, 'ChoPhepDang') ?>

    <?php // echo $form->field($model, 'KhoaSo') ?>

    <?php // echo $form->field($model, 'ChoPhepSua') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
