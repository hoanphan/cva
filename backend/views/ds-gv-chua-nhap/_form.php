<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DsGvChuaNhapDiem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-gv-chua-nhap-diem-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MaGiaoVien')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TenGiaoVien')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LopChuaNhap')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'LopDaNhap')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sms')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TuNgay')->textInput() ?>

    <?= $form->field($model, 'DenNgay')->textInput() ?>

    <?= $form->field($model, 'SDTGV')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
