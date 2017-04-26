<?php

use yii\helpers\Url;
use backend\component\WidgetBase;
use backend\component\BaseWidget;
use backend\models\DsLop;
use backend\BLL\RoleBLL;
use backend\BLL\DsHocSinhChuyenTruongBLL;

?>
<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success">
            <i class="ace-icon fa fa-signal"></i>
        </button>

        <button class="btn btn-info">
            <i class="ace-icon fa fa-pencil"></i>
        </button>

        <button class="btn btn-warning">
            <i class="ace-icon fa fa-users"></i>
        </button>

        <button class="btn btn-danger">
            <i class="ace-icon fa fa-cogs"></i>
        </button>
    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>
</div>
<ul class="nav nav-list" style="top: 0px;">
    <li class="<?=BaseWidget::isActive('site','index')?>">
        <a href="<?=Url::toRoute(['/site/index'])?>">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>

        <b class="arrow"></b>
    </li>
    <?php if((RoleBLL::checkFunction(0))):?>
   <li class="<?=BaseWidget::isActive('send','index')?>">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-desktop"></i>
            <span class="menu-text">
								Admin
							</span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu nav-hide" style="display: none;">
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Dịch vụ
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class=""<?=BaseWidget::isActive('send','index')?>"">
                        <a href="<?=Url::toRoute(['/send/index'])?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                           Gmail
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class=""<?=BaseWidget::isActive('send','sns')?>"">
                    <a href="<?=Url::toRoute(['/send/sms'])?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Sms
                    </a>

                    <b class="arrow"></b>
                    </li>

                </ul>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Kiểm tra
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class=""<?=BaseWidget::isActive('admin','check-input-scroses')?>"">
                    <a href="<?=Url::toRoute(['/admin/check-input-scroses'])?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Nhập điểm
                    </a>

                    <b class="arrow"></b>
                    </li>
                    <li class=""<?=BaseWidget::isActive('send','sns')?>"">
                    <a href="<?=Url::toRoute(['/send/sms'])?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                      Khác
                    </a>

                    <b class="arrow"></b>
                    </li>

                </ul>
            </li>


        </ul>
    </li>
    <?php endif?>
    <?php if((RoleBLL::checkFunction(0))):?>
    <li class="<?=BaseWidget::isActive('ds-hoc-sinh-chuyen-truong','transfer-school')?>">
        <a href="<?=Url::toRoute(['/hoc-sinh-chuyen-truong/transfer-school'])?>">
            <i class="menu-icon glyphicon glyphicon-edit"></i>
            <span class="menu-text"> Chuyển trường</span>
        </a>

        <b class="arrow"></b>
    </li>
    <?php endif; ?>
    <li class="<?=BaseWidget::isActive('ds-diem','index')?>">
        <a href="<?=Url::toRoute(['/ds-diem/index'])?>">
            <i class="menu-icon glyphicon glyphicon-edit"></i>
            <span class="menu-text"> Nhập điểm</span>
        </a>

        <b class="arrow"></b>
    </li>
    <?php if(DsHocSinhChuyenTruongBLL::KiemTraHocSinhChuyenTruong()):?>
        <li class="<?=BaseWidget::isActive('hoc-sinh-chuyen-truong','index')?>">
            <a href="<?=Url::toRoute(['/hoc-sinh-chuyen-truong/index'])?>">
                <i class="menu-icon fa fa-exchange"></i>
                <span class="menu-text">Hs chuyển trường</span>
            </a>

            <b class="arrow"></b>
        </li>
    <?php endif;?>
    <?php if ((DsLop::isHomeroomTeacher(Yii::$app->user->id))||RoleBLL::checkFunction(0)||RoleBLL::checkFunction(5)):?>
    <li class="<?=BaseWidget::isActive('so-lien-lac-dien-tu','index')?>">
        <a href="<?=Url::toRoute(['/so-lien-lac-dien-tu/index'])?>">
            <i class="menu-icon glyphicon glyphicon-book"></i>
            <span class="menu-text"> Sổ liên lạc điện tử </span>
        </a>

        <b class="arrow"></b>
    </li>
    <?php endif;?>
    <?php if (RoleBLL::checkFunction(0)||RoleBLL::checkFunction(5)||DsLop::isHomeroomTeacher(Yii::$app->user->id)):?>
    <li class="<?=BaseWidget::isActive('report')?>">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-pencil-square-o"></i>
            <span class="menu-text"> Báo cáo </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            <li class="<?=BaseWidget::isActive('report','report')?>">
                <a href="<?=Url::toRoute(['/report/report'])?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Theo Lớp
                </a>

                <b class="arrow"></b>
            </li>
            <?php if(RoleBLL::checkFunction(0)||RoleBLL::checkFunction(5)):?>
            <li class="<?=BaseWidget::isActive('report','report-group')?>">
                <a href="<?=Url::toRoute(['/report/report-group'])?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Theo Khối
                </a>

                <b class="arrow"></b>
            </li>


            <li class="<?=BaseWidget::isActive('report','report-level')?>">
                <a href="<?=Url::toRoute(['/report/report-level'])?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Học lực theo cấp
                </a>

                <b class="arrow"></b>
            </li>
                <li class="<?=BaseWidget::isActive('report','report-hl-mon-hoc')?>">
                    <a href="<?=Url::toRoute(['/report/report-hl-mon-hoc'])?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Dân tộc
                    </a>

                    <b class="arrow"></b>
                </li>

            <li class="<?=BaseWidget::isActive('report','report-conduct-caption')?>">
                <a href="<?=Url::toRoute(['/report/report-conduct-caption'])?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                   Hạnh kiểm và học lực
                </a>

                <b class="arrow"></b>
            </li>
                <li class="<?=BaseWidget::isActive('report','report-danhhieu')?>">
                    <a href="<?=Url::toRoute(['/report/report-danhhieu'])?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Theo danh hiệu
                    </a>

                    <b class="arrow"></b>
                </li>
            <?php endif;?>
        </ul>
    </li>
    <?php endif;?>
    <?php if (RoleBLL::checkFunction(0)||RoleBLL::checkFunction(6)):?>
    <?php endif;?>
    <?php if (RoleBLL::checkFunction(3)):?>
        <li class="<?=BaseWidget::isActive('change-scrose','edit')?>">
            <a href="<?=Url::toRoute(['/change-scrose/edit','str'=>0])?>">
                <i class="menu-icon fa fa-cogs"></i>
                <span class="menu-text"> Sửa điểm</span>
            </a>

            <b class="arrow"></b>
        </li>
    <?php endif;?>
    <?php if (RoleBLL::checkFunction(0)):?>
    <li class="<?=BaseWidget::isActive('ds-hoc-sinh','index')?>">
        <a href="<?=Url::toRoute(['/ds-hoc-sinh/index'])?>">
            <i class="menu-icon glyphicon glyphicon-edit"></i>
            <span class="menu-text"> Danh sách học sinh</span>
        </a>

        <b class="arrow"></b>
    </li>
    <?php endif;?>
    <?php if ((DsLop::isHomeroomTeacher(Yii::$app->user->id))||RoleBLL::checkFunction(0)||RoleBLL::checkFunction(5)):?>
    <li class="<?=BaseWidget::isActive('summary','index')?>">
        <a href="<?=Url::toRoute(['/summary/index'])?>">
            <i class="menu-icon fa fa-list-alt"></i>
            <span class="menu-text"> Tổng kết </span>
        </a>
        <b class="arrow"></b>
    </li>
    <?php endif;?>
    <?php if ((DsLop::isHomeroomTeacher(Yii::$app->user->id))):?>
    <li class="<?=BaseWidget::isActive('summary','conduct')?>">
        <a href="<?=Url::toRoute(['/summary/conduct'])?>">
            <i class="menu-icon fa fa-list-alt"></i>
            <span class="menu-text"> Xét hạnh kiểm </span>
        </a>

        <b class="arrow"></b>
    </li>
    <?php endif;?>
    <?php if (RoleBLL::checkFunction(0)):?>
    <li class="<?=BaseWidget::isActive('student-follow-class','index')?>">
        <a href="<?=Url::toRoute(['/student-follow-class/index'])?>">
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text">Học sinh theo lớp </span>
        </a>

        <b class="arrow"></b>
    </li>
    <?php endif;?>
    <!-- <li class="">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-pencil-square-o"></i>
            <span class="menu-text"> Forms </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            <li class="">
                <a href="form-elements.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Form Elements
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="form-elements-2.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Form Elements 2
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="form-wizard.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Wizard &amp; Validation
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="wysiwyg.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Wysiwyg &amp; Markdown
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="dropzone.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Dropzone File Upload
                </a>

                <b class="arrow"></b>
            </li>
        </ul>
    </li>

    <li class="">
        <a href="widgets.html">
            <i class="menu-icon fa fa-list-alt"></i>
            <span class="menu-text"> Widgets </span>
        </a>

        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="calendar.html">
            <i class="menu-icon fa fa-calendar"></i>

            <span class="menu-text">
								Calendar

								<span class="badge badge-transparent tooltip-error" title="" data-original-title="2 Important Events">
									<i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
								</span>
							</span>
        </a>

        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="gallery.html">
            <i class="menu-icon fa fa-picture-o"></i>
            <span class="menu-text"> Gallery </span>
        </a>

        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-tag"></i>
            <span class="menu-text"> More Pages </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            <li class="">
                <a href="profile.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    User Profile
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="inbox.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Inbox
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="pricing.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Pricing Tables
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="invoice.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Invoice
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="timeline.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Timeline
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="email.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Email Templates
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="login.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Login &amp; Register
                </a>

                <b class="arrow"></b>
            </li>
        </ul>
    </li>

    <li class="">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-file-o"></i>

            <span class="menu-text">
								Other Pages

								<span class="badge badge-primary">5</span>
							</span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            <li class="">
                <a href="faq.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    FAQ
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="error-404.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Error 404
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="error-500.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Error 500
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="grid.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Grid
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="blank.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Blank Page
                </a>

                <b class="arrow"></b>
            </li>
        </ul>
    </li>-->
</ul>
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>