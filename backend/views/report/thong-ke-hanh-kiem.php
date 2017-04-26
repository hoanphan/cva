<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/10/2016
 * Time: 2:20 PM
 */
use backend\BLL\DsHocSinhBLL;
use backend\BLL\DSLopBLL;
use backend\BLL\HanhKiemHocLucBLL;
use backend\models\DmDanToc;
use backend\models\DMHanhKiem;
use backend\models\DmHocLuc;
use backend\models\DSHocKy;
use backend\models\DSKhoi;
use backend\models\DSNamHoc;
$dsHanhKiem=DMHanhKiem::find()->all();
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
    <b> THỐNG KÊ </b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b style="text-transform: uppercase">Chất lượng hạnh kiểm học sinh <?=DSHocKy::getNameSemester($idSemester).'     - NĂM HỌC '.DSNamHoc::getNameCurrentYear()?></b>
</div>
<table style="width: 100%; border-spacing: 0px"; border="1">
    <thead >
        <tr style="background: #bababa; text-align: center">
            <th rowspan="3" style="text-align: center;width: 50px">STT</th>
            <th rowspan="3" style="text-align: center">Trường</th>
            <th rowspan="3" style="text-align: center">Số lớp</th>
            <th rowspan="3" style="text-align: center">Tổng số HS</th>
            <th rowspan="3" style="text-align: center">Tổng số HS dân tộc</th>
            <th colspan="<?=count($dsHanhKiem)*2?>" style="text-align: center">HẠNH KIỂM</th>

        </tr>
    <tr style="background: #bababa; text-align: center;">
        <?php for($i=0;$i<count($dsHanhKiem);$i++):?>
            <th colspan="2" style="text-align: center"><?=$dsHanhKiem[$i]->TenHanhKiem?></th>
        <?php endfor;?>
    </tr>
    <tr style="background: #bababa;">
        <?php for($i=0;$i<count($dsHanhKiem);$i++):?>
            <th style="text-align: center">Số lượng</th>
            <th style="text-align: center">Tỷ lệ %</th>
        <?php endfor;?>
    </tr>
    </thead>
    <tbody>
        <tr style="height: 30px">
            <td style="text-align: center;width: 20px">
                1
            </td>
            <td style="text-align: center">
                Trường Tiểu học, THCS, THPT Chu Văn An
            </td>
            <td style="text-align: center;width: 50px">
                <?=DSLopBLL::getCuontClassInLeve($idLevel)?>
            </td>
            <td style="text-align: center; width: 50px">
                <?php $slTong=DsHocSinhBLL::getCountStudentInAllLevel($idLevel);
                echo  $slTong?>
            </td>
            <td style="text-align: center;width: 50px">
                <?=DsHocSinhBLL::getCountNationInAllLevel($idLevel)?>
            </td>
            <?php for($i=0;$i<count($dsHanhKiem);$i++):?>
                <td  style="text-align: center"><?php $sl=HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevel($idLevel,$idSemester,$dsHanhKiem[$i]->MaHanhKiem);
                echo  $sl;?></td>
                <td  style="text-align: center"><?=round((double)($sl / $slTong), 3)*100?></td>
            <?php endfor;?>
        </tr>
    <tr style="height: 30px">
        <td style="color: white">dsadsad</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>  <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>


    </tr>

        <tr style="height: 30px">
            <td style="color: white">dsadsad</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>  <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>


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

