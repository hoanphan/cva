<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SoLienLacDienTuLop */

$this->title = 'Update So Lien Lac Dien Tu Lop: ' . $model->MaTuan;
$this->params['breadcrumbs'][] = ['label' => 'So Lien Lac Dien Tu Lops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MaTuan, 'url' => ['view', 'id' => $model->MaTuan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="so-lien-lac-dien-tu-lop-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
