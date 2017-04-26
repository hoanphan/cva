<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$bundle=\frontend\assets\AppAssetLogin::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?=$bundle->baseUrl?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<!--header start here-->
<div style="margin-top: 5%"
<h1></h1>
<div class="content-w3ls">
    <div class="form-agileits">

        <?php echo $content?>
    </div>
</div>
</div>
<div style="margin-top: 15%;  width: 40%; margin-left: auto; margin-right: auto">
    <p class="copyright">© 2016 Chu Van An | Design by <a href="http://namnguyengt.com/" target="_blank">Nam Nguyen</a> - Hotline:(+84)98 252 7337</p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
