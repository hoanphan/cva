<?php
    use  backend\models\DsLoaiDiem;
    use  backend\models\DsHocSinh;
    use    backend\models\DSTuan;
    use    backend\models\DsDiem;

    $listTypeScroses = DsLoaiDiem::find()->orderBy(['MaLoaiDiem'=>SORT_ASC])->all();
    // xanh, tím, vàng, đỏ , lá mạ
    $arrBack=['#99b3ff','#ffb3ff','#ffffb3','#ffb3b3','#70db70'];
?>
<style>
    table{
        border-color: #0a0a0a;
    }
</style>
<div class="col-xs-12">
    <div id="tableresult">
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

                        <table class="table table-striped table-bordered table-hover kv-grid-table kv-table-wrap"
                               style="table-layout: fixed; width: 100%">
                            <thead>
                            <tr class="size-row">
                                <th class="floatThead-col" rowspan="2"  style="text-align: center">STT</th>
                                <th class="floatThead-col" rowspan="2" width="8%"  style="text-align: center">Mã học sinh</th>
                                <th class="floatThead-col" rowspan="2" width="16%"  style="text-align: center">Tên học sinh</th>
                                <th class="floatThead-col" rowspan="2" width="8%"  style="text-align: center">Ngày sinh</th>
                                <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                                    <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                                        <th style="text-align: center"
                                            colspan="<?= $listTypeScroses[$i]->SoDiemToiDa ?>"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                                    <?php elseif ($listTypeScroses[$i]->SoDiemToiDa == 1): ?>
                                        <th style="text-align: center" rowspan="2"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </tr>
                            <tr class="size-row">
                                <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                                    <?php for ($j = 1; $j <= $listTypeScroses[$i]->SoDiemToiDa; $j++): ?>
                                        <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                                            <th class=""
                                                style="width: 20px"><?= $listTypeScroses[$i]->HienThi . '' . $j ?> </th>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php endfor; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $tabindex=0?>
                            <?php for($i=0;$i<count($model);$i++):?>
                            <?php $student= DsHocSinh::getStudent($model[$i]->MaHocSinh)?>
                            <tr>
                                <td style="text-align: center"> <?=$model[$i]->STT?></td>
                                <td style="text-align: center">
                                    <?=$model[$i]->MaHocSinh?>
                                </td>
                                <td  style="text-align: center">
                                    <?php echo DsHocSinh::getFullName($model[$i]->MaHocSinh)?>
                                </td >
                                <td  style="text-align: center">
                                    <?php if($student!=null):?>
                                    <?= DSTuan::formatDate($student->NgaySinh)?>
                                    <?php else:?>
                                    <?='Unknown'?>
                                    <?php endif;?>
                                </td>
                                <?php for ($k = 0; $k < count($listTypeScroses); $k++): ?>
                                    <?php for ($j = 1; $j <= $listTypeScroses[$k]->SoDiemToiDa; $j++): ?>
                                        <?= $scroses=DsDiem::findSocrose($model[$i]->MaHocSinh,$idYear,$Subject,$Semester,$listTypeScroses[$k]->MaLoaiDiem,$j,$tabindex,$arrBack[$k])?>
                                        <?php $tabindex=$tabindex+1?>
                                        <?php endfor;?>
                                <?php endfor;?>
                            </tr>
                            <?php endfor;?>
                            </tbody>

                        </table>
                    </div>
                    <div class="kv-panel-after"></div>
                    <div class="panel-footer">
                        <div class="kv-panel-pager">

                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>