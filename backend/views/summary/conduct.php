<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/17/2016
 * Time: 3:34 PM
 */
use backend\models\DMHanhKiem;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DSTuan;
use backend\BLL\TongKetTheoKyBLL;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin();
$listConduct = DMHanhKiem::find()->all();
$this->title = 'Cổng thông tin đào tạo Trường Chu Văn An - Tổng kết';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    table {
        border-color: #0a0a0a;
    }
</style>
<div style="display: none">
    <?php for ($i = 0; $i < count($model); $i++): ?>
    <a class="listStudent"><?=$model[$i]->MaHocSinh?></a>
    <?php endfor;?>
</div>
<div class="col-xs-12">
    <div class="col-xs-6">
        <?=$form->field($semester, 'MaHocKy')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(DSHocKy::find()->all(),'MaHocKy','TenHocKy'),

            'pluginOptions' => [
                'allowClear' => true
            ],
            'id'=>'semester'
        ]);?>
    </div>
    <div class="col-xs-6">
        <br>
             <span>
                        <?=
                            Html::button('<i class="glyphicon glyphicon-envelope"></i> Lưu', ['class' => 'btn btn-primary', ' data-toggle' => "modal", 'id' => "add"]) ?>
                            </span>
        <div id="cb"style="display: block">
            <select  name=""  class="form-control">
                <option value="" ></option>
                <?php for ($i = 0; $i < count($listConduct); $i++): ?>

                    <option value="<?= $listConduct[$i]->MaHanhKiem ?>" ><?= $listConduct[$i]->TenHanhKiem ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
</div>
</div>
<div class="col-xs-12">
    <div id="tableresult">
        <div id="w0-pjax" data-pjax-container="" data-pjax-push-state="" data-pjax-timeout="1000">
            <div id="w0" class="grid-view hide-resize" data-krajee-grid="kvGridInit_a1899889">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="pull-right">

                        </div>
                        <h3 class="panel-title">
                        </h3>
                        <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Danh sách hạnh kiểm</h3>

                        <div class="clearfix"></div>
                    </div>
                    <div class="kv-panel-before">
                        <div class="pull-right">
                            <div class="btn-toolbar kv-grid-toolbar" role="toolbar">


                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div id="w0-container" class="table-responsive kv-grid-container">

                        <table id="table" class="table table-striped table-bordered table-hover kv-grid-table kv-table-wrap"
                               style="table-layout: fixed; width: 100%">
                            <thead>
                            <tr class="size-row">
                                <th class="floatThead-col" style="text-align: center">STT</th>
                                <th class="floatThead-col" style="text-align: center">Mã học sinh</th>
                                <th class="floatThead-col" style="text-align: center">Tên học sinh</th>
                                <th class="floatThead-col" style="text-align: center">Ngày sinh</th>
                                <th class="floatThead-col" style="text-align: center">Hạnh kiểm</th>

                            </tr>

                            </thead>
                            <tbody>
                            <?php $tabindex = 0 ?>
                            <?php for ($i = 0; $i < count($model); $i++): ?>
                                <?php $student = DsHocSinh::getStudent($model[$i]->MaHocSinh) ?>
                                <tr>
                                    <td style="text-align: center"> <?= $model[$i]->STT ?></td>
                                    <td style="text-align: center">
                                        <?= $model[$i]->MaHocSinh ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php echo DsHocSinh::getFullName($model[$i]->MaHocSinh) ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php if ($student != null): ?>
                                            <?= DSTuan::formatDate($student->NgaySinh) ?>
                                        <?php else: ?>
                                            <?= 'Unknown' ?>
                                        <?php endif; ?>
                                    </td>

                                    <td class="addCb" id="<?= $student->MaHocSinh ?>">
                                       <p style="display: none"> <?=TongKetTheoKyBLL::getNameConduct($student->MaHocSinh,$idSemester)?></p>
                                    </td>

                                </tr>
                            <?php endfor; ?>
                            </tbody>

                        </table>
                    </div>
                    <div class="kv-panel-after"></div>
                    <div class="panel-footer">
                        <div class="kv-panel-pager">

                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end()?>
<script>
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang sử lí xin chờ....</h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');
    var dialogGetData = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang lấy dữ liệu xin chờ....</h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');
    $(document).ready(function () {


        $('.addCb').each(function () {
            var id = $(this).attr('id');
            var cb = $('#cb');
            var text1=$(this).find('p').text();
            $("#cb").find('option:selected').removeAttr("selected");
            if(text1!="-")
            {

                $("#cb").find('option').each(function () {

                    if($(this).val().toString().trim()==text1.toString().trim())
                    {
                        console.log($(this).val()+" "+text1);
                        $(this).attr('selected','selected');

                    }
                    else
                    {
                        $(this).removeAttr("selected");
                    }

                })
            }

            cb.find('select').attr('name', id);
            var text = cb.html();
            $(this).append(text);
        });
        $('#cb').remove();
        $('#add').click(function () {
            btnAddClickEvent();
        })
    });
    function btnAddClickEvent() {
        var idSemester=$('#dshocky-mahocky').val();
        if(idSemester!="") {
            $dialog.modal();
            $('.listStudent').each(function () {
                var idStudent = $(this).text();
                var maHocSinh = "select[name=" + $(this).text() + "]";
                var idConduct = $(maHocSinh).val();
                if(idStudent=='HS00206')
                    alert(idConduct);
                if (idConduct != ""&&idConduct!=null)
                    ajaxAddConduct(idStudent, idSemester, idConduct);
            });
            $dialog.modal('hide');
        }
        else
        {
            alert('Tên học kỳ không để trống');
        }
    }


    function ajaxAddConduct(idStudent,idSemester,idConduct)
    {
        $.ajax({
            url: '<?=Url::to(['add-conduct'])?>',
            type: 'POST',
            data: {
                idStudent: idStudent,
                idSemester:idSemester,
                idConduct:idConduct
            },
            success: function (result) {
               console.log(result);

            },
            error: function (jqxhr, textStatus, errorThrown) {
                alert(textStatus);

            }
        })
    }
    $(document).on('change','#dshocky-mahocky',function () {
        dialogGetData.modal();
        var idSemester=$('#dshocky-mahocky').val();
      $.ajax({
          url:'<?=Url::to(['get-list-conduct'])?>',
          type: 'POST',
          data: {
              idSemester:idSemester,
          },
          success: function (result) {
              dialogGetData.modal('hide');
              $('#table').remove();
              $('#w0-container').append(result);
          },
          error: function (jqxhr, textStatus, errorThrown) {
              alert(textStatus);

          }
      })
    })
</script>