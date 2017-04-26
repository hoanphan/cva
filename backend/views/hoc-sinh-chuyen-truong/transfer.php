<?php
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DsHocSinhChuyenTruong;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;

/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 4/25/2017
 * Time: 4:00 AM
 */
/**
 * @var DSKhoi $group
 * @var DsLop $class
 * @var \backend\models\DSHocSinhTheoLop[] $listStudent
 * @var  DsHocSinhChuyenTruong $transfer ;
 * @var DsHocSinhChuyenTruong[] $listTransfer ;
 */
?>
<style>
    .active-tr {
        background: #00b3ee;
    }

    .ui-icon-trash {
        color: #DD5A43;
    }
</style>
<?php $form = ActiveForm::begin() ?>
<div class="col-xs-12 col-sm-12 widget-container-col ui-sortable" id="widget-container-col-1">
    <div class=" ui-sortable-handle">
        <div>
            <h5 class="widget-title">Danh sách học sinh chuyển trường</h5>
        </div>

        <div class="widget-body">

            <div class="col-sm-6 widget-container-col ui-sortable" id="widget-container-col-12">
                <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">Tham số</h4>

                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-6 no-padding-left no-padding-right">
                            <div class="col-sm-6">
                                <?= $form->field($group, 'MaKhoi')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(DSKhoi::find()->asArray()->all(), 'MaKhoi', 'TenKhoi')
                                ]); ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($class, 'MaLop')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                    'pluginOptions' => [
                                        'depends' => ['dskhoi-makhoi'],
                                        'initialize' => true,
                                        'url' => Url::to(['/about/class']),
                                        'loadingText' => 'Loading child level 1 ...',
                                    ]
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 widget-container-col ui-sortable" id="widget-container-col-12">
                <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                    <div class="widget-header">
                        <h4 class="widget-title lighter">Tham số</h4>

                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-6 no-padding-left no-padding-right">
                            <div class="col-sm-12 form-inline">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="hidden" name="DsHocSinhChuyenTruong[ChuyenDi]" value="">
                                        <div><label class="radio-inline"><input
                                                        type="radio" id="dshocsinhchuyentruong-chuyendi1"
                                                        checked="checked">Chuyển
                                                đến</label>
                                            <label class="radio-inline"><input type="radio"
                                                                               id="dshocsinhchuyentruong-chuyendi2">Chuyển
                                                đi</label></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                   Hệ VNen <input type="checkbox" id="dshocsinhchuyentruong-hevnen"
                                           name="DsHocSinhChuyenTruong[HevNen]">
                                </div>
                                <div class="form-group">
                                    <?= $form->field($transfer, 'MaHocKy')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(DSHocKy::find()->where(['TongHop' => 0])->asArray()->all(), 'MaHocKy', 'TenHocKy')
                                    ])->label(false); ?>
                                </div>
                            </div>
                            <div class="col-sm-12  form-inline">
                                <div class=" form-group">
                                    <?= $form->field($transfer, 'NoiChuyen')->textInput()->label('Nơi chuyển') ?>
                                </div>
                                <div class=" form-group">
                                    <button class="btn btn-info" type="button" id="transfer">
                                        Chuyển trường
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="content">
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
                        </tr>
                        </thead>

                        <tbody id="sd-trasfer">
                        <?php if (count($listTransfer) == 0): ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php else: ?>
                            <?php for ($i = 0; $i < count($listTransfer); $i++): ?>
                                <tr id="<?= $listTransfer[$i]->MaHocSinh ?>" class="tf">
                                    <td><?= $i + 1 ?></td>
                                    <?php $student = DsHocSinh::getStudent($listTransfer[$i]->MaHocSinh) ?>
                                    <td><?= $student->MaHocSinh ?></td>
                                    <td><?= $student->HoDem ?></td>
                                    <td><?= $student->Ten ?></td>
                                    <td><?= $listTransfer[$i]->NoiChuyen ?></td>
                                </tr>
                            <?php endfor; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thông báo</h4>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa dữ liệu này không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="success-delete">Đồnng ý</button>
            </div>
        </div>

    </div>
