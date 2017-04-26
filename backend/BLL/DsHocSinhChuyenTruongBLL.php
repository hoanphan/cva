<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/6/2016
 * Time: 2:07 AM
 */

namespace backend\BLL;


use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DsHocSinhChuyenTruong;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsLop;
use backend\models\DSNamHoc;

class DsHocSinhChuyenTruongBLL
{
    public static function LayMaHocSinhChuyenTruongTheoKy($chuyenDi, $maHocKy)
    {
        //return DsHocSinhChuyenTruong::.Where(q => q.ChuyenDi == chuyenDi && q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
        return DsHocSinhChuyenTruong::find()->where(['ChuyenDi' => $chuyenDi, 'MaHocKy' => $maHocKy,'MaNamHoc'=>DSNamHoc::getCurrentYear()])->select('MaHocSinh')->all();
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
     * Kiểm tra giáo viên có học sinh chuyển trường không?
    **/
    public static function KiemTraHocSinhChuyenTruong()
    {
        $maGiaoVien=\Yii::$app->user->id;
        $maHocKy='K2';
        if(DSHocKy::getSemesterCurent()->MaHocKy==$maHocKy)
        {
            if(DsLop::isHomeroomTeacher($maGiaoVien))
            {
                $maNamHoc=DSNamHoc::getCurrentYear();

                if(DsHocSinhChuyenTruong::find()->where(['MaNamHoc'=>$maNamHoc,'MaHocKy'=>$maHocKy])
                    ->andWhere(['in','MaHocSinh',DSHocSinhTheoLop::find()->where(['MaNamHoc'=>$maNamHoc,'MaLop'=>DsLop::getClassFollowTeacher($maGiaoVien)->MaLop])->select('MaHocSinh')])->all()!=null)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
        else
            return false;
    }

    public static function LayMaHocSinhChuyenTruongTheoKyVaLop($chuyenDi, $maHocKy,$maLop)
    {
        //return DsHocSinhChuyenTruong::.Where(q => q.ChuyenDi == chuyenDi && q.MaHocKy == maHocKy).Select(q => q.MaHocSinh).ToArray();
        return DsHocSinhChuyenTruong::find() ->innerJoin(DSHocSinhTheoLop::tableName(),'dshocsinhtheolop.MaHocSinh=dshocsinhchuyentruong.MaHocSinh')
            ->where(['ChuyenDi' => $chuyenDi, 'MaHocKy' => $maHocKy,'dshocsinhtheolop.MaLop'=>$maLop,'dshocsinhchuyentruong.MaNamHoc'=>DSNamHoc::getCurrentYear()])
           ->all();
    }

}