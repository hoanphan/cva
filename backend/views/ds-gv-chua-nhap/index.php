<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\DsGvChuaNhapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ds Gv Chua Nhap Diems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ds-gv-chua-nhap-diem-index">
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


            'MaGiaoVien',
            'TenGiaoVien',
            'LopChuaNhap:ntext',
            'LopDaNhap:ntext',
            'sms:ntext',
            'SDTGV:ntext',

        ],
        'panel' => [
            'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách học sinh') . '</i>',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
            'footer' => false
        ]
    ]); ?>
</div>
