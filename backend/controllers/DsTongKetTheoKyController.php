<?php

namespace backend\controllers;

use Yii;
use backend\models\DsTongKetTheoKy;
use backend\ModelSearch\DsTongKetTheoKySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DsTongKetTheoKyController implements the CRUD actions for DsTongKetTheoKy model.
 */
class DsTongKetTheoKyController extends Controller
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
     * Lists all DsTongKetTheoKy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DsTongKetTheoKySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DsTongKetTheoKy model.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaHocSinh
     * @return mixed
     */
    public function actionView($MaNamHoc, $MaHocKy, $MaHocSinh)
    {
        return $this->render('view', [
            'model' => $this->findModel($MaNamHoc, $MaHocKy, $MaHocSinh),
        ]);
    }

    /**
     * Creates a new DsTongKetTheoKy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DsTongKetTheoKy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaHocSinh' => $model->MaHocSinh]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DsTongKetTheoKy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaHocSinh
     * @return mixed
     */
    public function actionUpdate($MaNamHoc, $MaHocKy, $MaHocSinh)
    {
        $model = $this->findModel($MaNamHoc, $MaHocKy, $MaHocSinh);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'MaNamHoc' => $model->MaNamHoc, 'MaHocKy' => $model->MaHocKy, 'MaHocSinh' => $model->MaHocSinh]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DsTongKetTheoKy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaHocSinh
     * @return mixed
     */
    public function actionDelete($MaNamHoc, $MaHocKy, $MaHocSinh)
    {
        $this->findModel($MaNamHoc, $MaHocKy, $MaHocSinh)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DsTongKetTheoKy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $MaNamHoc
     * @param string $MaHocKy
     * @param string $MaHocSinh
     * @return DsTongKetTheoKy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($MaNamHoc, $MaHocKy, $MaHocSinh)
    {
        if (($model = DsTongKetTheoKy::findOne(['MaNamHoc' => $MaNamHoc, 'MaHocKy' => $MaHocKy, 'MaHocSinh' => $MaHocSinh])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
