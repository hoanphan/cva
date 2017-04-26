<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->basePath = '@app/backend/web';
        $this->css = [
            'font-awesome/4.2.0/css/font-awesome.min.css',
            'fonts/fonts.googleapis.com.css',
            'css/ace.min.css',
        ];
        $this->js = [
            'js/ace-extra.min.js',

        ];
        $this->depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
            'yii\bootstrap\BootstrapPluginAsset'
        ];
        $this->jsOptions['position']=View::POS_HEAD;

    }


}
