<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DsTongKetTheoKy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-tong-ket-theo-ky-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MaNamHoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaHocKy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaHocSinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TrungBinhChung')->textInput() ?>

    <?= $form->field($model, 'MaHanhKiem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaDanhHieu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaHocLuc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaLenLop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'soBuoiNghi')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
