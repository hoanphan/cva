<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/9/2016
 * Time: 10:49 AM
 */

namespace backend\BLL;


use backend\models\DSHocKy;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsMonHoc;
use backend\models\DSNamHoc;
use frontend\models\DsMonHocTheoLop;

class DsMonHocTheoLopBLL extends DsMonHocTheoLop
{
    public static function getListSubjectFollowClass($idClass, $idSemester)
    {
        $idYear = DSNamHoc::getCurrentYear();
        if(DSHocKy::getSemesterSummary()->MaHocKy!=$idSemester)
              return DsMonHocTheoLop::find()->where(['MaNamHoc' => $idYear, 'MaLop' => $idClass, 'MaHocKy' => $idSemester])->all();
        else
             return DsMonHocTheoLop::find()->where(['MaNamHoc' => $idYear, 'MaLop' => $idClass])->groupBy('MaMonHoc')->all();
    }

    public static function LayMaMonHocTheoLopHocKy($maLop, $maHocKy)
    {
//return DB.DSMonHocTheoLops.Where(q => q.MaLop == maLop && q.MaHocKy == maHocKy).OrderBy(q=>q.MaMonHoc).Select(q => q.MaMonHoc).ToArray();
        return DsMonHocTheoLop::find()->where(['MaLop' => $maLop, 'MaHocKy' => $maHocKy])->orderBy(['MaMonHoc' => SORT_ASC])->select('MaMonHoc')->all();
    }

    public static function LayMonHocTheoLopKy($maLop, $maHocKy)
    {
        $dsMaMonHocTheoLopKy = Self::LayMaMonHocTheoLopHocKy($maLop, $maHocKy);
        $arr = array();
        for ($i = 0; $i < count($dsMaMonHocTheoLopKy); $i++) {
            $MonHoc = DsMonHoc::find()->where(['MaMonHoc' => $dsMaMonHocTheoLopKy[$i]])->all();
            array_push($arr, $MonHoc[0]);
        }
        return $arr;
    }

    /**
     * @param $idLevel
     * @param $idSubject
     */
    public static function LaySoLuongHocSinhHocMonHocCap($idLevel, $idSubject)
    {
        $idYear=DSNamHoc::getCurrentYear();
       return DSHocSinhTheoLop::find()->innerJoin('dsmonhoctheolop','dsmonhoctheolop.MaLop=dshocsinhtheolop.MaLop')
            ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dslop.MaKhoi=dskhoi.MaKhoi')
            ->where(['dshocsinhtheolop.MaNamHoc'=>$idYear,'dsmonhoctheolop.MaMonhoc'=>$idSubject,'dskhoi.MaCap'=>$idLevel])->count();
    }
}