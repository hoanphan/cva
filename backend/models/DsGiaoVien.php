<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "dsgiaovien".
 *
 * @property string $MaGiaoVien
 * @property string $HoDem
 * @property string $Ten
 * @property string $TenThuongGoi
 * @property string $BiDanh
 * @property string $NgaySinh
 * @property integer $GioiTinh
 * @property resource $Anh
 * @property string $SoCMND
 * @property string $NgayCapCMND
 * @property integer $NoiCapCMND
 * @property integer $MaTonGiao
 * @property integer $MaDanToc
 * @property string $NoiSinh
 * @property string $QueQuan
 * @property string $DiaChiThuongTru
 * @property string $DienThoai
 * @property string $Email
 * @property string $MonGiangDay
 * @property integer $MaTinhTrangSucKhoe
 * @property string $NgayVaoDoan
 * @property string $NoiVaoDoan
 * @property string $NgayVaoDang
 * @property string $NoiVaoDang
 * @property string $QuaTrinhCongTac
 * @property string $KhenThuong
 * @property string $KyLuat
 * @property string $TrangThai
 * @property string $BienChe
 * @property integer $MaTrinhDoChuan
 * @property string $NganhDaoTao
 * @property string $TrinhDoChuyenMon
 * @property string $ChuyenMonDaoTao
 * @property integer $MaTrinhDoChinhTri
 * @property integer $MaTrinhDoQLGD
 * @property integer $MaTrinhDoNgoaiNgu
 * @property integer $MaTrinhDoTinHoc
 * @property string $MaCongChuc
 * @property string $MaNgachCongChuc
 * @property string $SoSoBHXH
 * @property string $NgayVaoBienChe
 * @property string $NgayVaoNganh
 * @property string $NgayVaoTruong
 * @property integer $MaHeDaoTao
 * @property integer $MaChucVu
 * @property string $TrinhDo
 * @property string $TenVoHoacChong
 * @property string $NgaySinhVoChong
 * @property string $NgheNghiepVoChong
 * @property string $DiaChiCoQuanVoChong
 * @property string $HoTenBo
 * @property string $NgaySinhBo
 * @property string $NgheNghiepBo
 * @property string $HoTenMe
 * @property string $NgaySinhMe
 * @property string $NgheNghiepMe
 * @property string $AnhChiEm
 * @property string $ConCai
 * @property string $TPGiaDinh
 * @property string $TPBanThan
 * @property integer $MaToChuyenMon
 * @property string $TenDangNhap
 * @property string $MatKhau
 * @property string $MaQuyen
 */
