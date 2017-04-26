<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/9/2016
 * Time: 3:38 AM
 */

namespace backend\BLL;


use backend\models\DSCap;

class DSCapBLL extends DSCap
{
    public static function getNamCap($MaCap)
    {
        return DSCap::findOne($MaCap)->TenCap;
    }
}