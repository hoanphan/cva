<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SoLienLacDienTu */

$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Sổ liên lạc điện tử';
$this->params['breadcrumbs'][] = ['label' => 'So Lien Lac Dien Tus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MaHocSinh, 'url' => ['view', 'MaHocSinh' => $model->MaHocSinh, 'MaTuan' => $model->MaTuan, 'MaNamhoc' => $model->MaNamhoc]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="so-lien-lac-dien-tu-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
