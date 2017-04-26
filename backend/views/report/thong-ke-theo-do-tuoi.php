<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/10/2016
 * Time: 2:20 PM
 */
use backend\BLL\DsHocSinhBLL;
use backend\models\DmDanToc;
use backend\models\DSHocKy;
use backend\models\DSKhoi;
use backend\models\DSNamHoc;
use backend\models\DSTuan;

$dsKhoi=DSKhoi::find()->where(['MaCap'=>$idLevel])->orderBy(['TenKhoi'=>SORT_ASC])->all();
$dsDanToc=DmDanToc::find()->where(['ThongKeDanToc'=>1])->all();

if($idLevel=="TTHCS") {
    $tuoiBatDau = 11;
    $tuoKetThuc = 14;
}
else
{
    $tuoiBatDau = 15;
    $tuoKetThuc = 17;
}

?>
<html>
<head>

</head>
<body style="font-size: 14pt; font-family: 'TimeRomanNormal'">
<table class="col-xs-12" style="width: 100%">
    <tbody>
    <tr class="col-xs-6">
        <td style="text-align: center">
            <?php if($idLevel=="TTHCS"):?>
                PHÒNG GD&ĐT THÀNH PHỐ SƠN LA
            <?php else:?>
                SỞ GD & ĐT TỈNH SƠN LA
            <?php endif;?>
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
    <b>BIỂU THỐNG KÊ HỌC SINH THEO ĐỘ TUỔI</b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b style="text-transform: uppercase"><?=DSHocKy::getNameSemester($idSemester).'     - NĂM HỌC '.DSNamHoc::getNameCurrentYear()?></b>
