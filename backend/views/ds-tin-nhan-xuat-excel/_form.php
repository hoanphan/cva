<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DsTinNhanXuatExcel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-tin-nhan-xuat-excel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MaHocSinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TenHocSinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Thang')->textInput() ?>

    <?= $form->field($model, 'Ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SDT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NoiDung')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
