<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/29/2016
 * Time: 9:30 PM
 */
use kartik\grid\GridView;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'MaHocSinh',
        'HoDem',
        'Ten',
        'TenThuongGoi',
        // 'NgaySinh',
        // 'GioiTinh',
        // 'NoiSinh',
        // 'QueQuan',
        // 'HoTenBo',
        // 'NgheNghiepBo',
        // 'HoTenMe',
        // 'NgheNghiepMe',
        // 'Anh',
        // 'MaDanToc',
        // 'MaTonGiao',
        // 'MaTinhTrangSucKhoe',
        // 'NgayVaoDoan',
        // 'NoiVaoDoan',
           'MatKhau',
        // 'EmailPhuHuynh:email',
         'SoDienThoaiPhuHuynh',
        // 'DangKyDichVu',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
