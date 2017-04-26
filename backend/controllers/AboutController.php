<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/21/2016
 * Time: 8:36 AM
 */

namespace backend\controllers;


use backend\assets\AppAsset;
use backend\BLL\DsDiemBLL;
use backend\BLL\DsTongKetBLL;
use backend\BLL\LogBLL;
use backend\BLL\RoleBLL;
use backend\BLL\TongKetBLL;
use backend\BLL\TongKetTheoKyBLL;
use backend\component\GetSms;
use backend\component\SmsContent;
use backend\models\BookElectronic;
use backend\models\DsGiaoVien;
use backend\models\DsGvChuaNhapDiem;
use backend\models\DsHinhThucDanhGia;
use backend\models\DSHocKy;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DsMonHoc;
use app\ModelSearch\SoLienLacDienTuSearch;
use backend\component\ContentGmail;
use backend\models\DsThang;
use backend\models\PhanCongGiangDay;
use backend\models\SoLienLacDienTuLop;
use backend\ModelSearch\DsTinNhanHocSinhSearch;
use backend\ModelSearch\DsTinNhanXuatExcelSearch;
use DateTime;
use DateTimeZone;
use frontend\models\DsHocSinh;
use kartik\mpdf\Pdf;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use backend\component\CreateAttribute;
use backend\models\CreaateRescroses;
use backend\models\DSNamHoc;
use backend\models\DsDiem;
use yii\web\Session;
use yii\helpers\Html;