</div>
<?php ActiveForm::end() ?>
<script>
    var value = null;
    var student=null;
    var flag;
    var dialogLoad = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang lấy dữ liệu.....</h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');
    $(document).on('click', '.hs', function () {

        $('tr').each(function () {
            $(this).removeClass('active-tr')
        });
        value = $(this).attr('about');
        var semester = $('#dshocsinhchuyentruong-mahocky').val();
        checkStudent(value, semester);
        $(this).addClass('active-tr');
    });
    $(document).on('click', '.tf', function () {

        $('tr').each(function () {
            $(this).removeClass('active-tr')
        });
        value = $(this).attr('id');
        var semester = $('#dshocsinhchuyentruong-mahocky').val();
        checkStudent(value, semester);
        $(this).addClass('active-tr');
    });
    $(document).on('change', '#dslop-malop', function () {
        if ($(this).val() != null) {
            var id_class = $(this).val();
            var semester = $('#dshocsinhchuyentruong-mahocky').val();
            dialogLoad.modal();
            ajaxLoadData(id_class, semester);
        }
    });
    $(document).on('change', '#dshocsinhchuyentruong-mahocky', function () {
        if ($(this).val() != null) {
            var id_class = $('#dslop-malop').val();
            var semester = $(this).val();
            dialogLoad.modal();
            ajaxLoadData(id_class, semester);
        }
    })
    function ajaxLoadData(idClass, idSemester) {
        $.ajax({
                url: '<?=Url::to(['/hoc-sinh-chuyen-truong/get-transfer'])?>',
                type: 'POST',
                data: {
                    id_class: idClass,
                    semester: idSemester
                },
                success: function (result) {
                    $('#content').find('div').each(function () {
                        $(this).remove();
                    });
                    $('#content').append(result);
                    dialogLoad.modal('hide');
                }
            }
        )
    }
    $(document).on('click', '#transfer', function () {
        if ($('#dshocsinhchuyentruong-chuyendi1').is(':checked'))
            chuyenDi = 0;
        else
            chuyenDi = 1;
        if ($('#dshocsinhchuyentruong-hevnen').is(':checked'))
            vNen = 1;
        else
            vNen = 0;

        var to = $('input[name="DsHocSinhChuyenTruong[NoiChuyen]"]').val();
        flag = 1;

        checkValid(to);
        if (flag == 1) {
            var semester = $('#dshocsinhchuyentruong-mahocky').val();
            ajaxTransferStudent(value, semester, chuyenDi, vNen, to);
        }
    })
    function ajaxTransferStudent(idStudent, idSemester, typeTransfer, vNen, to) {
        $.ajax({
                url: '<?=Url::to(['/hoc-sinh-chuyen-truong/transfer-student'])?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    student: idStudent,
                    semester: idSemester,
                    type: typeTransfer,
                    vNen: vNen,
                    to: to
                },
                success: function (result) {
                    if (result['status'] == 'change') {
                        id = '#' + idStudent;
                        $(id).remove();
                        $('#sd-trasfer').append(result['html'])
                    }
                    else if (result['status'] == 'add') {
                        $('#sd-trasfer').append(result['html'])
                        if (result['remove'] == 'yes')
                            $('.active-tr').remove();
                    }
                    else
                        alert('Xảy ra lỗi trong quá trình lưu yêu cầu thực hiện lại tác vụ');
                    dialogLoad.modal('hide');
                }
            }
        )
    }
    function checkValid(to) {
        if (value == null) {
            alert('Bạn chưa chọn học sinh.');
            flag = 0;
        }
        if (to == '' || to == null) {
            alert('Nơi chuyển không được để trống.');
            flag = 0;
        }
    }
    function checkStudent(student, semester) {
        $.ajax({
            url: '<?=Url::to(['/hoc-sinh-chuyen-truong/check'])?>',
            type: 'POST',
            dataType: 'json',
            data: {
                student: student,
                semester: semester,
            },
            success: function (result) {
                if (result['status'] == 'ok') {
                    $('input[name="DsHocSinhChuyenTruong[NoiChuyen]"]').val(result['to']);
                    console.log(result['vnen']);
                    if (result['type'] == 1) {
                        $('#dshocsinhchuyentruong-chuyendi2').prop('checked', true);
                        ;
                        $('#dshocsinhchuyentruong-chuyendi1').prop('checked', false);
                    }
                    else {
                        $('#dshocsinhchuyentruong-chuyendi2').prop('checked', false);
                        ;
                        $('#dshocsinhchuyentruong-chuyendi1').prop('checked', true);
                    }
                    if (result['vnen'] == 1)
                        $('#dshocsinhchuyentruong-hevnen').prop('checked', true);
                    else
                        $('#dshocsinhchuyentruong-hevnen').prop('checked', false);
                }
                else {
                    $('input[name="DsHocSinhChuyenTruong[NoiChuyen]"]').val('');
                    $('#dshocsinhchuyentruong-chuyendi1').attr('checked', true);
                    $('#dshocsinhchuyentruong-chuyendi2').attr('checked', false);
                    $('#dshocsinhchuyentruong-hevnen').prop('checked', false);
                }
            }
        })
    }
    $(document).on('change', '#dshocsinhchuyentruong-chuyendi1', function () {
        if ($('#dshocsinhchuyentruong-chuyendi1').is(':checked')) {
            $('#dshocsinhchuyentruong-chuyendi2').attr('checked', false)
        }
    });
    $(document).on('change', '#dshocsinhchuyentruong-chuyendi2', function () {
        if ($('#dshocsinhchuyentruong-chuyendi2').is(':checked')) {
            $('#dshocsinhchuyentruong-chuyendi1').attr('checked', false)

        }
    });
    $(document).on('click', '.delete', function () {
         student = $(this).attr('about');
         $('#myModal').modal();

    })
    $(document).on('click','#success-delete',function () {
        var semester = $('#dshocsinhchuyentruong-mahocky').val();
        $.ajax({
                url: '<?=Url::to(['/hoc-sinh-chuyen-truong/delete'])?>',
                type: 'POST',
                data: {
                    student: student,
                    semester: semester
                },
                success: function (result) {
                   if(result=='ok')
                   {
                       id='#'+student;
                       $(id).remove();
                       $('#myModal').modal('hide');
                   }
                   else
                       alert('Đã xảy ra lỗi yêu cầu thực hiện lại tác vụ');

                }
            }
        )
    })
</script>