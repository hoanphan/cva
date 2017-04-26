<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/6/2016
 * Time: 2:37 AM
 */

namespace backend\BLL;


use backend\models\DsDiem;
use backend\models\DsLoaiDiem;

class DSLoaiDiemBLL
{
    public static function LoadMaDiemHocKy()
    {
//return DB.DSLoaiDiems.Where(q => q.LaHocKy == true).Select(q => q.MaLoaiDiem).FirstOrDefault();
        return DsLoaiDiem::findOne(['LaHocKy'=>1])->MaLoaiDiem;
    }
    public static function LoadMaLoaiDiemTongHop()
    {
       // return DB.DSLoaiDiems.Where(q => q.TinhToan == false).Select(q => q.MaLoaiDiem).FirstOrDefault().ToString();
        return DsLoaiDiem::findOne(['TinhToan'=>0])->MaLoaiDiem;
    }
}