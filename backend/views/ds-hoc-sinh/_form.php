<?php


use backend\models\DmDanToc;
use backend\models\DMTinhTrangSucKhoe;
use backend\models\DmTonGiao;
use kartik\datecontrol\DateControl;
use kartik\file\FileInput;
use kartik\tabs\TabsX;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DsHocSinh */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .tabs-krajee.tabs-left.tab-sideways .nav-tabs {
        left: -44px;
        margin-right: -154px;
    }
    .tabs-krajee.tabs-left .nav-tabs, .tabs-krajee.tabs-right .nav-tabs {
        width: 148px;
    }
</style>
<?php $form = ActiveForm::begin(['id' => 'login-form']);
$content1= $form->field($model, 'MaHocSinh')->textInput(['maxlength' => true,'disabled'=>'disabled']).
    $form->field($model, 'HoDem')->textInput(['maxlength' => true]).
    $form->field($model, 'Ten')->textInput(['maxlength' => true]).
    $form->field($model, 'TenThuongGoi')->textInput(['maxlength' => true]).
    $form->field($model, 'DaQuaLop')->textInput().
    $form->field($model, 'NgaySinh')->widget(DateControl::classname(),
       [

       ] ).
    $form->field($model, 'GioiTinh')->widget(SwitchInput::classname(), ['pluginOptions'=>[
        'handleWidth'=>60,
        'onText'=>'Nam',
        'offText'=>'Nữ'
    ]]).
    $form->field($model, 'MaDanToc')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(DmDanToc::find()->asArray()->all(),'MaDanToc','TenDanToc'),
        'options' => ['placeholder' => 'Chọn dân tộc ...'],
        'pluginOptions' => [
            'allowClear' => true
        ]]).
    $form->field($model, 'MaTonGiao')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(DmTonGiao::find()->asArray()->all(),'MaTonGiao','TenTonGiao'),
        'options' => ['placeholder' => 'Chọn tôn giáo ...'],
        'pluginOptions' => [
            'allowClear' => true
        ]]).
    $form->field($model, 'MaTinhTrangSucKhoe')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(DMTinhTrangSucKhoe::find()->asArray()->all(),'MaTinhTrangSucKhoe','TenTinhTrangSucKhoe'),
        'options' => ['placeholder' => 'Chọn sức khỏe ...'],
        'pluginOptions' => [
            'allowClear' => true
        ]]).
    $form->field($model, 'EmailPhuHuynh')->textInput(['maxlength' => true]).
    $form->field($model, 'SoDienThoaiPhuHuynh')->textInput(['maxlength' => true]).
    $form->field($model, 'DangKyDichVu')->widget(SwitchInput::classname(), ['pluginOptions'=>[
        'handleWidth'=>60,
        'onText'=>'Có',
        'offText'=>'Không'
    ]]).
    ' <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="text-align: center;">'.
    Html::submitButton('Thay đổi thông tin', ['class' => 'btn btn-lg btn-primary', 'name' => 'login-button']).
    '</div>
    </div>';
    $content2=$form->field($model, 'NoiSinh')->textInput(['maxlength' => true]).
        $form->field($model, 'QueQuan')->textInput(['maxlength' => true]).
        $form->field($model, 'HoTenBo')->textInput(['maxlength' => true]).
        $form->field($model, 'NgheNghiepBo')->textInput(['maxlength' => true]).
        $form->field($model, 'HoTenMe')->textInput(['maxlength' => true]).
        $form->field($model, 'NgheNghiepMe')->textInput(['maxlength' => true]).
        $form->field($model, 'Anh')->fileInput()->widget(FileInput::className(), [
            'pluginOptions' => [
                'initialPreview'=>[
                    \backend\models\DsGiaoVien::getImager(),
                ],
                'initialPreviewAsData'=>true,
                'initialPreviewConfig' => [
                    ['caption' =>'1.jpg', 'size' => '873727'],
                ],
                'maxFileSize'=>2800,
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' => 'Chọn ảnh'
            ],
            'options' => ['accept' => 'image/*']
        ]).
        $form->field($model, 'NgayVaoDoan')->widget(DateControl::classname(),
            [

            ] ).
        $form->field($model, 'NoiVaoDoan')->textInput(['maxlength' => true]).
        ' <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="text-align: center;">'.
        Html::submitButton('Thay đổi thông tin', ['class' => 'btn btn-lg btn-primary', 'name' => 'login-button']).
        '</div>
    </div>'
;
$items = [
    [
        'label'=>'<i class="fa fa-home home-icon"></i> Thông tin chính ',
        'content'=>$content1,
        'active'=>true,

    ],
    [
        'label'=>'<i class="glyphicon glyphicon-user"></i> Thông tin phụ',
        'content'=>$content2,
    ],

];
echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_LEFT,
    'encodeLabels'=>false
]);
?>


<?php ActiveForm::end(); ?>

