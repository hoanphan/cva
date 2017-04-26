<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 12/5/2016
 * Time: 4:26 PM
 */

namespace backend\BLL;


use backend\models\DsDiem;
use backend\models\DSHocKy;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsLoaiDiem;
use backend\models\DsLop;
use backend\models\DsMonHoc;
use backend\models\DSTongKetTheoKy;
use frontend\models\DsMonHocTheoLop;
use frontend\models\DSNamHoc;

class TongKetBLL
{
    public static function TinhDiemTBC($maHocKy, $tenDangNhap)
    {
        $maLop = DsLop::findOne(['MaGVCN' => $tenDangNhap])->MaLop;
        if ($maLop != null)
            $HocSinhs = DSHocSinhTheoLop::getListStudentFollowClass($maLop);
        else
            $HocSinhs = DSHocSinhTheoLop::find()->all();

        if ($maHocKy != DSHocKy::getSemesterSummary()->MaHocKy) {
            $maLoaiDiemTongHop=DsLoaiDiem::LoadLoaiDiemTongHop();
            $listMonHoc = DsMonHocTheoLop::find()->where(['MaLop' => $maLop, 'MaHocKy' => 'K1', 'MaNamHoc' => DSNamHoc::getCurrentYear()])->andWhere(['not in', 'MaMonHoc', DsMonHocTheoLop::find()->where(['MaLop' => $maLop, 'MaHocKy' => 'K2', 'MaNamHoc' => DSNamHoc::getCurrentYear()])->select('MaMonHoc')])->select('MaMonHoc')->all();
           /***
            * @var DsMonHocTheoLop[] $listMonHoc
            * @
           **/
            foreach ($listMonHoc as $MonHoc) {
                foreach ($HocSinhs as $item) {
                    $scrose=DsDiem::findOne(['MaHocSinh'=>$item->MaHocSinh,'MaMonHoc'=>$MonHoc->MaMonHoc,'MaHocKy' => 'K1', 'MaNamHoc' => DSNamHoc::getCurrentYear()]);
                    $kt = DsDiem::change($item->MaHocSinh,DSNamHoc::getCurrentYear(), 'K3', $MonHoc->MaMonHoc, $maLoaiDiemTongHop, 1, $scrose->Diem);
                    if (!$kt)
                        DsDiem::change($item->MaHocSinh,DSNamHoc::getCurrentYear(), 'K3', $MonHoc->MaMonHoc, $maLoaiDiemTongHop, 1, $scrose->Diem);

                }
            }
        }


        foreach ($HocSinhs as $item) {
            $TongDiemTB = 0;
            $TongHeSo = 0;
            //List<DSDiem> DSDiemTB = DSDiemBLL.TruyVanDiemTongHop(maHocKy, HocSinh.MaHocSinh);
            $DSDiemTB = DsDiem::LoadListScoresTongHop($maHocKy, $item->MaHocSinh, DsLoaiDiem::LoadLoaiDiemTongHop());
            foreach ($DSDiemTB as $DiemTB) {
                $TongDiemTB += $DiemTB->Diem * DsMonHoc::getSubjectFollowId($DiemTB->MaMonHoc)->HeSo;
                $TongHeSo += DsMonHoc::getSubjectFollowId($DiemTB->MaMonHoc)->HeSo;
            }
            //double tb = (double)TongDiemTB/(int)TongHeSo+0.00000001;
            //double trungBinh = Math.Round(tb, 1, MidpointRounding.AwayFromZero);
            //UTL.Ultils.ThongBao(trungBinh.ToString(), System.Windows.Forms.MessageBoxIcon.Exclamation);
            //DSTongKetTheoKyBLL . CapNhatDiemTBCTheoKy(maHocKy, HocSinh . MaHocSinh, Math . Round((double)(TongDiemTB / TongHeSo) + 0.0000000000001, 1, MidpointRounding . AwayFromZero));
            self::CapNhatDiemTBCTheoKy($maHocKy, $item->MaHocSinh, round((double)($TongDiemTB / $TongHeSo) + 0.0000000000001, 1));

        }

    }

    private static function CapNhatDiemTBCTheoKy($maHocKy, $maHocSinh, $trungBinhChung)
    {
        $maNamHoc = DSNamHoc::getCurrentYear();
//DSTongKetTheoKy TKTK = DB.DSTongKetTheoKies.Where(q => q.MaNamHoc == maNamHoc && q.MaHocKy == maHocKy && q.MaHocSinh == maHocSinh).FirstOrDefault();

        $dsTongKet = DSTongKetTheoKy::findOne(['MaNamHoc' => $maNamHoc, 'MaHocKy' => $maHocKy, 'maHocSinh' => $maHocSinh]);
        if ($dsTongKet != null) {
            $dsTongKet->TrungBinhChung = $trungBinhChung;
            $dsTongKet->save();
        }
        // $dsTongKet->save();
    }


}