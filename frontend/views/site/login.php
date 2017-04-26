<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Đăng nhập';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-w3ls">
    <h3 >Đăng nhập</h3>
    <div class="clear"></div>
</div>
<div class="site-login">
    <!--<input type="text" name="userid" value="USERNAME" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'USERNAME';}">-->
    <!--<input type="email" name="email" value="EMAIL@ADDRESS.COM" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'EMAIL@ADDRESS.COM';}">
    <input type="submit" class="sign-in" value="Submit">-->
    <div class="row">
        <div class="col-lg-10">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Tên đăng nhập</label>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder'=>"Tên đăng nhập",'class'=>"form-control", 'id'=>"inputEmail3"])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">

                    <label for="" class="col-sm-5 control-label">Mật khẩu</label>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'password')->passwordInput([ 'placeholder'=>"Mật khẩu",'class'=>"form-control"])->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <?= $form->field($model, 'rememberMe')->checkbox()->label('Nhớ tài khoản')?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-lg btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
