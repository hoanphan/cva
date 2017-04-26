<?php

namespace backend\controllers;

use backend\BLL\DSLoaiDiemBLL;
use backend\BLL\LogBLL;
use backend\models\DSHocKy;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLoaiDiem;
use backend\models\DsLop;
use backend\models\DsMonHoc;
use backend\models\DSNamHoc;
use League\CLImate\TerminalObject\Basic\Json;
use Yii;
use backend\models\DsDiem;
use app\ModelSearch\DsDiemSearch;
use yii\bootstrap\Html;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DsDiemController implements the CRUD actions for Dsdiem model.
 */
class DsDiemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'cho-diem','average-scores','report','change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Dsdiem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $log = new LogBLL();
        $log->update('Cập nhật điểm');
        $searchModel = new DsDiemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $semester = new DSHocKy();
        $gruopClass = new DSKhoi();
        $class = new DsLop();
        $subject = new DsMonHoc();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester,
            'gruop' => $gruopClass,
            'class' => $class,
            'subject' => $subject
        ]);
    }

    public function actionChoDiem()
    {
        $idSubject = $_POST['subject'];
        echo DsDiem::LaChoDiem($idSubject);
    }
    /**
     * Displays a single Dsdiem model.
     * @param string $MaHocSinh
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaMonHoc
     * @param string $MaLoaiDiem
     * @param integer $STTDiem
     * @return mixed
     */


    /**
     * Finds the Dsdiem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $MaHocSinh
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaMonHoc
     * @param string $MaLoaiDiem
     * @param integer $STTDiem
     * @return Dsdiem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($MaHocSinh, $MaNamHoc, $MaHocKy, $MaMonHoc, $MaLoaiDiem, $STTDiem)
    {
        if (($model = Dsdiem::findOne(['MaHocSinh' => $MaHocSinh, 'MaNamHoc' => $MaNamHoc, 'MaHocKy' => $MaHocKy, 'MaMonHoc' => $MaMonHoc, 'MaLoaiDiem' => $MaLoaiDiem, 'STTDiem' => $STTDiem])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $maHocKy
     * @param $maLop
     * @param $maMonHoc
     */
    public function actionAverageScores()
    {
        $maHocKy=$_POST['idSemester'];
         $maLop=$_POST['idClass'];
        $maMonHoc=$_POST['idSubject'];


        $maNamHoc = DSNamHoc::getCurrentYear();
        $LoaiDiems = DsLoaiDiem::getAll();
        $maHocSinhTheoLops = DSHocSinhTheoLop::getListStudentFollowClassAsArray($maLop);
        if (DsDiem::LaChoDiem($maMonHoc) == 1) {
            foreach ($maHocSinhTheoLops as $maHocSinh) {
                $TongDiem = 0;
                $TongHeSo = 0;
                foreach ($LoaiDiems as $LoaiDiem) {
                    if ($LoaiDiem->TinhToan == 1) {
                        $TongDiem += DsDiem::getSumListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem)* $LoaiDiem -> HeSo;
                        $TongHeSo += DsDiem::getCountListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem) * $LoaiDiem -> HeSo;
                    }
                }
                $maLoaiDiemTongHop = DsLoaiDiem::LoadLoaiDiemTongHop();
                if($TongHeSo!=0) {
                    $Scores = (double)round((double)($TongDiem / $TongHeSo), 1);
                    $kt =DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop,1, $Scores);
                    if(!$kt)
                        DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop,1, $Scores);
                }
            }
        } else {
            foreach ($maHocSinhTheoLops as $maHocSinh) {
                $TongSoDat = 0;
                $TongSoBaiKT = 0;
                foreach ($LoaiDiems as $LoaiDiem) {
                    if ($LoaiDiem->TinhToan == 1) {
                        $Diems = DsDiem::LoadListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem);
                        foreach ($Diems as $diem) {
                            if ($diem->Diem == -2) {
                                $TongSoDat++;
                            }
                        }
                        $TongSoBaiKT += DsDiem::getCountListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem);
                    }
                }
                $MaDiemHocKy = DsLoaiDiem::findOne(['LaHocKy' => 1])->MaLoaiDiem;
                $DiemHK = DsDiem::findOne(['MaNamHoc' => $maNamHoc, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $maMonHoc, 'MaLoaiDiem' => $MaDiemHocKy, 'MaHocSinh' =>$maHocSinh['MaHocSinh']]);
                $maLoaiDiemTongHop = DsLoaiDiem::LoadLoaiDiemTongHop();
                if (((float)$TongSoDat / $TongSoBaiKT) >= (0.6666) && ($DiemHK->Diem == -2)) {
                    if(!DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-2))
                    {
                       $kt= DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-2);
                       if(!$kt)
                           DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-2);
                    }
                } else {
                   $kt= DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-3);
                   if(!$kt)
                       DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-3);
                }
            }
        }
        if($maHocKy=='K2')
        {
            if (DsDiem::LaChoDiem($maMonHoc) == 1) {
                foreach ($maHocSinhTheoLops as $maHocSinh) {
                    $scoresK1 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K1', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                    $scoresK2 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K2', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                    $Scores = (double)round((double)(($scoresK1 + $scoresK2 * 2) / 3), 1);
                    $kt = DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                    if (!$kt)
                        DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                }
            }
            else
            {
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
    public  function  actionReport()
    {
        $idSemester=$_POST['idSemester'];
        $idSubject=$_POST['idSubject'];
        $idClass=$_POST['idClass'];
        echo '<span>'. Html::a(
    Html::button('<i class="glyphicon  glyphicon-print"></i> Xuất báo cáo', ['class' => 'btn',]),Url::toRoute(['/report/report-scroses','MaMonHoc'=>$idSubject,'MaHocKy'=>$idSemester,'MaLop'=>$idClass]), ['name'=>'Pdf', 'target'=>'_blank']).
'</span>';
    }
    public function actionChange()
    {
        $idYearCurent = DSNamHoc::getCurrentYear();
        $data=$_POST['myData'];
        $arr=\yii\helpers\Json::decode($data);

       foreach ($arr as $item)
       {
           DsDiem::change($item['student'], $idYearCurent, $item['semester'], $item['subject'], $item['type'], $item['serial'],  $item['value']);
       }
        $maHocKy=$arr[0]['semester'];
        $maLop=DSHocSinhTheoLop::getClassFollowClass($arr[0]['student']);
        $maMonHoc= $arr[0]['subject'];


        $maNamHoc = DSNamHoc::getCurrentYear();
        $LoaiDiems = DsLoaiDiem::getAll();
        $maHocSinhTheoLops = DSHocSinhTheoLop::getListStudentFollowClassAsArray($maLop);
        if (DsDiem::LaChoDiem($maMonHoc) == 1) {
            foreach ($maHocSinhTheoLops as $maHocSinh) {
                $TongDiem = 0;
                $TongHeSo = 0;
                foreach ($LoaiDiems as $LoaiDiem) {
                    if ($LoaiDiem->TinhToan == 1) {
                        $TongDiem += DsDiem::getSumListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem)* $LoaiDiem -> HeSo;
                        $TongHeSo += DsDiem::getCountListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem) * $LoaiDiem -> HeSo;
                    }
                }
                $maLoaiDiemTongHop = DsLoaiDiem::LoadLoaiDiemTongHop();
                if($TongHeSo!=0) {
                    $Scores = (double)round((double)($TongDiem / $TongHeSo), 1);
                    $kt =DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop,1, $Scores);
                    if(!$kt)
                        DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, $maHocKy, $maMonHoc, $maLoaiDiemTongHop,1, $Scores);
                }
            }
        } else {
            foreach ($maHocSinhTheoLops as $maHocSinh) {
                $TongSoDat = 0;
                $TongSoBaiKT = 0;
                foreach ($LoaiDiems as $LoaiDiem) {
                    if ($LoaiDiem->TinhToan == 1) {
                        $Diems = DsDiem::LoadListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem);
                        foreach ($Diems as $diem) {
                            if ($diem->Diem == -2) {
                                $TongSoDat++;
                            }
                        }
                        $TongSoBaiKT += DsDiem::getCountListScores($maHocKy, $maMonHoc,$maHocSinh['MaHocSinh'], $LoaiDiem->MaLoaiDiem);
                    }
                }
                $MaDiemHocKy = DsLoaiDiem::findOne(['LaHocKy' => 1])->MaLoaiDiem;
                $DiemHK = DsDiem::findOne(['MaNamHoc' => $maNamHoc, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $maMonHoc, 'MaLoaiDiem' => $MaDiemHocKy, 'MaHocSinh' =>$maHocSinh['MaHocSinh']]);
                $maLoaiDiemTongHop = DsLoaiDiem::LoadLoaiDiemTongHop();
                if (((float)$TongSoDat / $TongSoBaiKT) >= (0.6666) && ($DiemHK->Diem == -2)) {
                    if(!DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-2))
                    {
                        $kt= DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-2);
                        if(!$kt)
                            DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-2);
                    }
                } else {
                    $kt= DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-3);
                    if(!$kt)
                        DsDiem::change($maHocSinh['MaHocSinh'],$maNamHoc,$maHocKy,$maMonHoc,$maLoaiDiemTongHop,1,-3);
                }
            }
        }
        if($maHocKy=='K2')
        {
            if (DsDiem::LaChoDiem($maMonHoc) == 1) {
                foreach ($maHocSinhTheoLops as $maHocSinh) {
                    $scoresK1 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K1', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                    $scoresK2 = DsDiem::getScoresNumberFollowStudent($maHocSinh, $maNamHoc, 'K2', $maMonHoc, DSLoaiDiemBLL::LoadMaLoaiDiemTongHop(), 1);
                    $Scores = (double)round((double)(($scoresK1 + $scoresK2 * 2) / 3), 1);
                    $kt = DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                    if (!$kt)
                        DsDiem::change($maHocSinh['MaHocSinh'], $maNamHoc, 'K3', $maMonHoc, $maLoaiDiemTongHop, 1, $Scores);
                }
            }
            else
            {
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
        /*if (DsDiem::change($idStudent, $idYearCurent, $idSemester, $idSubject, $idScrose, $serial, $scrose))
            echo "ok";
        else
            echo "false";*/
        $dsStudentFolowClass = DSHocSinhTheoLop::getListStudentFollowClass($maLop);
        $str= $this->renderPartial('grid', ['model' => $dsStudentFolowClass, 'Semester' => $maHocKy,
            'Class' => $maLop, 'Subject' => $maMonHoc, 'idYear' => $maNamHoc
        ]);
        $arr=['value'=>$str];
        return \yii\helpers\Json::encode($arr);
    }
}
