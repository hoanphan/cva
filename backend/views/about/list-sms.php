<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\DsTinNhanHocSinhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="gridview">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'bordered' => true,
        'responsive' => true,
        'rowOptions' => ['style' => [
            'text-align' => 'center'
        ]],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'MaHocSinh',
            'TenHocSinh',
            'Thang',
            'Ky',
            // 'SDT',
            // 'NoiDung:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Sổ liên lạc điện tử') . '</i>',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
            'footer' => false
        ]
    ]); ?>
</div>

