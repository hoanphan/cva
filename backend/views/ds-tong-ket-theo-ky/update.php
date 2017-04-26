<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DsTongKetTheoKy */

$this->title = 'Update Ds Tong Ket Theo Ky: ' . $model->MaNamHoc;
$this->params['breadcrumbs'][] = ['label' => 'Ds Tong Ket Theo Kies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MaNamHoc, 'url' => ['view', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaHocSinh' => $model->MaHocSinh]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ds-tong-ket-theo-ky-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
