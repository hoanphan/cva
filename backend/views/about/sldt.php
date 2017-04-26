<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/23/2016
 * Time: 7:51 PM
 */
use kartik\grid\GridView;
use yii\helpers\Html;

?>

<div id="electricBook">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'resizableColumns' => true,
        'pjax' => true,
        'bordered' => true,
        'responsive' => true,
        'rowOptions' => ['style' => [
            'text-align' => 'center'
        ]],
        'headerRowOptions' => ['style' => [
            'text-align' => 'center'
        ]],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'MaHocSinh',
                'label' => 'Mã học sinh',

            ],
            [
                'attribute' => 'TenHocSinh',
                'label' => 'Họ và tên',

            ],
            [
                'attribute' => 'NgaySinh',
                'label' => 'Ngày sinh',
                'format' => ['date', 'php:d-m-Y']

            ],

            [
                'attribute' => 'Action',
                'label' => 'Hoạt động',
                'format' => 'html'
            ]
        ],
        'panel' => [
            'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Sổ liên lạc điện tử') . '</i>',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
            'footer' => false
        ]
    ]); ?>
</div>