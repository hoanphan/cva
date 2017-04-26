<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/10/2016
 * Time: 2:20 PM
 */
use backend\BLL\DsHocSinhBLL;
use backend\BLL\ThongKeDanhHieuBLL;
use backend\models\DmDanToc;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DSTuan;
$bundel=\backend\assets\AppAsset::register($this);
$dsKhoi=DSKhoi::find()->all();

?>
<html>
<head>

</head>
<body style="font-size: 14pt; font-family: 'TimeRomanNormal'">
<div class="table" style="text-align: center;">
    <table style="width: 100%; text-align: center;" >
        <tr>
            <td rowspan="3"><img src="<?= $bundel->baseUrl ?>/images/logo.png"></td>
        </tr>
        <tr>
            <td colspan="3" style="font-size: 14pt; font-family:'Times New Roman'"><b>DANH SÁCH HOC SINH DẠT DANH HIỆU</b>
            </td>
        </tr>
        <tr>
            <td>
                <b>Danh hiệu: </b> <?= \backend\models\DmDanhHieu::getNameAppellation($MaDanhHieu) ?>
            </td>
            <td>
                <b>Học kỳ: </b><?= \backend\models\DSHocKy::getNameSemester($idSemester) ?>
            </td>
            <td>
                <b> Năm học: </b> <?= \backend\models\DSNamHoc::getNameCurrentYear() ?>

            </td>
        </tr>
    </table>
</div>
<div>
    <table class="" style="text-align: center;width: 100%; border-spacing: 0px" ; border="1">
        <thead>
        <tr style="right: 30px">
            <th style="text-align: center; background-color: #d3d3d3;"
            >Lớp
            </th>
            <th style="text-align: center; background-color: #d3d3d3;width: 200px">Tổng số</th>
            <th style="text-align: center; background-color: #d3d3d3;"
            >Họ và tên
            </th>
            <th style="text-align: center;background-color: #d3d3d3;">Ngày sinh
            </th>
            <th style="text-align: center;background-color: #d3d3d3;">TBC</th>


        </tr>

        </thead>
        <tbody>

        <?php for ($i = 0; $i < count($dsKhoi); $i++): ?>
        <?php $listClass=DsLop::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear(),'MaKhoi'=>$dsKhoi[$i]->MaKhoi])->all();?>
           <tr>
                <td>
                    <?="Khối ".DSKhoi::getNameGruop($dsKhoi[$i]->MaKhoi)." chia ra:  "?>
                </td>
               <td><?=ThongKeDanhHieuBLL::LaySoLuongDanhHieuTrongKhoi($MaDanhHieu,$dsKhoi[$i]->MaKhoi,$idSemester)?></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
        <?php for($j=0;$j<count($listClass);$j++):?>

                <tr style=" ">

                    <td style="padding-left: 40px">
                        <?="Lớp ".DsLop::getNameClass($listClass[$j]->MaLop)?>
                    </td>
                    <td>
                        <?php $listStudent=ThongKeDanhHieuBLL::LayDanhSachHocSinhTrongLop($MaDanhHieu,$listClass[$j]->MaLop,$idSemester);
                            echo count($listStudent)
                        ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
            </tr>
                <?php for ($k=0;$k<count($listStudent);$k++):?>
                <tr>
                    <td></td>
                    <td></td>

                    <td>
                        <?php echo DsHocSinh::getFullName($listStudent[$k]->MaHocSinh)?>
                    </td>
                        <td>
                            <?php echo DsHocSinh::getNgaySinh($listStudent[$k]->MaHocSinh)?>
                        </td>
                    <td>
                        <?php echo $listStudent[$k]->TrungBinhChung?>
                    </td>
                </tr>
                <?php endfor;?>
            <?php endfor;?>
        <?php endfor; ?>
        </tbody>
        -->
    </table>
</div>
</body>
</html>