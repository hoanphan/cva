<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/15/2016
 * Time: 9:00 PM
 */

namespace backend\BLL;


use backend\models\DMHanhKiem;
use backend\models\DmHocLuc;
use backend\models\DsDiem;
use backend\models\DsHocSinhChuyenTruong;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsHocSinhThoiHoc;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DSTongKetTheoKy;
;

class TongKetTheoKyBLL
{
    public static function LayTongKetTheoKy($maHocKy)
    {
//return DB.DSTongKetTheoKies.Where('MaHocKy' == maHocKy).ToList();
        return DSTongKetTheoKy::find()->where(['MaHocKy' => $maHocKy])->all();
    }

    /**
     * @param $maHocKy
     * @param $tenDangNhap
     * @return array
     */
    public static function TongKetTheoKyTheoLop($maHocKy, $tenDangNhap)
    {
        $dsMaHSChuyenTruong = array();
        if ($maHocKy == "K1")
            $dsMaHSChuyenTruong = self::LayMaHocSinhChuyenTruongTheoKy(true, $maHocKy);
        else
            $dsMaHSChuyenTruong = self::LayMaHocSinhChuyenTruongTheoKy(true, "");
        $dsMaHSThoiHoc = array();
        if ($maHocKy == "K1")
            $dsMaHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHocSinhThoiHocTheoKy(2, $maHocKy);
        else
            $dsMaHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHocSinhThoiHocTheoKy(2, "");
        $maLop = DSLopBLL::LaGVCN($tenDangNhap);
        $arr = array();
        if ($maLop != null) {
            $dsMaHocSinhTheoLops = DSHocSinhTheoLopBLL::MaHocSinhTheoLopKy($maLop, $maHocKy);
            foreach ($dsMaHocSinhTheoLops as $dsMaHocSinhTheoLop) {
                $kt = true;
                foreach ($dsMaHSChuyenTruong as $item) {
                    if ($item == $dsMaHocSinhTheoLop)
                        $kt = false;
                }
                if ($kt) {
                    if(count($dsMaHSThoiHoc)>0)
                    foreach ($dsMaHSThoiHoc as $item) {
                        if ($item == $dsMaHocSinhTheoLop)
                            $kt = false;
                    }
                }
                if ($kt)
                    array_push($arr, DSTongKetTheoKy::findOne(['MaHocSinh' => $dsMaHocSinhTheoLop, 'MaHocKy' => $maHocKy]));
            }
            return $arr;
        } else
            //return DB . DSTongKetTheoKies . Where(q => q . MaHocKy == maHocKy && !dsMaHSChuyenTruong . Contains(q . MaHocSinh) && !dsMaHSThoiHoc . Contains(q . MaHocSinh)).ToList();
            $DsTongKetTheoKys = DSTongKetTheoKy::find()->where(['MaHocKy' => $maHocKy])->all();
        foreach ($DsTongKetTheoKys as $dsTongKetTheoKy) {
            $kt = true;
            foreach ($dsMaHSChuyenTruong as $item) {
                if ($item == $dsTongKetTheoKy->MaHocSinh)
                    $kt = false;
            }
            if ($kt) {
                foreach ($dsMaHSThoiHoc as $item) {
                    if ($item == $dsTongKetTheoKy->MaHocSinh)
                        $kt = false;
                }
            }
            if ($kt)
                array_push($arr, $dsTongKetTheoKy);
        }
    }


