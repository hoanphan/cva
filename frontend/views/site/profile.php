<?php

/* @var $this yiiwebView */
/* @var $form yiibootstrapActiveForm */
/* @var $model commonmodelsLoginForm */

use kartik\file\FileInput;
use kartik\tabs\TabsX;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
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

?>
<?php

$content1=' <div class="row">
        <div class="col-lg-10">
           
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Mật khẩu cũ</label>
                    <div class="col-sm-7">'.
                       $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder'=>"Mật khẩu cũ",'class'=>"form-control", 'id'=>"inputEmail3"])->label(false).
                    '</div>
                </div>
                <div class="form-group">

                    <label for="" class="col-sm-5 control-label">Mật khẩu mới</label>
                    <div class="col-sm-7">'.
                         $form->field($model, 'password1')->passwordInput([ 'placeholder'=>"Mật khẩu mới",'class'=>"form-control"])->label(false).
                    '</div>
                </div>
                <div class="form-group">

                    <label for="" class="col-sm-5 control-label">Nhập lại mật khẩu</label>
                    <div class="col-sm-7">'.
                         $form->field($model, 'password2')->passwordInput([ 'placeholder'=>"Nhập lại mật khẩu",'class'=>"form-control"])->label(false).

                    ' <label for="" class="col-sm-5 control-label" style="text-align: center;">'.$message.'</label></div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" style="text-align: center;">'.
                   Html::submitButton('Thay đổi thông tin', ['class' => 'btn btn-lg btn-primary', 'name' => 'login-button']).
                '</div>
            </div>
        </div>
       
    </div>';

$items = [
    [
        'label'=>'<i class="fa  fa-users"></i> Mật khẩu ',
        'content'=>$content1,
        'active'=>true,

    ],
    

];
echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_LEFT,
    'encodeLabels'=>false
]);
?>
 <?php ActiveForm::end(); ?>