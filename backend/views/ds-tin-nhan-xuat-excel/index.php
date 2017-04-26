<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\DsTinNhanXuatExcelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ds Tin Nhan Xuat Excels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-tin-nhan-xuat-excel-index">


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


            'MaHocSinh',
            'TenHocSinh',
            'Thang',
            'Ky',
             'SDT',
             [
                 'attribute'=>'NoiDung',
                 'format'=>'html',

             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách tin nhắn được lấy') . '</i>',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
            'footer' => false
        ]
    ]); ?>
</div>
