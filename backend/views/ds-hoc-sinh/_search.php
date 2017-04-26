<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\ModelSearch\DsHocSinhSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dshocsinh-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MaHocSinh') ?>

    <?= $form->field($model, 'HoDem') ?>

    <?= $form->field($model, 'Ten') ?>

    <?= $form->field($model, 'TenThuongGoi') ?>

    <?= $form->field($model, 'DaQuaLop') ?>

    <?php // echo $form->field($model, 'NgaySinh') ?>

    <?php // echo $form->field($model, 'GioiTinh') ?>

    <?php // echo $form->field($model, 'NoiSinh') ?>

    <?php // echo $form->field($model, 'QueQuan') ?>

    <?php // echo $form->field($model, 'HoTenBo') ?>

    <?php // echo $form->field($model, 'NgheNghiepBo') ?>

    <?php // echo $form->field($model, 'HoTenMe') ?>

    <?php // echo $form->field($model, 'NgheNghiepMe') ?>

    <?php // echo $form->field($model, 'Anh') ?>

    <?php // echo $form->field($model, 'MaDanToc') ?>

    <?php // echo $form->field($model, 'MaTonGiao') ?>

    <?php // echo $form->field($model, 'MaTinhTrangSucKhoe') ?>

    <?php // echo $form->field($model, 'NgayVaoDoan') ?>

    <?php // echo $form->field($model, 'NoiVaoDoan') ?>

    <?php // echo $form->field($model, 'MatKhau') ?>

    <?php // echo $form->field($model, 'EmailPhuHuynh') ?>

    <?php // echo $form->field($model, 'SoDienThoaiPhuHuynh') ?>

    <?php // echo $form->field($model, 'DangKyDichVu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
