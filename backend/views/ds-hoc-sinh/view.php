<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DsHocSinh */

$this->title = $model->MaHocSinh;
$this->params['breadcrumbs'][] = ['label' => 'Dshocsinhs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dshocsinh-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->MaHocSinh], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->MaHocSinh], [
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
            'HoDem',
            'Ten',
            'TenThuongGoi',
            'DaQuaLop',
            'NgaySinh',
            'GioiTinh',
            'NoiSinh',
            'QueQuan',
            'HoTenBo',
            'NgheNghiepBo',
            'HoTenMe',
            'NgheNghiepMe',
            'Anh',
            'MaDanToc',
            'MaTonGiao',
            'MaTinhTrangSucKhoe',
            'NgayVaoDoan',
            'NoiVaoDoan',
            'MatKhau',
            'EmailPhuHuynh:email',
            'SoDienThoaiPhuHuynh',
            'DangKyDichVu',
        ],
    ]) ?>

</div>
