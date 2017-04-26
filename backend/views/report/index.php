<?php
/**
 * Created by PhpStorm.
 * User: PHANHOANDHTB
 * Date: 11/3/2016
 * Time: 12:24 AM
 */
use backend\models\DsHocSinh;
use backend\models\DSTuan;
use backend\models\DsDiem;

$bundel = \backend\assets\AppAsset::register($this);
$listTypeScroses = \backend\models\DsLoaiDiem::find()->all();
$model = \backend\models\DSHocSinhTheoLop::getListStudentFollowClass($idClass);
$idTeacher = \backend\models\PhanCongGiangDay::getTeacherFollowSubject($idSubject, $idClass, $idSemester);
?>
<html>
<head></head>
<body style="font-family: 'Times New Roman'">
<div class="table" style="text-align: center;">
    <table style="width: 100%; text-align: center">
        <tr>
            <td rowspan="3"><img src="<?= $bundel->baseUrl ?>/images/logo.png"></td>
        </tr>
        <tr>
            <td colspan="4" style="font-size: 14pt; font-family:'Times New Roman'"><b>BẢNG ĐIỂM TỔNG KẾT MÔN HỌC</b>
            </td>
        </tr>
        <tr>
            <td>
                <b>Lớp: </b> <?= \backend\models\DsLop::getNameClass($idClass) ?>
            </td>
            <td>
                <b>Học kỳ: </b><?= \backend\models\DSHocKy::getNameSemester($idSemester) ?>
            </td>
            <td>
                <b> Năm học: </b> <?= \backend\models\DSNamHoc::getNameCurrentYear() ?>

            </td>
            <td>
                <b> Môn học: </b> <?= \backend\models\DsMonHoc::getNameSubject($idSubject) ?>
            </td>
        </tr>
    </table>
</div>
<div>
    <table class="" style="text-align: center;width: 100%; border-spacing: 0px;border: solid 1px black">
        <thead>
        <tr style="right: 30px">
            <th style="text-align: center; background-color: #d3d3d3;border-bottom: 1px solid black;border-right: 1px solid black"
                rowspan="2">STT
            </th>
            <th style="text-align: center; background-color: #d3d3d3;border-bottom: 1px solid black;border-right: 1px solid black"
                rowspan="2">Mã HS
            </th>
            <th style="text-align: center; background-color: #d3d3d3;border-bottom: 1px solid black;border-right: 1px solid black"
                rowspan="2">Họ và tên
            </th>
            <th style="text-align: center;background-color: #d3d3d3;border-bottom: 1px solid black;border-right: 1px solid black"
                rowspan="2">Ngày sinh
            </th>
            <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                    <th style="text-align: center;background-color: #d3d3d3;border-bottom: 1px solid black;border-right: 1px solid black"
                        colspan="<?= $listTypeScroses[$i]->SoDiemToiDa ?>"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                <?php elseif ($listTypeScroses[$i]->SoDiemToiDa == 1): ?>
                    <th class="" rowspan="2"
                        style="width: 40px; text-align: center;background-color: #d3d3d3;border-bottom: 1px solid black;border-right: 1px solid black"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if($idSemester=='K2'):?>
            <th style="text-align: center;background-color: #d3d3d3;border-bottom: 1px solid black;border-right: 1px solid black"
                rowspan="2">TBC cả năm
            </th>
            <?php endif;?>
        </tr>
        <tr class="size-row">
            <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                <?php for ($j = 1; $j <= $listTypeScroses[$i]->SoDiemToiDa; $j++): ?>
                    <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                        <th class=""
                            style="width: 40px; text-align: center; background-color: #d3d3d3; border-bottom: 1px solid black;border-right: 1px solid black"><?= $listTypeScroses[$i]->HienThi . $j ?> </th>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endfor; ?>
        </tr>
        </thead>
        <tbody>
        <?php $tabindex = 0 ?>
        <?php for ($i = 0; $i < count($model); $i++): ?>
            <?php $student = DsHocSinh::getStudent($model[$i]->MaHocSinh) ?>
            <tr>
                <td style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black"> <?= $model[$i]->STT ?></td>
                <td style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black">
                    <?= $model[$i]->MaHocSinh ?>
                </td>
                <td style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black">
                    <?php echo DsHocSinh::getFullName($model[$i]->MaHocSinh) ?>
                </td>
                <td style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black">
                    <?php if ($student != null): ?>
                        <?= DSTuan::formatDate($student->NgaySinh) ?>
                    <?php else: ?>
                        <?= 'Unknown' ?>
                    <?php endif; ?>
                </td>
                <?php for ($k = 0; $k < count($listTypeScroses); $k++): ?>
                    <?php for ($j = 1; $j <= $listTypeScroses[$k]->SoDiemToiDa; $j++): ?>
                        <?= $scroses = DsDiem::findScroseReport($model[$i]->MaHocSinh, \backend\models\DSNamHoc::getCurrentYear(), $idSubject, $idSemester, $listTypeScroses[$k]->MaLoaiDiem, $j) ?>
                    <?php endfor; ?>
                <?php endfor; ?>
                <?php if($idSemester=='K2'):?>
                    <?= $scroses = DsDiem::findScroseReport2($model[$i]->MaHocSinh, \backend\models\DSNamHoc::getCurrentYear(), $idSubject, 'K3', 'LD5',1) ?>
                <?php endif;?>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>
<br>
<div>
    <table style="width: 100%">
        <tbody>
        <tr>
            <td style="width: 70%"></td>
            <td style="text-align: center"><b>Giáo viên bộ môn</b></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center"><br/><br/><b><?= \backend\models\DsGiaoVien::getFullName($idTeacher) ?></b>
            </td>
        </tr>
        </tbody>


    </table>
</div>
</div>
</body>
</html>