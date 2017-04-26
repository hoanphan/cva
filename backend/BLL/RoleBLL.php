<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 10/11/2016
 * Time: 3:24 PM
 */

namespace backend\BLL;


use backend\models\DsChucNang;
use backend\models\DsGiaoVien;
use backend\models\DsQuyenChucNang;
use DateTime;

class RoleBLL
{
    private static function getRoleFollowTeacher()
    {
        return DsGiaoVien::findOne(\Yii::$app->user->id)->MaQuyen;
    }
    private static function getListRoleAndFunction()
    {
        $id=self::getRoleFollowTeacher();
        return DsQuyenChucNang::find()->where(['MaQuyen'=>$id])->all();
    }
    public static function checkFunction($_function)
    {
        $kt=false;
        $list=self::getListRoleAndFunction();
        foreach ($list as $item)
        {
            $function=DsChucNang::findOne($item->MaChucNang);
            if($function->ChucNang==$_function)
            {
                $kt=true;
                break;
            }
        }
        return $kt;
    }
    public static function ConvertStringToDate($str)
    {
        $date = explode('-', $str);
        $date1=new DateTime();
        return $date1->setDate((int)$date[0],(int)$date[1],(int)$date[2]);
    }
    public static function ConvertStringToMonth($str)
    {
        $date = explode('-', $str);
        $date1=new DateTime();
        return $date[1];
    }
}