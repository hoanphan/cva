<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/6/2016
 * Time: 2:19 AM
 */

namespace backend\BLL;


use backend\models\DsHocSinhChuyenTruong;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsHocSinhThoiHoc;
use backend\models\DSNamHoc;

class DSHocSinhThoiHocBLL
{
    /// <summary>
    /// Lấy mã học sinh thôi học theo học kỳ
    /// </summary>
    /// <param name="loaiThoiHoc">
    /// = 0 - Tự thôi học
    /// = 1 - Buộc thôi học
    /// = 2 - Tất cả</param>
    /// <param name="maHocKy">
    /// = maHocKy - Theo mã học kỳ
    /// = "" - Tất cả</param>
    /// <returns></returns>
    public static function LayMaHocSinhThoiHocTheoKy($loaiThoiHoc, $maHocKy)
    {
        $maNamHienTai = DSNamHoc::getCurrentYear();
        $HocSinhThoiHocs = null;
        switch ($loaiThoiHoc) {
            case 0:
//$HocSinhThoiHocs = DB.DSHocSinhThoiHocs.Where(q => q.MaNamHoc == maNamHienTai && q.BuocThoiHoc == false).ToList();
                $HocSinhThoiHocs = DsHocSinhThoiHoc::find()->where(['MaNamHoc' => $maNamHienTai, 'BuocThoiHoc' => 0])->all();
                break;
            case 1:
//HocSinhThoiHocs = DB.DSHocSinhThoiHocs.Where(q => q.MaNamHoc == maNamHienTai && q.BuocThoiHoc == true).ToList();
                $HocSinhThoiHocs = DsHocSinhThoiHoc::find()->where(['MaNamHoc' => $maNamHienTai, 'BuocThoiHoc' => 1])->all();
                break;
            case 2:
//$HocSinhThoiHocs = DB.DSHocSinhThoiHocs.Where(q => q.MaNamHoc == maNamHienTai).ToList();
                $HocSinhThoiHocs = DsHocSinhThoiHoc::find()->where(['MaNamHoc' => $maNamHienTai])->all();
                break;
            default:
                $HocSinhThoiHocs = null;
                break;
        }
        $arr = array();
        if ($HocSinhThoiHocs != null)
            if ($maHocKy == "") {
                $arr = array_column($HocSinhThoiHocs, 'MaHocSinh');
                return $arr;
            } else {
                //return HocSinhThoiHocs.Where(q => q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
                foreach ($HocSinhThoiHocs as $item) {
                    if ($item['MaHocKy'] == $maHocKy) {
                        array_push($arr, $item['MaHocKy']);
                    }
                }
                return $arr;
            }
        return null;
    }
    /// <summary>
    /// Lấy ra danh sách mã sinh viên chuyển trường theo năm học hiện tại
    /// </summary>
    /// <param name="loaiThoi"> = 1 - Buộc thôi học
    ///                           = 0 - Tự thôi học
    ///                           = 2 - Tất cả</param>
    /// <param name="maHocKy"> = HK1 - Mã học kỳ
    ///                           = "" - Tất cả</param>
    /// <returns>
    /// Mảng các chuỗi, mỗi chuỗi là một mã sinh viên chuyển trường theo loaiChuyen
    /// </returns>
    public static function LayMaHSThoiHoc($loaiThoi, $maHocKy)
    {
        $maNamHienTai = DSNamHoc::getCurrentYear();
        switch ($loaiThoi) {
            case 0:
                if ($maHocKy == "")
//return DB.DSHocSinhThoiHocs.Where(q => q.BuocThoiHoc == false).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhThoiHoc::find()->where(['BuocThoiHoc' => 0])->select('MaHocSinh')->all();
                else
//return DB.DSHocSinhThoiHocs.Where(q => q.BuocThoiHoc == false && q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhThoiHoc::find()->where(['BuocThoiHoc' => 0, 'MaHocKy' => $maHocKy])->select('MaHocSinh')->all();
            case 1:
                if ($maHocKy == "")
//return DB.DSHocSinhThoiHocs.Where(q => q.BuocThoiHoc == true).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhThoiHoc::find()->where(['BuocThoiHoc' => 1])->select('MaHocSinh')->all();
                else
//return DB.DSHocSinhThoiHocs.Where(q => q.BuocThoiHoc == true && q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhThoiHoc::find()->where(['BuocThoiHoc' => 1, 'MaHocKy' => $maHocKy])->select('MaHocSinh')->all();
            case 2:
                if ($maHocKy == "")
//return DB.DSHocSinhThoiHocs.Select(q => q.MaHocSinh).ToArray();
                    return DsHocSinhThoiHoc::find()->select('MaHocSinh')->all();
                else
                    return DsHocSinhThoiHoc::find()->where(['MaHocKy' => $maHocKy])->select('MaHocSinh')->all();
            default:
                return null;
        }
    }

    public static function MaHocSinhTheoLopChuaChuyenTruongThoiHoc($maHocKy, $maLop)
    {

        if ($maHocKy == "HK1")
            $dsMaHSChuyenTruong = DSHocSinhChuyenTruongBLL::LayMaHocSinhChuyenTruongTheoKy(true, $maHocKy);
        else
            $dsMaHSChuyenTruong = DSHocSinhChuyenTruongBLL::LayMaHSChuyenTruong(1, "");
        if ($maHocKy == "HK1")
            $dsMaHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHocSinhThoiHocTheoKy(2, $maHocKy);
        else
            $dsMaHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHSThoiHoc(2, "");
        $arr = array();
        $dsHocSinhTheoLops = DSHocSinhTheoLop::find()->where(['MaLop' => $maLop])->select('MaHocSinh')->all();
        foreach ($dsHocSinhTheoLops as $dsHocSinhTheoLop)
        {
            $kt=true;
            foreach($dsMaHSChuyenTruong as $item)
            {
                if($item==$dsHocSinhTheoLop)
                {
                    $kt=false;
                }
            }
            if($kt)
            {
                foreach($dsMaHSThoiHoc as $item)
                {
                    if($item==$dsHocSinhTheoLop)
                    {
                        $kt=false;
                    }
                }
            }
            if($kt)
                array_push($arr,$dsHocSinhTheoLop);
        }
/*        return DB . DSHocSinhTheoLops . Where(q => q . MaLop == maLop && !dsMaHSChuyenTruong . Contains(q . MaHocSinh) && !dsMaHSThoiHoc . Contains(q . MaHocSinh)).Select(q => q . MaHocSinh).ToArray();*/
        return $arr;
}

}