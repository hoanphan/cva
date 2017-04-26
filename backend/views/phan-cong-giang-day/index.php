<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\PhanCongGiangDaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Phan Cong Giang Days';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phan-cong-giang-day-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Phan Cong Giang Day', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'MaNamHoc',
            'MaHocKy',
            'MaGiaoVien',
            'MaMonHoc',
            'MaLop',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
