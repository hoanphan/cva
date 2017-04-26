<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PhanCongGiangDay */

$this->title = $model->MaNamHoc;
$this->params['breadcrumbs'][] = ['label' => 'Phan Cong Giang Days', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phan-cong-giang-day-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaGiaoVien' => $model->MaGiaoVien, 'MaMonHoc' => $model->MaMonHoc, 'MaLop' => $model->MaLop], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaGiaoVien' => $model->MaGiaoVien, 'MaMonHoc' => $model->MaMonHoc, 'MaLop' => $model->MaLop], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'MaNamHoc',
            'MaHocKy',
            'MaGiaoVien',
            'MaMonHoc',
            'MaLop',
        ],
    ]) ?>

</div>
