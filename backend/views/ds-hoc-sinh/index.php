<?php

use backend\models\DsHocSinh;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\DsHocSinhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List student';
$this->params['breadcrumbs'][] = $this->title;
$bundle=\backend\assets\AppAsset::register($this);
$url="";

?>
<a id="countStudent" style="display: none"><?=\backend\models\DsHocSinh::find()->count()?></a>
<div class="dshocsinh-index">

    <i><u>Lưu ý :</u></i>
    <dl>
        <dt><i>Trường mật khẩu là mật khẩu đầu tiên gửi cho phụ huynh học sinh.</i></dt>
        <dt><i>Danh sách gửi tin nhắn chỉ gửi cho những phụ huynh có học sinh đăng kí dịch vụ.</i></dt>
        <dt><i class="ace-icon fa fa-hand-o-right" style="color: red">Sau khi chấp nhân generate toàn bộ mật khẩu của học sinh sẽ trở về mật khẩu đầu tiên.</i></dt>
    </dl>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('generate', null,['class' => 'btn btn-success','id'=>'showConfig', "data-toggle"=>"modal","data-target"=>"#myModal"]) ?>
    </p>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
                </div>
                <div class="modal-body">
                    Bạn có muốn reset toàn bộ mật khẩu của học sinh?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="send">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">cảnh báo</h4>
                </div>
                <div class="modal-body" id="contentError">
                    Lỗi đã sảy ra
                    <br/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>

                </div>
            </div>
        </div>
    </div>
    <div id="gridview">
    <?= GridView::widget([
	    'dataProvider' => $dataProvider,
	    'filterModel' => $searchModel,
	    'pjax' => true,
	    'bordered' => true,
	    'responsive' => true,
	    'rowOptions' => ['style' => [
		    'text-align' => 'center'
	    ]],
	    'export'=>[ 'target'=>GridView::TARGET_SELF],
	    'toolbar' => [
		    ['content' =>
			     Html::a('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Thêm học sinh'), ['create'], ['class' => 'btn btn-success'])
		    ],
		    '{export}',
		    '{toggleData}',
	    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'MaHocSinh',

            [
                'attribute'=> 'MaHocSinh',
                'filterType'=>GridView::FILTER_SELECT2,
                'filterWidgetOptions'=>[
                    'data'=>ArrayHelper::map(DsHocSinh::ArrayNameAndIdStudent(),'MaHocSinh','HoVaTen'),
                    'options' => ['placeholder' => ' Tên học sinh...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
                'value'=>function($data)
                {
                    return $data->getFullName($data->MaHocSinh);
                },
                'label'=>'Họ và tên'

            ],

            //'DaQuaLop',

            [
                'attribute'=>'NgaySinh',
                'filterType'=>GridView::FILTER_DATE,
                'format'=>['date', 'php:d-m-Y']
            ],

             [
                 'attribute'=>'MatKhau',
                 'filter'=>false,
                 'value'=>function($data)
                 {
                     return $data->getDayOfBithToText($data->NgaySinh);
                 }
             ],
            // 'EmailPhuHuynh:email',
             'SoDienThoaiPhuHuynh',
            [
                'attribute'=>'DangKyDichVu',
                'value'=>function($data)
                {
                   if($data->DangKyDichVu==1)
                   {
                       return 'Có';
                   }
                   else
                       return "Không";
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>[0=>'Không',1=>'Có'],
                'filterWidgetOptions'=>[
                    'options' => ['placeholder' => 'Chọn...'],
                    'pluginOptions' => [
                        'allowClear' => true,

                    ],
                ]
            ],



            [
            		'class' =>ActionColumn::className(),
		            'header'=>'Action',
		            'template' => '{create} {update} {delete} {config_password}',
		            'buttons'=>[
			            'config_password'=>function($url,$model)
			            {
				            return  Html::a('<span class="fa fa-gavel"></span> ', Url::to(['config','id'=>$model->MaHocSinh]), [
				            ]);
			            }
		            ]
            ],
        ],
	    'panel' => [
		    'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách học sinh') . '</i>',
		    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset"), ['index'], ['class' => 'btn btn-info']),
		    'footer' => false
	    ]
    ]);

    ?>
    </div>
</div>
<a id="urlBase" style="display: none"><?= \yii\helpers\Url::toRoute(['/ds-hoc-sinh/change-all-pass'])?></a>
<script src="<?=$bundle->baseUrl?>/js/jsStudent.js"></script>
