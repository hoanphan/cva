<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DsGvChuaNhapDiem */

$this->title = 'Update Ds Gv Chua Nhap Diem: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ds Gv Chua Nhap Diems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ds-gv-chua-nhap-diem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