class AboutController extends Controller
{
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
                        'actions' => [
                            'gruop',
                            'class',
                            'subject',
                            'grid',
                            'grid-socrose',
                            'count',
                            'change',
                            'logout',
                            'week-change',
                            'week-change1',
                            'send-gmail',
                            'semseter',
                            'get-sms',
                            'send-sms',
                            'check-input-scroses-ajax',
                            'test'

                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     *
     */
    public function actionGruop()
    {
        $id_teacher = Yii::$app->user->getId();
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            if (RoleBLL::checkFunction(0) || RoleBLL::checkFunction(3))
                $list = DSKhoi::getAllGruop();
            else
                $list = DSKhoi::getListGruopClassFollowDivision($id_teacher, $id);
            $selected = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                if (count($list) > 0) {
                    for ($i = 0; $i < count($list); $i++) {
                        $out[$i] = ['id' => $list[$i]->MaKhoi, 'name' => 'Khối ' . $list[$i]->TenKhoi];
                    }
                    $selected = $list[0]->MaKhoi;
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected' => $selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     *
     */
    public function actionClass()
    {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id_teacher = Yii::$app->user->getId();
            $ids = $_POST['depdrop_parents'];
            $id_gruop = empty($ids[0]) ? null : $ids[0];
            $id_semester = empty($ids[1]) ? null : $ids[1];
            if (RoleBLL::checkFunction(0) || RoleBLL::checkFunction(3) || RoleBLL::checkFunction(5)) {
                if ($id_gruop != null) {
                    $out = DsLop::getListClassFlollowGruopClass($id_gruop);
                    $selected = null;

                    if (count($out) > 0) {
                        $selected = $out[0]['id'];

                        // Shows how you can preselect a value
                        echo Json::encode(['output' => $out, 'selected' => $selected]);
                        return;
                    }
                }
            } else
                if ($id_gruop != null && $id_semester != null) {
                    if (RoleBLL::checkFunction(0) || RoleBLL::checkFunction(3))
                        $out = DsLop::getListClassFlollowGruopClass($id_gruop);
                    else
                        $out = DsLop::getListClassFlollowDivisionAndGruopClass($id_teacher, $id_semester, $id_gruop);
                    $selected = null;

                    if (count($out) > 0) {
                        $selected = $out[0]['id'];

                        // Shows how you can preselect a value
                        echo Json::encode(['output' => $out, 'selected' => $selected]);
                        return;
                    }
                }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionSubject()
    {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id_teacher = Yii::$app->user->getId();
            $ids = $_POST['depdrop_parents'];
            $id_class = empty($ids[0]) ? null : $ids[0];
            $id_semester = empty($ids[1]) ? null : $ids[1];
            if ($id_class != null && $id_semester != null) {
                if (RoleBLL::checkFunction(0) || RoleBLL::checkFunction(3))
                    $list = DsMonHoc::getSubjectFollowClass($id_semester, $id_class);
                else
                    $list = DsMonHoc::getListSubjectFollowDivision($id_teacher, $id_semester, $id_class);
                $selected = null;

                if (count($list) > 0) {
                    foreach ($list as $item) {
                        array_push($out, ['id' => $item->MaMonHoc, 'name' => $item->TenMonHoc]);
                    }
                    $selected = $out[0]['id'];
                    $_SESSION["Semsester"] = $id_semester;
                    $_SESSION["Class"] = $id_class;
                    $_SESSION["Subject"] = $selected;
                    // Shows how you can preselect a value
                    echo Json::encode(['output' => $out, 'selected' => $selected]);
                    return;
                }
            }

        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGrid()
    {
        $MaLop = $_POST['MaLop'];
        $HocKy = $_POST['HocKy'];
        $MonHoc = $_POST['MonHoc'];

        $collum = CreateAttribute::createAttribs($HocKy, $MonHoc, $MaLop);
        $dataProvider = CreaateRescroses::Create($HocKy, $MaLop, $MonHoc);
        return $this->renderPartial('gridview', ['collum' => $collum, 'dataProvider' => $dataProvider]);
    }

    public function actionGridSocrose()
    {
        $MaLop = $_POST['Class'];
        $HocKy = $_POST['Semester'];
        $MonHoc = $_POST['Subject'];

        $idYearCurrent = DSNamHoc::getCurrentYear();
        $dsStudentFolowClass = DSHocSinhTheoLop::getListStudentFollowClass($MaLop);
        return $this->renderPartial('grid', ['model' => $dsStudentFolowClass, 'Semester' => $HocKy,
            'Class' => $MaLop, 'Subject' => $MonHoc, 'idYear' => $idYearCurrent
        ]);
    }

    public function actionCount()
    {
        $MaLop = $_POST['MaLop'];
        $HocKy = $_POST['HocKy'];
        $MonHoc = $_POST['MonHoc'];
        return CreateAttribute::SumInput($HocKy, $MonHoc, $MaLop);
    }

    public function actionChange()
    {
        $idYearCurent = DSNamHoc::getCurrentYear();
        $idSemester = $_POST['idSemester'];
        $idSubject = $_POST['idSubject'];
        $idStudent = $_POST['idStudent'];
        $idScrose = $_POST['idScrose'];
        $serial = $_POST['serial'];
        $scrose = $_POST['scroces'];
        if (DsDiem::change($idStudent, $idYearCurent, $idSemester, $idSubject, $idScrose, $serial, $scrose))
            echo "ok";
        else
            echo "false";
    }

    public function actionLogout()
    {
        $log = new LogBLL();
        $log->update('Đăng xuất');
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionWeekChange()
    {
        $week = $_POST['week'];
        $idClass = DsLop::getClassFollowTeacher(Yii::$app->user->id)->MaLop;
        $dataProvider = BookElectronic::create($idClass, $week);
        return $this->renderPartial('sldt', [
            'dataProvider' => $dataProvider,

        ]);

    }

    /**
     * @return button create or update class electrict book
     */
    public function actionWeekChange1()
    {
        $week = $_POST['week'];
        $idClass = DsLop::getClassFollowTeacher(Yii::$app->user->id)->MaLop;
        if (SoLienLacDienTuLop::findToId($idClass, $week)) {
            echo Html::a('<i class="fa fa-pencil-square-o"></i>' . Yii::t("app", " Update"), Url::toRoute(['so-lien-lac-dien-tu-lop/update', 'MaTuan' => $week]), ['class' => 'btn ']);
        } else
            echo Html::a('<i class="glyphicon glyphicon-plus"></i>' . Yii::t("app", " Add"), Url::toRoute(['so-lien-lac-dien-tu-lop/create', 'MaTuan' => $week]), ['class' => 'btn btn-danger']);

    }

    public function actionSendGmail()
    {

        $month = '11';
        $semester = 'K1';
        $index=(int)0;
        $listStudent = DSHocSinhTheoLop::find()->all();
            $item=$listStudent[$index];
            $addEmail = DsHocSinh::findOne($item->MaHocSinh)->EmailPhuHuynh;

               if ($addEmail != null || $addEmail != "") {
                   $arr = explode(',', $addEmail);
                   $content = ContentGmail::sendText($item->MaHocSinh, $semester, $month);
                   for ($i = 0; $i < count($arr); $i++)
                       Yii::$app->mailer->compose()->setFrom('truongcvadhtb@gmail.com')->setTo($arr[$i])->setSubject('Trường TH, THCS, THPT Chu Văn An kính gửi tới quý phụ huynh kết quả học tập của học sinh trong tháng' . $month)->setHtmlBody($content)->send();
               }

        $index++;
        echo $index;


    }

    public function actionSendSms()
    {

        $month = $_POST['month'];
        $semester = $_POST['semester'];
        $listStudent = DsHocSinh::find()->where(['DangKyDichVu' => 1])->all();
        $idYear = DSNamHoc::getCurrentYear();
        $count = 480;
        foreach ($listStudent as $item) {
            $content = SmsContent::contentSms($semester, $item->MaHocSinh, $idYear, $month);
            $numberPhone = $item->SoDienThoaiPhuHuynh;
            if ($numberPhone != null) {
                if (strlen($content) < 480) {
                    SmsContent::sendSms($numberPhone, $content, $item->MaHocSinh, $month);
                } else
                    while ($count < strlen($content) - 1) {
                        $content1 = substr($content, 0, $count);

                        SmsContent::sendSms($numberPhone, $content1, $item->MaHocSinh, $month);
                        $content = substr($content, $count + 1);
                        if (strlen($content) < 480) {
                            SmsContent::sendSms($numberPhone, $content, $item->MaHocSinh, $month);
                        }
                    }

            }


        }
        $searchModel = new DsTinNhanHocSinhSearch();
        $month = (integer)$month;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $month);
        return $this->renderPartial("sms", [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSemseter()
    {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id_teacher = Yii::$app->user->getId();
            $ids = $_POST['depdrop_parents'];
            $id_month = empty($ids[0]) ? null : $ids[0];
            if ($id_month != null) {
                $id_semester = DsThang::findOne(['STTThang' => $id_month])->MaHocKy;
                $list = DSHocKy::find()->where(['MaHocKy' => $id_semester])->all();
                $selected = null;

                if (count($list) > 0) {
                    foreach ($list as $item) {
                        array_push($out, ['id' => $item->MaHocKy, 'name' => $item->TenHocKy]);
                    }
                    $selected = $out[0]['id'];

                    // Shows how you can preselect a value
                    echo Json::encode(['output' => $out, 'selected' => $selected]);
                    return;
                }
            }

        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionCheckInputScrosesAjax()
    {
        $idSemester = $_POST['semester'];
       $dateStart = RoleBLL::ConvertStringToDate($_POST['dateStart']);
        $dateEnd = RoleBLL::ConvertStringToDate($_POST['dateEnd']);
        $listTeacher = PhanCongGiangDay::find()->where(['MaHocKy' => $idSemester])->groupBy('MaGiaoVien')->select('MaGiaoVien')->all();;
        for ($i =0;$i<count($listTeacher); $i++) {
            $idTeacher =$listTeacher[$i]->MaGiaoVien;
            $teacher = DsGiaoVien::findByUsername($idTeacher);
            $strMessage = "";
            $strMessageGvNhapRoi = "";
            $sms1="";
            $PhanCongGiangDay = PhanCongGiangDay::find()->where(['MaNamHoc' => DSNamHoc::getCurrentYear(),
                'MaHocKy' => $idSemester, 'MaGiaoVien' => $idTeacher])->all();
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
                    $sms1 .= DsMonHoc::getNameSubjectSMS($idSubject)."(".DsLop::getNameClass($idClass) . ")\\n";
                    $strMessage .= DsMonHoc::getNameSubject($idSubject)."(".DsLop::getNameClass($idClass) . ")\n";
                } else
                    $strMessageGvNhapRoi .= DsMonHoc::getNameSubject($idSubject)."(".DsLop::getNameClass($idClass) . ")\n";
            }
            $sms = new DsGvChuaNhapDiem();
            $sms->MaGiaoVien = $idTeacher;
            $sms->sms=$sms1;
            if($teacher->DienThoai!=null)
            $sms->SDTGV = $teacher->DienThoai;
            else
                $sms->SDTGV="Unknown";
            $sms->TuNgay = $dateStart->format('y-m-d');
            $sms->DenNgay = $dateEnd->format('y-m-d');
            $sms->TenGiaoVien = DsGiaoVien::getFullName($idTeacher);
            $sms->LopChuaNhap = $strMessage;
            $sms->LopDaNhap = $strMessageGvNhapRoi;
            $sms->save();
        }


    }
    public function actionGetSms()
    {
        $month = $_POST['month'];
        $semester =$_POST['semester'];
        $index=$_POST['index'];
        GetSms::getSms($month,$semester,$index);

        $index++;
        echo $index;
    }
    public function actionTest()
    {
      $idYear=DSNamHoc::getCurrentYear();
     echo   GetSms::getSmsSummary( 'K1',1);
        //TongKetTheoKyBLL::XetDanhHieu("K1","GV003");
    }

}