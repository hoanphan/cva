<?php

use frontend\models\DsLoaiDiem;
use frontend\models\DsHocKy;

$bundel = \frontend\assets\AppAsset::register($this);
$listSemester = DsHocKy::find()->all();
$listTypeScroses = DsLoaiDiem::find()->orderBy(['MaLoaiDiem' => SORT_ASC])->all();
$idClass = \frontend\models\DSHocSinhTheoLop::getClassFollowStudent(Yii::$app->user->id);
$idYearCurrent = \frontend\models\DSNamHoc::getCurrentYear();
$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Điểm';
?>

<div id="dsdiem-index">
    <div class="col-xs-12">
        <?php for ($z = 0;
                   $z < count($listSemester);
                   $z++): ?>


            <a id="<?php echo $listSemester[$z]->MaHocKy; ?>">
                <div class="row">
                    <div class="col-xs-5 label label-lg label-info arrowed-in arrowed-right"
                         style="margin-bottom: 5px; text-align: left">
                        <?php echo $listSemester[$z]->TenHocKy; ?>
                    </div>
                </div>

            </a>
            <div class="col-xs-12" id="<?php echo 'a' . $listSemester[$z]->MaHocKy; ?>" style="display: none">

                    <div id="w0-pjax" data-pjax-container="" data-pjax-push-state="" data-pjax-timeout="1000">
                        <div id="w0" class="grid-view hide-resize" data-krajee-grid="kvGridInit_a1899889">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="pull-right">

                                    </div>
                                    <h3 class="panel-title">
                                    </h3>
                                    <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Danh sách điểm</h3>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="kv-panel-before">
                                    <div class="pull-right">
                                        <div class="btn-toolbar kv-grid-toolbar" role="toolbar">


                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>

                                <div id="w0-container" class="table-responsive kv-grid-container">

                                    <table
                                        class="table table-striped table-bordered table-hover col-xs-12"
                                    >
                                        <thead>
                                        <tr class="size-row">
                                            <th class="floatThead-col" rowspan="2" style="text-align: center">#</th>
                                            <th class="floatThead-col" rowspan="2" width="10%"
                                                style="text-align: center">
                                                Tên môn học
                                            </th>
                                            <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                                                <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                                                    <th style="text-align: center"
                                                        colspan="<?= $listTypeScroses[$i]->SoDiemToiDa ?>"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                                                <?php elseif ($listTypeScroses[$i]->SoDiemToiDa == 1): ?>
                                                    <th style="text-align: center"
                                                        rowspan="2"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </tr>
                                        <tr class="size-row">
                                            <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                                                <?php for ($j = 1; $j <= $listTypeScroses[$i]->SoDiemToiDa; $j++): ?>
                                                    <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                                                        <th class=""
                                                            style="text-align: center"><?= $listTypeScroses[$i]->HienThi . '' . $j ?> </th>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            <?php endfor; ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php echo \frontend\models\ListRescroses::getList(Yii::$app->user->id, $listSemester[$z]->MaHocKy, $idClass, $idYearCurrent); ?>

                                        </tbody>

                                    </table>
                                </div>
                                <div class="kv-panel-after"></div>

                            </div>
                        </div>
                    </div>

            </div>

            <script>
                $(document).ready(function () {
                    $('#<?php echo $listSemester[$z]->MaHocKy;?>').click(function () {
                        $("#<?php echo 'a' . $listSemester[$z]->MaHocKy;?>").fadeToggle();
                        var img = $(this).find('.row').find('div');
                        img.removeClass();
                        img.addClass('col-xs-5 label label-lg label-info arrowed-in arrowed-right')

                    });
                })
            </script>
        <?php endfor; ?>
    </div>
</div>