class DsGiaoVien extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dsgiaovien}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaGiaoVien'], 'required'],
            [['NgaySinh', 'NgayCapCMND', 'NgayVaoDoan', 'NgayVaoDang', 'NgayVaoBienChe', 'NgayVaoNganh', 'NgayVaoTruong', 'NgaySinhVoChong', 'NgaySinhBo', 'NgaySinhMe'], 'safe'],
            [['GioiTinh', 'NoiCapCMND', 'MaTonGiao', 'MaDanToc', 'MaTinhTrangSucKhoe', 'MaTrinhDoChuan', 'MaTrinhDoChinhTri', 'MaTrinhDoQLGD', 'MaTrinhDoNgoaiNgu', 'MaTrinhDoTinHoc', 'MaHeDaoTao', 'MaChucVu', 'MaToChuyenMon'], 'integer'],
            [['Anh', 'QuaTrinhCongTac', 'KhenThuong', 'KyLuat', 'AnhChiEm', 'ConCai'], 'string'],
            [['MaGiaoVien'], 'string', 'max' => 5],
            [['HoDem', 'NoiSinh', 'QueQuan', 'DiaChiThuongTru', 'DienThoai', 'MonGiangDay', 'NoiVaoDoan', 'NoiVaoDang', 'TrangThai', 'BienChe', 'NganhDaoTao', 'TrinhDoChuyenMon', 'ChuyenMonDaoTao', 'MaCongChuc', 'MaNgachCongChuc', 'SoSoBHXH', 'TrinhDo', 'DiaChiCoQuanVoChong', 'TPGiaDinh', 'TPBanThan', 'TenDangNhap'], 'string', 'max' => 50],
            [[ 'MatKhau'], 'string', 'max' => 60],
            [['Ten', 'SoCMND'], 'string', 'max' => 10],
            [['TenThuongGoi', 'BiDanh', 'TenVoHoacChong', 'HoTenBo', 'HoTenMe'], 'string', 'max' => 30],
            [['Email'], 'string', 'max' => 40],
            [['NgheNghiepVoChong', 'NgheNghiepBo', 'NgheNghiepMe'], 'string', 'max' => 20],
            [['MaQuyen'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaGiaoVien' => 'Ma Giao Vien',
            'HoDem' => 'Ho Dem',
            'Ten' => 'Ten',
            'TenThuongGoi' => 'Ten Thuong Goi',
            'BiDanh' => 'Bi Danh',
            'NgaySinh' => 'Ngay Sinh',
            'GioiTinh' => 'Gioi Tinh',
            'Anh' => 'Anh',
            'SoCMND' => 'So Cmnd',
            'NgayCapCMND' => 'Ngay Cap Cmnd',
            'NoiCapCMND' => 'Noi Cap Cmnd',
            'MaTonGiao' => 'Ma Ton Giao',
            'MaDanToc' => 'Ma Dan Toc',
            'NoiSinh' => 'Noi Sinh',
            'QueQuan' => 'Que Quan',
            'DiaChiThuongTru' => 'Dia Chi Thuong Tru',
            'DienThoai' => 'Dien Thoai',
            'Email' => 'Email',
            'MonGiangDay' => 'Mon Giang Day',
            'MaTinhTrangSucKhoe' => 'Ma Tinh Trang Suc Khoe',
            'NgayVaoDoan' => 'Ngay Vao Doan',
            'NoiVaoDoan' => 'Noi Vao Doan',
            'NgayVaoDang' => 'Ngay Vao Dang',
            'NoiVaoDang' => 'Noi Vao Dang',
            'QuaTrinhCongTac' => 'Qua Trinh Cong Tac',
            'KhenThuong' => 'Khen Thuong',
            'KyLuat' => 'Ky Luat',
            'TrangThai' => 'Trang Thai',
            'BienChe' => 'Bien Che',
            'MaTrinhDoChuan' => 'Ma Trinh Do Chuan',
            'NganhDaoTao' => 'Nganh Dao Tao',
            'TrinhDoChuyenMon' => 'Trinh Do Chuyen Mon',
            'ChuyenMonDaoTao' => 'Chuyen Mon Dao Tao',
            'MaTrinhDoChinhTri' => 'Ma Trinh Do Chinh Tri',
            'MaTrinhDoQLGD' => 'Ma Trinh Do Qlgd',
            'MaTrinhDoNgoaiNgu' => 'Ma Trinh Do Ngoai Ngu',
            'MaTrinhDoTinHoc' => 'Ma Trinh Do Tin Hoc',
            'MaCongChuc' => 'Ma Cong Chuc',
            'MaNgachCongChuc' => 'Ma Ngach Cong Chuc',
            'SoSoBHXH' => 'So So Bhxh',
            'NgayVaoBienChe' => 'Ngay Vao Bien Che',
            'NgayVaoNganh' => 'Ngay Vao Nganh',
            'NgayVaoTruong' => 'Ngay Vao Truong',
            'MaHeDaoTao' => 'Ma He Dao Tao',
            'MaChucVu' => 'Ma Chuc Vu',
            'TrinhDo' => 'Trinh Do',
            'TenVoHoacChong' => 'Ten Vo Hoac Chong',
            'NgaySinhVoChong' => 'Ngay Sinh Vo Chong',
            'NgheNghiepVoChong' => 'Nghe Nghiep Vo Chong',
            'DiaChiCoQuanVoChong' => 'Dia Chi Co Quan Vo Chong',
            'HoTenBo' => 'Ho Ten Bo',
            'NgaySinhBo' => 'Ngay Sinh Bo',
            'NgheNghiepBo' => 'Nghe Nghiep Bo',
            'HoTenMe' => 'Ho Ten Me',
            'NgaySinhMe' => 'Ngay Sinh Me',
            'NgheNghiepMe' => 'Nghe Nghiep Me',
            'AnhChiEm' => 'Anh Chi Em',
            'ConCai' => 'Con Cai',
            'TPGiaDinh' => 'Tpgia Dinh',
            'TPBanThan' => 'Tpban Than',
            'MaToChuyenMon' => 'Ma To Chuyen Mon',
            'TenDangNhap' => 'Ten Dang Nhap',
            'MatKhau' => 'Mat Khau',
            'MaQuyen'=>'Ma Quyen',
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
        return static::findOne(['MaGiaoVien' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['MaGiaoVien' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
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
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->Ten;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->MatKhau);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->MatKhau = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->MatKhau = Yii::$app->security->generateRandomString();
    }


    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {

    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {

    }
    public static function findTeacher($idTeacher)
    {

        return DsGiaoVien::findOne(['MaGiaoVien'=>$idTeacher]);
    }
    public static function getFullName($idTeacher)
    {
        $teacher=self::findTeacher($idTeacher);
        if($teacher!=null)
        return $teacher->HoDem.' '.$teacher->Ten;
        else
            return $idTeacher;
    }
    public static function getImager()
    {
        $url=self::findTeacher(Yii::$app->user->id)->Anh;
        if($url!=null)
            return BaseUrl::home().Yii::$app->params['uploadImages'].$url;
        else
            return null;
    }
    public static function CreateListIdAndName()
    {
        $arrTeacher=[];
        $lisTeacher=DsGiaoVien::find()->all();
        foreach ($lisTeacher as $item)
        {
            $arr=['MaGiaoVien'=>$item->MaGiaoVien,'HoTen'=>self::getFullName($item->MaGiaoVien)];
            array_push($arrTeacher,$arr);
        }
        return $arrTeacher;
    }

}
