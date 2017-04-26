<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/6/2016
 * Time: 2:41 AM
 */

namespace backend\BLL;


use backend\models\DSHocSinhTheoLop;
use backend\models\DsLop;
use backend\models\DSNamHoc;

class DSLopBLL
{
    public static function LaGVCN($maNguoiDung)
    {
//return DB.DSLops.Where(q => q.MaGVCN == maNguoiDung).Select(q => q.MaLop).FirstOrDefault();
        return DsLop::findOne(['MaGVCN' => $maNguoiDung])->MaLop;
    }

    public static function LayLopTheoGVCN($maGiaoVien)
    {
//return DB.DSLops.Where(q => q.MaGVCN == maGiaoVien).ToList();
        return DsLop::find()->where(['MaGVCN'=>$maGiaoVien])->all();
    }
    public static function LoadAll()
    {
    return DsLop::find()->all();
    }
    public static function getCuontClassInLeve($idLevel)
    {
        $dsLop=DsLop::find()->innerJoin(['dskhoi','dslop.MaKhoi=dskhoi.MaKhoi'])->where(['dskhoi.MaCap'=>$idLevel])->all();
        $sl=0;
        $idYear=DSNamHoc::getCurrentYear();
        foreach ($dsLop as $item)
        {
            if(DSHocSinhTheoLop::find()->where(['MaLop'=>$item->MaLop,'MaNamHoc'=>$idYear])->count()>0)
            {
                $sl++;
            }
        }
        return $sl;
    }
}