<?php
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\DSHocKy;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$form=ActiveForm::begin();
$bundel=\backend\assets\AppAsset::register($this);
?>
    <a id="countStudent" style="display: none"><?=\backend\models\DSHocSinhTheoLop::find()->count()?></a>
<div class="">
    <div class="col-sm-2">
        <div class="form-group field-account-lev0">
            <br/>
            <label class="">Tháng </label>
            <label id="month" value="<?=\backend\models\DsThang::getMonthCurrent()?>"><?=\backend\models\DsThang::getMonthCurrent()?></label>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group field-account-lev0">
            <?php /** @var TYPE_NAME $form */
            echo $form->field($semester, 'TenHocKy')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DSHocKy::find()->where(['TongHop' => 0])->asArray()->all(), 'MaHocKy', 'TenHocKy'),
            ]); ?>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group field-account-lev3">
            <div class="form-group field-dslop-tenlop" style="margin-top: 20px;">

                        <span>
                        <?= Html::a(
                            Html::button('<i class="glyphicon glyphicon-envelope"></i> Gửi gmail', ['class' => 'btn btn-primary', ' data-toggle' => "modal", 'id' => "mail"])) ?>
                            </span>
            </div>
        </div>
    </div>

</div>

<div class="col-sm-12">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'resizableColumns' => true,
    'pjax' => true,
    'bordered' => true,
    'responsive' => true,
    'rowOptions' => ['style' => [
        'text-align' => 'center'
    ]],
    'headerRowOptions' => ['style' => [
        'text-align' => 'center'
    ]],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'MaHocSinh',
        'HoDem',
        'Ten',
         'EmailPhuHuynh:email',
         'SoDienThoaiPhuHuynh',
         [
             'attribute'=>'DangKyDichVu',
             'value'=>function($data)
             {
                 if($data->DangKyDichVu==1)
                     return 'Có';
                 else
                     return 'Không';
             }
         ],

    ],
    'panel' => [
        'heading' => '<i><i class="glyphicon glyphicon-leaf"></i>' . Yii::t('app', 'Danh sách học sinh sử dụng dịch vụ') . '</i>',
        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>' . Yii::t("app", " Reset") . '.', ['index'], ['class' => 'btn btn-info']),
        'footer' => false
    ]
]); ?>
</div>
<script>
    var gt=0;
    var countStudent=parseInt($('#countStudent').text());
    $(document).ready(function () {
        $('textarea').remove();
        var dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;">Đang thư</h3></div>' +
            '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress">'+
            '<div id="value" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">'+
            '0% Complete (success)'
            +'</div> </div></div></div>' +
            '</div>' +
            '</div></div></div>');
        $('#mail').click(function () {
            gt=0;
            var month=$('#month').text();
            var semester=$('#dshocky-tenhocky').val();
            dialog.modal()
            ajax(month,semester);
        })
    });
    function ajax(month,semester) {
        $.ajax({
            url:'<?=Url::toRoute(['about/send-gmail'])?>',
            type:'POST',
            data:{
                month:month,
                semester:semester,
                index:gt
            },
            success: function (result) {
                gt=parseInt(result);
                var i=parseInt(result);
                i=Math.round((i/countStudent)*100,2);
                $('#value').text(i + '% Complete (success)');
                $('#value').width(i+'%');
                if(gt!=countStudent)
                    ajax(month,semester);
                else {
                    dialog.modal('hide');

                }
            },
            error:function(jqxhr,textStatus,errorThrown)
            {
                setErrorText(textStatus);
                dialog.modal('hide');
                dialogError.modal();
            }
        })
    }
</script>
<?php ActiveForm::end()?>