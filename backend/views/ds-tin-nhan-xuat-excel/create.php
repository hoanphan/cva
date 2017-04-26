<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DsTinNhanXuatExcel */

$this->title = 'Create Ds Tin Nhan Xuat Excel';
$this->params['breadcrumbs'][] = ['label' => 'Ds Tin Nhan Xuat Excels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-tin-nhan-xuat-excel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
