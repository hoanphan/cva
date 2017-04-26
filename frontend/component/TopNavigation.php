<?php
namespace frontend\component;


use yii\base\Widget;

class TopNavigation extends Widget
{
    public function run()
    {
        return $this->render('topNavigation');
    }
}