<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 10/18/2016
 * Time: 3:24 PM
 */
use backend\models\DSHocKy;
use kartik\datecontrol\DateControl;
use kartik\field\FieldRange;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;


$form = ActiveForm::begin();
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                Bạn có muốn lấy dữ liệu  không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="get">Đồng ý</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Thieu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">cảnh báo</h4>
            </div>
            <div class="modal-body" id="contentError">
                Không để trường ngày bắt đầu hoặc ngày kết thúc trống
                <br/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>

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
<div class="row">
    <a style="display: none" id="countTeacher"><?php echo \backend\models\DsGiaoVien::find()->count()?></a>
    <div class="col-xs-12">
        <div class="col-xs-3">
            <label></label>
           <?php echo $form->field($semester, 'TenHocKy')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(DSHocKy::find()->where(['TongHop' => 0])->asArray()->all(), 'MaHocKy', 'TenHocKy'),

            ])->label(false); ?>
        </div>
        <div class="col-xs-6">
            <?php echo FieldRange::widget([
                'form' => $form,
                'model' => $model,
                'attribute1' => 'BatDauTuNgay',
                'attribute2' => 'KetThucNgay',
                'type' => FieldRange::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'widgetOptions1' => [
                    'options' => [
                        'pluginOptions' => ['autoclose' => true,],
                    ],
                ],
                'widgetOptions2' => [


                    'options' => [
                        'pluginOptions' => ['autoclose' => true,],
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-xs-3">
            <label></label></br>
            <button type="button" class="btn btn-primary" data-toggle="button" id="get1">Lấy dữ liệu</button>
        </div>
    </div>
</div>
<script>
    var countTeacher=parseInt($('#countTeacher').text())-1;
    var dateStart;
    var dateEnd;
    var semester;
        $('#get1').click(function () {
                dateStart= $('#dstuan-batdautungay').val();
                dateEnd=$('#dstuan-ketthucngay').val();
                 semester=$('#dshocky-tenhocky').val();
            if(dateStart!=""&&dateEnd!="") {
                $('#myModal').modal();
            }
            else
                $('#Thieu').modal();
        })

    var gt=0;
    var dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang trong quá trình xử lý</h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress">'+
        '<div id="value" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">'+
        '100% Complete (success)'
        +'</div> </div></div></div>' +
        '</div>' +
        '</div></div></div>');
    $('#get').click(function () {
        $('#myModal').modal('hide');
        $.ajax({
            url: '<?=\yii\helpers\Url::toRoute('/admin/check-input-scroses-delete-all')?>',
            type: 'POST',
            success: function () {
                dialog.modal();
                ajax();
            },
            error:function(jqxhr,textStatus,errorThrown)
            {
                $('#contentError').append(errorThrown);
                dialog.modal('hide');
                $('#myModal1').modal();
            }
        });

    });
    function ajax() {
        $.ajax({
            url: '<?=\yii\helpers\Url::toRoute('/about/check-input-scroses-ajax')?>',
            type: 'POST',
            data: {dateStart:dateStart,dateEnd:dateEnd,semester:semester},
            success: function (result) {

                    window.location='<?=\yii\helpers\Url::toRoute(['/ds-gv-chua-nhap/index'])?>'

            },
            error:function(jqxhr,textStatus,errorThrown)
            {
                $('#contentError').append(errorThrown);
                dialog.modal('hide');
                $('#myModal1').modal();
            }
        });
    }
</script>
