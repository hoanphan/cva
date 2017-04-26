<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DsDiem */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Dsdiems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dsdiem-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
