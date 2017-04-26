<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/6/2016
 * Time: 2:06 AM
 */

namespace backend\BLL;


use backend\models\DmHocLuc;
use backend\models\DmHocLucTheoDiemThi;
use backend\models\DsDiem;
use backend\models\DsHocSinh;
use backend\models\DsHocSinhChuyenTruong;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsLoaiDiem;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use frontend\models\DsMonHoc;

class DsDiemBLL
{

    /// <summary>
    /// Dùng để kiểm tra việc nhập điểm Học kỳ của các môn học được tính hệ số trong TBC trong một lớp
    /// dựa trên Mã học kỳ và Tên đăng nhập (ứng với Giáo viên chủ nhiệm)
    /// </summary>
    /// <returns>
    /// Trả về True nếu tất cả các điểm học kỳ đã được nhập
    /// Trả về False nếu có một phần điểm chưa được nhập
    /// </returns>
    public static function KiemTraNhapDiemHocKyCacMonHocDuocTinhTBC($maHocKy, $tenDangNhap)
    {
        $maDSHSChuyenTruong = DsHocSinhChuyenTruongBLL::LayMaHocSinhChuyenTruongTheoKy(true, $maHocKy);
        $maDSHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHocSinhThoiHocTheoKy(2, $maHocKy);
        $danhSachMon = "";
        $maLop = DsLopBLL::LaGVCN($tenDangNhap);
        $maLoaiDiem = DSLoaiDiemBLL::LoadMaDiemHocKy();
        $MonHocs = DSMonHocBLL::LayMonHocDuocTinhHeSoTheoLopKy($maLop, $maHocKy);
        $HocSinhs = array();
        if ($maLop != null) //HocSinhs = DB.DSHocSinhTheoLops.Where(q => q.MaLop == maLop && !maDSHSChuyenTruong.Contains(q.MaHocSinh) && !maDSHSThoiHoc.Contains(q.MaHocSinh)).Select(q => q.DSHocSinh).ToList();
        {
            $DsHocSinhTheoLop = DSHocSinhTheoLop::find()->where(['MaLop' => $maLop])->all();
            foreach ($DsHocSinhTheoLop as $item) {
                $check = true;
                foreach ($maDSHSChuyenTruong as $hocSinhChuyenTruong) {
                    if ($hocSinhChuyenTruong == $item['MaHocSinh']) {
                        $check = false;
                        break;
                    }
                }
                foreach ($maDSHSThoiHoc as $hocThoiHoc) {
                    if ($hocThoiHoc == $item['MaHocSinh']) {
                        $check = false;
                        break;
                    }
                }
                $HocSinh = DsHocSinh::findOne($item->MaHocSinh);
                if ($check) {
                    array_push($HocSinhs, $HocSinh);
                }

            }
        } else {
            //  HocSinhs = DB . DSHocSinhTheoLops . Where(q => !maDSHSChuyenTruong . Contains(q . MaHocSinh) && !maDSHSThoiHoc . Contains(q . MaHocSinh)).Select(q => q . DSHocSinh).ToList();
            $DsHocSinhTheoLop = DSHocSinhTheoLop::find()->all();
            foreach ($DsHocSinhTheoLop as $item) {
                $check = true;
                foreach ($maDSHSChuyenTruong as $hocSinhChuyenTruong) {
                    if ($hocSinhChuyenTruong == $item['MaHocSinh']) {
                        $check = false;
                        break;
                    }
                }
                foreach ($maDSHSThoiHoc as $hocThoiHoc) {
                    if ($hocThoiHoc == $item['MaHocSinh']) {
                        $check = false;
                        break;
                    }
                }
                $HocSinh = DsHocSinh::findOne($item->MaHocSinh);
                if ($check) {
                    array_push($HocSinhs, $HocSinh);
                }
            }
//string[] MaHocSinhs = HocSinhs . Select(q => q . MaHocSinh).ToArray();
//foreach (MonHoc in MonHocs)
            foreach ($MonHocs as $monHoc) {
                foreach ($HocSinhs as $hocSinh)
                    if (DsDiem::findOne(['MaHocSinh' => $hocSinh->MaHocSinh, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $monHoc->MaMonHoc, 'MaLoaiDiem' => $maLoaiDiem, 'MaNamHoc' => DSNamHoc::getCurrentYear()]) == null) {
                        $danhSachMon .= " " . $monHoc->TenMonHoc;
                        break;
                    }
            }

            //int soDiemChuaNhap = DB . DSDiems . Where(q => MaHocSinhs . Contains(q . MaHocSinh) && q . MaHocKy == maHocKy && q . MaMonHoc == MonHoc . MaMonHoc && q . MaLoaiDiem == maLoaiDiem && q . Diem == -1).Count();
            /*if (soDiemChuaNhap > 0) {
                danhSachMon += " " + MonHoc . TenMonHoc;
                co = false;
            }
            }*/;
            return trim($danhSachMon);
        }
    }

