<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DsTinNhanHocSinh */

$this->title = 'Update Ds Tin Nhan Hoc Sinh: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ds Tin Nhan Hoc Sinhs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ds-tin-nhan-hoc-sinh-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
