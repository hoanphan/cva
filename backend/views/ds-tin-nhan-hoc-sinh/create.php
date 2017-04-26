<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DsTinNhanHocSinh */

$this->title = 'Create Ds Tin Nhan Hoc Sinh';
$this->params['breadcrumbs'][] = ['label' => 'Ds Tin Nhan Hoc Sinhs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-tin-nhan-hoc-sinh-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
