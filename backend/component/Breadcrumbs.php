<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 8/11/2016
 * Time: 10:49 AM
 */

namespace backend\component;

use yii\base\Widget;



class Breadcrumbs extends Widget
{
    public function run()
    {
       return $this->render('breadcrumb');
    }
}