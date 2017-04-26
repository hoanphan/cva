<?php
namespace backend\controllers;


use backend\BLL\DsDiemBLL;
use backend\BLL\DsTongKetBLL;
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
use frontend\models\DsMonHocTheoLop;
use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\LoginForm;
use backend\BLL\TongKetBLL;


/**
 * Site controller
 */
class SummaryController extends Controller
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
                        'actions' => ['index','conduct','get-conduct','add-conduct','check-average','average-scroses','hoc-luc','xet-hoc-luc','xet-danh-hieu','change-semester','get-list-conduct','get-summary'],
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

    /**
     * @return action Tổng kết
     */
    public function  actionIndex()
    {
        $semester=new DSHocKy();
        $class=new DsLop();
        $searchModel = new DsTongKetTheoKySearch();
        $idUser=Yii::$app->user->id;
        $kt=0;

       if ($class->load(Yii::$app->request->post()))
       {
           $idClass=$class['TenLop'];
       }
       else {
           if (DsLop::isHomeroomTeacher($idUser)) {
               $idClass = DsLop::getClassFollowTeacher($idUser)->MaLop;
               $kt=1;
           } else {
               $dsLop = DsLop::find()->all();
               $idClass = $dsLop[0]->MaLop;
           }
       }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$idClass,'K1');
        return $this->render("index",['semester'=>$semester,'class'=>$class,
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,'kt'=>$kt]);
    }

    /**
     * @return action ds hạnh kiểm
     */
    public function  actionConduct()
    {
        $idClass=DsLop::findOne(['MaGVCN'=>Yii::$app->user->id])->MaLop;
        $dsHocSinhTheoLop=DSHocSinhTheoLop::find()->where(['MaLop'=>$idClass])->orderBy(['STT'=>SORT_ASC])->all();
        $semester=new DsHocKy();

        return $this->render("conduct",['model'=>$dsHocSinhTheoLop,'idSemester'=>'K1','semester'=>$semester]);
    }
    public function actionGetConduct()
    {
        $idStudent=$_POST['idStudent'];
        $idSemester=$_POST['idSemester'];
         echo TongKetTheoKyBLL::getNameConduct($idStudent,$idSemester);
    }
    public function actionAddConduct()
    {
        $idStudent=$_POST['idStudent'];
        $idSemester=$_POST['idSemester'];
        $idConduct=$_POST['idConduct'];
        if(TongKetTheoKyBLL::addConduct($idStudent,$idSemester,$idConduct))
            echo "ok";
        else
            echo "ko dc roi";
    }
    public function actionCheckAverage()
    {
       $SemesterSummary= DSHocKy::getSemesterSummary()->MaHocKy;
       $idUser=Yii::$app->user->id;
       $idSemester=$_POST['idSemester'];
        $dsMonHoc="";
        if($idSemester!=$SemesterSummary) {
            if (DsLop::isHomeroomTeacher($idUser)) {
                DsDiemBLL::KiemTraNhapDiemHocKyCacMonHoc($idSemester, $idUser, $dsMonHoc);
            } else
                DsDiemBLL::KiemTraNhapDiemHocKyCacMonHocDuocTinhTBCToanTruong($idSemester, $idUser, $dsMonHoc);
        }
       echo  $dsMonHoc;
    }
    public function actionAverageScroses()
    {
        $idUser=Yii::$app->user->id;
        $idSemester=$_POST['idSemester'];

        if(DsLop::isHomeroomTeacher($idUser))
        {
            TongKetBLL::TinhDiemTBC($idSemester,$idUser);
        }
        else {
            $dsLop=DsLop::find()->select('MaLop')->all();
            TongKetTheoKyBLL::XetHocLucTheoDSLop($idSemester,$dsLop);

        }
    }
    public function  actionHocLuc()
    {
        $SemesterSummary= DSHocKy::getSemesterSummary()->MaHocKy;
        $idUser=Yii::$app->user->id;
        $idSemester=$_POST['idSemester'];
        $dsMonHoc="";
        if($SemesterSummary!=$idSemester) {
            if (DsLop::isHomeroomTeacher($idUser)) {
                DsDiemBLL::KiemTraNhapDiemHocKyCacMonHoc($idSemester, $idUser, $dsMonHoc);
            } else
                DsDiemBLL::KiemTraNhapDiemHocKyCacMonHocToanTruong($idSemester, $idUser, $dsMonHoc);
        }
        echo  $dsMonHoc;
    }
    public function  actionXetHocLuc()
    {
        $idUser=Yii::$app->user->id;
        $idSemester=$_POST['idSemester'];

        if(DsLop::isHomeroomTeacher($idUser))
        {
            //DsDiemBLL::KiemTraNhapDiemHocKyCacMonHoc($idSemester,$idUser,$dsMonHoc);

            TongKetTheoKyBLL::XetHocLuc($idSemester,$idUser);
        }
        else {
            $dsLop=DsLop::find()->select('MaLop')->all();
            TongKetTheoKyBLL::XetHocLucTheoDSLop($idSemester,$dsLop);
        }
    }
    public function  actionXetDanhHieu()
    {
        $idUser=Yii::$app->user->id;
        $idSemester=$_POST['idSemester'];
        echo TongKetTheoKyBLL::XetDanhHieu($idSemester,$idUser);
    }
    public function actionChangeSemester()
    {
	    $idClass=DsLop::findOne(['MaGVCN'=>Yii::$app->user->id])->MaLop;
	    $idSemester=$_POST['semester'];
	    $dsHocSinhTheoLop=DSHocSinhTheoLop::find()->where(['MaLop'=>$idClass])->orderBy(['STT'=>SORT_ASC])->all();
    	return $this->renderPartial('change-semester',['model'=>$dsHocSinhTheoLop,'idSemester'=>$idSemester]);
    }
    public function actionGetListConduct()
    {
        $this->layout=false;
        $idSemester=$_POST['idSemester'];
        $idClass=DsLop::findOne(['MaGVCN'=>Yii::$app->user->id])->MaLop;
        $dsHocSinhTheoLop=DSHocSinhTheoLop::find()->where(['MaLop'=>$idClass])->orderBy(['STT'=>SORT_ASC])->all();
        $semester=new DsHocKy();

        return $this->render("get-conduct",['model'=>$dsHocSinhTheoLop,'idSemester'=>$idSemester,'semester'=>$semester]);
    }
    public function actionGetSummary()
    {
        $this->layout=false;
        $idSemester=$_POST['idSemester'];
        $semester=new DSHocKy();
        $class=new DsLop();
        $searchModel = new DsTongKetTheoKySearch();
        $idUser=Yii::$app->user->id;
        $kt=0;

        if ($class->load(Yii::$app->request->post()))
        {
            $idClass=$class['TenLop'];
        }
        else {
            if (DsLop::isHomeroomTeacher($idUser)) {
                $idClass = DsLop::getClassFollowTeacher($idUser)->MaLop;
                $kt=1;
            } else {
                $dsLop = DsLop::find()->all();
                $idClass = $dsLop[0]->MaLop;
            }
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$idClass,$idSemester);
        return $this->render("get-summary",['semester'=>$semester,'class'=>$class,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kt'=>$kt]);
    }
}
