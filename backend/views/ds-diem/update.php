<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DsDiem */

$this->title = 'C: ' . $model->MaHocSinh;
$this->params['breadcrumbs'][] = ['label' => 'Dsdiems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MaHocSinh, 'url' => ['view', 'MaHocSinh' => $model->MaHocSinh, 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaMonHoc' => $model->MaMonHoc, 'MaLoaiDiem' => $model->MaLoaiDiem, 'STTDiem' => $model->STTDiem]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dsdiem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
