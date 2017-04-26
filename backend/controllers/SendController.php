<?php
namespace backend\controllers;


use backend\component\GetSms;
use backend\component\SmsContent;
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
use frontend\models\ContactForm;
use frontend\models\DSHocSinhTheoLop;
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
class SendController extends Controller
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
                        'actions' => ['index', 'sms', 'test','check-sms','combobox-change','count-sms','send-information-student','get-sms','get-sms-summary'],
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
    public function actionIndex()
    {
        $semester=new DSHocKy();
        $searchModel = new DsHocSinhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,true);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester'=>$semester
        ]);

    }
    public function actionSms()
    {
        $semester=new DSHocKy();
        $searchModel = new DsHocSinhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,true);
        $month=new DsThang();
        DsTinNhanXuatExcel::deleteAll();
        return $this->render('sms', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester'=>$semester,
            'month'=>$month
        ]);
    }
    /**
     * Logout action.
     *
     * @return string
     */

    public function actionCheckSms()
    {
        $month=4;
        $searchModel = new DsTinNhanHocSinhSearch();
        $dsTinNhan=DsTinNhanHocSinh::find()->where(['Thang'=>$month])->all();
        foreach ($dsTinNhan as $item)
        {
            $tinNhan=DsTinNhanHocSinh::findOne(['idSms'=>$item->idSms]);
           if($tinNhan->LoiPhatSinh=="100") {
               $value = SmsContent::checkSendSms($item->idSms);
               if ($value == "5" || $tinNhan == "6") {
                   $tinNhan->delete();
               } else {
                   $tinNhan->TrangThai = $value;
               }
           }
            else
            {
                SmsContent::sendSms($tinNhan->SddtPhuHuynh,$tinNhan->NoiDung,$tinNhan->MaHocSinh,$tinNhan->Thang);
                $tinNhan->delete();
            }

        }
        $month=(integer)$month;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$month);
        return $this->renderPartial("check",[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionComboboxChange()
    {

        $month=$_POST['month'];
        $month=(integer)$month;
        $searchModel = new DsTinNhanHocSinhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$month);
        return $this->renderPartial("check",[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCountSms()
    {

        $month=$_POST['month'];
        $month=(integer)$month;
        return  $dsTinNhan=DsTinNhanHocSinh::find()->where(['Thang'=>$month])->count();
    }
    /**
     *
     */
    public function actionSendInformationStudent()
    {
        $listStudent=DSHocSinhTheoLop::find()->all();
        DsTinNhanXuatExcel::deleteAll();
        Loi::deleteAll();
        foreach ($listStudent as $item)
        {
            $tin_nhan=new DsTinNhanXuatExcel();
            $tin_nhan->MaHocSinh=$item->MaHocSinh;
            $tin_nhan->TenHocSinh=DsHocSinh::getFullName($item->MaHocSinh);
            $tin_nhan->Ky="K1";
            $tin_nhan->Thang="10";
            $tin_nhan->SDT=DsHocSinh::getSoDienThoaiPhuHuynh($item->MaHocSinh);
            $tin_nhan->NoiDung=SmsContent::contentSmsInformation($item->MaHocSinh);

           if(!$tin_nhan->save())
           {
               $loi=new Loi();
               $loi->MaHocSinh=$item->MaHocSinh;

           }
        }
        return $this->redirect(Url::toRoute(['/ds-tin-nhan-xuat-excel/index']));
    }
    public function actionGetSms()
    {
        $month = $_POST['month'];
        $semester = $_POST['semester'];
        $index=(int)$_POST['index'];
           GetSms::getSms($month, $semester,$index);
            $index++;
        echo $index;

    }
    public function actionGetSmsSummary()
    {
        $semester = $_POST['semester'];
        $index=(int)$_POST['index'];
        GetSms::getSmsSummary( $semester,$index);
        $index++;
        echo $index;

    }

}
