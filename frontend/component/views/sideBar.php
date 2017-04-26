<?php

use yii\helpers\Url;
use frontend\component\BaseWidget;
use backend\models\DsLop;


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

    <li class="<?=BaseWidget::isActive('site','diem')?>">
        <a href="<?=Url::toRoute(['/site/index'])?>">
            <i class="menu-icon glyphicon glyphicon-edit"></i>
            <span class="menu-text"> Điểm</span>
        </a>

        <b class="arrow"></b>
    </li>
    <li class="<?=BaseWidget::isActive('site','sldt')?>">
        <a href="<?=Url::toRoute(['/site/sldt'])?>">
            <i class="menu-icon glyphicon glyphicon-book"></i>
            <span class="menu-text"> Sổ liên lạc điện tử </span>
        </a>

        <b class="arrow"></b>
    </li>

    <!--<li class="<?/*=BaseWidget::isActive('ds-hoc-sinh','index')*/?>">
        <a href="<?/*=Url::toRoute(['/ds-hoc-sinh/index'])*/?>">
            <i class="menu-icon glyphicon glyphicon-edit"></i>
            <span class="menu-text"> Danh sách học sinh</span>
        </a>

        <b class="arrow"></b>
    </li>-->

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