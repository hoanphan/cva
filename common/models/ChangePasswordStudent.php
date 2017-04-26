<?php
namespace common\models;

use backend\models\DsGiaoVien;
use frontend\models\DsHocSinh;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ChangePasswordStudent extends Model
{
    public $password;
    public $password1;
    public $password2;
    public $phone;
    public $email;
    public $image;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            // rememberMe must be a boolean value
            [['password','password1','password2'], 'string','min' => 6],
            [['email','image'], 'string'],
            [['phone','image'], 'string','min'=>10],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password1','incorectPassword']

        ];
    }
    public function attributeLabels()
    {
        return [
            'password' => 'Mật khẩu cũ',
            'password1' => 'Mật khẩu mới',
            'password2' => 'Nhập lại mật khẩu',
            'email'=>'Tài khoản email',
            'phone'=>'Số điện thoại',
            'image'=>'Ảnh đại diện'

        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }
    public function incorectPassword($attribute,$params)
    {
        if($this->password2!=$this->password1) {
            $this->addError($params, 'Mật khẩu nhập không trùng nhau');
            return false;
        }
        else
            return true;

    }
    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function resetPassword()
    {

            if ($this->validate()) {
                $user = $this->getUser();
                $user->MatKhau = Yii::$app->security->generatePasswordHash($this->password1);
                return $user->save();
            } else {
                return false;
            }

    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = DsHocSinh::findByUsername(Yii::$app->user->id);
        }

        return $this->_user;
    }
}
