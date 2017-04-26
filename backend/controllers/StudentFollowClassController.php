<?php
namespace backend\controllers;


use backend\BLL\DsDiemBLL;
use backend\BLL\DsTongKetBLL;
use backend\BLL\LogBLL;
use backend\BLL\TongKetTheoKyBLL;
use backend\component\GetSms;
use backend\component\SmsContent;
use backend\models\DMHanhKiem;
use backend\models\DmHocLuc;
use backend\models\DsDiem;
use backend\models\DsEmailSmsGuiToanBo;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DsMonHoc;
use backend\models\DSNamHoc;
use backend\component\ContentGmail;
use backend\component\CreateAttribute;

use backend\models\DsThang;
use backend\models\DsTinNhanHocSinh;
use backend\models\DsTinNhanXuatExcel;
use backend\models\Loi;
use backend\ModelSearch\DsEmailSmsGuiToanBoSearch;
use backend\ModelSearch\DsHocSinhSearch;
use backend\ModelSearch\DsTinNhanHocSinhSearch;
use backend\ModelSearch\DsTongKetTheoKySearch;
use frontend\models\ContactForm;
use backend\models\DSHocSinhTheoLop;
use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\LoginForm;


/**
 * Site controller
 */
class StudentFollowClassController extends Controller
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
                        'actions' => ['index','get','change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function  actionIndex()
    {
        $log = new LogBLL();
        $log->update('Cập nhật danh sách học sinh theo lớp');
        $semester = new DSHocKy();
        $groupClass = new DSKhoi();
        $class = new DsLop();
        return $this->render('index', [
            'semester' => $semester,
            'group' => $groupClass,
            'class' => $class,

        ]);
    }
    public function actionGet()
    {
        $MaLop = $_POST['Class'];

        $idYearCurrent = DSNamHoc::getCurrentYear();
        $dsStudentFolowClass = DSHocSinhTheoLop::getListStudentFollowClass($MaLop);
        return $this->renderPartial('get', ['model' => $dsStudentFolowClass,
            'Class' => $MaLop, 'idYear' => $idYearCurrent
        ]);
    }
    public function actionChange()
    {
        $idStudent=$_POST['idStudent'];
        $value=$_POST['value'];
        $idYear=DSNamHoc::getCurrentYear();
       $student= DSHocSinhTheoLop::findOne(['MaHocSinh'=>$idStudent,'MaNamHoc'=>$idYear]);
       $student->STT=$value;
       echo  $student->save();
    }

}
