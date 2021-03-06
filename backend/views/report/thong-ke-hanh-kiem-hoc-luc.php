<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/10/2016
 * Time: 2:20 PM
 */
use backend\BLL\DsHocSinhBLL;
use backend\BLL\HanhKiemHocLucBLL;
use backend\models\DmDanToc;
use backend\models\DMHanhKiem;
use backend\models\DmHocLuc;
use backend\models\DSHocKy;
use backend\models\DSKhoi;
use backend\models\DSNamHoc;

$dsKhoi = DSKhoi::find()->where(['MaCap' => $idLevel])->orderBy(['TenKhoi' => SORT_ASC])->all();
$dsDanToc = DmDanToc::find()->where(['ThongKeDanToc' => 1])->all();
$listHanhKiem=DMHanhKiem::find()->all();
$listHocLuc=DmHocLuc::find()->all();
$listKhoi=DSKhoi::find()->where(['MaCap'=>$idLevel])->all();
$slTong1=0;
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
    <b>THỐNG KÊ KẾT QUẢ XẾP LOẠI HỌC LỰC, HẠNH KIỂM HỌC SINH HỌC <?= DSHocKy::getNameSemester($idSemester) ?></b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b style="text-transform: uppercase"><?= '      NĂM HỌC ' . DSNamHoc::getNameCurrentYear() ?></b>
</div>
<table style="width: 100%; border-spacing: 0px" ; border="1">
    <thead>
        <tr>
            <th rowspan="3" style="width: 94px;text-align: center">
                Lớp
            </th>
            <th style="text-align: center" rowspan="3" style="width: 94px;text-align: center">
                Tổng số
            </th>
            <th style="text-align: center" colspan="<?=count($listHanhKiem)*2?>">
                XẾP LOẠI HẠNH KIỂM
            </th>
            <th style="text-align: center" colspan="<?=count($listHocLuc)*2?>">
                XẾP LOẠI HỌC LỰC
            </th>
            <th rowspan="3" style="width: 120px;text-align: center">
                Ghi chú
            </th>
        </tr>
        <tr>
            <?php for($i=0;$i<count($listHanhKiem);$i++):?>
            <th style="text-align: center" colspan="2"><?=$listHanhKiem[$i]->TenHanhKiem?></th>
            <?php endfor;?>
            <?php for($i=0;$i<count($listHocLuc);$i++):?>
                <th style="text-align: center" colspan="2"><?=$listHocLuc[$i]->TenHocLuc?></th>
            <?php endfor;?>
        </tr>
        <tr>
            <?php for($i=0;$i<count($listHanhKiem);$i++):?>
                <th style="text-align: center">TS</th>
                <th style="text-align: center">%</th>
            <?php endfor;?>
            <?php for($i=0;$i<count($listHocLuc);$i++):?>
                <th style="text-align: center" >TS</th>
                <th style="text-align: center">%</th>
            <?php endfor;?>
        </tr>
    </thead>
    <tbody>
        <?php for ($i=0;$i<count($listKhoi);$i++):?>
            <tr>
                <td style="text-align: center">Lớp <?= $listKhoi[$i]->TenKhoi?></td>
                <td style="text-align: center; font-weight: bold"><?php
                    $slTong1+=$slTong=DsHocSinhBLL::getCountStudentInAllGruop($listKhoi[$i]->MaKhoi);
                    echo $slTong;?>
                </td>
                <?php for ($j=0;$j<count($listHanhKiem);$j++):?>
                    <td style="text-align: center; font-weight: bold"><?php $sl=HanhKiemHocLucBLL::getSLHocLucHanhKiem($listKhoi[$i]->MaKhoi,$idSemester,$listHanhKiem[$j]->MaHanhKiem);
                        echo $sl?>
                    </td>
                    <td style="text-align: center">
                        <?php if($slTong!=0)
                            echo round(($sl/$slTong)*100,1);
                        else
                            echo "0";
                        ?>
                    </td>
                <?php endfor;?>
                <?php for ($j=0;$j<count($listHocLuc);$j++):?>
                    <td style="text-align: center; font-weight: bold"><?php $sl=HanhKiemHocLucBLL::getSLHocLucHanhKiem($listKhoi[$i]->MaKhoi,$idSemester,$listHocLuc[$j]->MaHocLuc,1);
                        echo $sl?>
                    </td>
                    <td style="text-align: center">
                        <?php if($slTong!=0)
                            echo round(($sl/$slTong)*100,1);
                            else
                                echo "0";
                        ?>
                    </td>
                <?php endfor;?>
                <td style="text-align: center">
                    Không xếp loại
                    Hạnh kiểm: 0 ---
                    Không xếp loại
                    Học lực: 0
                </td>
            </tr>
        <?php endfor;?>
        <tr>
            <td style="text-align: center">Tổng số</td>
            <td style="text-align: center; font-weight: bold">
                <?=DsHocSinhBLL::getCountStudentInAllLevel($idLevel)?>
            </td>
            <?php for ($j=0;$j<count($listHanhKiem);$j++):?>
                <td style="text-align: center; font-weight: bold"><?php $sl=HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevel($idLevel,$idSemester,$listHanhKiem[$j]->MaHanhKiem);
                    echo $sl?>
                </td>
                <td style="text-align: center">
                    <?php if($slTong1!=0)
                        echo round(($sl/$slTong1)*100,1);
                    else
                        echo "0";
                    ?>
                </td>
            <?php endfor;?>
            <?php for ($j=0;$j<count($listHocLuc);$j++):?>
                <td style="text-align: center; font-weight: bold"><?php $sl=HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevel($idLevel,$idSemester,$listHocLuc[$j]->MaHocLuc,1);
                    echo $sl?>
                </td>
                <td style="text-align: center">
                    <?php if($slTong1!=0)
                        echo round(($sl/$slTong1)*100,1);
                    else
                        echo "0";
                    ?>
                </td>
            <?php endfor;?>
            <td></td>
        </tr>
    </tbody>
</table>
<table style="width: 100%">
    <tbody>
        <tr>
            <td style="width: 50%"></td>
            <td STYLE="text-align: center"><p><i>Sơn La, ngày tháng năm 20</i></p></td>
        </tr>
        <tr>
            <td style="text-align: center"><p><b>NGƯỜI LẬP BIỂU</b></p></td>
            <td style="text-align: center"><p><b>HIỆU TRƯỞNG</b></p></td>
        </tr>
    </tbody>
</table>
</body>
</html>