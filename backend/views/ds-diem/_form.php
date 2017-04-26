<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\DsHocSinh;
/* @var $this yii\web\View */
/* @var $model backend\models\Dsdiem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dsdiem-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MaHocSinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaNamHoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaHocKy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaMonHoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaLoaiDiem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STTDiem')->textInput() ?>

    <?= $form->field($model, 'Diem')->textInput() ?>

    <?= $form->field($model, 'DiemCu')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ChoPhepDang')->textInput() ?>

    <?= $form->field($model, 'KhoaSo')->textInput() ?>

    <?= $form->field($model, 'ChoPhepSua')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
