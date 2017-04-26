<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DsTinNhanHocSinh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ds-tin-nhan-hoc-sinh-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idSms')->textInput() ?>

    <?= $form->field($model, 'MaHocSinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SddtPhuHuynh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NoiDung')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CacLanCoGangGui')->textInput() ?>

    <?= $form->field($model, 'Thang')->textInput() ?>

    <?= $form->field($model, 'TrangThai')->textInput() ?>

    <?= $form->field($model, 'LoiPhatSinh')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
