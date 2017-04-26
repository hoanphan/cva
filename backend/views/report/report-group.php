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
$form=ActiveForm::begin();
$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Báo cáo theo khối';
$this->params['breadcrumbs'][] = $this->title;
?>
<html>
<body style="">
<div class="row">
    <div class="">

        <div class="col-sm-2">
    <div class="form-group field-account-lev0">
        <?php /** @var TYPE_NAME $form */
        echo $form->field($semester, 'TenHocKy')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(DSHocKy::find()->asArray()->all(), 'MaHocKy', 'TenHocKy'),
        ]); ?>
    </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group field-account-lev1" style="">
                <?php
                    echo $form->field($gruop, 'TenKhoi')->widget(DepDrop::classname(), [
                        'options' => ['placeholder' => 'Chọn ...'],
                        'type' => DepDrop::TYPE_SELECT2,

                        'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                        'pluginOptions' => [
                            'depends' => ['dshocky-tenhocky'],
                            'initialize' => true,
                            'url' => Url::to(['/about/gruop']),
                            'loadingText' => 'danh sách khối ...',
                        ]
                    ]);
                 ?>
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
        <iframe name="idFrame" id="idFrame" src="<?=Url::toRoute(['/report/report-theo-khoi','MaKhoi'=>'K06','MaHocKy'=>'K1'])?>" style="width: 100%; height: 400px"></iframe>
    </div>
<script>
    $(document).ready(function () {
        $('#get').click(function () {
            var MaHocKy=$('#dshocky-tenhocky').val();
            var MaKhoi=$('#dskhoi-tenkhoi').val();
            
           var url="<?=Url::toRoute(['/report/report-theo-khoi'])?>"+'?MaKhoi='+MaKhoi+'&MaHocKy='+MaHocKy;
            $('#idFrame').attr('src', url);
        })
    })
</script>
</body>
</html>
<?php ActiveForm::end()?>