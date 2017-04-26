<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DsTongKetTheoKy */

$this->title = $model->MaNamHoc;
$this->params['breadcrumbs'][] = ['label' => 'Ds Tong Ket Theo Kies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-tong-ket-theo-ky-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaHocSinh' => $model->MaHocSinh], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaHocSinh' => $model->MaHocSinh], [
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
            'MaHocSinh',
            'TrungBinhChung',
            'MaHanhKiem',
            'MaDanhHieu',
            'MaHocLuc',
            'MaLenLop',
            'soBuoiNghi',
        ],
    ]) ?>

</div>
