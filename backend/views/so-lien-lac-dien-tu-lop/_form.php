<?php

use navatech\roxymce\widgets\RoxyMceWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\DSTuan;
use backend\models\DsLop;
/* @var $this yii\web\View */
/* @var $model backend\models\SoLienLacDienTuLop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="so-lien-lac-dien-tu-lop-form">

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
                            <i class="ace-icon fa fa-caret-right blue"></i>Mã lớp:
                        </div>
                        <div class="col-xs-6">
                           <label><?= $model->MaLop?></label>
                        </div>
                    </li>

                    <li>
                        <div class="col-xs-6">
                            <i class="ace-icon fa fa-caret-right blue"></i>Tên lớp:
                        </div>
                        <div class="col-xs-6">
                           <label><?=DsLop::getNameClass($model->MaLop)?></label>
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
            </div>
        </div>
    </div>
	<?=$form->field($model, 'NoiDung')->textarea()->widget(RoxyMceWidget::className(),[

	])->label("Nội dung") ?>
    <?php ActiveForm::end(); ?>

</div>