</div>
<table style="width: 100%; border-spacing: 0px"; border="1">
    <thead >
    <tr>
        <th rowspan="2" style="text-align: center;width: 250px">Đánh giá học sinh</th>
        <th rowspan="2" style="text-align: center">Tổng số</th>
        <th colspan="<?=count($dsKhoi)?>" style="text-align: center">Chia ra</th>

    </tr>
    <tr >
        <?php for($i=0;$i<count($dsKhoi);$i++):?>
            <th  style="text-align: center"><?='Lớp '.$dsKhoi[$i]->TenKhoi?></th>
        <?php endfor;?>
    </tr>
    </thead>
    <tbody>
    <!--Thống kê đoạn đầu-->
        <tr style=";background-color: #d3d3d3">
            <td >Tổng số học sinh</td>
            <td style="text-align: center"><?= DsHocSinhBLL::getCountStudentInAllLevel($idLevel)?></td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruop($dsKhoi[$i]->MaKhoi)?></td>
            <?php endfor;?>
        </tr>
        <tr>
            <td>Trong TS: + Nữ</td>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,1)?></td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruop($dsKhoi[$i]->MaKhoi,1)?></td>
            <?php endfor;?>
        </tr>
        <tr>
            <td style="padding-left: 62px"> + Dân tộc</td>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInAllLevel($idLevel)?></td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInGruop($dsKhoi[$i]->MaKhoi)?></td>
            <?php endfor;?>
        </tr>
        <tr>
            <td style="padding-left: 62px"> + Nữ dân tộc</td>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInAllLevelAndWormen($idLevel)?></td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInGruopWormen($dsKhoi[$i]->MaKhoi)?></td>
            <?php endfor;?>
        </tr>
   <!-- Kết Thúc-->
    <!--Thống kê theo tổng số học sinh-->
        <tr style=";background-color: #d3d3d3">
            <td>Số học sinh theo độ tuổi</td>
            <td style="text-align: center"><?= DsHocSinhBLL::getCountStudentInAllLevel($idLevel)?></td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruop($dsKhoi[$i]->MaKhoi)?></td>
            <?php endfor;?>
        </tr>
        <tr>
            <td>Chia ra: -Dưới <?=$tuoiBatDau?> tuổi </td>
            <td style="text-align: center">
                <?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,null,$tuoiBatDau,0)?>
            </td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowAge($dsKhoi[$i]->MaKhoi,null,$tuoiBatDau,0)?></td>
            <?php endfor;?>
        </tr>
        <?php for ($i=$tuoiBatDau;$i<=$tuoKetThuc;$i++):?>
            <tr>
                <td style="padding-left: 42px; ">-<?=$i." Tuổi"?> </td>
                <td style="text-align: center">
                    <?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,null,$i,1)?>
                </td>
                <?php for ($k=0;$k<count($dsKhoi);$k++):?>
                    <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowAge($dsKhoi[$k]->MaKhoi,null,$i,1)?></td>
                <?php endfor;?>
            </tr>
        <?php endfor;?>
        <tr>
            <td style="padding-left: 42px">-Trên <?=$tuoKetThuc?> tuổi </td>
            <td style="text-align: center">
                <?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,null,$tuoKetThuc,2)?>
            </td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowAge($dsKhoi[$i]->MaKhoi,null,$tuoKetThuc,2)?></td>
            <?php endfor;?>
        </tr>
    <!-- Kết Thúc-->
    <!--Thống kê theo tổng số học sinh Nữ-->
        <tr style=";background-color: black">
            <td>Số học sinh Nữ theo độ tuổi</td>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,1)?></td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruop($dsKhoi[$i]->MaKhoi,1)?></td>
            <?php endfor;?>
        </tr>
        <tr>
            <td>Chia ra: -Dưới <?=$tuoiBatDau?> tuổi </td>
            <td style="text-align: center">
                <?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,1,$tuoiBatDau,0)?>
            </td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowAge($dsKhoi[$i]->MaKhoi,$tuoiBatDau,0)?></td>
            <?php endfor;?>
        </tr>
        <?php for ($i=$tuoiBatDau;$i<=$tuoKetThuc;$i++):?>
            <tr>
                <td style="padding-left: 42px">-<?=$i." Tuổi"?> </td>
                <td style="text-align: center">
                    <?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,1,$i,1)?>
                </td>
                <?php for ($k=0;$k<count($dsKhoi);$k++):?>
                    <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowAge($dsKhoi[$k]->MaKhoi,1,$i,1)?></td>
                <?php endfor;?>
            </tr>
        <?php endfor;?>
        <tr>
            <td style="padding-left: 42px">-Trên <?=$tuoKetThuc?> tuổi </td>
            <td style="text-align: center">
                <?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel,1,$tuoKetThuc,2)?>
            </td>
            <?php for ($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowAge($dsKhoi[$i]->MaKhoi,1,$tuoKetThuc,2)?></td>
            <?php endfor;?>
        </tr>
    <tr style=";background-color: #d3d3d3">
        <td style=""> Số học sinh Dân tộc theo độ tuổi</td>
        <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInAllLevel($idLevel)?></td>
        <?php for ($i=0;$i<count($dsKhoi);$i++):?>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInGruop($dsKhoi[$i]->MaKhoi)?></td>
        <?php endfor;?>
    </tr>
    <tr>
        <td>Chia ra: -Dưới <?=$tuoiBatDau?> tuổi </td>
        <td style="text-align: center">
            <?=DsHocSinhBLL::getCountStudentInAllLevelFollowNation($idLevel,$tuoiBatDau,0)?>
        </td>
        <?php for ($i=0;$i<count($dsKhoi);$i++):?>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowNation($dsKhoi[$i]->MaKhoi,$tuoiBatDau,0)?></td>
        <?php endfor;?>
    </tr>
    <?php for ($i=$tuoiBatDau;$i<=$tuoKetThuc;$i++):?>
        <tr>
            <td style="padding-left: 42px">-<?=$i." Tuổi"?> </td>
            <td style="text-align: center">
                <?=DsHocSinhBLL::getCountStudentInAllLevelFollowNation($idLevel,$i,1)?>
            </td>
            <?php for ($k=0;$k<count($dsKhoi);$k++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowNation($dsKhoi[$k]->MaKhoi,$i,1)?></td>
            <?php endfor;?>
        </tr>
    <?php endfor;?>
    <tr>
        <td style="padding-left: 42px">-<?= "Trên ". $tuoKetThuc."tuổi"?> </td>
        <td style="text-align: center">
            <?=DsHocSinhBLL::getCountStudentInAllLevelFollowNation($idLevel,$tuoKetThuc,2)?>
        </td>
        <?php for ($k=0;$k<count($dsKhoi);$k++):?>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountStudentInAllGruopFollowNation($dsKhoi[$k]->MaKhoi,$tuoKetThuc,2)?></td>
        <?php endfor;?>
    </tr>
    </tbody>
</table>
<table style="width: 100%">
    <tbody>
    <tr>
        <td width="50%"></td>
        <td style="text-align: center"><p><i>Sơn La, ngày...tháng...năm 20..</i></p></td>
    </tr>
    <tr>
        <td width="" style="text-transform: uppercase; font-weight: bold;text-align: center"><p>NGƯỜI LẬP BIỂU</p></td>
        <td width="" style="text-transform: uppercase; font-weight: bold;text-align: center"><p>HIỆU TRƯỞNG</p></td>
    </tr>
    </tbody>
</table>
</body>
</html>