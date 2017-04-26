<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DsTinNhanXuatExcel */

$this->title = 'Update Ds Tin Nhan Xuat Excel: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ds Tin Nhan Xuat Excels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ds-tin-nhan-xuat-excel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
