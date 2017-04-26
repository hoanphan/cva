<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SoLienLacDienTuLop */

$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Sổ liên lạc điện tử';;
$this->params['breadcrumbs'][] = ['label' => 'So Lien Lac Dien Tu Lops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-lien-lac-dien-tu-lop-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
