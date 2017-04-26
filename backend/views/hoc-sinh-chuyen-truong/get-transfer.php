<?php
use backend\models\DsHocSinh;
/**

 * @var \backend\models\DSHocSinhTheoLop[] $listStudent

 * @var DsHocSinhChuyenTruong[] $listTransfer ;
 */
?>
<div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" id="widget-container-col-2">
    <div class="widget-box widget-color-blue ui-sortable-handle" id="widget-box-2">
        <div class="widget-header">
            <h5 class="widget-title bigger lighter">
                <i class="ace-icon fa fa-table"></i>
                Danh sách học sinh
            </h5>

        </div>

        <div class="widget-body">
            <div class="widget-main no-padding text-center">
                <table class="table table-bordered">
                    <thead class="thin-border-bottom">
                    <tr>
                        <th class="text-center">
                            STT
                        </th>

                        <th class="text-center">
                            Mã HS
                        </th>
                        <th class="text-center">
                            Họ đệm
                        </th>
                        <th class="text-center">
                            Tên
                        </th>
                        <th class="text-center">
                            Ngày sinh
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php for ($i = 0; $i < count($listStudent); $i++): ?>
                        <tr about="<?= $listStudent[$i]->MaHocSinh ?>" class="hs">
                            <td><?= $i + 1 ?></td>
                            <?php $student = DsHocSinh::getStudent($listStudent[$i]->MaHocSinh) ?>
                            <td><?= $student->MaHocSinh ?></td>
                            <td><?= $student->HoDem ?></td>
                            <td><?= $student->Ten ?></td>
                            <td><?= DSHocSinh::getNgaySinh($student->MaHocSinh) ?></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" id="widget-container-col-2">
    <div class="widget-box widget-color-blue ui-sortable-handle" id="widget-box-2">
        <div class="widget-header">
            <h5 class="widget-title bigger lighter">
                <i class="ace-icon fa fa-table"></i>
                Danh sách chuyển
            </h5>

        </div>

        <div class="widget-body">
            <div class="widget-main no-padding text-center">
                <table class="table table-bordered">
                    <thead class="thin-border-bottom">
                    <tr>
                        <th class="text-center">
                            STT
                        </th>

                        <th class="text-center">
                            Mã HS
                        </th>
                        <th class="text-center">
                            Họ đệm
                        </th>
                        <th class="text-center">
                            Tên
                        </th>
                        <th class="text-center">
                            Nơi chuyển
                        </th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody id="sd-trasfer">
                        <?php for ($i = 0; $i < count($listTransfer); $i++): ?>
                            <tr id="<?= $listTransfer[$i]->MaHocSinh ?>" class="tf">
                                <td><?= $i + 1 ?></td>
                                <?php $student = DsHocSinh::getStudent($listTransfer[$i]->MaHocSinh) ?>
                                <td><?= $student->MaHocSinh ?></td>
                                <td><?= $student->HoDem ?></td>
                                <td><?= $student->Ten ?></td>
                                <td><?= $listTransfer[$i]->NoiChuyen ?></td>
                                <td><span class="ui-icon  delete" about="<?=$student->MaHocSinh?>"><i class="ace-icon glyphicon glyphicon-trash ui-icon-trash"></i></span></td>
                            </tr>
                        <?php endfor; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
