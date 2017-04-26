<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 4/20/2017
 * Time: 9:11 AM
 */

namespace backend\controllers;


use backend\BLL\DsHocSinhChuyenTruongBLL;
use backend\BLL\DSLopBLL;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DsHocSinhChuyenTruong;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use frontend\models\DsMonHocTheoLop;
use League\CLImate\TerminalObject\Basic\Json;
use yii\web\Controller;
use  backend\models\DsDiem;


class HocSinhChuyenTruongController extends Controller
{
    public function actionIndex()
    {
        $listStudent = DsHocSinhChuyenTruongBLL::LayMaHocSinhChuyenTruongTheoKyVaLop(0, 'K2', DsLop::getClassFollowTeacher(\Yii::$app->user->id));
        $subjects = DsMonHocTheoLop::find()->where(['MaLop' => DsLop::getClassFollowTeacher(\Yii::$app->user->id), 'MaHocKy' => 'K1'])->all();
        return $this->render('index', ['subjects' => $subjects, 'listStudent' => $listStudent]);
    }

    public function actionSave()
    {
        $data = $_POST['arr'];
        $arr = \yii\helpers\Json::decode($data);
        $maNamHoc = DSNamHoc::getCurrentYear();
        foreach ($arr as $item) {
            DsDiem::change($item['MaHocSinh'], $maNamHoc, 'K1', $item['MaMonHoc'], 'LD5', 1, $item['value']);
        }
    }

    public function actionTransferSchool()
    {
        $year = DSNamHoc::getCurrentYear();
        $semester = 'K1';
        $idClass = DSLopBLL::LoadAll()[0]->MaLop;
        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $idClass, 'MaNamHoc' => $year])
            ->andWhere(['not in','MaHocSinh',DsHocSinhChuyenTruong::find()->where(['MaNamHoc'=>$year,'ChuyenDi'=>DsHocSinhChuyenTruong::IS_TRASFER])
                ->select('MaHocSinh')])->all();
        $lisTransfer = DsHocSinhChuyenTruong::find()->where(['MaNamHoc' => $year, 'MaHocKy' => $semester])
            ->andWhere(['in', 'MaHocSinh', DSHocSinhTheoLop::find()->where(['MaLop' => $idClass, 'MaNamHoc' => $year])->select('MaHocSinh')])->all();
        $gruop = new DSKhoi();
        $class = new DsLop();
        $transfer = new DsHocSinhChuyenTruong();
        return $this->render('transfer', ['listStudent' => $listStudent, 'listTransfer' => $lisTransfer, 'transfer' => $transfer
            , 'group' => $gruop, 'class' => $class]);
    }

    public function actionGetTransfer()
    {
        $year = DSNamHoc::getCurrentYear();
        $class = $_POST['id_class'];
        $semester = $_POST['semester'];
        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class, 'MaNamHoc' => $year])
            ->andWhere(['not in','MaHocSinh',DsHocSinhChuyenTruong::find()->where(['MaNamHoc'=>$year,'ChuyenDi'=>DsHocSinhChuyenTruong::IS_TRASFER])
                ->select('MaHocSinh')])->all();
        $listTransfer = DsHocSinhChuyenTruong::find()->where(['MaNamHoc' => $year, 'MaHocKy' => $semester])
            ->andWhere(['in', 'MaHocSinh', DSHocSinhTheoLop::find()->where(['MaLop' => $class, 'MaNamHoc' => $year])->select('MaHocSinh')])->all();
        return $this->renderPartial('get-transfer', ['listStudent' => $listStudent, 'listTransfer' => $listTransfer]);
    }

    public function actionTransferStudent()
    {
        $year = DSNamHoc::getCurrentYear();
        $student = $_POST['student'];
        $semester = $_POST['semester'];
        $type = $_POST['type'];
        $vNen = $_POST['vNen'];
        $to = $_POST['to'];

        $hs = DsHocSinhChuyenTruong::findOne(['MaHocSinh' => $student, 'MaNamHoc' => $year, 'MaHocKy' => $semester]);
        if ($hs !== null) {

            $hs->ChuyenDi = $type;
            $hs->HevNen = $vNen;
            $hs->NoiChuyen = $to;
            if ($hs->save()) {
                $student=DsHocSinh::getStudent($student);
                        $html = "<tr id='".$student->MaHocSinh."' class='tf'><td></td><td>$student->MaHocSinh</td><td>$student->HoDem</td><td>$student->Ten</td><td>$to</td><td><span class=\"ui-icon  delete\" about=\"<?=$student->MaHocSinh?>\"><i class=\"ace-icon glyphicon glyphicon-trash ui-icon-trash\"></i></span></td></tr>";
                $arr = ['status' => 'change','html'=>$html];
                return \yii\helpers\Json::encode($arr);
            } else {
                $arr = ['status' => 'error'];
                return \yii\helpers\Json::encode($arr);
            }
        } else {
                $hs=new DsHocSinhChuyenTruong();
                $hs->MaHocSinh=$student;
                $hs->ChuyenDi = $type;
                $hs->HevNen = $vNen;
                $hs->NoiChuyen = $to;
                $hs->MaNamHoc=$year;
                $hs->MaHocKy=$semester;
            if ($hs->save()) {
                $student=DsHocSinh::getStudent($student);
                $html = "<tr id='".$student->MaHocSinh."' class='tf'><td></td><td>$student->MaHocSinh</td><td>$student->HoDem</td><td>$student->Ten</td><td>$to</td><td><span class=\"ui-icon  delete\" about=\"<?=$student->MaHocSinh?>\"><i class=\"ace-icon glyphicon glyphicon-trash ui-icon-trash\"></i></span></td></tr>";
                if($type==1)
                $arr = ['status' => 'add','remove'=>'yes','html'=>$html];
                else
                    $arr = ['status' => 'add','remove'=>'no','html'=>$html];
                return \yii\helpers\Json::encode($arr);
            } else {
                $arr = ['status' => 'error'];
                return \yii\helpers\Json::encode($arr);
            }
        }
    }
    public function  actionCheck()
    {
        $year=DSNamHoc::getCurrentYear();
        $student = $_POST['student'];
        $semester = $_POST['semester'];
        $hs = DsHocSinhChuyenTruong::findOne(['MaHocSinh' => $student, 'MaNamHoc' => $year, 'MaHocKy' => $semester]);
        if($hs!==null)
        {
            $student=DsHocSinh::findOne($student);
            $arr=['status'=>'ok','type'=>$hs->ChuyenDi,'id'=>$hs->MaHocSinh,'fistName'=>$student->Ten,'lastName'=>$student->HoDem,
                'to'=>$hs->NoiChuyen,'vnen'=>$hs->HevNen,'ngaysinh'=>DsHocSinh::getNgaySinh($student->MaHocSinh)];
            return \yii\helpers\Json::encode($arr);
        }
        else {
            $arr = ['status' => 'false'];
            return \yii\helpers\Json::encode($arr);
        }
    }
    public function actionDelete()
    {
        $year=DSNamHoc::getCurrentYear();
        $student = $_POST['student'];
        $semester = $_POST['semester'];
        $hs = DsHocSinhChuyenTruong::findOne(['MaHocSinh' => $student, 'MaNamHoc' => $year, 'MaHocKy' => $semester]);
        if($hs->delete())
            echo 'ok';
        else
            echo 'fail';
    }
}