<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/9/2016
 * Time: 2:52 PM
 */

namespace backend\BLL;


use backend\models\DSNamHoc;
use backend\models\DSTongKetTheoKy;

class DsTongKetBLL extends DSTongKetTheoKy
{
    public static function getTongKet($idSemester, $idStudent)
    {
        return DSTongKetTheoKy::findOne(['MaNamHoc' => DSNamHoc::getCurrentYear(), 'MaHocKy' => $idSemester, 'MaHocSinh' => $idStudent]);
    }

    public static function TongKetTheoKyTheoLop($maHocKy, $tenDangNhap)
    {
    }
}