<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PhanCongGiangDay */

$this->title = 'Update Phan Cong Giang Day: ' . $model->MaNamHoc;
$this->params['breadcrumbs'][] = ['label' => 'Phan Cong Giang Days', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MaNamHoc, 'url' => ['view', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaGiaoVien' => $model->MaGiaoVien, 'MaMonHoc' => $model->MaMonHoc, 'MaLop' => $model->MaLop]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="phan-cong-giang-day-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
