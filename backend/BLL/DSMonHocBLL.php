<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/6/2016
 * Time: 2:44 AM
 */

namespace backend\BLL;


use backend\models\DsMonHoc;
use frontend\models\DsMonHocTheoLop;
use yii\db\Query;
use yii\rbac\Item;

class DSMonHocBLL
{
    public static function LayMonHocDuocTinhHeSoTheoLopKy($maLop, $maHocKy)
    {
//string[] DSMaMonHocTheoLop = DB.DSMonHocTheoLops.Where(q => q.MaLop == maLop && q.MaHocKy == maHocKy).Select(q => q.MaMonHoc).ToArray();
        $DSMaMonHocTheoLop = DsMonHocTheoLop::find()->where(['MaLop' => $maLop, 'MaHocKy' => $maHocKy])->select('MaMonHoc')->all();
        $dsMonHoc = DsMonHoc::find()->andWhere(['not', ['HeSo' => 0]])->all();

        $arr = array();
        foreach ($dsMonHoc as $item) {
            foreach ($DSMaMonHocTheoLop as $MaMonHoc)
                if ($item->MaMonHoc == $MaMonHoc['MaMonHoc']) {
                    array_push($arr, $item);
                }
        }
        return $arr;
//return DB.DSMonHocs.Where(q => DSMaMonHocTheoLop.Contains(q.MaMonHoc) && q.HeSo != 0).ToList();
    }

    public static function KiemTraXetHocLuc($maHocLuc)
    {
        return DsMonHoc::findOne($maHocLuc)->XetHocLuc;
    }

    public static function LayMonHocTheoLopKy($maLop, $maHocKy)
    {
//$DSMaMonHocTheoLop = DB.DSMonHocTheoLops.Where(q => q.MaLop == maLop && q.MaHocKy == maHocKy).Select(q => q.MaMonHoc).ToArray();
        $DSMaMonHocTheoLops = DsMonHocTheoLop::find()->where(['MaLop' => $maLop, 'MaHocKy' => $maHocKy])->select('MaMonHoc')->all();
        $arr = array();

        foreach ($DSMaMonHocTheoLops as $DSMaMonHocTheoLop) {
            $dsMonHoc = DsMonHoc::find()->where(['MaMonHoc' => $DSMaMonHocTheoLop])->all();
            array_push($arr, $dsMonHoc[0]);
        }
        return $arr;
//return DB.DSMonHocs.Where(q => DSMaMonHocTheoLop.Contains(q.MaMonHoc)).ToList();
    }
    public static function LaChoDiem($id)
    {
        return DsMonHoc::findOne($id)->MaHinhThucDanhGia;
    }

    /**
     * @param $idLevel
     * @return array|\yii\db\ActiveRecord[] moon hocj theo caaps
     */
    public static function LayDanhSachMonHocTheoCap($idLevel)
    {
        if($idLevel=="TTHCS")
        {
            return DsMonHoc::find()->where(['>','ThuTuThongKeTHCS',0])->orderBy(['ThuTuThongKeTHCS'=>SORT_ASC])->all();
        }
        else
            return DsMonHoc::find()->where(['>','ThuTuThongKeTHPT',0])->orderBy(['ThuTuThongKeTHCS'=>SORT_ASC])->all();
    }
}