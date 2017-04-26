<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use navatech\roxymce\widgets\RoxyMceWidget;
use backend\models\DsHocSinh;
use backend\models\DSTuan;
/* @var $this yii\web\View */
/* @var $model backend\models\SoLienLacDienTu */
/* @var $form yii\widgets\ActiveForm */
echo  str_replace("/backend",'',Url::toRoute(['/roxymce/default/index']));
?>

<div class="so-lien-lac-dien-tu-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-12">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                    <b>Thông tin sổ liên lạc điện tử</b>
                </div>
            </div>

            <div>
                <ul class="list-unstyled spaced">
                    <li>
                        <div class="col-xs-6">
                        <i class="ace-icon fa fa-caret-right blue"></i>Mã học sinh:
                        </div>
                        <div class="col-xs-6">
                            <label><?= $model->MaHocSinh?></label>
                        </div>
                    </li>

                    <li>
                        <div class="col-xs-6">
                            <i class="ace-icon fa fa-caret-right blue"></i>Tên học sinh:
                        </div>
                        <div class="col-xs-6">
                            <label><?= Dshocsinh::getFullName($model->MaHocSinh)?></label>
                        </div>
                    </li>

                    <li>
                        <div class="col-xs-6">
                            <i class="ace-icon fa fa-caret-right blue"></i>Ngày sinh:
                        </div>
                        <div class="col-xs-6">

                            <label><?=Dshocsinh::getNgaySinh($model->MaHocSinh)?></label>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-6">
                            <i class="ace-icon fa fa-caret-right blue"></i>Tên tuần:
                        </div>
                        <div class="col-xs-6">
                            <label><?=$model->MaTuan?></label>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-6">
                            <i class="ace-icon fa fa-caret-right blue"></i>Ngày bắt đầu:
                        </div>
                        <div class="col-xs-6">
                            <label><?= DSTuan::formatDate(DSTuan::getWeek($model->MaTuan)->BatDauTuNgay)?></label>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-6">
                            <i class="ace-icon fa fa-caret-right blue"></i>Ngày kết thúc:
                        </div>
                        <div class="col-xs-6">
                            <label><?= DSTuan::formatDate(DSTuan::getWeek($model->MaTuan)->KetThucNgay)?></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- /.col -->
        <div class="col-sm-3"></div>
    </div>
    <div class="col-sm-12">
        <div class="col-sm-9">

        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::a('Back',['index'],['class' =>'btn' ]) ?>
            </div>

        </div>
    </div>

    <?=$form->field($model, 'NoiDung')->textarea()->widget(RoxyMceWidget::className(),[
		'action'=>Url::toRoute(['/roxymce/default/index'])
    ])->label("Nội dung") ?>


    <?php ActiveForm::end(); ?>

</div>
