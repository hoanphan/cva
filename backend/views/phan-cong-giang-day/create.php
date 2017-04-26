<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PhanCongGiangDay */

$this->title = 'Create Phan Cong Giang Day';
$this->params['breadcrumbs'][] = ['label' => 'Phan Cong Giang Days', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phan-cong-giang-day-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
