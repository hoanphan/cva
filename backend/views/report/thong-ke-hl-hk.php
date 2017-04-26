<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/10/2016
 * Time: 2:20 PM
 */
use backend\BLL\DsHocSinhBLL;
use backend\BLL\HanhKiemHocLucBLL;
use backend\BLL\ThongKeDanhHieuBLL;
use backend\models\DmDanToc;
use backend\models\DMHanhKiem;
use backend\models\DmHocLuc;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DSTuan;
$bundel=\backend\assets\AppAsset::register($this);
$dsKhoi=DSKhoi::find()->where(['MaCap'=>$MaCap])->all();
$dsHocLuc=DmHocLuc::find()->all();
$dsHanhKiem=DMHanhKiem::find()->all();
?>
<html>
<head>

</head>
<body style="font-size: 14pt; font-family: 'TimeRomanNormal'">
<body lang='vi'>
<table class="col-xs-12" style="width: 100%">
    <tbody>
    <tr class="col-xs-6">


        <td style="text-align: center">
            <?php if($MaCap=="TTHCS"):?>
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
    <b>BIỂU THỐNG KÊ KẾT QUẢ HỌC TẬP RÈN</b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b>LUYỆN THEO HẠNH KIỂM - HỌC LỰC</b>
</div>

<div style="text-transform: uppercase; text-align: center">
    <b>HỌC KỲ I <?=DSHocKy::getNameSemester($MaHocKy)?> NĂM HỌC <?=DSNamHoc::getNameCurrentYear()?></b>
