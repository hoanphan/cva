<?php
namespace backend\controllers;


use backend\models\CreaateRescroses;

use backend\component\ContentGmail;

use backend\models\DsGiaoVien;
use backend\models\DsHocSinh;
use backend\models\Login;
use common\models\ChangePassword;
use Yii;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\LoginForm;
use yii\web\UploadedFile;
use  backend\BLL\LogBLL;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
   public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'login',
                            'error',

                            'test'
                        ],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'profile'
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Dsdiem::addScrose('HS00001','20152016','K1','MH01','LD1',2,8);
        //if(Dsdiem::updateScroses('HS00001','20152016','MH01','K1','LD1',1,6))
        $log=new LogBLL();
        $log->update('Trang chủ');
        return $this->render('index', [

        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout='loginMain';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            if( $model->login()) {
                $login=new Login();
                $login->TaiKhoan=$model->username;
                $login->QuyenDangNhap="Giáo viên";
                $login->ThanhCong=1;
                $loginBLl=new LogBLL();
                $loginBLl->Add($login);
                return $this->goBack();

            }
            else {
                $login=new Login();
                $login->TaiKhoan=$model->username;
                $login->QuyenDangNhap="Chưa xác định";
                $login->ThanhCong=0;
                $loginBLl=new LogBLL();
                $loginBLl->Add($login);
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }
        else
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionProfile()
    {
        $log=new LogBLL();
        $log->update('Cập nhật thông tin');
        $model = new ChangePassword();
        $teacher=DsGiaoVien::findTeacher(Yii::$app->user->id);
        $model->email=$teacher->Email;
        $model->phone=$teacher->DienThoai;
        if ($model->load(Yii::$app->request->post())) {
            $str=$_POST['ChangePassword'];
            $image=UploadedFile::getInstanceByName('ChangePassword[image]');
            if($image!=null) {

                $model->image = Yii::$app->security->generateRandomString() . "." . $image->extension;
                $path = Yii::$app->params['uploadImages'] . $model->image;
                $image->saveAs($path);
            }
            if($str['password1']==$str['password2']) {
                if ($model->resetPassword()) {
                    $model->password1='';
                    $model->password='';
                    $model->password2='';
                    if($image!=null) {
                        $teacher->Anh = $model->image;

                    }
                    $teacher->Email=$model->email;
                    $teacher->DienThoai=$model->phone;
                    if($teacher->save())
                    return $this->render('profile', ['message'=>'Cập nhật thành công',
                        'model' => $model,
                    ]);
                    else
                        return $this->render('profile', ['message'=>'Cập nhật không thành công',
                            'model' => $model,
                        ]);
                }
                else{

                    return $this->render('profile', ['message'=>'Cập nhật thành công',
                        'model' => $model,
                    ]);
                }
            }
            elseif($str['password1']!=null)
            {
                return $this->render('profile', ['message'=>'Mật khẩu cũ và mật khẩu nhập lại không trùng nhau',
                    'model' => $model,
                ]);
            }
            else
            {
                if($image!=null) {
                    $teacher->Anh = $model->image;

                }
                $teacher->Email=$model->email;
                $teacher->DienThoai=$model->phone;
                $teacher->save();
            }

        }
        else
        {
            return $this->render('profile', ['message'=>'',
                'model' => $model,
            ]);
        }

    }

}
