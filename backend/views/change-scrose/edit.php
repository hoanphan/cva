<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\DSHocKy;
use backend\models\DSNamHoc;
use backend\models\DsMonHoc;
use backend\models\DsGiaoVien;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\ModelSearch\PhanCongGiangDaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Phan Cong Giang Days';
$this->params['breadcrumbs'][] = $this->title;
$bundle=\backend\assets\AppAsset::register($this);
?>
<?php if($stringCheck!=null):?>
    <a id="result" style="display: none"><?=$stringCheck?></a>
<?php else:?>
    <a id="result" style="display: none"></a>
<?php endif;?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                Bạn có muốn mở điểm lại toàn bộ cho giáo viên này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="success">Đồng ý</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialogSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                mở điểm thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dialogError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
<div class="phan-cong-giang-day-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'bordered' => true,
        'responsive' => true,
        'rowOptions' => ['style' => [
            'text-align' => 'center'
        ]],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>  'MaGiaoVien',
                'filterType'=>GridView::FILTER_SELECT2,
                'filterWidgetOptions'=>[

                    'data'=>ArrayHelper::map(DsGiaoVien::CreateListIdAndName(),'MaGiaoVien','HoTen')
                    ,
                    'options' => ['placeholder' => 'Chọn giáo viên ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
                'value'=>function($data)
                {
                    return $data->getTextTeacher($data->MaGiaoVien);
                },
                'label'=>'Tên giáo viên',
                'group'=>true,  // enable grouping
            ],
            [
                'attribute'=>'MaNamHoc',
                'filterType'=>GridView::FILTER_SELECT2,
                'filterWidgetOptions'=>[

                    'data'=>ArrayHelper::map(DSNamHoc::find()->where(['NamHienTai'=>1])->asArray()->all(),'MaNamHoc','TenNamHoc')
                    ,
                    'options' => ['placeholder' => 'Chọn năm học ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
                'value'=>function($data)
                {
                    return $data->getTextYear($data->MaNamHoc);
                },
                'label'=>'Tên năm học'
            ],
            [
                'attribute'=> 'MaHocKy',
                'filterType'=>GridView::FILTER_SELECT2,
                'filterWidgetOptions'=>[
                    'data'=>ArrayHelper::map(DSHocKy::find()->where(['TongHop'=>0])->asArray()->all(),'MaHocKy','TenHocKy'),
                    'options' => ['placeholder' => 'Chọn học kỳ ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
                'value'=>function($data)
                {
                    return $data->getTextSemester($data->MaHocKy);
                },
                'label'=>'Tên học kỳ'

            ],
            [
                'attribute'=> 'MaMonHoc',
                'filterType'=>GridView::FILTER_SELECT2,
                'filterWidgetOptions'=>[
                    'data'=>ArrayHelper::map(DsMonHoc::find()->asArray()->all(),'MaMonHoc','TenMonHoc'),
                    'options' => ['placeholder' => 'Chọn môn học ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
                'value'=>function($data)
                {
                    return $data->getTextSubject($data->MaMonHoc);
                },
                'label'=>'Tên môn học'

            ],

            [
                'attribute'=> 'MaLop',
                'filter'=>false,

                'value'=>function($data)
                {
                    return $data->getTextClass($data->MaLop);
                },
                'label'=>'Tên lớp'

            ],

            [
                'class' => '\kartik\grid\ActionColumn',
                'template'    => '{change}',
                'buttons' => [
                    'change' => function ($url,$data) {
                        $MaMonHoc=$data->MaMonHoc;
                        return Html::a('<span class="fa fa-cog"></span>',Url::toRoute(['change','idSubject'=>$data->MaMonHoc,'idSemester'=>$data->MaHocKy,'idClass'=>$data->MaLop ]), [
                            'data-confirm'=>'Bạn có muốn mở điểm lại toàn bộ cho giáo viên này?',
                            'data-method'=>'post',

                            'class'=>'btnChange']);
                    }
                ],
            ]

        ],
        'panel' => [
            'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách phân công giảng dạy') . '</i>',
            'footer' => false
        ]
    ]); ?>

</div>
<a id="urlChange" style="display: none"></a>
<script>
    $(document).ready(function () {
        var str=$('#result').text();
        if(str=="1")
        {
            $('#dialogSuccess').modal();
        }
        else
        if(str=="2")
            $('#dialogError').modal();
    })
</script>

