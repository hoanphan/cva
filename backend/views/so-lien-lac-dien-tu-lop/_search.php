<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\ModelSearch\SoLienLacDienTuLopSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="so-lien-lac-dien-tu-lop-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MaTuan') ?>

    <?= $form->field($model, 'MaNam') ?>

    <?= $form->field($model, 'MaLop') ?>

    <?= $form->field($model, 'NoiDung') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
