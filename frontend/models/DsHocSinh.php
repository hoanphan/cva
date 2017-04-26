<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "dshocsinh".
 *
 * @property string $MaHocSinh
 * @property string $HoDem
 * @property string $Ten
 * @property string $TenThuongGoi
 * @property integer $DaQuaLop
 * @property string $NgaySinh
 * @property integer $GioiTinh
 * @property string $NoiSinh
 * @property string $QueQuan
 * @property string $HoTenBo
 * @property string $NgheNghiepBo
 * @property string $HoTenMe
 * @property string $NgheNghiepMe
 * @property string $Anh
 * @property integer $MaDanToc
 * @property integer $MaTonGiao
 * @property integer $MaTinhTrangSucKhoe
 * @property string $NgayVaoDoan
 * @property string $NoiVaoDoan
 * @property string $MatKhau
 * @property string $EmailPhuHuynh
 * @property string $SoDienThoaiPhuHuynh
 * @property integer $DangKyDichVu
 */
class DsHocSinh extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocsinh';
    }

    private static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh'], 'required'],
            [['DaQuaLop', 'GioiTinh', 'MaDanToc', 'MaTonGiao', 'MaTinhTrangSucKhoe', 'DangKyDichVu'], 'integer'],
            [['NgaySinh', 'NgayVaoDoan'], 'safe'],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['HoDem', 'NoiSinh', 'QueQuan', 'HoTenBo', 'NgheNghiepBo', 'HoTenMe', 'NgheNghiepMe', 'NoiVaoDoan'], 'string', 'max' => 50],
            [['Ten'], 'string', 'max' => 10],
            [['TenThuongGoi'], 'string', 'max' => 30],
            [['Anh', 'MatKhau'], 'string', 'max' => 200],
            [['EmailPhuHuynh'], 'string', 'max' => 100],
            [['SoDienThoaiPhuHuynh'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHocSinh' => 'Ma Hoc Sinh',
            'HoDem' => 'Ho Dem',
            'Ten' => 'Ten',
            'TenThuongGoi' => 'Ten Thuong Goi',
            'DaQuaLop' => 'Da Qua Lop',
            'NgaySinh' => 'Ngay Sinh',
            'GioiTinh' => 'Gioi Tinh',
            'NoiSinh' => 'Noi Sinh',
            'QueQuan' => 'Que Quan',
            'HoTenBo' => 'Ho Ten Bo',
            'NgheNghiepBo' => 'Nghe Nghiep Bo',
            'HoTenMe' => 'Ho Ten Me',
            'NgheNghiepMe' => 'Nghe Nghiep Me',
            'Anh' => 'Anh',
            'MaDanToc' => 'Ma Dan Toc',
            'MaTonGiao' => 'Ma Ton Giao',
            'MaTinhTrangSucKhoe' => 'Ma Tinh Trang Suc Khoe',
            'NgayVaoDoan' => 'Ngay Vao Doan',
            'NoiVaoDoan' => 'Noi Vao Doan',
            'MatKhau' => 'Mat Khau',
            'EmailPhuHuynh' => 'Email Phu Huynh',
            'SoDienThoaiPhuHuynh' => 'So Dien Thoai Phu Huynh',
            'DangKyDichVu' => 'Dang Ky Dich Vu',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['MaHocSinh' => $id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }
    public static function findByUsername($username)
    {
        return static::findOne(['MaHocSinh' => $username,'DangKyDichVu'=>1]);
    }
    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->MaHocSinh;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->Ten;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->MatKhau);
    }
    public function setPassword($password)
    {
        $this->MatKhau = Yii::$app->security->generatePasswordHash($password);
    }

}