    public static function KiemTraNhapDiemHocKyCacMonHocDuocTinhTBCToanTruong($maHocKy, $tenDangNhap, &$danhSachMon)
    {
        $co = true;
        //$Lops = DB.DSLops.ToList();
        $Lops = DsLop::find()->all();
//string maLoaiDiem = DSLoaiDiemBLL.LoadMaDiemHocKy();
        $maLoaiDiem = DSLoaiDiemBLL::LoadMaDiemHocKy();
        $soDiemChuaNhap = 0;
        foreach ($Lops as $Lop) {

            $str="";
//List<DSMonHoc> MonHocs = DSMonHocBLL.LayMonHocDuocTinhHeSoTheoLopKy(Lop.MaLop, maHocKy);
            $MonHocs = DSMonHocBLL::LayMonHocDuocTinhHeSoTheoLopKy($Lop->MaLop, $maHocKy);

//List<DSHocSinh> HocSinhs;
            $HocSinhs = null;
            if ($Lop->MaLop != null)
                $HocSinhs = DSHocSinhTheoLop::find()->where(['MaLop' => $Lop->MaLop])->all();
            else
                $HocSinhs = DSHocSinhBLL:: LoadAll();
            /*string[] MaHocSinhs = HocSinhs . Select(q => q . MaHocSinh).ToArray();*/
            foreach ($MonHocs as $monHoc) {
                foreach ($HocSinhs as $hocSinh)
                    if (DsDiem::findOne(['MaHocSinh' => $hocSinh->MaHocSinh, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $monHoc->MaMonHoc, 'MaLoaiDiem' => $maLoaiDiem, 'MaNamHoc' => DSNamHoc::getCurrentYear()]) == null) {
                        $soDiemChuaNhap++;

                        break;
                    }
                if ($soDiemChuaNhap > 0) {
                    $str .= " " . $monHoc->TenMonHoc;
                    $co = false;
                }
            }
            if($str!="")
            {
                $danhSachMon .= "<br/>" . $Lop->TenLop . ": ".$str;
            }
            trim($danhSachMon);
        }

        return $co;
    }

