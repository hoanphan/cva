<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DsDiem */

$this->title = $model->MaHocSinh;
$this->params['breadcrumbs'][] = ['label' => 'Dsdiems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dsdiem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'MaHocSinh' => $model->MaHocSinh, 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaMonHoc' => $model->MaMonHoc, 'MaLoaiDiem' => $model->MaLoaiDiem, 'STTDiem' => $model->STTDiem], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'MaHocSinh' => $model->MaHocSinh, 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaMonHoc' => $model->MaMonHoc, 'MaLoaiDiem' => $model->MaLoaiDiem, 'STTDiem' => $model->STTDiem], [
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
            'MaHocSinh',
            'MaNamHoc',
            'MaHocKy',
            'MaMonHoc',
            'MaLoaiDiem',
            'STTDiem',
            'Diem',
            'DiemCu:ntext',
            'ChoPhepDang',
            'KhoaSo',
            'ChoPhepSua',
        ],
    ]) ?>

</div>
