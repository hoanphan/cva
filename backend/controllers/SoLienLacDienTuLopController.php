<?php

namespace backend\controllers;

use backend\BLL\LogBLL;
use backend\models\DSNamHoc;
use Yii;
use backend\models\SoLienLacDienTuLop;
use backend\ModelSearch\SoLienLacDienTuLopSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\DsLop;

/**
 * SoLienLacDienTuLopController implements the CRUD actions for SoLienLacDienTuLop model.
 */
class SoLienLacDienTuLopController extends Controller
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
        ];
    }

    /**
     * Lists all SoLienLacDienTuLop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $log=new LogBLL();
        $log->update('danh sách sổ liên lạc điện tử cả lớp');
        $searchModel = new SoLienLacDienTuLopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SoLienLacDienTuLop model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $log=new LogBLL();
        $log->update('Xem  sổ liên lạc điện tử cả lớp');
        $model=SoLienLacDienTuLop::findOne(['MaTuan'=>$id,'MaLop'=>DsLop::getClassFollowTeacher(Yii::$app->user->id)->MaLop,'MaNam'=>DSNamHoc::getCurrentYear()]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new SoLienLacDienTuLop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($MaTuan)
    {
        $log=new LogBLL();
        $log->update('Tạo sổ liên lạc điện tử cả lớp');
        $idClass=DsLop::getClassFollowTeacher(Yii::$app->user->id)->MaLop;

        $model = new SoLienLacDienTuLop();
        $model->MaTuan=$MaTuan;
        $model->MaLop=$idClass;
        $model->MaNam=DSNamHoc::getCurrentYear();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->MaTuan]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SoLienLacDienTuLop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($MaTuan)
    {
        $log=new LogBLL();
        $log->update('Cập nhật sổ liên lạc điện tử cả lớp');
        $model=SoLienLacDienTuLop::findOne(['MaTuan'=>$MaTuan,'MaLop'=>DsLop::getClassFollowTeacher(Yii::$app->user->id)->MaLop,'MaNam'=>DSNamHoc::getCurrentYear()]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->MaTuan]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SoLienLacDienTuLop model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $log=new LogBLL();
        $log->update('Xóa sổ liên lạc điện tử cả lớp');
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SoLienLacDienTuLop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SoLienLacDienTuLop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SoLienLacDienTuLop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
