<?php

namespace backend\controllers;


use backend\BLL\LogBLL;
use backend\BLL\RoleBLL;
use backend\models\BookElectronic;

use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DSTuan;

use Yii;
use backend\models\SoLienLacDienTu;
use app\ModelSearch\SoLienLacDienTuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * SoLienLacDienTuController implements the CRUD actions for SoLienLacDienTu model.
 */
class SoLienLacDienTuController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete','class-change'],
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
    public function actionClassChange()
    {
        $week=$_POST['week'];
        $idClass=$_POST['class'];
        $dataProvider = BookElectronic::create($idClass,$week);
        return $this->renderPartial('class-change', [
            'dataProvider' => $dataProvider,

        ]);

    }

    /**
     * Lists all SoLienLacDienTu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $log=new LogBLL();
        $log->update('Danh sách sổ liên lạc điện tử');
        DSTuan::updateListWeek();
        if(RoleBLL::checkFunction(0)||RoleBLL::checkFunction(5)) {
            $searchModel = new SoLienLacDienTuSearch();
            $idClass="L023";
            $idWeek = DSTuan::getLastWeek(DSNamHoc::getCurrentYear())->MaTuan;
            $dataProvider = BookElectronic::create("Unknown", $idWeek);
            $gruop=new DSKhoi();
            $class=new DsLop();
            $week = new DSTuan();
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'week' => $week,
                'gruop'=>$gruop,
                'class'=>$class,
                'idClass' => $idClass
            ]);
        }
        else {
            $searchModel = new SoLienLacDienTuSearch();
            $idClass = DsLop::getClassFollowTeacher(Yii::$app->user->id)->MaLop;
            $idWeek = DSTuan::getLastWeek(DSNamHoc::getCurrentYear())->MaTuan;
            $dataProvider = BookElectronic::create($idClass, $idWeek);
            $week = new DSTuan();
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'week' => $week,
                'idClass' => $idClass
            ]);
        }
    }

    /**
     * Displays a single SoLienLacDienTu model.
     * @param string $MaHocSinh
     * @param integer $MaTuan
     * @return mixed
     */
    public function actionView($MaHocSinh, $MaTuan)
    {
        $log=new LogBLL();
        $log->update('Xem sổ liên lạc điện tử');
        $MaNamhoc=DSNamHoc::getCurrentYear();
        $model=$this->findModel($MaHocSinh, $MaTuan, $MaNamhoc);
        $MaNamhoc=DSNamHoc::getCurrentYear();
        if ($model->load(Yii::$app->request->post()))
        {
            $model->save();
        }
        return $this->render('view', [
            'model' => $this->findModel($MaHocSinh, $MaTuan, $MaNamhoc),
        ]);
    }

    /**
     * Creates a new SoLienLacDienTu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($MaHocSinh,$MaTuan)
    {
        $log=new LogBLL();
        $log->update('Thêm sổ liên lạc điện tử');
        $yearCurrent=DSNamHoc::getCurrentYear();
        $model = new SoLienLacDienTu();
        $model->MaHocSinh=$MaHocSinh;
        $model->MaTuan=$MaTuan;
        $model->MaNamhoc=$yearCurrent;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'MaHocSinh' => $model->MaHocSinh, 'MaTuan' => $model->MaTuan, 'MaNamhoc' => $model->MaNamhoc]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SoLienLacDienTu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $MaHocSinh
     * @param integer $MaTuan
     * @param string $MaNamhoc
     * @return mixed
     */
    public function actionUpdate($MaHocSinh, $MaTuan)
    {
        $log=new LogBLL();
        $log->update('Sửa sổ liên lạc điện tử');
        $idYearCurrent=DSNamHoc::getCurrentYear();
        $model = $this->findModel($MaHocSinh, $MaTuan,$idYearCurrent);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'MaHocSinh' => $model->MaHocSinh, 'MaTuan' => $model->MaTuan, 'MaNamhoc' => $model->MaNamhoc]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SoLienLacDienTu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $MaHocSinh
     * @param integer $MaTuan
     * @param string $MaNamhoc
     * @return mixed
     */
    public function actionDelete($MaHocSinh, $MaTuan)
    {
        $log=new LogBLL();
        $log->update('Xóa sổ liên lạc điện tử');
        $MaNamhoc=DSNamHoc::getCurrentYear();
        $this->findModel($MaHocSinh, $MaTuan, $MaNamhoc)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SoLienLacDienTu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $MaHocSinh
     * @param integer $MaTuan
     * @param string $MaNamhoc
     * @return SoLienLacDienTu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($MaHocSinh, $MaTuan, $MaNamhoc)
    {
        if (($model = SoLienLacDienTu::findOne(['MaHocSinh' => $MaHocSinh, 'MaTuan' => $MaTuan, 'MaNamhoc' => $MaNamhoc])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
