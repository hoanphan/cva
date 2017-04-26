<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\ModelSearch\SoLienLacDienTuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="so-lien-lac-dien-tu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MaHocSinh') ?>

    <?= $form->field($model, 'MaTuan') ?>

    <?= $form->field($model, 'MaNamhoc') ?>

    <?= $form->field($model, 'NoiDung') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
