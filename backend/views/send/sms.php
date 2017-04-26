<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/26/2016
 * Time: 8:11 PM
 */
$bundle=\backend\assets\AppAsset::register($this);
?>
    <script type="text/javascript" src="<?=$bundle->baseUrl?>/js/jquery.countdown.js"></script>

<?php
use kartik\depdrop\DepDrop;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\DSHocKy;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$form=ActiveForm::begin();
$bundel=\backend\assets\AppAsset::register($this);
?>
    <a id="countStudent" style="display: none"><?=\backend\models\DSHocSinhTheoLop::find()->count()?></a>
    <div class="">
        <div class="col-sm-2">
            <div class="form-group field-account-lev0">
                <?php /** @var TYPE_NAME $form */
                echo $form->field($month, 'TenThang')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\backend\models\DsThang::find()->asArray()->all(),'STTThang','TenThang')
                ]); ?>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group field-account-lev0">
                <?php /** @var TYPE_NAME $form */
                echo $form->field($semester, 'TenHocKy')->widget(DepDrop::classname(), [
                    'options' => ['placeholder' => 'Chọn ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                    'pluginOptions' => [
                        'depends' => ['dsthang-tenthang'],
                        'url' => Url::to(['/about/semseter']),
                        'loadingText' => 'danh sách kỳ ...',
                    ]
                ]); ?>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group field-account-lev3">
                <div class="form-group field-dslop-tenlop" style="margin-top: 20px;">

                        <span>
                        <?= Html::a(
                            Html::button('<i class=""><img style="width: 16px;height: 16px" src="'.$bundel->baseUrl.'/images/sendSms.png"></i> Gửi Tin nhắn', ['class' => 'btn btn-danger', ' data-toggle' => "modal", 'id' => "sms"])) ?>
                            </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group field-account-lev3">
                <div class="form-group field-dslop-tenlop" style="margin-top: 20px;">

                        <span>
                        <?= Html::a(
                            Html::button('<i class=" fa fa-cloud-download"></i> Lấy dữ liệu', ['class' => 'btn btn-info', ' data-toggle' => "modal", 'id' => "get"])) ?>
                            </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2" id="" style="display: block">
            <div class="form-group field-account-lev3">
                <div class="form-group field-dslop-tenlop" style="margin-top: 20px;">

                        <span>
                        <?= Html::a(
                            Html::button('<i class=" glyphicon glyphicon-repeat"></i> Lấy tổng kết theo kỳ', ['class' => 'btn btn-success', ' data-toggle' => "modal", 'id' => "get-summary"])) ?>
                            </span>
                </div>
            </div>
        </div>

    </div>

    <div class="col-sm-12" id="gridview">
        <div class="gridview">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'resizableColumns' => true,
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
                    'MaHocSinh',
                    'HoDem',
                    'Ten',
                    'EmailPhuHuynh:email',
                    'SoDienThoaiPhuHuynh',
                    [
                        'attribute'=>'DangKyDichVu',
                        'value'=>function($data)
                        {
                            if($data->DangKyDichVu==1)
                                return 'Có';
                            else
                                return 'Không';
                        }
                    ],
                ],
                'panel' => [
                    'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách học sinh sử dụng dịch vụ') . '</i>',
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
                    'footer' => false
                ]
            ]); ?>
        </div>
    </div>
    <script>
        var gt=0;
        var countStudent=parseInt($('#countStudent').text());
        var dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;">Đang gửi dữ liệu lên server</h3></div>' +
            '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
            '</div></div></div>');
        var dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;">Đang lấy dữ liệu </h3></div>' +
            '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress">'+
            '<div id="value" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">'+
            '0% Complete (success)'
            +'</div> </div></div></div>' +
            '</div>' +
            '</div></div></div>');
        var dialogWait=$('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;">Xin chờ 1 chút</h3></div>' +
            '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
            '</div></div></div>');
        $(document).ready(function () {
            $('textarea').remove();
            $('#dsthang-tenthang').change(function () {
                comboboxChage();
            })
            $('#sms').click(function () {
                sendSms();
            });
            $('#get').click(function () {
                getData();
            });
            $('#repeat').click(function () {
                Request();
            })
            $('#get-summary').click(function () {
                getDataSumary();
            })
        })
        function getData() {
            gt=0;
            var month=$('#dsthang-tenthang').val();
            var semester=$('#dshocky-tenhocky').val();
            dialog.modal();

            ajax(month,semester);
        }
        function getDataSumary() {
            gt=0;
            var month=$('#dsthang-tenthang').val();
            var semester=$('#dshocky-tenhocky').val();

            if(semester!="") {
                dialog.modal();
                ajaxGetSummary(month, semester);
            }
            else
            {
                alert("Trường này không để trống");
            }
        }
        function ajax(month,semester) {
            $.ajax({
                url:'<?=Url::toRoute(['about/get-sms'])?>',
                type:'POST',
                data:{
                    month:month,
                    semester:semester,
                    index:gt
                },
                success: function (result) {
                    gt=parseInt(result);
                    var i=parseInt(result);
                    i=Math.round((i/countStudent)*100,2);
                    $('#value').text(i + '% Complete (success)');
                    $('#value').width(i+'%');
                    if(gt!=countStudent)
                        ajax(month,semester);
                    else {
                        dialog.modal('hide');
                        window.location='<?=Url::toRoute(['ds-tin-nhan-xuat-excel/index'])?>';
                    }
                },
                error:function(jqxhr,textStatus,errorThrown)
                {
                    setErrorText(textStatus);
                    dialog.modal('hide');
                    dialogError.modal();
                }
            })
        }
        function ajaxGetSummary(month,semester) {
            $.ajax({
                url:'<?=Url::toRoute(['send/get-sms-summary'])?>',
                type:'POST',
                data:{
                    month:month,
                    semester:semester,
                    index:gt
                },
                success: function (result) {
                    gt=parseInt(result);
                    var i=parseInt(result);
                    i=Math.round((i/countStudent)*100,2);
                    $('#value').text(i + '% Complete (success)');
                    $('#value').width(i+'%');
                    if(gt!=countStudent)
                        ajaxGetSummary(month,semester);
                    else {
                        dialog.modal('hide');
                        window.location='<?=Url::toRoute(['ds-tin-nhan-xuat-excel/index'])?>';
                    }
                },
                error:function(jqxhr,textStatus,errorThrown)
                {
                    setErrorText(textStatus);
                    dialog.modal('hide');
                    dialogError.modal();
                }
            })
        }
        function sendSms() {
            var month=$('#dsthang-tenthang').val();
            var semester=$('#dshocky-tenhocky').val();
            if(semester!=null&&semester!='') {
                dialog.modal()
                $.ajax({
                    url: '<?=Url::toRoute(['about/send-sms'])?>',
                    type: 'POST',
                    data: {
                        month: month,
                        semester: semester
                    },
                    success: function (result) {
                        dialog.modal('hide');
                        $('#gridview').find('.gridview').remove();
                        $('#gridview').append(result);
                        var test = new Date()
                        var day = test.getDate();
                        var month = test.getMonth() + 1;
                        var year = test.getFullYear();
                        var hour = test.getHours();
                        var minute = test.getMinutes() + 5;
                        var mini = test.getSeconds();
                        var str = year + "/" + month + "/" + day + " " + hour + ":" + minute + ":" + mini;
                        $("#getting-started")
                            .countdown(str, function (event) {
                                $(this).text(
                                    event.strftime('%M:%S')
                                );
                                if (event.strftime('%M:%S') == "00:00") {
                                    dialogWait.modal();
                                    $.ajax(
                                        {
                                            url: '<?=Url::toRoute(['send/check-sms'])?>',
                                            type: 'POST',
                                            data: {
                                                month: month
                                            },
                                            success: function (result) {
                                                $('#gridview').find('.gridview').remove();
                                                $('#gridview').append(result);
                                                dialogWait.modal('hide');
                                            }
                                        }
                                    )
                                }
                            });
                        $('#sms').attr('disabled', 'disabled');
                    }
                })
            }
        }
        function comboboxChage() {
            var month=$('#dsthang-tenthang').val();
            dialogWait.modal();
            $.ajax(
                {
                    url: '<?=Url::toRoute(['send/combobox-change'])?>',
                    type: 'POST',
                    data: {
                        month: month
                    },
                    success: function (result) {
                        $('#gridview').find('.gridview').remove();
                        $('#gridview').append(result);
                        dialogWait.modal('hide');
                        $.ajax(
                            {
                                url: '<?=Url::toRoute(['send/count-sms'])?>',
                                type: 'POST',
                                data: {
                                    month: month
                                },
                                success: function (result) {
                                    if(result>0)
                                        $('#request').css('display','block')
                                    else
                                        $('#request').css('display','none')
                                }
                            }
                        )
                    }
                }
            )
        }
        function Request() {
            var month=$('#dsthang-tenthang').val();
            dialogWait.modal();
            $.ajax(
                {
                    url: '<?=Url::toRoute(['send/check-sms'])?>',
                    type: 'POST',
                    data: {
                        month: month
                    },
                    success: function (result) {
                        $('#gridview').find('.gridview').remove();
                        $('#gridview').append(result);
                        dialogWait.modal('hide');
                    }
                }
            )
        }
    </script>
<?php ActiveForm::end()?>