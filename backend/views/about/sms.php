<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\DsTinNhanHocSinhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="gridview">
    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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

            //'id',
            [
                'attribute'=>'idSms',
                'label'=>'Mã Tin nhắn'
            ],
            [
                'attribute'=>  'MaHocSinh',
                'label'=>'Mã học sinh',

            ],
            [
                'attribute'=> 'SddtPhuHuynh',
                'label'=>'Số điện thọa phụ huynh',

            ],
            [
                'attribute'=> 'SddtPhuHuynh',
                'label'=>'Các lần cố gắng gửi',

            ],
            //'NoiDung:ntext',

            // 'Thang',
            [
                'attribute'=>'TrangThai',
                'label'=>'Trạng thái',
            ],
            [
                'attribute'=>'LoiPhatSinh',
                'label'=>'Lỗi phát sinh',
                'value'=>function($data) {
                    if ($data->LoiPhatSinh == "103")
                        return "Số dư tài khoản không đủ dể gửi tin";

                    elseif ($data->LoiPhatSinh == "101")
                        return "Đăng nhập thất bại";
                    elseif ($data->LoiPhatSinh == "102")
                        return "Tài khoản đã bị khóa";
                    elseif ($data->LoiPhatSinh == "104")
                        return "Mã Brandname không đúng";
                    elseif ($data->LoiPhatSinh == "118")
                        return "Loại tin nhắn không hợp lệ";

                    elseif ($data->LoiPhatSinh == "119")
                        return "Brandname quảng cáo phải gửi ít nhất 20 số điện thoại";

                    elseif ($data->LoiPhatSinh == "131")
                        return "Tin nhắn brandname quảng cáo độ dài tối đa 422 kí tự";

                    elseif ($data->LoiPhatSinh == "132")
                        return "Không có quyền gửi tin nhắn đầu số cố định 8755";
                    elseif ($data->LoiPhatSinh == "100")
                        return "Đang chờ gửi";
                    else
                        return"Không phát hiện được lỗi";
                }

            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách học sinh sử dụng dịch vụ') . '</i>',

        ]
    ]);?>
</div>

