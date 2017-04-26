<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\DSHocKy;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?php /** @var TYPE_NAME $form */
            echo $form->field($model, 'TenHocKy')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DSHocKy::find()->asArray()->all(),'MaHocKy','TenHocKy')
            ]);?>
            <?php

            echo $form->field($gruop, 'TenKhoi')->widget(DepDrop::classname(), [

                'options' => ['placeholder' => 'Select ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['dshocky-tenhocky'],
                    'url' => Url::to(['/site/subcat']),
                    'loadingText' => 'Danh sách khối...',
                ]
            ]);
            echo $form->field($class, 'TenLop')->widget(DepDrop::classname(), [

                'options' => ['placeholder' => 'Select ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['dskhoi-tenkhoi'],
                    'url' => Url::to(['/site/class']),
                    'loadingText' => 'danh sách lớp ...',
                ]
            ]);
            echo $form->field($subject, 'TenMonHoc')->widget(DepDrop::classname(), [

                'options' => ['placeholder' => 'Select ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['dslop-tenlop'],
                    'url' => Url::to(['/account/child-account']),
                    'loadingText' => 'Danh sách môn học...',
                ]
            ]);
            ?>
            <?= $form->field($model, 'TenHocKy')->passwordInput() ?>



            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
