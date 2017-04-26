<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/7/2016
 * Time: 4:30 PM
 */
use backend\BLL\DSMonHocBLL;
use backend\models\DmHocLuc;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DsMonHoc;
use backend\models\DSNamHoc;

$maHocKy = $idSemester;
$dsKhoi = DSKhoi::find()->where(['MaCap' => $MaCap])->orderBy(['TenKhoi' => SORT_ASC])->all();
$slKhoi = DSKhoi::find()->where(['MaCap' => $MaCap])->count();
$sumStudent = 0;
$idYear = DSNamHoc::getCurrentYear();
$DsMonHoc = DsMonHoc::layDanhSachMonHocTheoCap($MaCap);
$dsHocLuc = DmHocLuc::find()->orderBy(['MucUuTien' => SORT_ASC])->all();
foreach ($dsKhoi as $item) {
    $DsLop = DsLop::find()->where(['MaKhoi' => $item->MaKhoi, 'MaNamHoc' => $idYear])->all();
    foreach ($DsLop as $record) {
        $sumStudent += DSHocSinhTheoLop::find()->where(['MaLop' => $record->MaLop, 'MaNamHoc' => $idYear])->count();
    }
}
?>
<html>
<head>

</head>
<body lang='vi'>
<table class="col-xs-12" style="width: 100%">
    <tbody>
    <tr class="col-xs-6">


        <td style="text-align: center">
            <?php if ($MaCap == "TTHCS"): ?>
                PHÒNG GD&ĐT THÀNH PHỐ SƠN LA
            <?php else: ?>
                SỞ GD & ĐT TỈNH SƠN LA
            <?php endif; ?>
        </td>

        <td style="text-align: center">
            <p><b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<b></p>

        </td>
    </tr>
    <tr class="col-xs-6">
        <td style="text-align: center">
            <b><u>TRƯỜNG TH, THCS & THPT CHU VĂN AN</u></b>
        </td>
        <td style="text-align: center">
            <p><b><u>Độc lập - Tự do - Hạnh phúc</u></b></p>
        </td>
    </tr>
    </tbody>
</table>
<br/>
<br/>
<div style="text-transform: uppercase; text-align: center">
    <b>BIỂU THỐNG KÊ KẾT QUẢ HỌC TẬP RÈN</b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b>LUYỆN THEO HỌC LỰC CỦA MÔN HỌC</b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b>HỌC KỲ <?= \backend\models\DSHocKy::getNameSemester($maHocKy) ?> - NĂM
        HỌC <?= DSNamHoc::getNameCurrentYear() ?></b>
</div>
<div>

    <table style="width: 100%; border-spacing: 0px" border="1" class="">
        <thead>
        <tr>
            <th rowspan="2" style="text-align: center; ;width: 40%">Môn học</th>
            <th rowspan="2" style="text-align: center;;width: 20%">Tổng số</th>
            <th colspan="<?= $slKhoi ?>" style="text-align: center; ;width: 40%">Chia ra</th>
        </tr>
        <tr style="">
            <?php for ($i = 0; $i < $slKhoi; $i++): ?>
                <th style="text-align: center;"><?= $dsKhoi[$i]->TenKhoi ?></th>
            <?php endfor; ?>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($DsMonHoc); $i++): ?>
            <tr>
                <td style=" ;background-color: #d3d3d3"><?= $DsMonHoc[$i]->TenMonHoc ?></td>
                <td style="text-align: center; ;background-color: #d3d3d3"><?= $sumStudent ?></td>
                <?php for ($j = 0; $j < $slKhoi; $j++): ?>
                    <td style="text-align: center; ;background-color: #d3d3d3 ">
                        <?= DsLop::tongSoHocSinhTrongKhoi($dsKhoi[$j]->MaKhoi) ?>
                    </td>
                <?php endfor; ?>
            </tr>
            <?php if (DSMonHocBLL::LaChoDiem($DsMonHoc[$i]->MaMonHoc) == 1): ?>
                <?php for ($j = 0; $j < count($dsHocLuc); $j++): ?>
                    <tr>
                        <?php if ($j == 0): ?>
                            <td style=" ;"><?= 'Chia ra: -' . $dsHocLuc[$j]->TenHocLuc ?></td>
                        <?php else: ?>
                            <td style="padding-left: 50px">
                                <p><?= '-' . $dsHocLuc[$j]->TenHocLuc ?></p>
                            </td>
                        <?php endif; ?>
                        <td style="text-align: center;">
                            <?php
                            echo DSHocSinhTheoLop::TheoKhoiKhongDanhGia($dsHocLuc[$j]->MaHocLuc, $DsMonHoc[$i]->MaMonHoc, $maHocKy, $dsKhoi);
                            ?>

                        </td>
                        -->
                        <?php for ($k = 0; $k < $slKhoi; $k++): ?>
                            <td style="text-align: center;"><?= DSHocSinhTheoLop::layTongSoHocSinhTheoHocLucKhongDanhGia($dsHocLuc[$j]->MaHocLuc, $DsMonHoc[$i]->MaMonHoc, $dsKhoi[$k], $maHocKy) ?></td>
                        <?php endfor ?>
                    </tr>
                <?php endfor; ?>
                <?php else:?>
                <tr>

                        <td style=" ;"><?= 'Chia ra: - Đạt' ?></td>


                    <td style="text-align: center;">
                        <?php
                        echo DSHocSinhTheoLop::TheoKhoiDanhGia(-2, $DsMonHoc[$i]->MaMonHoc, $maHocKy, $dsKhoi);
                        ?>

                    </td>
                    -->
                    <?php for ($k = 0; $k < $slKhoi; $k++): ?>
                        <td style="text-align: center;"><?= DSHocSinhTheoLop::layTongSoHocSinhTheoHocLucDanhGia(-2, $DsMonHoc[$i]->MaMonHoc, $dsKhoi[$k], $maHocKy) ?></td>
                    <?php endfor ?>
                </tr>
                <tr>

                    <td style=" padding-left: 50px;"><?= 'Chưa đạt' ?></td>


                    <td style="text-align: center;">
                        <?php
                        echo DSHocSinhTheoLop::TheoKhoiDanhGia(-3, $DsMonHoc[$i]->MaMonHoc, $maHocKy, $dsKhoi);
                        ?>

                    </td>
                    -->
                    <?php for ($k = 0; $k < $slKhoi; $k++): ?>
                        <td style="text-align: center;"><?= DSHocSinhTheoLop::layTongSoHocSinhTheoHocLucDanhGia(-3, $DsMonHoc[$i]->MaMonHoc, $dsKhoi[$k], $maHocKy) ?></td>
                    <?php endfor ?>
                </tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tbody>
    </table>
    <table width="100%" style="text-align: center">
        <tr>
            <td style="width: 50%"></td>
            <td><i>Sơn La, ngày tháng năm 20</i></td>
        </tr>
        <tr>
            <td><b>NGƯỜI LẬP BIÊU</b></td>
            <td><b>HIỆU TRƯỞNG</b></td>
        </tr>

    </table>
</div>
</body>
</html>
