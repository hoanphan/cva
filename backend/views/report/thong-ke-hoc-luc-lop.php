<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/9/2016
 * Time: 10:27 AM
 */
use backend\models\DmDanhHieu;
use backend\models\DsDiem;
use backend\models\DSNamHoc;
use backend\models\DsHocSinh;
use backend\models\DSTuan;
use backend\models\DMHanhKiem;
use backend\models\DmHocLuc;

$model = \backend\models\DSHocSinhTheoLop::find()->where(['MaLop' => $idClass, 'MaNamHoc' => \backend\models\DSNamHoc::getCurrentYear()])->orderBy(['STT' => SORT_ASC])->all();
$bundel = \backend\assets\AppAsset::register($this);
$listSubject = \backend\BLL\DsMonHocTheoLopBLL::getListSubjectFollowClass($idClass, $idSemester);
$idTypeScrose = \backend\models\DsLoaiDiem::LoadLoaiDiemTongHop();
$listCappacity = \backend\models\DmHocLuc::find()->all();
$listConduct = DMHanhKiem::find()->all();
$listAppellation=DmDanhHieu::find()->where(['>','ingiaykhen',0])->orderBy(['mucuutien'=>SORT_ASC])->all();
?>
<html>
<head></head>
<body lang="vi">
<div class="table" style="text-align: center;">
    <table style="width: 100%; text-align: center;" >
        <tr>
            <td rowspan="3"><img src="<?= $bundel->baseUrl ?>/images/logo.png"></td>
        </tr>
        <tr>
            <td colspan="4" style="font-size: 14pt; font-family:'Times New Roman'"><b>BẢNG ĐIỂM TỔNG KẾT LỚP</b>
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
        </tr>
    </table>
</div>
<div>
    <table class="" style="text-align: center;width: 100%; border-spacing: 0px" ; border="1">
        <thead>
        <tr style="right: 30px">
            <th style="text-align: center; background-color: #d3d3d3;"
            >STT
            </th>
            <th style="text-align: center; background-color: #d3d3d3;"
            >Mã HS
            </th>
            <th style="text-align: center; background-color: #d3d3d3;"
            >Họ và tên
            </th>
            <th style="text-align: center;background-color: #d3d3d3;">Ngày sinh
            </th>
            <?php for ($i = 0; $i < count($listSubject); $i++): ?>
                <th style="text-align: center;background-color: #d3d3d3;width: 42px"><?= \backend\models\DsMonHoc::getNameSubject($listSubject[$i]->MaMonHoc) ?></th>
            <?php endfor; ?>
            <th style="text-align: center;background-color: #d3d3d3;">TBC</th>
            <th style="text-align: center;background-color: #d3d3d3;">Học lực</th>
            <th style="text-align: center;background-color: #d3d3d3;width: 60px">Hạnh kiểm</th>
            <th style="text-align: center;background-color: #d3d3d3;width: 80px">Danh hiệu</th>

        </tr>

        </thead>
        <tbody>

        <?php for ($i = 0; $i < count($model); $i++): ?>
            <?php $student = DsHocSinh::getStudent($model[$i]->MaHocSinh) ?>
            <?php if ($i % 2 != 0): ?>
                <tr style=" background-color: #d3d3d3;">
            <?php else: ?>
                <tr style=" ">
            <?php endif; ?>
            <td style="text-align: center;"> <?= $model[$i]->STT ?></td>
            <td style="text-align: center;">
                <?= $model[$i]->MaHocSinh ?>
            </td>
            <td style="text-align: center;">
                <?php echo DsHocSinh::getFullName($model[$i]->MaHocSinh) ?>
            </td>
            <td style="text-align: center;">
                <?php if ($student != null): ?>
                    <?= DSTuan::formatDate($student->NgaySinh) ?>
                <?php else: ?>
                    <?= ' ' ?>
                <?php endif; ?>
            </td>
            <?php for ($k = 0; $k < count($listSubject); $k++): ?>
                <td> <?= DsDiem::getScoresFollowStudentReport($model[$i]->MaHocSinh, DSNamHoc::getCurrentYear(), $idSemester, $listSubject[$k]->MaMonHoc, $idTypeScrose, 1) ?></td>
            <?php endfor; ?>
            <?php $TongKet = \backend\BLL\DsTongKetBLL::getTongKet($idSemester, $model[$i]->MaHocSinh) ?>
            <td><p><b><?php if(isset($TongKet->TrungBinhChung))
                                echo $TongKet->TrungBinhChung;
                            else
                                echo "";
                ?></b></p></td>
            <td><p><?php
                    if(isset($TongKet->MaHocLuc))
                    echo \backend\models\DmHocLuc::GetLearningCapacity($TongKet->MaHocLuc);
                    else
                        echo "";
                        ?></p></td>
            <td><p><?php
                    if(isset($TongKet->MaHanhKiem))
                        echo \backend\models\DMHanhKiem::getNameConduct($TongKet->MaHanhKiem);
                    else
                        echo "";
                    ?>
                    </p></td>
            <td><p><b><?php
                        if(isset($TongKet->MaDanhHieu))
                            echo \backend\models\DmDanhHieu::getNameAppellation($TongKet->MaDanhHieu) ;
                        else
                            echo "";
                        ?>
                       </b></p></td>
            </tr>
        <?php endfor; ?>
        </tbody>
        -->
    </table>
