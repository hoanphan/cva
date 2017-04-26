<?php

use backend\BLL\RoleBLL;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use  backend\models\DSTuan;
use yii\helpers\ArrayHelper;
use backend\models\DSNamHoc;
use yii\helpers\Url;
use backend\models\DSKhoi;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\ModelSearch\SoLienLacDienTuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Sổ liên lạc điện tử';
$this->params['breadcrumbs'][] = $this->title;
$form=ActiveForm::begin();
?>
<div class="so-lien-lac-dien-tu-index">

    <style>
        th {
            text-align: center;
        }
    </style>
    <div class="form-horizontal">
        <?php if(RoleBLL::checkFunction(0)||RoleBLL::checkFunction(5)):?>
            <input id="check" value="1" style="display: none"/>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="col-xs-1">Khối</div>
                    <div class="col-xs-2">
                        <?php echo $form->field($gruop, 'TenKhoi')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(DSKhoi::find()->asArray()->all(), 'MaKhoi', 'TenKhoi'),
                        'options' => ['placeholder' => 'Chọn một khối ...'],
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-1">Lớp</div>
                    <div class="col-xs-2">
                        <?php

                        echo $form->field($class, 'TenLop')->widget(DepDrop::classname(), [

                            'options' => ['placeholder' => 'Chọn ...'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                            'pluginOptions' => [
                                'depends' => ['dskhoi-tenkhoi'],
                                'url' => Url::to(['/about/class']),
                                'loadingText' => 'danh sách lớp ...',
                            ]
                        ])->label(false); ?>
                    </div>
                    <div class="col-xs-1">Tuần</div>
                    <div class="col-xs-5">
                        <?= Select2::widget([
                            'model' => $week,
                            'attribute' => 'MaTuan',
                            'data' => DSTuan::createArrayWeek(),
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) ?>

                    </div>
                </div>
            </div>
        <?php else:?>
            <input id="check" value="0" style="display: none"/>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-1">
                        <label class="col-sm-3 control-label no-padding-right">Tuần </label>
                    </div>
                    <div class="col-xs-5">
                        <?= Select2::widget([
                            'model' => $week,
                            'attribute' => 'MaTuan',
                            'data' => DSTuan::createArrayWeek(),
                            'pluginOptions' => [
                                'allowClear' => true
                            ],

                        ]) ?>
                    </div>
                    <div class="col-xs-3">
                        <label class="col-sm-12 control-label no-padding-right">Sổ liên lạc điện tử của cả lớp: </label>
                    </div>
                    <div class="col-xs-2" id="electricBookButton">
                        <?php if(\backend\models\SoLienLacDienTuLop::findToId($idClass,DSTuan::getLastWeek(DSNamHoc::getCurrentYear())->MaTuan)==false):?>
                            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>' . Yii::t("app", " Add"),Url::toRoute(['so-lien-lac-dien-tu-lop/create','MaTuan'=>DSTuan::getLastWeek(DSNamHoc::getCurrentYear())->MaTuan]), ['class' => 'btn btn-danger']) ?>
                        <?php else:?>
                            <?= Html::a('<i class="fa fa-pencil-square-o"></i>' . Yii::t("app", " Update"),Url::toRoute(['so-lien-lac-dien-tu-lop/update','MaTuan'=>DSTuan::getLastWeek(DSNamHoc::getCurrentYear())->MaTuan]), ['class' => 'btn ']);?>
                        <?php endif;?>
                    </div>
                </div>
            </div>

        <?php endif;?>
        <div class="electricBook">
            <div id="electricBook">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
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

                        [
                            'attribute' => 'MaHocSinh',
                            'label' => 'Mã học sinh',

                        ],
                        [
                            'attribute' => 'TenHocSinh',
                            'label' => 'Họ và tên',

                        ],
                        [
                            'attribute' => 'NgaySinh',
                            'label' => 'Ngày sinh',
                            'format' => ['date', 'php:d-m-Y']

                        ],

                        [
                            'attribute' => 'Action',
                            'label' => 'Hoạt động',
                            'format' => 'html'
                        ]
                    ],
                    'panel' => [
                        'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Sổ liên lạc điện tử') . '</i>',
                        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
                        'footer' => false
                    ]
                ]); ?>
            </div>
        </div>
        <script>
            var check=$('#check').val();
            var dialogLoad = $(
                '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
                '<div class="modal-dialog modal-m">' +
                '<div class="modal-content">' +
                '<div class="modal-header"><h3 style="margin:0;">Đang lấy dữ liệu.....</h3></div>' +
                '<div class="modal-body">' +
                '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
                '</div>' +
                '</div></div></div>');
            $(document).ready(function () {
                $('textarea').remove();
                $('#dstuan-matuan').change(function () {
                    weekChage();
                });
                $('#dslop-tenlop').change(function () {
                   classChange();
                })

            });
            function weekChage() {
                if(check=="0") {
                    dialogLoad.modal();
                    var value = $('#dstuan-matuan').val();

                    $.ajax({
                        url: '<?=Url::toRoute(['about/week-change'])?>',
                        type: 'POST',
                        data: {
                            week: value
                        },
                        success: function (result) {
                            $('.electricBook').find('#electricBook').remove();
                            $('.electricBook').append(result);

                        }
                    });
                    $.ajax({
                        url: '<?=Url::toRoute(['about/week-change1'])?>',
                        type: 'POST',
                        data: {
                            week: value
                        },
                        success: function (result) {
                            $('#electricBookButton').find('a').remove();
                            $('#electricBookButton').append(result);

                        }
                    });

                    dialogLoad.modal('hide');
                }
                else
                {
                    classChange();
                }
            }
            function classChange() {
                dialogLoad.modal();
                var idClass=$('#dslop-tenlop').val();
                if(idClass!=null)
                {
                    var value = $('#dstuan-matuan').val();
                    $.ajax({
                        url: '<?=Url::toRoute(['so-lien-lac-dien-tu/class-change'])?>',
                        type: 'POST',
                        data: {
                            week: value,
                            class:idClass
                        },
                        success: function (result) {
                            $('.electricBook').find('#electricBook').remove();
                            $('.electricBook').append(result);
                            dialogLoad.modal('hide');
                        }
                    });
                }
            }
        </script>
    </div>
</div>
<?php ActiveForm::end()?>