    public static function LayMaHocSinhChuyenTruongTheoKy($chuyenDi, $maHocKy)
    {
        //return DsHocSinhChuyenTruong::.Where(q => q.ChuyenDi == chuyenDi && q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
        return DsHocSinhChuyenTruong::find()->where(['ChuyenDi' => $chuyenDi, 'MaHocKy' => $maHocKy])->select('MaHocSinh')->all();
    }
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
    public static function MaHocSinhTheoLopChuaChuyenTruongThoiHoc($maHocKy, $maLop)
    {

        if ($maHocKy == "HK1")
            $dsMaHSChuyenTruong = self::LayMaHocSinhChuyenTruongTheoKy(true, $maHocKy);
        else
            $dsMaHSChuyenTruong = self::LayMaHSChuyenTruong(1, "");
        if ($maHocKy == "HK1")
            $dsMaHSThoiHoc = self::LayMaHocSinhThoiHocTheoKy(2, $maHocKy);
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
    public static function LayDiemTB($maHocSinh, $maHocKy, $maLoaiDiem)
    {
        return DSDiem::find()->Where(['MaHocSinh' => $maHocSinh, 'MaHocKy' => $maHocKy, 'MaLoaiDiem' => $maLoaiDiem])->all();
    }
    public static function XetHocLuc($maHocKy, $tenDangNhap)
    {
//List<DSLop> Lops;
        if (DSLopBLL::LaGVCN($tenDangNhap) != null)
            $Lops = DSLopBLL::LayLopTheoGVCN($tenDangNhap);
        else
            $Lops = DSLopBLL::LoadAll();
        $maLoaiDiemTongHop = DSLoaiDiemBLL::LoadMaLoaiDiemTongHop();
        $TongKetTheoKies = self::LayTongKetTheoKy($maHocKy);
        foreach ($Lops as $lop) {
            $MonHocTheoLops = DsMonHocTheoLopBLL::LayMonHocTheoLopKy($lop->MaLop, $maHocKy);
            $maHocSinhTheoLops = self::MaHocSinhTheoLopChuaChuyenTruongThoiHoc($maHocKy, $lop->MaLop);
            foreach ($maHocSinhTheoLops as $maHocSinh) {
                $DiemTBs = self::LayDiemTB($maHocSinh, $maHocKy, $maLoaiDiemTongHop);
                //$TBC = (float)Math.Round((decimal)TongKetTheoKies.Where(q => q.MaHocSinh == maHocSinh).Select(q => q.TrungBinhChung).FirstOrDefault(),1,MidpointRounding.AwayFromZero);
                $TBC = round(DSTongKetTheoKy::findOne(['MaHocSinh' => $maHocSinh])->TrungBinhChung, 2);
                $ToanVan80 = false;
                $ToanVan65 = false;
                $ToanVan50 = false;
                $duoi65 = 0;
                $duoi50 = 0;
                $duoi35 = 0;
                $duoi20 = 0;
                $monKhongDat = 0;
                foreach ($DiemTBs as $DiemTB) {
                    if ($DiemTB->Diem == -3)
                        $monKhongDat++;
                    if (($DiemTB->Diem < 2) && ($DiemTB->Diem > 0)) {
                        $duoi20++;
                        $duoi35++;
                        $duoi65++;
                    }
                    if (($DiemTB->Diem < 3.5) && ($DiemTB->Diem > 0)) {
                        $duoi35++;
                        $duoi50++;
                        $duoi65++;
                    }
                    if (($DiemTB->Diem < 5) && ($DiemTB->Diem > 0)) {
                        $duoi50++;
                        $duoi65++;
                    }
                    if (($DiemTB->Diem < 6.5) && ($DiemTB->Diem > 0)) {
                        $duoi65++;
                    }
                    /*if ((DiemTB.DSMonHoc.XetHocLuc == true) && ($DiemTB->Diem >= 5))
                    {
                        ToanVan50 = true;
                    }*/
                    if ((DSMonHocBLL::KiemTraXetHocLuc(($DiemTB->MaMonHoc)) == 1) && ($DiemTB->Diem >= 5)) {
                        $ToanVan50 = true;
                    }
                    /*if ((DiemTB.DSMonHoc.XetHocLuc == true) && ($DiemTB->Diem >= 6.5))
                    {
                        ToanVan65 = true;
                    }*/
                    if ((DSMonHocBLL::KiemTraXetHocLuc(($DiemTB->MaMonHoc)) == 1) && ($DiemTB->Diem >= 6.5)) {
                        $ToanVan65 = true;
                    }
                    /*if ((DiemTB.DSMonHoc.XetHocLuc == true) && ($DiemTB->Diem >= 8))
                    {
                        ToanVan80 = true;
                    }*/
                    if ((DSMonHocBLL::KiemTraXetHocLuc(($DiemTB->MaMonHoc)) == 1) && ($DiemTB->Diem >= 8)) {
                        $ToanVan80 = true;
                    }
                }
                $DatHocLuc = 0;
                /*if ((ToanVan80 == true) && ($duoi65 == 0) && (monKhongDat == 0) && (TBC >= 8))
                    DatHocLuc = 1;
                if ((ToanVan65 == true) && ($duoi50 == 0) && (monKhongDat == 0) && (TBC >= 6.5) && (DatHocLuc == 0))
                    DatHocLuc = 2;
                if ((ToanVan50 == true) && (duoi35 == 0) && (monKhongDat == 0) && (TBC >= 5) && (DatHocLuc == 0))
                    DatHocLuc = 3;
                if ((duoi20 == 0) && (TBC >= 3.5) && (DatHocLuc == 0))
                    DatHocLuc = 4;
                if (DatHocLuc == 0)
                    DatHocLuc = 5;
                int i;*/
                if (($ToanVan80 == true) && ($duoi65 == 0) && ($monKhongDat == 0) && ($TBC >= 8))
                    $DatHocLuc = 1;
                if (($ToanVan65 == true) && ($duoi50 == 0) && ($monKhongDat == 0) && ($TBC >= 6.5) && ($DatHocLuc == 0))
                    $DatHocLuc = 2;
                if (($ToanVan50 == true) && ($duoi35 == 0) && ($monKhongDat == 0) && ($TBC >= 5) && ($DatHocLuc == 0))
                    $DatHocLuc = 3;
                if (($duoi20 == 0) && ($TBC >= 3.5) && ($DatHocLuc == 0))
                    $DatHocLuc = 4;
                if ($DatHocLuc == 0)
                    $DatHocLuc = 5;

                //if (maHocSinh == "HS00217")
                //    i = 0;
                //Xử lý trường hợp chỉ có 1 môn làm ảnh hưởng đến học lực tổng
                //Xử lý trường hợp với các môn tính điểm
                if ($monKhongDat == 0) {
                    if (($TBC >= 8) && ($duoi50 == 1) && ($DatHocLuc == 3))
                        $DatHocLuc = 2;
                    if (($TBC >= 8) && ($duoi35 == 1) && ($DatHocLuc == 4))
                        $DatHocLuc = 3;
                    if (($TBC >= 6.5) && ($duoi35 == 1) && ($DatHocLuc == 4))
                        $DatHocLuc = 3;
                    if (($TBC >= 6.5) && ($duoi20 == 1) && ($DatHocLuc == 5))
                        $DatHocLuc = 4;
                } else {
                    if ($monKhongDat == 1) {
                        if (($TBC >= 8) && ($duoi50 == 0) && ($DatHocLuc == 3))
                            $DatHocLuc = 2;
                        if (($TBC >= 8) && ($duoi35 == 0) && ($DatHocLuc == 4))
                            $DatHocLuc = 3;
                        if (($TBC >= 6.5) && ($duoi35 == 0) && ($DatHocLuc == 4))
                            $DatHocLuc = 3;
                        if (($TBC >= 6.5) && ($duoi20 == 0) && ($DatHocLuc == 5))
                            $DatHocLuc = 4;
                    }
                }
                //Xử lý trường hợp với các môn đánh giá xếp loại


                /*  DSTongKetTheoKy TongKetTheoKy = DB . DSTongKetTheoKies . Where(q => q . MaHocSinh == maHocSinh && q . MaHocKy == maHocKy).FirstOrDefault();
                  TongKetTheoKy . MaHocLuc = DB . DMHocLucs . Where(q => q . MucUuTien == $DatHocLuc).Select(q => q . MaHocLuc).FirstOrDefault();*/

                $tongKetTheoKy = DSTongKetTheoKy::findOne(['MaHocSinh' => $maHocSinh, 'MaHocKy' => $maHocKy]);
                $tongKetTheoKy->MaHocLuc = DmHocLuc::findOne(['MucUuTien' => $DatHocLuc])->MaHocLuc;
                $tongKetTheoKy->save();
            }
        }

    }

    public static function XetHocLucTheoDSLop($maHocKy, $tenLops)
    {
//string[] maLops = DB.DSLops.Where(q => tenLops.Contains(q.TenLop)).Select(q => q.MaLop).ToArray();
        $maLops = array();
        $ThongBao = "";
        foreach ($tenLops as $tenLop) {
            $maLop = DsLop::findOne($tenLop)->TenLop;
            array_push($maLops, $maLop);
        }
        foreach ($maLops as $maLop) {
// $maGVCN = DB.DSLops.Where(q => q.MaLop == maLop).Select(q => q.MaGVCN).FirstOrDefault();
            $maGVCN = DsLop::findOne($maLop)->MaGVCN;
            $danhSachMonChuaNhapDiemHocKy = "";
            if (DSDiemBLL::KiemTraNhapDiemHocKyCacMonHoc($maHocKy, $maGVCN, $danhSachMonChuaNhapDiemHocKy) == true) {
                self::XetHocLuc($maHocKy, $maGVCN);
            } else {
                /*UTL . Ultils . ThongBao("Chưa cập nhật điểm học kỳ ở các môn: " + danhSachMonChuaNhapDiemHocKy
                    + "\r\nVui lòng nhập đầy đủ trước khi thực hiện chức năng này.", MessageBoxIcon . Error);*/
                $ThongBao = "Chưa cập nhật điểm học kỳ ở các môn: " . $danhSachMonChuaNhapDiemHocKy
                    . "\r\nVui lòng nhập đầy đủ trước khi thực hiện chức năng này.";
            }
        }
        return $ThongBao;
    }

    public static function XetDanhHieu($maHocKy, $tenDangNhap)
    {
        $str = null;
        $TongKetTheoKies = self::TongKetTheoKyTheoLop($maHocKy, $tenDangNhap);
        $TieuChuanDanhHieus = TieuChuanDanhHieuBLL::LoadAll();
        $idYear=DSNamHoc::getCurrentYear();
        $kiemTraDieuKienXetDanhHieu = true;
//foreach (DSTongKetTheoKy TongKetTheoKy in TongKetTheoKies)
        foreach ($TongKetTheoKies as $tongKetTheoKy) {
            /*if (($TongKetTheoKy . MaHocLuc == null) || (TongKetTheoKy . MaHanhKiem == null))
                kiemTraDieuKienXetDanhHieu = false;*/
            if (($tongKetTheoKy->MaHocLuc == null) || ($tongKetTheoKy->MaHanhKiem == null))
                $kiemTraDieuKienXetDanhHieu = false;
        }
        if ($kiemTraDieuKienXetDanhHieu == true) {
            foreach ($TongKetTheoKies as $tongKetTheoKy) {
                $MaDanhHieu = TieuChuanDanhHieuBLL:: LayMaDanhHieu($tongKetTheoKy->MaHocLuc, $tongKetTheoKy->MaHanhKiem);
                $tongKetTheoKy=DSTongKetTheoKy::findOne(['MaHocSinh'=>$tongKetTheoKy->MaHocSinh,'MaHocKy'=>$maHocKy,'MaNamHoc'=>$idYear]);
                var_dump($tongKetTheoKy->MaHocSinh.' '.$MaDanhHieu);
              $tongKetTheoKy->MaDanhHieu=$MaDanhHieu;
                $tongKetTheoKy->save();
                if($MaDanhHieu==null) {
                    $tongKetTheoKy = DSTongKetTheoKy::findOne(['MaHocSinh' => $tongKetTheoKy->MaHocSinh, 'MaHocKy' => $maHocKy, 'MaNamHoc' => $idYear]);

                }
            }
        } else {
            $str = "Vui lòng nhập đầy đủ thông tin Hạnh kiểm trước khi thực hiện chức năng này.";
        }
        return $str;
    }

    public static function XetDanhHieuTheoDSLop($maHocKy, $tenLops)
    {
//string[] maLops = DB.DSLops.Where(q => tenLops.Contains(q.TenLop)).Select(q => q.MaLop).ToArray();
        $maLops = array();
        foreach ($tenLops as $tenLop) {
            array_push($maLops, DsLop::findOne(['TenLop' => $tenLops])->MaLop);
        }
        foreach ($maLops as $maLop) {
//$maGVCN = DB.DSLops.Where(q => q.MaLop == maLop).Select(q => q.MaGVCN).FirstOrDefault();
            $maGVCN = DsLop::findOne($maLop)->MaGVCN;
            Self::XetDanhHieu($maHocKy, $maGVCN);
        }
    }
    public static  function  getNameConduct($idStudent,$idSemester)
    {
        $idYear=DSNamHoc::getCurrentYear();
        if(self::getIdConduct($idStudent,$idSemester)!=null) {
            $maHanhKiem = DSTongKetTheoKy::findOne(['MaHocSinh' => $idStudent, 'MaHocKy' => $idSemester, 'MaNamHoc' => $idYear])->MaHanhKiem;
            if ($maHanhKiem != null)
                return DMHanhKiem::findOne($maHanhKiem)->MaHanhKiem;
            else
                return "-";
        }
        else
            return "-";
    }
    public  static function  getIdConduct($idStudent,$idSemester)
    {
        $idYear=DSNamHoc::getCurrentYear();
        return DSTongKetTheoKy::findOne(['MaHocSinh'=>$idStudent,'MaHocKy'=>$idSemester,'MaNamHoc'=>$idYear]);
    }
    public static function addConduct($idStudent,$idSemester,$idConduct)
    {
        $conduct=self::getIdConduct($idStudent,$idSemester);
        $conduct->MaHanhKiem=$idConduct;
         return $conduct->save();
    }
}