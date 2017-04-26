<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/15/2016
 * Time: 9:32 PM
 */

namespace backend\BLL;


use backend\models\DsHocSinhChuyenTruong;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSNamHoc;

class DSHocSinhTheoLopBLL
{
    public static function MaHocSinhTheoLopChuaChuyenTruongThoiHoc($maHocKy, $maLop)
    {
        $dsMaHSChuyenTruong = array();
        if ($maHocKy == "HK1")
            $dsMaHSChuyenTruong = DSHocSinhChuyenTruongBLL::LayMaHocSinhChuyenTruongTheoKy(true, $maHocKy);
        else
            $dsMaHSChuyenTruong = DSHocSinhChuyenTruongBLL::LayMaHSChuyenTruong(1, "");
//string[] dsMaHSThoiHoc;
        $dsMaHSThoiHoc = array();
        if ($maHocKy == "HK1")
            $dsMaHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHocSinhThoiHocTheoKy(2, $maHocKy);
        else
            $dsMaHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHSThoiHoc(2, "");
//return DB.DSHocSinhTheoLops.Where(q => q.MaLop == maLop && !dsMaHSChuyenTruong.Contains(q.MaHocSinh) && !dsMaHSThoiHoc.Contains(q.MaHocSinh)).Select(q => q.MaHocSinh).ToArray();
        $arr = array();
        $dsHocSinh = DSHocSinhTheoLop::find()->where(['MaLop' => $maLop])->all();
        for ($i = 0; $i < count($dsHocSinh); $i++) {
            $kt = true;
            foreach ($dsMaHSChuyenTruong as $item) {
                if ($dsHocSinh[$i]->MaHocSinh == $item) {
                    $kt = false;
                }
            }
            if ($kt)
                foreach ($dsMaHSThoiHoc as $item) {
                    if ($dsHocSinh[$i]->MaHocSinh == $item) {
                        $kt = false;
                    }
                }
            if ($kt)
                array_push($arr, $dsHocSinh[$i]);
        }
        return $arr;
    }
    /// <summary>
    /// Lấy ds mã học sinh chuyển trường trong kỳ 2
    /// Dùng trong trường hợp HS chuyển đến kỳ 2 thì sẽ không lấy để xuất hiện trong kỳ 1
    /// </summary>
    /// <param name="chuyenDi">=1: Chuyển đi; =0: Chuyển đến</param>
    /// <param name="maHocKy"></param>
    /// <returns></returns>
    public static function LayMaHocSinhChuyenTruongLechKy()
    {
        // return DB.DSHocSinhChuyenTruongs.Where(q => q.ChuyenDi == false && q.MaHocKy == "K2").Select(q => q.MaHocSinh).ToArray();
        return  DsHocSinhChuyenTruong::find()->where(['ChuyenDi'=>0,'MaHocKy'=>'K2'])->select('MaHocSinh')->all();
    }
    /**
     * @param $maLop
     * @param $maHocKy
     * @return string
     */
    public static function LayMaHSChuyenTruong($loaiChuyen, $maHocKy)
    {
        $maNamHienTai = DSNamHoc::getCurrentYear();
        switch ($loaiChuyen) {
            case 0:
                if ($maHocKy == "")
//return DB.DSHocSinhChuyenTruongs.Where(q => q.ChuyenDi == false).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhChuyenTruong::find()->where(['ChuyenDi' => 0])->select('MaHocSinh')->all();
                else
//return DB.DSHocSinhChuyenTruongs.Where(q => q.ChuyenDi == false && q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhChuyenTruong::find()->where(['ChuyenDi' => 0, 'MaHocKy' => $maHocKy])->select('MaHocSinh')->all();
            case 1:
                if ($maHocKy == "")
//return DB.DSHocSinhChuyenTruongs.Where(q => q.ChuyenDi == true).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhChuyenTruong::find()->where(['ChuyenDi' => 1])->select('MaHocSinh')->all();
                else
                    /*return DB.DSHocSinhChuyenTruongs.Where(q => q.ChuyenDi == true && q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();*/
                    return DsHocSinhChuyenTruong::find()->where(['ChuyenDi' => 1, 'MaHocKy' => $maHocKy])->select('MaHocSinh')->all();
            case 2:
                if ($maHocKy == "")
//return DB.DSHocSinhChuyenTruongs.Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhChuyenTruong::find()->select('MaHocSinh')->all();
                else
//return DB.DSHocSinhChuyenTruongs.Where(q => q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhChuyenTruong::find()->where(['MaHocKy' => $maHocKy])->select('MaHocSinh')->all();
            default:
                return null;
        }
    }
    /// <summary>
    /// Lấy ds mã học sinh chuyển trường trong kỳ 2
    /// Dùng trong trường hợp HS chuyển đến kỳ 2 thì sẽ không lấy để xuất hiện trong kỳ 1
    /// </summary>
    /// <param name="chuyenDi">=1: Chuyển đi; =0: Chuyển đến</param>
    /// <param name="maHocKy"></param>
    /// <returns></returns>


    public static function MaHocSinhTheoLopKy($maLop, $maHocKy)
    {
        $maDSHSChuyenDenKy2 = self::LayMaHocSinhChuyenTruongLechKy();
        $maDSHSThoiHocKy2 = DSHocSinhThoiHocBLL::LayMaHocSinhThoiHocTheoKy(2, $maHocKy);

        $maDSHSChuyenDi = self::LayMaHSChuyenTruong(1, $maHocKy);
        if ($maHocKy == "K2" || $maHocKy == "K3") {


            $maDSHSThoiHocKy2 = DSHocSinhThoiHocBLL::LayMaHocSinhThoiHocTheoKy(2, "");
            $maDSHSChuyenDi = self::LayMaHSChuyenTruong(1, "");
        }
        $arr = array();
        $dsHocSinhTheoLops = DSHocSinhTheoLop::find()->where(['MaLop' => $maLop])->select('MaHocSinh')->all();
        foreach ($dsHocSinhTheoLops as $dsHocSinhTheoLop) {
            $kt = true;
            foreach ($maDSHSChuyenDi as $item)
                if ($dsHocSinhTheoLop->MaHocSinh == $item)
                    $kt = false;
            if ($kt) {
                foreach ($maDSHSChuyenDenKy2 as $item)
                    if ($dsHocSinhTheoLop->MaHocSinh == $item)
                        $kt = false;
            }
            if ($kt) {
                if(count($maDSHSThoiHocKy2)>0)
                foreach ($maDSHSThoiHocKy2 as $item)
                    if ($dsHocSinhTheoLop->MaHocSinh == $item)
                        $kt = false;
            }
            if ($kt)
                array_push($arr, $dsHocSinhTheoLop);
        }
        return $arr;

    }

}