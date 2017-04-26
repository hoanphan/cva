<?php
namespace console\controllers;

use backend\models\DSHocSinhTheoLop;
use backend\models\DsLoaiDiem;
use backend\models\DsMonHoc;
use backend\models\DsDiem;
use backend\models\DSNamHoc;
use frontend\models\DsMonHocTheoLop;
use backend\BLL\DSLoaiDiemBLL;
use Yii;
use yii\console\Controller;

/**
 * Site controller
 */
class RunController extends Controller
{
    /**
     *
     */
    public function actionIndex()
    {
        echo 'aadsa';
    }

    public function actionChange()
    {
        $idYearCurent = '20162017';

        /***@var DsMonHocTheoLop[] $subjects * */
        $subjects = DsMonHocTheoLop::find()->where(['MaLop' => 'L037', 'MaHocKy' => 'K2'])->all();
        /***@var DSHocSinhTheoLop[] $students * */
        $students = DSHocSinhTheoLop::find()->where(['MaLop' => 'L037'])->all();
        /**@var DsLoaiDiem[] $typeScrose * */
        $typeScrose = DsLoaiDiem::find()->where(['TongHop' => 0])->all();
        foreach ($subjects as $subject) {
            foreach ($students as $student) {
                foreach ($typeScrose as $item) {
                    $monhoc = DsMonHoc::findOne($subject->MaMonHoc);
                    if ($monhoc->MaHinhThucDanhGia == 1) {
                    } else {
                        DsDiem::change($student->MaHocSinh, $idYearCurent, 'K2', $subject->MaMonHoc, $item->MaLoaiDiem, 1, -2);
                        echo "hoc sinh " . $student->MaHocSinh . "\n";
                    }
                }
            }
        }

        $maHocKy = 'K2';
        $maLop = 'L037';

        $maNamHoc = DSNamHoc::getCurrentYear();
        $LoaiDiems = DsLoaiDiem::getAll();
        $maHocSinhTheoLops = DSHocSinhTheoLop::getListStudentFollowClassAsArray($maLop);
        $maLoaiDiemTongHop = 'LD5';
        foreach ($subjects as $subject) {
            $maMonHoc = $subject->MaMonHoc;
            $monhoc = DsMonHoc::findOne($subject->MaMonHoc);
            if ($monhoc->MaHinhThucDanhGia != 1) {
                if (DsDiem::LaChoDiem($maMonHoc) == 1) {
                    foreach ($maHocSinhTheoLops as $maHocSinh) {
                        $TongDiem = 0;
                        $TongHeSo = 0;
                        foreach ($LoaiDiems as $LoaiDiem) {
                            if ($LoaiDiem->TinhToan == 1) {
                                $TongDiem += DsDiem::getSumListScores($maHocKy, $maMonHoc, $maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem) * $LoaiDiem->HeSo;
                                $TongHeSo += DsDiem::getCountListScores($maHocKy, $maMonHoc, $maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem) * $LoaiDiem->HeSo;
                            }
                        }
                        $maLoaiDiemTongHop = DsLoaiDiem::LoadLoaiDiemTongHop();
                        if ($TongHeSo != 0) {
                            $Scores = (double)round((double)($TongDiem / $TongHeSo), 1);
                            $kt = DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                            if (!$kt)
                                DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                        }
                    }
                } else {
                    foreach ($maHocSinhTheoLops as $maHocSinh) {
                        $TongSoDat = 0;
                        $TongSoBaiKT = 0;
                        foreach ($LoaiDiems as $LoaiDiem) {
                            if ($LoaiDiem->TinhToan == 1) {
                                $Diems = DsDiem::LoadListScores($maHocKy, $maMonHoc, $maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem);
                                foreach ($Diems as $diem) {
                                    if ($diem->Diem == -2) {
                                        $TongSoDat++;
                                    }
                                }
                                $TongSoBaiKT += DsDiem::getCountListScores($maHocKy, $maMonHoc, $maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem);
                            }
                        }
                        $MaDiemHocKy = DsLoaiDiem::findOne(['LaHocKy' => 1])->MaLoaiDiem;
                        $DiemHK = DsDiem::findOne(['MaNamHoc' => $maNamHoc, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $maMonHoc, 'MaLoaiDiem' => $MaDiemHocKy, 'MaHocSinh' => $maHocSinh['MaHocSinh']]);
                        $maLoaiDiemTongHop = DsLoaiDiem::LoadLoaiDiemTongHop();
                        if (((float)$TongSoDat / $TongSoBaiKT) >= (0.6666) && ($DiemHK->Diem == -2)) {
                            if (!DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop, 1, -2)) {
                                $kt = DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop, 1, -2);
                                if (!$kt)
                                    DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop, 1, -2);
                            }
                        } else {
                            $kt = DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop, 1, -3);
                            if (!$kt)
                                DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop, 1, -3);
                        }
                    }
                }
                if ($maHocKy == 'K2') {
                    if (DsDiem::LaChoDiem($maMonHoc) == 1) {
                        foreach ($maHocSinhTheoLops as $maHocSinh) {
                            $scoresK1 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K1', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                            $scoresK2 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K2', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                            $Scores = (double)round((double)(($scoresK1 + $scoresK2 * 2) / 3), 1);
                            $kt = DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                            if (!$kt)
                                DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                        }
                    } else {
                        foreach ($maHocSinhTheoLops as $maHocSinh) {
                            $scoresK1 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K1', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                            $scoresK2 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K2', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                            $Scores = (double)round((double)(($scoresK1 + $scoresK2 * 2) / 3), 0);
                            $kt = DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                            if (!$kt)
                                DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                        }
                    }
                }
            }
        }
        /*if (DsDiem::change($idStudent, $idYearCurent, $idSemester, $idSubject, $idScrose, $serial, $scrose))
            echo "ok";
        else
            echo "false";*/
    }
}
