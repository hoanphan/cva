<?php
/**
 * Created by PhpStorm.
 * User: PHANHOANDHTB
 * Date: 11/3/2016
 * Time: 3:40 PM
 */
use backend\models\DSHocKy;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use navatech\simplehtmldom\SimpleHTMLDom;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\DSCap;
$form=ActiveForm::begin();
?>
    <div class="row">
        <div class="">
            <div class="col-sm-2">
                <div class="form-group field-account-lev0">
                    <?php /** @var TYPE_NAME $form */
                    echo $form->field($report, 'TenKhoi')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\backend\BLL\ReportBLL::getListReport(), 'id', 'name'),
                    ])->label('Loại'); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group field-account-lev0">
                    <?php /** @var TYPE_NAME $form */
                    echo $form->field($level, 'MaCap')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(DSCap::find()->all(), 'MaCap', 'TenCap'),
                    ])->label('Cấp'); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group field-account-lev0">
                    <?php /** @var TYPE_NAME $form */
                    echo $form->field($semester, 'TenHocKy')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(DSHocKy::find()->asArray()->all(), 'MaHocKy', 'TenHocKy'),
                    ]); ?>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group field-account-lev3">
                    <div class="form-group field-dslop-tenlop" style="margin-top: 20px; ">

                        <span>
                         <?= Html::button('Lấy dữ liệu', ['class' => 'btn btn-lg btn-primary', 'name' => 'get-button','id'=>'get']) ?>
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
    <div class="col-xs-12" >
        <iframe id="idFrame" src="<?=Url::toRoute(['/report/report-nation','level'=>'TTHCS','idSemester'=>'K1'])?>" style="width: 100%; height: 400px"></iframe>
    </div>
    <script>
        $(document).ready(function () {
            $('#get').click(function () {
                var typeReport=$('#dskhoi-tenkhoi').val();
                var levelq = $('#dscap-macap').val();
                var semester = $('#dshocky-tenhocky').val();
                if(typeReport=='DanToc') {

                    var url = "<?=Url::toRoute(['/report/report-nation'])?>" + '?level=' + levelq + '&idSemester=' + semester;
                    $('#idFrame').attr('src', url);
                }
                else
                    if (typeReport=='DoTuoi')
                    {

                        var url = "<?=Url::toRoute(['/report/report-age'])?>"+'?level='+levelq+'&semester='+semester;
                        $('#idFrame').attr('src', url);
                    }
                    else
                        if(typeReport=='HlHk')
                    {
                        var   url = "<?=Url::toRoute(['/report/report-hanh-kiem-hoc-luc'])?>"+ '?level=' + levelq + '&semester=' + semester;
                        $('#idFrame').attr('src', url);
                    }
                    else
                        if(typeReport=='HlHk1')
                        {
                            var   url = "<?=Url::toRoute(['/report/report-thong-ke-hk-hl'])?>"+ '?level=' + levelq + '&semester=' + semester;
                            $('#idFrame').attr('src', url);
                        }
                        else
                        if(typeReport=='HocLuc')
                        {
                            var   url = "<?=Url::toRoute(['/report/report-hoc-luc'])?>"+ '?MaCap=' + levelq + '&HocKy=' + semester;
                            $('#idFrame').attr('src', url);
                        }
                        else
                        if(typeReport=='HanhKiem')
                        {
                            var   url = "<?=Url::toRoute(['/report/report-hanh-kiem'])?>"+ '?MaCap=' + levelq + '&HocKy=' + semester;
                            $('#idFrame').attr('src', url);
                        }
                        else
                        if(typeReport=='KhaGioi')
                        {
                            var   url = "<?=Url::toRoute(['/report/report-ty-le-kha-gioi'])?>"+ '?MaCap=' + levelq + '&HocKy=' + semester;
                            $('#idFrame').attr('src', url);
                        }
            })
        })
    </script>
<?php ActiveForm::end()?>