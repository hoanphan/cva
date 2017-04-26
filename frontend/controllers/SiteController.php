<?php
namespace frontend\controllers;

use backend\BLL\LogBLL;
use backend\models\DsMonHocTheoLop;
use backend\models\Login;
use common\models\ChangePassword;
use common\models\ChangePasswordStudent;
use common\models\StudentLoginForm;
use frontend\models\DsHocSinh;
use frontend\models\DSHocSinhTheoLop;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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
                        ],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'diem',
                            'sldt',
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
       /* return $this->render('index');*/
       return $this->redirect(['diem']);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout='loginMain';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new StudentLoginForm();
        if ($model->load(Yii::$app->request->post()) ) {
            if($model->login()) {
                $login=new Login();
                $login->TaiKhoan=$model->username;
                $login->QuyenDangNhap="Học sinh";
                $login->ThanhCong=1;
                $loginBLl=new LogBLL();
                $loginBLl->Add($login);
                return $this->goBack();
            }
            else {
                $login=new Login();
                $login->TaiKhoan=$model->username;

                $login->ThanhCong=0;
                $login->QuyenDangNhap="Chưa xác định - học sinh";
                $loginBLl=new LogBLL();
                $loginBLl->Add($login);
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $log=new LogBLL();
        $log->update('Đăng xuất');
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionDiem()
    {
        $log=new LogBLL();
        $log->update('Xem điểm');
        return $this->render('diem');
    }
    public function actionSldt()
    {
        $log=new LogBLL();
        $log->update('Xem sổ liên lạc điện tử');
        $idClass=DSHocSinhTheoLop::getClassFollowStudent(Yii::$app->user->getId());
        return $this->render('sldt',['class'=>$idClass]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        $log=new LogBLL();
        $log->update('Thay đổi thông tin');
        $model = new ChangePasswordStudent();
        $hocSinh=DsHocSinh::findOne(Yii::$app->user->id);
        $model->email=$hocSinh->EmailPhuHuynh;
        $model->phone=$hocSinh->SoDienThoaiPhuHuynh;
        if ($model->load(Yii::$app->request->post())) {
            $str=$_POST['ChangePasswordStudent'];

            if($str['password1']==$str['password2']) {
                if ($model->resetPassword()) {
                    $model->password1='';
                    $model->password='';
                    $model->password2='';
                    $hocSinh->EmailPhuHuynh=$model->email;
                    $hocSinh->SoDienThoaiPhuHuynh=$model->phone;
                     if($hocSinh->save())
                    return $this->render('profile', ['message'=>'Cập nhật thành công',
                        'model' => $model,
                    ]);
                    else
                        return $this->render('profile', ['message'=>'Cập nhật không thành công',
                            'model' => $model,
                        ]);
                }
                else{

                        return $this->render('profile', ['message'=>'Cập nhật không thành công',
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

        }
        else
        {
            return $this->render('profile', ['message'=>'',
                'model' => $model,
            ]);
        }

    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {

        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
