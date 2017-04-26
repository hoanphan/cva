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
$dsKhoi=DSKhoi::find()->where(['MaCap'=>$idLevel])->orderBy(['TenKhoi'=>SORT_ASC])->all();
$dsDanToc=DmDanToc::find()->where(['ThongKeDanToc'=>1])->all();
?>
<html>
<head>

</head>
<body style="font-size: 14pt; font-family: 'Times New Roman'">
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
    <b>BIỂU THỐNG KÊ THEO DÂN TỘC</b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b style="text-transform: uppercase"><?=DSHocKy::getNameSemester($idSemester).'     - NĂM HỌC '.DSNamHoc::getNameCurrentYear()?></b>
</div>
<table style="width: 100%; border-spacing: 0px"; border="1">
    <thead >
        <tr style="background: #bababa; text-align: center">
            <th rowspan="3" style="text-align: center;width: 250px">Dân tộc</th>
            <th rowspan="3" style="text-align: center">Tổng số</th>
            <th rowspan="3" style="text-align: center">Nữ</th>
            <th colspan="<?=count($dsKhoi)*2?>" style="text-align: center">Chia ra</th>

        </tr>
    <tr style="background: #bababa; text-align: center;">
        <?php for($i=0;$i<count($dsKhoi);$i++):?>
            <th colspan="2" style="text-align: center"><?='Lớp '.$dsKhoi[$i]->TenKhoi?></th>
        <?php endfor;?>
    </tr>
    <tr style="background: #bababa;">
        <?php for($i=0;$i<count($dsKhoi);$i++):?>
            <th style="text-align: center">TS</th>
            <th style="text-align: center">Nữ</th>
        <?php endfor;?>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tổng số</td>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInAllLevel($idLevel)?></td>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInAllLevelAndWormen($idLevel)?></td>
            <?php for($i=0;$i<count($dsKhoi);$i++):?>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInGruop($dsKhoi[$i]->MaKhoi)?></td>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInGruopWormen($dsKhoi[$i]->MaKhoi)?></td>
            <?php endfor;?>
        </tr>
    <?php for ($i=0;$i<count($dsDanToc);$i++):?>
        <tr>
        <?php if ($i==0):?>
            <td>Chia ra:<?=' '.$dsDanToc[$i]->TenDanToc?></td>
            <?php else:?>
            <td style="padding-left: 56px"><?=' '.$dsDanToc[$i]->TenDanToc?></td>
            <?php endif;?>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInAllLevelFollowNation($idLevel,$dsDanToc[$i]->MaDanToc)?></td>
            <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInAllLevelAndWormenAndNation($idLevel,$dsDanToc[$i]->MaDanToc)?></td>
            <?php for($j=0;$j<count($dsKhoi);$j++):?>
                <td style="text-align: center"><?= DsHocSinhBLL::getCountNationInGruopFollowNation($dsKhoi[$j]->MaKhoi,$dsDanToc[$i]->MaDanToc)?></td>
                <td style="text-align: center"><?=DsHocSinhBLL::getCountNationInGruopWormenNation($dsKhoi[$j]->MaKhoi,$dsDanToc[$i]->MaDanToc)?></td>
            <?php endfor;?>

        </tr>
        <?php endfor;?>
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

