<?php
use kartik\grid\GridView;
use backend\models\DSTongKetTheoKy;

/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 4/1/2017
 * Time: 10:44 AM
 */
?>
<div id="table">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

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
                'value' => function ($data) {
                    return DSTongKetTheoKy::getFullName($data->MaHocSinh);
                }
            ],

            'TrungBinhChung',
            [
                'attribute' => 'MaHanhKiem',
                'value' => function ($data) {
                    return DSTongKetTheoKy::getTextHanhKiem($data->MaHanhKiem);
                }
            ],
            [
                'attribute' => 'MaHocLuc',
                'value' => function ($data) {
                    return DSTongKetTheoKy::getTextHocLuc($data->MaHocLuc);
                }
            ],
            [
                'attribute' => 'MaDanhHieu',
                'value' => function ($data) {
                    return DSTongKetTheoKy::getTextDanhHieu($data->MaDanhHieu);
                }
            ],


            // 'MaLenLop',
            // 'soBuoiNghi',


        ],
        'panel' => [
            'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách học sinh') . '</i>',
            'footer' => false
        ]
    ]); ?>
</div>
