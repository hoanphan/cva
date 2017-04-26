<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/12/2016
 * Time: 3:24 PM
 */

namespace backend\BLL;


use backend\models\TieuChuanDanhHieu;

class TieuChuanDanhHieuBLL
{
    public static function LayMaDanhHieu($maHocLuc, $maHanhKiem)
    {
//return DB.TieuChuanDanhHieus.Where(q => q.MaHocLuc == maHocLuc && q.MaHanhKiem == maHanhKiem).Select(q => q.MaDanhHieu).FirstOrDefault();

    if(TieuChuanDanhHieu::findOne(['MaHocLuc'=>$maHocLuc,'MaHanhKiem'=>$maHanhKiem])!=null)
        return TieuChuanDanhHieu::findOne(['MaHocLuc'=>$maHocLuc,'MaHanhKiem'=>$maHanhKiem])->MaDanhHieu;
    else
        return "";
    }
public static function LoadAll()
{
    /*return DB.TieuChuanDanhHieus.ToList();*/
    return TieuChuanDanhHieu::find()->all();
}
}