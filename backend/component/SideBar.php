<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 8/11/2016
 * Time: 10:44 AM
 */

namespace backend\component;
use yii\base\Widget;

class SideBar extends Widget
{
    public function run()
    {
        return $this->render('sideBar');
    }
}
