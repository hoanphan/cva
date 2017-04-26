<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DsHocSinh */

$this->title = 'Cập nhật học sinh: ' . $model->MaHocSinh;
$this->params['breadcrumbs'][] = ['label' => 'Dshocsinhs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MaHocSinh, 'url' => ['view', 'id' => $model->MaHocSinh]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dshocsinh-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
