<?php
    use frontend\models\DsHocSinh;
?>
<div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->


    <div class="table-header">
        Danh sách điểm
    </div>

    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div class="table-responsive">

        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th rowspan="2">STT</th>
                <th rowspan="2">Mã học sinh</th>
                <th rowspan="2">Tên học sinh</th>
                <th rowspan="2">Ngày sinh</th>
                <?php for ($i = 0; $i < count($listTypeScores); $i++): ?>
                    <?php if ($listTypeScores[$i]->SoDiemToiDa > 1): ?>
                        <th colspan="<?= $listTypeScores[$i]->SoDiemToiDa ?>"><?= $listTypeScores[$i]->TenLoaiDiem ?></th>
                    <?php else: ?>
                        <th rowspan="2"><?= $listTypeScores[$i]->TenLoaiDiem ?></th>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
            <tr>
                <?php for ($i = 0; $i < count($listTypeScores); $i++): ?>
                    <?php if ($listTypeScores[$i]->SoDiemToiDa > 1): ?>
                        <?php for ($j = 1; $j <= $listTypeScores[$i]->SoDiemToiDa; $j++): ?>
                            <th><?= $listTypeScores[$i]->HienThi . $j ?></th>
                        <?php endfor; ?>

                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($listStudent); $i++): ?>
                <?php $student = DsHocSinh::getFullName($listStudent[$i]->MaHocSinh) ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $listStudent[$i]->MaHocSinh ?></td>
                    <?php if ($student != null): ?>
                        <td></td>
                        <td></td>
                    <?php else: ?>
                        <td>Unknown</td>
                        <td>Unknown</td>
                    <?php endif; ?>
                   <!-- <?php /*for ($j = 0; $j < count($listTypeScores); $j++): */?>
                        <?php /*for ($z = 0; $z < $listTypeScores[$j]->SoDiemToiDa; $z++): */?>
                            <td><?/*= $scores = Dsdiem::getScoresFollowStudent($listStudent[$i]->MaHocSinh, $YearCurrent, 'K1', 'MH01', $listTypeScores[$j]->MaLoaiDiem, ($z + 1)) */?></td>
                        <?php /*endfor; */?>
                    --><?php /*endfor; */?>
                </tr>
            <?php endfor; ?>
            </tbody>


        </table>

    </div>

</div><!-- /.col -->