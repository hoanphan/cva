<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DsHocSinh */

$this->title = 'hêm mới học sinh';
$this->params['breadcrumbs'][] = ['label' => 'Dshocsinhs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dshocsinh-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
