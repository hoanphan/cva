<?php

use yii\helpers\Html;
use  app\common\models\DSTuan;

/* @var $this yii\web\View */
/* @var $model backend\models\SoLienLacDienTu */

$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Sổ liên lạc điện tử';
$this->params['breadcrumbs'][] = ['label' => 'So Lien Lac Dien Tus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="so-lien-lac-dien-tu-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
