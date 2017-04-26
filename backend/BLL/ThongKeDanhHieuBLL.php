<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/30/2016
 * Time: 7:00 PM
 */

namespace backend\BLL;


use backend\models\DSNamHoc;
use backend\models\DSTongKetTheoKy;

class ThongKeDanhHieuBLL
{
    public static function LaySoLuongDanhHieuTrongKhoi($maDanhHieu,$idKhoi,$idSemester)
    {
        $idYear=DSNamHoc::getCurrentYear();
       return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')
            ->innerJoin('dslop','dshocsinhtheolop.MaLop=dslop.MaLop')->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaDanhHieu'=>$maDanhHieu,'MaHocKy'=>$idSemester,'MaKhoi'=>$idKhoi])->count();
    }
    public static function LaySoLuongDanhHieuTrongLop($maDanhHieu,$idLop,$idSemester)
    {
        $idYear=DSNamHoc::getCurrentYear();
        return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')
           ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaDanhHieu'=>$maDanhHieu,'MaHocKy'=>$idSemester,'MaLop'=>$idLop])->count();
    }
    public static function LayDanhSachHocSinhTrongLop($maDanhHieu,$idLop,$idSemester)
    {
        $idYear=DSNamHoc::getCurrentYear();
        return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')
            ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaDanhHieu'=>$maDanhHieu,'MaHocKy'=>$idSemester,'MaLop'=>$idLop])->all();
    }
}