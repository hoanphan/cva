<?php
    use backend\assets\AppAsset;
    $bundle=AppAsset::register($this)
?>
<div class="navbar-header pull-left">
    <a href="index.html" class="navbar-brand">
        <small>
            <i class="fa fa-leaf"></i>
            CVA Student
        </small>
    </a>
</div>
<div class="navbar-buttons navbar-header pull-right" role="navigation">
    <ul class="nav ace-nav">





        <li class="light-blue">
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">

                <img class="nav-user-photo" src="<?=$bundle->baseUrl?>/avatars/user.jpg" alt="Jason's Photo">
                <span class="user-info">
									<small>Xin chào,</small>
                                    <?=\backend\models\DsHocSinh::getFullName(Yii::$app->user->id)?>
								</span>

                <i class="ace-icon fa fa-caret-down"></i>
            </a>

            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(["/site/profile"])?>">
                        <i class="ace-icon fa fa-user"></i>
                        Thay đổi thông tin
                    </a>
                </li>

                <li class="divider"></li>

                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(["/site/logout"])?>">
                        <i class="ace-icon fa fa-power-off"></i>
                        Đăng xuất
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>