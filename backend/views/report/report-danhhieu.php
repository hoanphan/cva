<?php
/**
 * Created by PhpStorm.
 * User: PHANHOANDHTB
 * Date: 11/3/2016
 * Time: 3:40 PM
 */
use backend\models\DmDanhHieu;
use backend\models\DSCap;
use backend\models\DSHocKy;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use navatech\simplehtmldom\SimpleHTMLDom;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
$form=ActiveForm::begin();
$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Báo cáo theo cấp';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="">
            <div class="col-sm-2">
                    <div class="form-group">

                        <?php /** @var TYPE_NAME $form */

                        echo $form->field($danhHieu, 'madanhhieu')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(DmDanhHieu::find()->where(['ingiaykhen'=>1])->all(), 'madanhhieu', 'tendanhhieu'),
                            'value'=>$idDanhHieu
                        ])->label('Loại');
                        ?>
                    </div>
            </div>
            <div class="col-sm-2">
                    <div class="form-group field-account-lev0">
                        <?php /** @var TYPE_NAME $form */
                        echo $form->field($semester, 'TenHocKy')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(DSHocKy::find()->asArray()->all(), 'MaHocKy', 'TenHocKy'),
                            'value'=>$idSemester,
                            'pluginEvents'=>[
                                "select2:unselecting" => "function() { log('unselecting'); }",
                            ]
                        ]); ?>
                    </div>

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
        <iframe id="idFrame" src="<?=Url::toRoute(['/report/report-dh','MaDH'=>$idDanhHieu,'HocKy'=>$idSemester])?>" style="width: 100%; height: 500px"></iframe>
    </div>
    <script>
        $(document).ready(function () {
            $('#get').click(function () {
                var MaHocKy=$('#dshocky-tenhocky').val();
                var MaDH=$('#dmdanhhieu-madanhhieu').val();

                var url="<?=Url::toRoute(['/report/report-dh'])?>"+'?MaDH='+MaDH+'&HocKy='+MaHocKy;
                $('#idFrame').attr('src', url);
            })
        })
    </script>
<?php ActiveForm::end()?>