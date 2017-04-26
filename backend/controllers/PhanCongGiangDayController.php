<?php

namespace backend\controllers;

use Yii;
use backend\models\PhanCongGiangDay;
use backend\ModelSearch\PhanCongGiangDaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhanCongGiangDayController implements the CRUD actions for PhanCongGiangDay model.
 */
class PhanCongGiangDayController extends Controller
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
     * Lists all PhanCongGiangDay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhanCongGiangDaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PhanCongGiangDay model.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaGiaoVien
     * @param string $MaMonHoc
     * @param string $MaLop
     * @return mixed
     */
    public function actionView($MaNamHoc, $MaHocKy, $MaGiaoVien, $MaMonHoc, $MaLop)
    {
        return $this->render('view', [
            'model' => $this->findModel($MaNamHoc, $MaHocKy, $MaGiaoVien, $MaMonHoc, $MaLop),
        ]);
    }

    /**
     * Creates a new PhanCongGiangDay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PhanCongGiangDay();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaGiaoVien' => $model->MaGiaoVien, 'MaMonHoc' => $model->MaMonHoc, 'MaLop' => $model->MaLop]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PhanCongGiangDay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaGiaoVien
     * @param string $MaMonHoc
     * @param string $MaLop
     * @return mixed
     */
    public function actionUpdate($MaNamHoc, $MaHocKy, $MaGiaoVien, $MaMonHoc, $MaLop)
    {
        $model = $this->findModel($MaNamHoc, $MaHocKy, $MaGiaoVien, $MaMonHoc, $MaLop);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaGiaoVien' => $model->MaGiaoVien, 'MaMonHoc' => $model->MaMonHoc, 'MaLop' => $model->MaLop]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PhanCongGiangDay model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaGiaoVien
     * @param string $MaMonHoc
     * @param string $MaLop
     * @return mixed
     */
    public function actionDelete($MaNamHoc, $MaHocKy, $MaGiaoVien, $MaMonHoc, $MaLop)
    {
        $this->findModel($MaNamHoc, $MaHocKy, $MaGiaoVien, $MaMonHoc, $MaLop)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PhanCongGiangDay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaGiaoVien
     * @param string $MaMonHoc
     * @param string $MaLop
     * @return PhanCongGiangDay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($MaNamHoc, $MaHocKy, $MaGiaoVien, $MaMonHoc, $MaLop)
    {
        if (($model = PhanCongGiangDay::findOne(['MaNamHoc' => $MaNamHoc, 'MaHocKy' => $MaHocKy, 'MaGiaoVien' => $MaGiaoVien, 'MaMonHoc' => $MaMonHoc, 'MaLop' => $MaLop])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
