<?php

use backend\BLL\RoleBLL;
use backend\models\DSHocKy;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\DsLoaiDiem;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


$listTypeScroses = Dsloaidiem::find()->all();
/* @var $this yii\web\View */
/* @var $searchModel app\ModelSearch\DsDiemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Nhập điểm';
$this->params['breadcrumbs'][] = $this->title;
$form = ActiveForm::begin(['id' => 'form',

]);
$bundel=\backend\assets\AppAsset::register($this);
?>
<input id="txtLaChoDiem" style="display: none"/>
<div class="">
    <div class="col-sm-2">
        <div class="form-group field-account-lev0">
            <?php /** @var TYPE_NAME $form */
            echo $form->field($semester, 'TenHocKy')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DSHocKy::find()->where(['TongHop' => 0])->asArray()->all(), 'MaHocKy', 'TenHocKy'),
                'options' => ['placeholder' => 'Chọn một học kỳ ...'],
            ]); ?>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group field-account-lev1">
            <?php

            echo $form->field($gruop, 'TenKhoi')->widget(DepDrop::classname(), [

                'options' => ['placeholder' => 'Chọn ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                'pluginOptions' => [
                    'depends' => ['dshocky-tenhocky'],
                    'url' => Url::to(['/about/gruop']),
                    'loadingText' => 'danh sách khối ...',
                ]
            ]); ?>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group field-account-lev2">

            <?php

            echo $form->field($class, 'TenLop')->widget(DepDrop::classname(), [

                'options' => ['placeholder' => 'Chọn ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                'pluginOptions' => [
                    'depends' => ['dskhoi-tenkhoi', 'dshocky-tenhocky'],
                    'url' => Url::to(['/about/class']),
                    'loadingText' => 'danh sách lớp ...',
                ]
            ]); ?>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group field-account-lev3">
            <?php echo $form->field($subject, 'TenMonHoc')->widget(DepDrop::classname(), [

                'options' => ['placeholder' => 'Chọn ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                'pluginOptions' => [
                    'depends' => ['dslop-tenlop', 'dshocky-tenhocky'],
                    'url' => Url::to(['/about/subject']),
                    'loadingText' => 'Danh sách môn học...',
                ]
            ]);
            ?>

        </div>

    </div>
    <p id="semester" style="display: none"><?=DSHocKy::getSemesterCurent()->MaHocKy?></p>
    <div class="col-sm-2">
        <div class="form-group field-account-lev3">
            <div class="form-group field-dslop-tenlop" style="margin-top: 20px;" id="btn-save">

                        <span>
                        <?= Html::a(
                            Html::button('<i class="glyphicon glyphicon-floppy-disk"></i> Lưu', ['class' => 'btn btn-primary', ' data-toggle' => "modal",'data-target' => "#Message"])) ?>
                            </span>
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group field-account-lev3" ">
            <div class="form-group field-dslop-tenlop" style="margin-top: 20px;" id="report" >

            </div>
        </div>
    </div>
</div>
<div id="dsdiem-index">
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
                                    <th class="floatThead-col" rowspan="2">#</th>
                                    <th class="floatThead-col" rowspan="2" width="8%">Mã học sinh</th>
                                    <th class="floatThead-col" rowspan="2" width="16%">Tên học sinh</th>
                                    <th class="floatThead-col" rowspan="2" width="10%">Ngày sinh</th>
                                    <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                                        <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                                            <th class=""
                                                colspan="<?= $listTypeScroses[$i]->SoDiemToiDa ?>"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                                        <?php elseif ($listTypeScroses[$i]->SoDiemToiDa == 1): ?>
                                            <th class="" rowspan="2"><?= $listTypeScroses[$i]->TenLoaiDiem ?></th>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </tr>
                                <tr class="size-row">
                                    <?php for ($i = 0; $i < count($listTypeScroses); $i++): ?>
                                        <?php for ($j = 1; $j <= $listTypeScroses[$i]->SoDiemToiDa; $j++): ?>
                                            <?php if ($listTypeScroses[$i]->SoDiemToiDa > 1): ?>
                                                <th class=""
                                                    style="width: 20px"><?= $listTypeScroses[$i]->HienThi . ' ' . $j ?> </th>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php endfor; ?>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="<?= Dsloaidiem::find()->sum('SoDiemToiDa') + 4 ?>">
                                        <div class="empty">Không tìm thấy kết quả nào.</div>
                                    </td>
                                </tr>
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
</div>
    <div class="modal fade" id="Message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><h3 class="panel-title"><i class="fa fa-bullhorn"></i>
                            Thông báo</h3></h4>
                </div>
                <div class="modal-body">
                    Bạn có đã chắc chắn dữ liệu đã nhập đầy đủ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="saveChage">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>
<a id="getScrosesUrl" style="display: none"><?=Url::toRoute(['about/grid-socrose'])?></a>
<a id="slCountScroses" style="display: none"><?=\backend\component\CreateAttribute::SumInput()+1?></a>
<a id="choDiem" style="display: none"><?=Url::toRoute('cho-diem')?></a>
<a id="ajaxSave" style="display: none"><?=Url::toRoute(['change'])?></a>
<a id="ajaxAvgeScrose" style="display: none"><?php echo Url::toRoute(['/ds-diem/average-scores'])?></a>
    <a id="ajaxReport" style="display: none"><?php echo Url::toRoute(['/ds-diem/report'])?></a>
    <script src="<?=$bundel->baseUrl?>/js/scroses.js">
    </script>

<?php $form=ActiveForm::end()?>