    public static function LayDiemTB($maHocSinh, $maHocKy, $maLoaiDiem)
    {
        return DSDiem::find()->Where(['MaHocSinh' => $maHocSinh, 'MaHocKy' => $maHocKy, 'MaLoaiDiem' => $maLoaiDiem])->all();
    }
    /// <summary>
    /// Dùng để kiểm tra việc nhập điểm Học kỳ của tất cả các môn học trong một lớp
    /// dựa trên Mã học kỳ và Tên đăng nhập (ứng với Giáo viên chủ nhiệm)
    /// </summary>
    /// <returns>
    /// Trả về True nếu tất cả các điểm học kỳ đã được nhập
    /// Trả về False nếu có một phần điểm chưa được nhập
    /// </returns>
    public static function KiemTraNhapDiemHocKyCacMonHoc($maHocKy, $tenDangNhap, &$danhSachMon)
    {
        $dsMaHSChuyenTruong = DsHocSinhChuyenTruongBLL::LayMaHSChuyenTruong(1, "");
        $dsMaHSThoiHoc = DSHocSinhThoiHocBLL::LayMaHSThoiHoc(2, "");
        $co = true;
        $maLop = DSLopBLL::LaGVCN($tenDangNhap);
        $maLoaiDiem = DSLoaiDiemBLL::LoadMaDiemHocKy();
        $MonHocs = DSMonHocBLL::LayMonHocTheoLopKy($maLop, $maHocKy);

        $MaHocSinh = array();
        if ($maLop != null) //HocSinhs = DB.DSHocSinhTheoLops.Where(q => q.MaLop == maLop && !dsMaHSChuyenTruong.Contains(q.MaHocSinh) && !dsMaHSThoiHoc.Contains(q.MaHocSinh)).Select(q => q.DSHocSinh).ToList();
        {

            $dsHocSinhTheoLops = DSHocSinhTheoLop::find()->where(['MaLop' => $maLop])->select('MaHocSinh')->all();
            foreach ($dsHocSinhTheoLops as $dsHocSinhTheoLop) {
                $kt = true;
                foreach ($dsMaHSChuyenTruong as $item) {
                    if ($dsHocSinhTheoLop == $item)
                        $kt = false;
                }
                if ($kt) {
                    foreach ($dsMaHSThoiHoc as $item)
                        if ($dsHocSinhTheoLop == $item)
                            $kt = false;
                }
                if ($kt)
                    array_push($MaHocSinh, $dsHocSinhTheoLop);
            }
        } else /*HocSinhs = DB.DSHocSinhTheoLops.Where(q => !dsMaHSChuyenTruong.Contains(q.MaHocSinh) && !dsMaHSThoiHoc.Contains(q.MaHocSinh)).Select(q => q.DSHocSinh).ToList();
string[] MaHocSinhs = HocSinhs.Select(q => q.MaHocSinh).ToArray();*/ {

            $dsHocSinhTheoLops = DSHocSinhTheoLop::find()->select('MaHocSinh')->all();
            foreach ($dsHocSinhTheoLops as $dsHocSinhTheoLop) {
                $kt = true;
                foreach ($dsMaHSChuyenTruong as $item) {
                    if ($dsHocSinhTheoLop == $item)
                        $kt = false;
                }
                if ($kt) {
                    foreach ($dsMaHSThoiHoc as $item)
                        if ($dsHocSinhTheoLop == $item)
                            $kt = false;
                }
                if ($kt)
                    array_push($MaHocSinh, $dsHocSinhTheoLop);
            }
        }
        foreach ($MonHocs as $monHoc) {
            $kt = true;
            foreach ($MaHocSinh as $maHocSinh) {
                if (DsDiem::findOne(['MaHocSinh' => $maHocSinh, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $monHoc->MaMonHoc, 'MaLoaiDiem' => $maLoaiDiem]) == null) {
                    $kt = false;
                    break;
                }
            }
            //$soDiemChuaNhap = DB . DSDiems . Where(q => MaHocSinhs . Contains(q . MaHocSinh) && q . MaHocKy == maHocKy && q . MaMonHoc == MonHoc . MaMonHoc && q . MaLoaiDiem == maLoaiDiem && q . Diem == -1).Count();
            if ((!$kt) && ($monHoc->MaMonHoc != "MH15")) {
                $danhSachMon .= " " . $monHoc->TenMonHoc;
                $co = false;
            }
        }
        $danhSachMon = trim($danhSachMon);
        return $co;
    }

    public static function KiemTraNhapDiemHocKyCacMonHocToanTruong($maHocKy, $tenDangNhap, &$danhSachMon)
    {
        $co = true;
        $Lops = DsLop::find()->all();
        $maLoaiDiem = DSLoaiDiemBLL::LoadMaDiemHocKy();
        foreach ($Lops as $Lop) {

            $MonHocs = DSMonHocBLL:: LayMonHocTheoLopKy($Lop->MaLop, $maHocKy);
            $str="";
            if ($Lop->MaLop != null)
                //$HocSinhs = DB . DSHocSinhTheoLops . Where(q => q . MaLop == Lop . MaLop).Select(q => q . DSHocSinh).ToList();
                $HocSinh = DSHocSinhTheoLop::find()->where(['MaLop' => $Lop->MaLop])->all();
            else
                $HocSinhs = DSHocSinhBLL:: LoadAll();

        }
        /*foreach ($MonHocs as $monHoc)
        {
            int soDiemChuaNhap = DB . DSDiems . Where(q => MaHocSinhs . Contains(q . MaHocSinh) && q . MaHocKy == maHocKy && q . MaMonHoc == MonHoc . MaMonHoc && q . MaLoaiDiem == maLoaiDiem && q . Diem == -1).Count();
if ((soDiemChuaNhap > 0) && (MonHoc . MaMonHoc != "MH15")) {
    danhSachMon += " " + MonHoc . TenMonHoc;
    co = false;
}
}*/
        foreach ($MonHocs as $monHoc) {
            $kt = true;
            foreach ($HocSinh as $item) {
                if (DsDiem::findOne(['MaHocSinh' => $item->MaHocSinh, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $monHoc->MaMonHoc, 'MaLoaiDiem' => $maLoaiDiem, 'Diem' => -1]) == null) {
                    $kt = false;
                    break;
                }
            }
            //$soDiemChuaNhap = DB . DSDiems . Where(q => MaHocSinhs . Contains(q . MaHocSinh) && q . MaHocKy == maHocKy && q . MaMonHoc == MonHoc . MaMonHoc && q . MaLoaiDiem == maLoaiDiem && q . Diem == -1).Count();
            if ((!$kt) && ($monHoc->MaMonHoc != "MH15")) {

                $danhSachMon .= " " . $monHoc->TenMonHoc;
                $co = false;
            }
        }
       $danhSachMon= trim($danhSachMon);
        return $co;
    }

