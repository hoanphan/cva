<?php
namespace backend\component;
 use yii\bootstrap\Widget;
 use yii;

 class BaseWidget extends Widget
 {
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
     public static function isActiveContent()
     {
          $getController=Yii::$app->controller->id;

            switch ($getController)
            {
                case 'bac':
                    return 'active open';
                    break;
                case 'ngach':
                    return 'active open';
                    break;
                case 'phong-khoa':
                    return 'active open';
                    break;
                case 'to-bo-mon':
                    return 'active open';
                    break;
                case 'lop':
                    return 'active open';
                    break;
                case 'teacher':
                    return 'active open';
                    break;
                case 'mon-hoc':
                    return 'active open';
                    break;
                case'ten-dinh-muc':
                    return 'active open';
                    break;
                default :
                    return '';
                    break;
            }
     }
 }