<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\common\models\DSHocKy;
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

            <?php echo $form->field($model, 'TenHocKy')->dropDownList(ArrayHelper::map(DSHocKy::find()->asArray()->all(),'MaHocKy','TenHocKy'), ['id'=>'cat_id']);

            // Additional input fields passed as params to the child dropdown's pluginOptions
            echo Html::hiddenInput('input-type-1', 'Additional value 1', ['id'=>'input-type-1']);
            echo Html::hiddenInput('input-type-2', 'Additional value 2', ['id'=>'input-type-2']);

            // Child # 1
            echo $form->field($model, 'MaHocKy')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'options'=>['id'=>'subcat1_id', 'placeholder'=>'dsadas ...'],
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['cat1-id'],
                    'url'=>Url::to(['/site/subcat']),
                    'params'=>['input-type-1', 'input-type-2']
                ]
            ]);?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