    public static function KiemTraDiemTrongKhoang($idlevel,$idCaption,$idMonHoc,$idYear)
    {
        $idSrose=DsLoaiDiem::LoadLoaiDiemTongHop();
       $hocLuc= DmHocLuc::findOne($idCaption);
       if(DSMonHocBLL::LaChoDiem($idMonHoc)==1)
       return  DsDiem::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dsdiem.MaHocSinh')
             ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
             ->where(['dskhoi.MaCap'=>$idlevel,'dsdiem.MaNamHoc'=>$idYear,'dsdiem.MaLoaiDiem'=>$idSrose,'dsdiem.MaMonHoc'=>$idMonHoc])->andWhere(['>=','dsdiem.Diem',$hocLuc->DiemMocDuoi])
             ->andWhere(['<','dsdiem.Diem',$hocLuc->DiemMocTren])->count();
       else
       {
           if($idCaption=='TL1')
           {
               return  DsDiem::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dsdiem.MaHocSinh')
                   ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                   ->where(['dskhoi.MaCap'=>$idlevel,'dsdiem.MaNamHoc'=>$idYear,'dsdiem.MaLoaiDiem'=>$idSrose,'dsdiem.MaMonHoc'=>$idMonHoc])
                   ->andWhere(['dsdiem.Diem'=>-2])->count();
           }
           elseif($idCaption=='TL4')
               return  DsDiem::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dsdiem.MaHocSinh')
                   ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                   ->where(['dskhoi.MaCap'=>$idlevel,'dsdiem.MaNamHoc'=>$idYear,'dsdiem.MaLoaiDiem'=>$idSrose,'dsdiem.MaMonHoc'=>$idMonHoc])
                   ->andWhere(['dsdiem.Diem'=>-3])->count();
           else
               return 0;
       }
    }
    public static function KiemTraDiemTrongKhoangDiemHocKy($idlevel,$idCaption,$idMonHoc,$idYear)
    {
        $idSrose="LD4";
        $hocLuc= DmHocLucTheoDiemThi::findOne($idCaption);
        if(DSMonHocBLL::LaChoDiem($idMonHoc)==1) {
            return DsDiem::find()->innerJoin('dshocsinhtheolop', 'dshocsinhtheolop.MaHocSinh=dsdiem.MaHocSinh')
                ->innerJoin('dslop', 'dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi', 'dskhoi.MaKhoi=dslop.MaKhoi')
                ->where(['dskhoi.MaCap' => $idlevel, 'dsdiem.MaNamHoc' => $idYear, 'dsdiem.MaLoaiDiem' => $idSrose, 'dsdiem.MaMonHoc' => $idMonHoc])->andWhere(['>=', 'dsdiem.Diem', $hocLuc->DiemMocDuoi])
                ->andWhere(['<', 'dsdiem.Diem', $hocLuc->DiemMocTren])->count();

        }
        else
        {
            if($idCaption=='TL1')
            {
                return  DsDiem::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dsdiem.MaHocSinh')
                    ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                    ->where(['dskhoi.MaCap'=>$idlevel,'dsdiem.MaNamHoc'=>$idYear,'dsdiem.MaLoaiDiem'=>$idSrose,'dsdiem.MaMonHoc'=>$idMonHoc])
                    ->andWhere(['dsdiem.Diem'=>-2])->count();
            }
            elseif($idCaption=='TL4')
                return  DsDiem::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dsdiem.MaHocSinh')
                    ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                    ->where(['dskhoi.MaCap'=>$idlevel,'dsdiem.MaNamHoc'=>$idYear,'dsdiem.MaLoaiDiem'=>$idSrose,'dsdiem.MaMonHoc'=>$idMonHoc])
                    ->andWhere(['dsdiem.Diem'=>-3])->count();
            else
                return 0;
        }
    }
}