<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/27/2016
 * Time: 10:00 AM
 */

namespace backend\component;


use  backend\models\DsEmailSmsGuiToanBo;
use backend\models\DsHocSinh;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSNamHoc;
use backend\models\DsTinNhanXuatExcel;
use backend\models\Loi;
use yii\data\ArrayDataProvider;

class GetSms
{
      public static function getSms($month,$semester,$index)
    {
           $idYear=DSNamHoc::getCurrentYear();
            $listStudent=DSHocSinhTheoLop::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear()])->all();
            $item=$listStudent[$index];
			$tin_nhan=new DsTinNhanXuatExcel();
            $tin_nhan->MaHocSinh=$item->MaHocSinh;
            $tin_nhan->TenHocSinh=DsHocSinh::getFullName($item->MaHocSinh);
            $tin_nhan->SDT=DsHocSinh::getSoDienThoaiPhuHuynh($item->MaHocSinh);
            $tin_nhan->NoiDung=SmsContent::contentSmsExcel($semester,$item->MaHocSinh,$idYear,$month);
            $tin_nhan->Ky=$semester;
            $tin_nhan->Thang=$month;
            $tin_nhan->save();
    }
    public static function getSmsSummary($semester,$index)
    {
        $idYear=DSNamHoc::getCurrentYear();
        $listStudent=DSHocSinhTheoLop::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear()])->all();
        $item=$listStudent[$index];
        $tin_nhan=new DsTinNhanXuatExcel();
        $tin_nhan->MaHocSinh=$item->MaHocSinh;
        $tin_nhan->TenHocSinh=DsHocSinh::getFullName($item->MaHocSinh);
        $tin_nhan->SDT=DsHocSinh::getSoDienThoaiPhuHuynh($item->MaHocSinh);
        $tin_nhan->NoiDung=SmsContent::contentSmsExcelSummary($semester,$item->MaHocSinh,$idYear);
        $tin_nhan->Ky=$semester;
        $tin_nhan->Thang=0;
         return $tin_nhan->save();
    }
}