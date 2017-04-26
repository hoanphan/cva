<?php
use frontend\models\DSTuan;
use frontend\models\SoLienLacDienTu;
use frontend\models\DSNamHoc;

/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/24/2016
 * Time: 4:26 AM
 */
$bundel = \frontend\assets\AppAsset::register($this);
$yearCurrent = DSNamHoc::getCurrentYear();
$listWeek = DSTuan::find()->where(['MaNamHoc' => $yearCurrent])->orderBy(['MaTuan' => SORT_DESC])->all();
$this->title='Cổng thông tin đào tạo Trường Chu Văn An - Sổ liên lạc điện tử';
?>
<div style="margin-left: 30px">
    <?php for ($i = 0; $i < count($listWeek); $i++): ?>
        <div>
            <a id="<?php echo $listWeek[$i]->MaTuan; ?>">
                <div class="row">
                    <div class="col-xs-5 label label-lg label-success arrowed-in arrowed-right"
                         STYLE="margin-bottom: 5px; text-align: left">
                        <?php echo $listWeek[$i]->TenTuan; ?>
                    </div>
                </div>
            </a>
            <div class="col-xs-12" id="<?php echo 'a' . $listWeek[$i]->MaTuan; ?>" style="display: none">
                <?= SoLienLacDienTu::getContent(Yii::$app->user->id, $listWeek[$i]->MaTuan, $yearCurrent) ?>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#<?php echo $listWeek[$i]->MaTuan;?>').click(function () {
                    $("#<?php echo 'a' . $listWeek[$i]->MaTuan;?>").fadeToggle();
                    var img = $(this).find('img');
                    var scr = img.attr('src');
                    if (scr == '/images/Add.png')
                        img.attr('src', '<?=$bundel->baseUrl?>/images/sub.png');
                    else
                        img.attr('src', '<?=$bundel->baseUrl?>/images/Add.png');

                });
            })
        </script>
    <?php endfor; ?>
</div>