</div>
<div>
    <table style="width: 100%; border-spacing: 0px" ; border="1">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center">Đánh giá học sinh</th>
                <th rowspan="2" style="text-align: center">Tổng số</th>
                <th colspan="<?=count($dsKhoi)?>" style="text-align: center">Tổng số</th>
            </tr>
            <tr>
                <?php for($i=0;$i<count($dsKhoi);$i++):?>
                <th rowspan="" style="text-align: center">Lớp <?=$dsKhoi[$i]->TenKhoi?></th>
                <?php endfor;?>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #adadad">
                <td>Số học sinh chia theo hạnh kiểm</td>
                <td style="text-align: center">
                    <?=DsHocSinhBLL::getCountStudentInAllLevel($MaCap)?>
                </td>
                <?php for($i=0;$i<count($dsKhoi);$i++):?>
                    <td rowspan="" style="text-align: center"> <?=DsHocSinhBLL::getCountStudentInAllGruop($dsKhoi[$i]->MaKhoi)?></td>
                <?php endfor;?>
            </tr>
            <?php for ($i=0;$i<count($dsHanhKiem);$i++):?>
            <tr style="background-color: #cecece">
                <?php if($i==0):?>
                <td>Chia ra: -<?=$dsHanhKiem[$i]->TenHanhKiem?></td>
                <?php else:?>
                    <td style="padding-left: 42px">-<?=$dsHanhKiem[$i]->TenHanhKiem?></td>
                <?php endif;?>
                <td style="text-align: center"><?=HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevel($MaCap,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem)?></td>
                <?php for($j=0;$j<count($dsKhoi);$j++):?>
                <td style="text-align: center"><?=HanhKiemHocLucBLL::getSLHocLucHanhKiem($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem);
                    ?>
                </td>
                    <?php endfor;?>

            </tr>
                <tr >
                    <td style="padding-left: 82px">
                        Trong TS: + Nữ
                    </td>
                    <td style="text-align: center">
                        <?= HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevelWoman($MaCap,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem)?>
                    </td >
                    <?php for ($j=0;$j<count($dsKhoi);$j++):?>
                        <td style="text-align: center">
                            <?=HanhKiemHocLucBLL::getSLHocLucHanhKiemAllGruopWoman($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem)?>
                        </td>
                    <?php endfor;?>
                </tr>
                <tr>
                    <td style="padding-left: 140px" >
                        + Dân tộc
                    </td>
                    <td style="text-align: center">
                        <?= HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevelNation($MaCap,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem)?>
                    </td>
                    <?php for ($j=0;$j<count($dsKhoi);$j++):?>
                        <td style="text-align: center">
                            <?=HanhKiemHocLucBLL::getSLHocLucHanhKiemNation($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem)?>
                        </td>
                    <?php endfor;?>
                </tr>
                <tr>
                    <td style="padding-left: 140px" >
                        + Nữ dân tộc
                    </td>
                    <td style="text-align: center">
                        <?= HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevelNationWormen($MaCap,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem)?>
                    </td>
                    <?php for ($j=0;$j<count($dsKhoi);$j++):?>
                        <td style="text-align: center">
                            <?=HanhKiemHocLucBLL::getSLHocLucHanhKiemNationWormen($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHanhKiem[$i]->MaHanhKiem)?>
                        </td>
                    <?php endfor;?>
                </tr>
        <?php endfor;?>
            <tr style="background-color: #adadad">
                <td>Số học sinh chia theo học lực</td>
                <td style="text-align: center">
                    <?=DsHocSinhBLL::getCountStudentInAllLevel($MaCap)?>
                </td>
                <?php for($i=0;$i<count($dsKhoi);$i++):?>
                    <td rowspan="" style="text-align: center"> <?=DsHocSinhBLL::getCountStudentInAllGruop($dsKhoi[$i]->MaKhoi)?></td>
                <?php endfor;?>
            </tr>
            <?php for ($i=0;$i<count($dsHocLuc);$i++):?>
                <tr style="background-color: #cecece">
                    <?php if($i==0):?>
                        <td>Chia ra: -<?=$dsHocLuc[$i]->TenHocLuc?></td>
                    <?php else:?>
                        <td style="padding-left: 42px">-<?=$dsHocLuc[$i]->TenHocLuc?></td>
                    <?php endif;?>
                    <td style="text-align: center"><?=HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevel($MaCap,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,"a")?></td>
                        <?php for($j=0;$j<count($dsKhoi);$j++):?>
                    <td style="text-align: center"><?=HanhKiemHocLucBLL::getSLHocLucHanhKiem($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,1);
                        ?>
                    </td>
                <?php endfor;?>

                </tr>
                <tr >
                    <td style="padding-left: 82px">
                        Trong TS: + Nữ
                    </td>
                    <td style="text-align: center">
                        <?= HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevelWoman($MaCap,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,1)?>
                    </td >
                    <?php for ($j=0;$j<count($dsKhoi);$j++):?>
                        <td style="text-align: center">
                            <?=HanhKiemHocLucBLL::getSLHocLucHanhKiemAllGruopWoman($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,1)?>
                        </td>
                    <?php endfor;?>
                </tr>
                <tr>
                    <td style="padding-left: 140px" >
                        + Dân tộc
                    </td>
                    <td style="text-align: center">
                        <?= HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevelNation($MaCap,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,1)?>
                    </td>
                    <?php for ($j=0;$j<count($dsKhoi);$j++):?>
                        <td style="text-align: center">
                            <?=HanhKiemHocLucBLL::getSLHocLucHanhKiemNation($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,1)?>
                        </td>
                    <?php endfor;?>
                </tr>
                <tr>
                    <td style="padding-left: 140px" >
                        + Nữ dân tộc
                    </td>
                    <td style="text-align: center">
                        <?= HanhKiemHocLucBLL::getSLHocLucHanhKiemAllLevelNationWormen($MaCap,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,1)?>
                    </td>
                    <?php for ($j=0;$j<count($dsKhoi);$j++):?>
                        <td style="text-align: center">
                            <?=HanhKiemHocLucBLL::getSLHocLucHanhKiemNationWormen($dsKhoi[$j]->MaKhoi,$MaHocKy,$dsHocLuc[$i]->MaHocLuc,1)?>
                        </td>
                    <?php endfor;?>
                </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>
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