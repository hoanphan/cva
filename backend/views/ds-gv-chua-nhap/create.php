<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DsGvChuaNhapDiem */

$this->title = 'Create Ds Gv Chua Nhap Diem';
$this->params['breadcrumbs'][] = ['label' => 'Ds Gv Chua Nhap Diems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-gv-chua-nhap-diem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
