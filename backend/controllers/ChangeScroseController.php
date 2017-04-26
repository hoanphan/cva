<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 10/14/2016
 * Time: 1:12 AM
 */

namespace backend\controllers;


use backend\BLL\LogBLL;
use backend\BLL\RoleBLL;
use backend\models\DsDiem;
use backend\models\DSHocSinhTheoLop;
use backend\models\PhanCongGiangDay;
use backend\ModelSearch\PhanCongGiangDaySearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Session;

class ChangeScroseController extends Controller
{ /**
 * @inheritdoc
 */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'change' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['edit','change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionEdit()
    {
        if(isset($_SESSION['kt']))
        {
            if($_SESSION['kt']==1) {
                $str = "1";
            }
            elseif($_SESSION['kt']==2)
                $str="2";
            else
                $str="3";
            $_SESSION['kt']=3;
        }
        else
            $str="3";
        $log = new LogBLL();
        $log->update('Sửa điểm điểm');
        if(RoleBLL::checkFunction(3)) {

            $searchModel = new PhanCongGiangDaySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('edit', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'stringCheck'=>$str
            ]);
        }
        else
            return $this->redirect(Url::toRoute(['/site/index']));
    }
    public function actionChange($idSubject,$idSemester,$idClass)
    {
        $kt=true;
        if(RoleBLL::checkFunction(3)) {
            $listStudent=DSHocSinhTheoLop::getListStudentFollowClass($idClass);
            foreach ($listStudent as $item)
            {
                $list= DsDiem::find()->where(['MaMonHoc'=>$idSubject,'MaHocSinh'=>$item->MaHocSinh,'MaHocKy'=>$idSemester])->all();
                foreach ($list as $item2) {
                    $diem = DsDiem::findOne(['MaMonHoc' => $idSubject, 'MaHocSinh' => $item2->MaHocSinh,
                        'MaHocKy' => $idSemester, 'MaLoaiDiem' => $item2->MaLoaiDiem,
                        'STTDiem' => $item2->STTDiem]);
                    if($diem!=null) {
                        $diem->ChoPhepSua = 0;
                        if (!$diem->save()) {
                            $kt=false;
                            break;
                        }
                    }
                }

            }

        }
        if($kt=true)
            $_SESSION['kt']=1;
        else
            $_SESSION['kt']=2;
        return $this->redirect(['edit']);
    }

}