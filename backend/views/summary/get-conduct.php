<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 4/1/2017
 * Time: 8:50 AM
 */
use backend\models\DMHanhKiem;
use backend\models\DsHocSinh;
use backend\models\DSTuan;
use backend\BLL\TongKetTheoKyBLL;
$listConduct = DMHanhKiem::find()->all();
?>

<div style="display: none" class="remove">
    <?php for ($i = 0; $i < count($model); $i++): ?>
        <a class="listStudent"><?= $model[$i]->MaHocSinh ?></a>
    <?php endfor; ?>
</div>
<div class="col-xs-12 remove">
    <div class="col-xs-6">
        <div id="cb" style="display: block">
            <select name="" class="form-control">
                <option value=""></option>
                <?php for ($i = 0; $i < count($listConduct); $i++): ?>

                    <option value="<?= $listConduct[$i]->MaHanhKiem ?>"><?= $listConduct[$i]->TenHanhKiem ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
</div>
</div>


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
                <p style="display: none"> <?= TongKetTheoKyBLL::getNameConduct($student->MaHocSinh, $idSemester) ?></p>
            </td>

        </tr>
    <?php endfor; ?>
    </tbody>

</table>

<script>
    $(document).ready(function () {


        $('.addCb').each(function () {
            var id = $(this).attr('id');
            var cb = $('#cb');
            var text1 = $(this).find('p').text();
            $("#cb").find('option:selected').removeAttr("selected");
            if (text1 != "-") {

                $("#cb").find('option').each(function () {

                    if ($(this).val().toString().trim() == text1.toString().trim()) {
                        console.log($(this).val() + " " + text1);
                        $(this).attr('selected', 'selected');

                    }
                    else {
                        $(this).removeAttr("selected");
                    }

                })
            }

            cb.find('select').attr('name', id);
            var text = cb.html();
            $(this).append(text);
        });
        $('#cb').remove();
        $('.remove').remove();
    });
</script>