</div>
<div>
    <table style="width: 95%">
        <tbody>
        <tr>
            <td style="width: 40%">
                <table border="1" style="border-spacing: 0px">
                    <thead>
                    <tr>
                        <th colspan="<?= count($listCappacity) + 1 ?>"
                            style="background-color: #d3d3d3; text-align: center"><b>Thống kê theo Học lực</b></th>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b>Học lực</b></td>
                        <?php for ($i = 0; $i < count($listCappacity); $i++): ?>
                            <th style="text-align: center;width: 62px"><?= $listCappacity[$i]->TenHocLuc ?></th>
                        <?php endfor; ?>
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <td>Số lượng</td>
                        <?php for ($i = 0; $i < count($listCappacity); $i++): ?>
                            <td style="text-align: center"><?= DmHocLuc::getCountCaptionFollowClass($model, $idSemester, $listCappacity[$i]->MaHocLuc) . '/' . count($model) ?></td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td>Phần trăm(%)</td>
                        <?php for ($i = 0; $i < count($listCappacity); $i++): ?>
                            <td style="text-align: center"><?= round(DmHocLuc::getCountCaptionFollowClass($model, $idSemester, $listCappacity[$i]->MaHocLuc) / count($model)*100, 1) ?></td>
                        <?php endfor; ?>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 40%">
                <table border="1" style="border-spacing: 0px">
                    <thead>
                    <tr>
                        <th colspan="<?= count($listConduct) + 1 ?>"
                            style="background-color: #d3d3d3; text-align: center"><b>Thống kê theo Hạnh kiểm</b></th>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b>Hạnh kiểm</b></td>
                        <?php for ($i = 0; $i < count($listConduct); $i++): ?>
                            <th style="text-align: center;width: 62px"><?= $listConduct[$i]->TenHanhKiem ?></th>
                        <?php endfor; ?>
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <td>Số lượng</td>
                        <?php for ($i = 0; $i < count($listConduct); $i++): ?>
                            <td style="text-align: center"><?= DMHanhKiem::getCountConductFollowClass($model, $idSemester, $listConduct[$i]->MaHanhKiem) . '/' . count($model) ?></td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td>Phần trăm(%)</td>
                        <?php for ($i = 0; $i < count($listConduct); $i++): ?>
                            <td style="text-align: center"><?= round(DMHanhKiem::getCountConductFollowClass($model, $idSemester, $listConduct[$i]->MaHanhKiem) / count($model)*100, 1) ?></td>
                        <?php endfor; ?>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 20%;text-align: center;align-items: center; padding-left: 30px" rowspan="2">
                <table>
                    <tbody>
                    <tr>
                        <td><b>Giáo viên chủ nhiệm</b></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td  style="height: 150px">
                            <b><?=\backend\models\DsLop::getHomeroomTeacher($idClass)?></b></td>
                    </tr>

                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 40%">
                <table border="1" style="border-spacing: 0px">
                    <thead>
                    <tr>
                        <th colspan="<?= count($listAppellation) + 1 ?>"
                            style="background-color: #d3d3d3; text-align: center"><b>Thống kê theo Hạnh kiểm</b></th>
                    </tr>
                    <tr>
                        <td style="text-align: center; width: 190px"><b>Danh hiệu</b></td>
                        <?php for ($i = 0; $i < count($listAppellation); $i++): ?>
                            <th style="text-align: center;width: 110px"><?= $listAppellation[$i]->tendanhhieu ?></th>
                        <?php endfor; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Danh hiệu</td>
                        <?php for ($i = 0; $i < count($listAppellation); $i++): ?>
                            <td style="text-align: center"><?= DmDanhHieu::getCountAppletionFollowClass($model, $idSemester, $listAppellation[$i]->madanhhieu) . '/' . count($model) ?></td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td>Phần trăm (%)</td>
                        <?php for ($i = 0; $i < count($listAppellation); $i++): ?>
                            <td style="text-align: center"><?= round(DmDanhHieu::getCountAppletionFollowClass($model, $idSemester, $listAppellation[$i]->madanhhieu)/ count($model)*100, 1) ?></td>
                        <?php endfor; ?>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
