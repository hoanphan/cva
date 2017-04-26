<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 8/11/2016
 * Time: 5:59 PM
 */

namespace backend\component;
use Yii;

class WidgetBase
{
     /**
     * @param      $controller
     * @param null $action
     * @param null $params
     *
     * @return string
     */
     public static function isActive($controller, $action = null, $params = null) {

        $string = '';
        if(!is_array($controller)) {
            $controller = [$controller];
        }
        if(!is_array($action) && $action != null) {
            $action = [$action];
        }
        if(!is_array($params) && $params != null) {
            $params = [$params];
        }
        if(in_array(Yii::$app->controller->id, $controller)) {
            if($action == null || ($action != null && in_array(Yii::$app->controller->action->id, $action))) {
                if($params == null || in_array($params, array_chunk(Yii::$app->controller->actionParams, 1, true))) {
                    $string = 'active';
                }
            }
        }
        if($string=='active'&&$action==null)
        {
            $string='active open';
        }
        return $string;
    }
}