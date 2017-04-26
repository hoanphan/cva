<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PhanCongGiangDay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="phan-cong-giang-day-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MaNamHoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaHocKy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaGiaoVien')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaMonHoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaLop')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
