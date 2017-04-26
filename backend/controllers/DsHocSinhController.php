<?php

namespace backend\controllers;

use Yii;
use backend\models\DsHocSinh;
use backend\ModelSearch\DsHocSinhSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DsHocSinhController implements the CRUD actions for Dshocsinh model.
 */
class DsHocSinhController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'update', 'delete','change-all-pass','config'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Dshocsinh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DsHocSinhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,false);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dshocsinh model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dshocsinh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DsHocSinh();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->MaHocSinh]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	/**
	 * reset a password student.
	 *
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *  @param string $id (id student)
	 * @return mixed
	 */
    public function actionConfig($id) {

		$student=DsHocSinh::findOne($id);
	    $student->MatKhau=Yii::$app->security->generatePasswordHash(DsHocSinh::getDayOfBithToText($student->NgaySinh));
	    $student->save();
	    return $this->redirect(['index']);
    }

	/**
     * Updates an existing Dshocsinh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->MaHocSinh]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionChangeAllPass()
    {
        $index=$_POST['index'];
        $listStudent=DsHocSinh::getListStudent();
        $index=(int)$index;
        $student=DsHocSinh::findOne($listStudent[$index]->MaHocSinh);
        $student->MatKhau=Yii::$app->security->generatePasswordHash(DsHocSinh::getDayOfBithToText($student->NgaySinh));
        $student->save();
        $index=(int)$index+1;
        echo $index;
    }

    /**
     * Deletes an existing Dshocsinh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dshocsinh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dshocsinh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DsHocSinh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
