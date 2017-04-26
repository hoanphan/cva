<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\DsTinNhanHocSinhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ds Tin Nhan Hoc Sinhs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-tin-nhan-hoc-sinh-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ds Tin Nhan Hoc Sinh', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'idSms',
            'MaHocSinh',
            'SddtPhuHuynh',
            'NoiDung:ntext',
            // 'CacLanCoGangGui',
            // 'Thang',
            // 'TrangThai',
            // 'LoiPhatSinh',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
