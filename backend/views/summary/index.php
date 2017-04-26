<?php
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DSTongKetTheoKy;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\DSHocKy;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/7/2016
 * Time: 9:44 AM
 */
$yearCurent = DSNamHoc::getCurrentYear();
$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Tổng kết';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>


    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                       aria-expanded="true" aria-controls="collapseOne">
                        Lấy dữ liệu
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="">
                        <div class=" center-block">
                            <div class="form-group field-account-lev3">
                                <div class="form-group field-dslop-tenlop" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <div class="col-sm-4">
                                            <div class="form-group field-account-lev0">
                                                <?= $form->field($semester, 'TenHocKy')->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(DSHocKy::find()->all(), 'MaHocKy', 'TenHocKy'),
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                    'id' => 'Semester'
                                                ]); ?>
                                            </div>
                                        </div>
                                        <?php if ($kt == 0): ?>
                                            <div class="col-sm-4">
                                                <div class="form-group field-account-lev0">
                                                    <?= $form->field($class, 'TenLop')->widget(Select2::classname(), [
                                                        'data' => ArrayHelper::map(DsLop::find()->where(['MaNamHoc' => $yearCurent])->all(), 'MaLop', 'TenLop'),
                                                        'options' => ['placeholder' => 'Chọn lớp...'],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                        'id' => 'class']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group field-account-lev0">
                                                    <br/>
                                                    <span>
                                                 <?= Html::a(
                                                     HTML::submitButton('<i class=""></i> Lấy dữ liệu', ['class' => 'btn btn-primary', ' data-toggle' => "modal", 'id' => 'get'])) ?>
                                            </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="col-sm-4">
                   <span>
                       <?= Html::a(
                           Html::button('<i class=""></i> Tính trung bình cộng', ['class' => 'btn ', ' data-toggle' => "modal", 'id' => "TBC"])) ?>
                   </span>
                                        </div>
                                        <div class="col-sm-4">
                   <span>
                       <?= Html::a(
                           Html::button('<i class=""></i> Xét học lực', ['class' => 'btn btn-success', ' data-toggle' => "modal", 'id' => "HL"])) ?>
                   </span>
                                        </div>
                                        <div class="col-sm-4">
                   <span>
                       <?= Html::a(
                           Html::button('<i class=""></i> Xét danh hiệu', ['class' => 'btn btn-info', ' data-toggle' => "modal", 'id' => "DH"])) ?>
                   </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <div id="table-appea">
        <div id="table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,

                'pjax' => true,
                'bordered' => true,
                'responsive' => true,
                'rowOptions' => ['style' => [
                    'text-align' => 'center'
                ]],
                'headerRowOptions' => ['style' => [
                    'text-align' => 'center'
                ]],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'MaHocSinh',
                        'value' => function ($data) {
                            return DSTongKetTheoKy::getFullName($data->MaHocSinh);
                        }
                    ],

                    'TrungBinhChung',
                    [
                        'attribute' => 'MaHanhKiem',
                        'value' => function ($data) {
                            return DSTongKetTheoKy::getTextHanhKiem($data->MaHanhKiem);
                        }
                    ],
                    [
                        'attribute' => 'MaHocLuc',
                        'value' => function ($data) {
                            return DSTongKetTheoKy::getTextHocLuc($data->MaHocLuc);
                        }
                    ],
                    [
                        'attribute' => 'MaDanhHieu',
                        'value' => function ($data) {
                            return DSTongKetTheoKy::getTextDanhHieu($data->MaDanhHieu);
                        }
                    ],


                    // 'MaLenLop',
                    // 'soBuoiNghi',


                ],
                'panel' => [
                    'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách học sinh') . '</i>',
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
                    'footer' => false
                ]
            ]); ?>
        </div>
    </div>

    <script>
        var dialogError;
        function SetLoi(Loi) {
            dialogError = $('' +
                ' <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">' +
                '<div class="modal-dialog" role="document">' +
                '<div class="modal-content">'
                + '<div class="modal-header">'
                + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span' +
                'aria-hidden="true">&times;</span></button>' +
                '<h4 class="modal-title" id="myModalLabel"><h3 class="panel-title"><i class="fa fa-bullhorn"></i>' +
                'Thông báo</h3></h4>' +
                '</div> <div class="modal-body"> Lớp chưa nhập <br/>' + Loi + '</div>' +
                '<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button> </div> </div> </div>'
            );
        }
        var dialogSave = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;">Đang xử lí ...</h3></div>' +
            '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
            '</div></div></div>');
        $(document).on('change', '#dshocky-tenhocky', function () {
            var idSemester = $('#dshocky-tenhocky').val();
            ajaxReload(idSemester);
        })
        $(document).ready(function () {
            $('textarea').remove();
            $('#TBC').click(function () {
                var idSemester = $('#dshocky-tenhocky').val();
                if (idSemester != null) {
                    ajaxCheckAvegerSumer(idSemester);
                }

            });
            $('#HL').click(function () {
                var idSemester = $('#dshocky-tenhocky').val();
                if (idSemester != null) {
                    ajaxCheckHL(idSemester);
                }
            });
            $('#DH').click(function () {
                var idSemester = $('#dshocky-tenhocky').val();
                if (idSemester != null) {
                    ajaxCheckDH(idSemester);
                }
            })

        })
        function ajaxCheckAvegerSumer(idSemester) {
            dialogSave.modal();
            $.ajax({
                url: '<?=Url::to(['check-average'])?>',
                type: 'POST',
                data: {

                    idSemester: idSemester
                },
                success: function (result) {
                    if (result != null && result != "") {
                        dialogSave.modal('hide');
                        SetLoi(result);
                        dialogError.modal();
                    }
                    else {

                        $.ajax({
                            url: '<?=Url::to(['average-scroses'])?>',
                            type: 'POST',
                            data: {

                                idSemester: idSemester
                            },
                            success: function (result) {
                                ajaxReload(idSemester)
                            },
                            error: function (jqxhr, textStatus, errorThrown) {
                                dialogSave.modal('hide');
                                SetLoi(errorThrown);
                                dialogError.modal();
                            }
                        });
                        dialogSave.modal('hide');
                    }
                },
                error: function (jqxhr, textStatus, errorThrown) {
                    alert(textStatus);

                }
            })
        }
        function ajaxCheckHL(idSemester) {
            dialogSave.modal();
            $.ajax({
                url: '<?=Url::to(['hoc-luc'])?>',
                type: 'POST',
                data: {
                    idSemester: idSemester
                },
                success: function (result) {
                    if (result != null && result != "") {
                        dialogSave.modal('hide');
                        SetLoi(result);
                        dialogError.modal();
                    }
                    else {

                        $.ajax({
                            url: '<?=Url::to(['xet-hoc-luc'])?>',
                            type: 'POST',
                            data: {

                                idSemester: idSemester
                            },
                            success: function (result) {
                              ajaxReload(idSemester)
                            },
                            error: function (jqxhr, textStatus, errorThrown) {
                                dialogSave.modal('hide');
                                SetLoi(errorThrown);
                                dialogError.modal();
                            }
                        });
                        dialogSave.modal('hide');
                    }
                },
                error: function (jqxhr, textStatus, errorThrown) {
                    alert(textStatus);

                }
            })
        }
        function ajaxCheckDH(idSemester) {
            dialogSave.modal();
            $.ajax({
                url: '<?=Url::to(['xet-danh-hieu'])?>',
                type: 'POST',
                data: {

                    idSemester: idSemester
                },
                success: function (result) {
                    if (result != null && result != "") {
                        dialogSave.modal('hide');
                        SetLoi(result);
                        dialogError.modal();
                    }
                    else {
                       ajaxReload(idSemester)
                        dialogSave.modal('hide');
                    }
                },
                error: function (jqxhr, textStatus, errorThrown) {
                    alert(textStatus);

                }
            })
        }
        function ajaxReload(idSemester) {
            dialogSave.modal();
            $.ajax({
                url: '<?=Url::to(['get-summary'])?>',
                type: 'POST',
                data: {
                    idSemester: idSemester
                },
                success: function (result) {
                    dialogSave.modal('hide');
                    $('#table').remove();
                    $('#table-appea').append(result);
                },
                error: function (jqxhr, textStatus, errorThrown) {
                    alert(textStatus);

                }
            })
        }
    </script>
<?php ActiveForm::end() ?>