<?php
use backend\models\DsMonHoc;
use backend\models\DsHocSinhChuyenTruong;
use backend\models\DsHocSinh;
use backend\models\DSTuan;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 4/20/2017
 * Time: 9:20 AM
 */
/**
 * @var \frontend\models\DsMonHocTheoLop[] $subjects
 * @var \backend\models\DsHocSinhChuyenTruong[] $listStudent
 **/
?>
<style>
    table {
        border-color: #0a0a0a;
    }
</style>
<div class="container" style="margin-bottom: 20px">
    <div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" id="widget-container-col-1">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Lưu</button>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn lưu dữ liệu này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="save">Đồng ý</button>
            </div>
        </div>
    </div>
</div>
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
                                <th class="floatThead-col" rowspan="2" style="text-align: center">STT</th>
                                <th class="floatThead-col" rowspan="2" width="8%" style="text-align: center">Mã học
                                    sinh
                                </th>
                                <th class="floatThead-col" rowspan="2" width="14%" style="text-align: center">Tên học
                                    sinh
                                </th>
                                <th class="floatThead-col" rowspan="2" width="10%" style="text-align: center">Ngày sinh
                                </th>
                                <?php foreach ($subjects as $subject): ?>
                                    <th style="text-align: center"> <?= DsMonHoc::findOne($subject->MaMonHoc)->TenMonHoc ?></th>
                                <?php endforeach; ?>
                            </tr>

                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php
                            foreach ($listStudent as $student): ?>
                                <?php if ($student->HevNen != DsHocSinhChuyenTruong::IS_HEVNEN): ?>
                                    <?php $hs = DsHocSinh::findOne($student->MaHocSinh) ?>
                                    <tr>
                                        <td style="text-align: center"><?= $i ?> </td>
                                        <td style="text-align: center">
                                            <?= $student->MaHocSinh ?>
                                        </td>
                                        <td style="text-align: center">
                                            <?php echo $hs->HoDem . ' ' . $hs->Ten ?>
                                        </td>
                                        <td style="text-align: center">
                                            <?php if ($student != null): ?>
                                                <?= DSTuan::formatDate($hs->NgaySinh) ?>
                                            <?php else: ?>
                                                <?= 'Unknown' ?>
                                            <?php endif; ?>
                                        </td>
                                        <?php foreach ($subjects as $subject): ?>
                                            <?= \backend\models\DsDiem::findScoresSummary($student->MaHocSinh, $subject->MaMonHoc) ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
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
<div class="modal fade" id="modalEror" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                Trường dữ liệu bạn nhập chưa đúng, vui lòng kiểm tra lại?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="save">Đồng ý</button>
            </div>
        </div>
    </div>
</div>
<script>
    var dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang lưu xin chờ 1 chút....</h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');
    var kt = 0;
    $(document).on('click', '#save', function () {
        $('#myModal').modal('hide');
        dialog.modal();
        var arr = [];
        Invalid();
        if (kt!=1) {
            $('tbody').find('tr').find('input[type="text"]').each(function () {
                var value = $(this).val();
                var name = $(this).attr('id');
                if (value != '-')
                    var res = name.split('_');
                arr.push({
                    MaHocSinh: res[0],
                    MaMonHoc: res[1],
                    value:value
                });
            });
            $.ajax({
                url:'<?=Url::to(['save'])?>',
                type:'POST',
                dataType:'json',
                data:{
                    arr:JSON.stringify(arr)
                },
                success:function (result) {
                    window.location.reload();
                },

            })
        }
    });
    function Invalid() {
        $('tbody').find('tr').find('input[type="text"]').each(function () {
            var value = $(this).val();
            if (value != "-") {
                if (!$.isNumeric(value))
                    kt = 1;
                else {
                    if (parseInt(value) != -2 || parseInt(value) != -3) {
                        if (parseInt(value) > 10 || parseInt(value) < 0)
                            kt = 1;
                    }
                }
            }
        });
        if (kt == 1) {
            dialog.modal('hide');
            $('#modalEror').modal();
        }
    }
</script>