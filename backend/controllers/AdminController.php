<?php

namespace backend\controllers;

use backend\BLL\RoleBLL;
use backend\models\DsDiem;
use backend\models\DsGiaoVien;
use backend\models\DsGvChuaNhapDiem;
use backend\models\DSHocKy;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsLop;
use backend\models\DsMonHoc;
use backend\models\DSNamHoc;
use backend\models\DSTuan;
use backend\models\PhanCongGiangDay;
use DateTime;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AdminController extends Controller
{


    public function actionCheckInputScroses()
    {
        $model=new DSTuan();
        $semester=new DSHocKy();
        return $this->render('check-input-scroses',['model'=>$model,'semester'=>$semester]);
    }
    public function actionCheckInputScrosesDeleteAll()
    {
        DsGvChuaNhapDiem::deleteAll();
    }
    public function actionCheckInputScrosesAjax()
    {
        $idSemester=$_POST['semester'];
        $index=(int)$_POST['index'];
        $dateStart=RoleBLL::ConvertStringToDate($_POST['dateStart']);
        $dateEnd=RoleBLL::ConvertStringToDate($_POST['dateEnd']);

       $listTeacher=DsGiaoVien::find()->all();
        $idTeacher=$listTeacher[$index]->MaGiaoVien;
        $teacher=DsGiaoVien::findByUsername($idTeacher);
        $strMessage="";
        $strMessageGvNhapRoi="";

        $PhanCongGiangDay=PhanCongGiangDay::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear(),
            'MaHocKy'=>$idSemester,'MaGiaoVien'=>$idTeacher])->all();
        if($PhanCongGiangDay!=null) {
            foreach ($PhanCongGiangDay as $divisionTeacher) {
                $idClass = $divisionTeacher->MaLop;
                $idSubject = $divisionTeacher->MaMonHoc;
                $kt = false;
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $idClass, 'MaNamHoc' => DSNamHoc::getCurrentYear()])->all();
                foreach ($listStudent as $student) {
                    $listScrose = DsDiem::find()->where(['MaHocSinh' => $student->MaHocSinh,
                        'MaHocKy' => $idSemester, 'MaMonHoc' => $idSubject,
                        'MaNamHoc' => DSNamHoc::getCurrentYear()])->all();
                    if ($listScrose != null) {
                        foreach ($listScrose as $scroses) {
                            $date = RoleBLL::ConvertStringToDate(substr($scroses->DiemCu, strripos($scroses->DiemCu, "#") + 1));
                            if ($date >= $dateEnd) {
                                $kt = true;
                                break;
                            } elseif ($dateStart <= $date && $date < $dateEnd) {
                                $kt = true;
                                break;
                            }

                        }
                        if ($kt == true)
                            break;
                    }
                }
                if ($kt == false) {
                    $strMessage .= "Lớp: " . DsLop::getNameClass($idClass) . " Môn học: " . DsMonHoc::getNameSubject($idSubject) . "\n";
                }
                else
                    $strMessageGvNhapRoi.= "Lớp: " . DsLop::getNameClass($idClass) . " Môn học: " . DsMonHoc::getNameSubject($idSubject) . "\n";
            }
        }
        if($strMessage!=null) {
            $sms = new DsGvChuaNhapDiem();
            $sms->MaGiaoVien=$idTeacher;
            $sms->SDTGV=$teacher->DienThoai;
            $sms->TuNgay=$dateStart->format('y-m-d');
            $sms->DenNgay=$dateEnd->format('y-m-d');
            $sms->TenGiaoVien=DsGiaoVien::getFullName($idTeacher);
            $sms->LopChuaNhap=$strMessage;
            $sms->LopChuaNhap=$strMessageGvNhapRoi;
            $sms->save();
        }
        echo $index+1;
       echo  $idSemester;

    }

}