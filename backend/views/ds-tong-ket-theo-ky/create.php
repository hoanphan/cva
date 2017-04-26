<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DsTongKetTheoKy */

$this->title = 'Create Ds Tong Ket Theo Ky';
$this->params['breadcrumbs'][] = ['label' => 'Ds Tong Ket Theo Kies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-tong-ket-theo-ky-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
