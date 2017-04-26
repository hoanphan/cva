<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/10/2016
 * Time: 2:20 PM
 */
use backend\BLL\DsDiemBLL;
use backend\BLL\DsHocSinhBLL;
use backend\BLL\DSMonHocBLL;
use backend\BLL\DsMonHocTheoLopBLL;
use backend\models\DmDanToc;
use backend\models\DSHocKy;
use backend\models\DSKhoi;
use backend\models\DSNamHoc;
$dsHocLuc=\backend\models\DmHocLuc::find()->all();
$dsDanToc=DmDanToc::find()->where(['ThongKeDanToc'=>1])->all();
$dsMonHoc=DSMonHocBLL::LayDanhSachMonHocTheoCap($idLevel);
$idYear=DSNamHoc::getCurrentYear();
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
    <b>BIỂU THỐNG KÊ TỈ LỆ PHẦN TRĂM</b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b>ĐIỂM GIỎI, KHÁ, TRUNG BÌNH, YẾU, KÉM</b>
</div>
<div style="text-transform: uppercase; text-align: center">
    <b style="text-transform: uppercase"><?=DSHocKy::getNameSemester($idSemester).'     - NĂM HỌC '.DSNamHoc::getNameCurrentYear()?></b>
</div>
<table style="width: 100%; border-spacing: 0px"; border="1">
    <thead >
        <tr style="background: #bababa; text-align: center">
            <th rowspan="2" style="text-align: center;width: 150px">Môn</th>
            <th rowspan="2" style="text-align: center;width: 150px">Tổng số</th>

            <?php for ($i=0;$i<count($dsHocLuc);$i++):?>
                <th colspan="2" style="text-align: center"><?=$dsHocLuc[$i]->TenHocLuc?></th>
            <?php endfor;?>

        </tr>
    <tr style="background: #bababa; text-align: center;">
        <?php for ($i=0;$i<count($dsHocLuc);$i++):?>
            <th rowspan="1" style="text-align: center">TS</th>
            <th rowspan="1" style="text-align: center">%</th>
        <?php endfor;?>
    </tr>

    </thead>
    <tbody>
        <?php for ($i=0;$i<count($dsMonHoc);$i++):?>
            <tr>
                <td style="text-align: center"><?=$dsMonHoc[$i]->TenMonHoc?></td>
                <td style="text-align: center"><?php $ts= DsMonHocTheoLopBLL::LaySoLuongHocSinhHocMonHocCap($idLevel,$dsMonHoc[$i]->MaMonHoc); echo  $ts?></td>
                <?php for ($j=0;$j<count($dsHocLuc);$j++):?>
                    <td style="text-align: center; font-weight: bold"><?php $sl=DsDiemBLL::KiemTraDiemTrongKhoang($idLevel,$dsHocLuc[$j]->MaHocLuc,$dsMonHoc[$i]->MaMonHoc,$idYear);
                        echo $sl;
                    ?></td>
                    <td style="text-align: center">
                        <?php if($ts!=0):?>
                        <?= round($sl/$ts,3)*100?>
                        <?php else:?>
                        0
                        <?php endif;?>
                    </td>
                <?php endfor;?>

            </tr>
        <?php endfor;?>
    </tbody>
</table>
<p style="padding-left: 50px"><i>Lưu ý: Đối với các môn đánh giá bằng nhận xét thì Thống kê điểm Đạt trong cột Giỏi, điểm Chưa đạt trong cột Yếu</i></p>
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

