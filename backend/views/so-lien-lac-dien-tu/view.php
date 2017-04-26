<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\models\SoLienLacDienTu;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\SoLienLacDienTu */

$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Sổ liên lạc điện tử';
$this->params['breadcrumbs'][] = ['label' => 'So Lien Lac Dien Tus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$fullName=SoLienLacDienTu::getNameStudent($model->MaHocSinh);
$starDay=SoLienLacDienTu::getStartDay($model->MaTuan);
$endDay=SoLienLacDienTu::getEndDay($model->MaTuan);
?>
<h1></h1>
<div class="so-lien-lac-dien-tu-view">

    <?= DetailView::widget([
        'mode' => DetailView::MODE_VIEW,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'fadeDelay' => 809,
        'model' => $model,
        'deleteOptions' => [
            'url'=>'delete',
            'params'=>['MaHocSinh' => $model->MaHocSinh,'MaTuan'=>$model->MaTuan],
            'confirm'=>'Bạn có muốn xóa dữ liệu này không?'
        ],
        'panel' => [
            'heading' => '<i class="fa fa-books"></i> ' . Yii::t('app', 'Chi tiết sổ liên lạc điện tử')
            , 'type' => DetailView::TYPE_SUCCESS,
            'footer' => false,
        ],

        'attributes' => [
            [
                'group'=>true,
                'label'=>'Thông tin chính',
                'rowOptions' => ['class' => DetailView::TYPE_INFO],
            ],
            [
                'attribute' => 'MaHocSinh',
                'type' => DetailView::INPUT_HIDDEN,
                'label' => 'Mã học sinh',
                'valueColOptions' => ['style' => 'width:70%'],

            ],
            [
                'attribute' => 'MaHocSinh',
                'type' => DetailView::INPUT_HIDDEN,
                'value'=>$fullName,
                'valueColOptions' => ['style' => 'width:70%'],
                'label' => 'Tên học sinh',
            ],
            [
                'attribute' => 'MaTuan',
                'type' => DetailView::INPUT_HIDDEN,
                'valueColOptions' => ['style' => 'width:70%'],
                'label' => 'Tên tuần',
            ],
            [
                'attribute' => 'MaHocSinh',
                'type' => DetailView::INPUT_HIDDEN,
                'value'=>$starDay,
                'valueColOptions' => ['style' => 'width:70%'],
                'label' => 'Bắt đầu từ ngày',
            ],
            [
                'attribute' => 'MaHocSinh',
                'type' => DetailView::INPUT_HIDDEN,
                'value'=>$endDay,
                'valueColOptions' => ['style' => 'width:70%'],
                'label' => 'Kết thúc ngày',
            ],
            [

                'attribute' => 'NoiDung',
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class'=>\navatech\roxymce\widgets\RoxyMceWidget::className(),
                        'name'        => 'NoiDung', //default name of textarea which will be auto generated, REQUIRED if not using 'model' section
                        'value'       => isset($_POST['NoiDung']) ? $_POST['NoiDung'] : '', //default value of current textarea, NOT REQUIRED
                        'action'      => Url::to(['/roxymce/default']), //default roxymce action route, NOT REQUIRED
                        'options'     => [//TinyMce options, NOT REQUIRED, see https://www.tinymce.com/docs/
                            'title' => 'RoxyMCE',//title of roxymce dialog, NOT REQUIRED
                        ],
                        'htmlOptions' => [],//html options of this widget, NOT REQUIRED

                ],
                'format' => 'html',
                'value' => $model->NoiDung,
                'valueColOptions' => ['style' => 'width:70%'],
                'label'=>'Nội dung'
            ],

        ],
    ]) ?>


</div>
