<?php

namespace backend\models;

use DateTime;
use Yii;

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
class DsHocSinh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocsinh';
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
            'MaHocSinh' => 'Mã học sinh',
            'HoDem' => 'Họ đệm',
            'Ten' => 'Tên',
            'TenThuongGoi' => 'Tên thường gọi',
            'DaQuaLop' => 'Đã qua lớp',
            'NgaySinh' => 'Ngày sinh',
            'GioiTinh' => 'Giới tính',
            'NoiSinh' => 'Nơi sinh',
            'QueQuan' => 'Quê quán',
            'HoTenBo' => 'Họ tên bố',
            'NgheNghiepBo' => 'Nghề nghiệp bố',
            'HoTenMe' => 'Họ tên mẹ',
            'NgheNghiepMe' => 'Nghề nghiệp mẹ',
            'Anh' => 'Ảnh',
            'MaDanToc' => 'Mã dân tộc',
            'MaTonGiao' => 'Mã tôn giáo',
            'MaTinhTrangSucKhoe' => 'Mã tình trạng sức khỏe',
            'NgayVaoDoan' => 'Ngày vào đoàn',
            'NoiVaoDoan' => 'Nơi vào đoàn',
            'MatKhau' => 'Mật khẩu',
            'EmailPhuHuynh' => 'Email Phụ huynh',
            'SoDienThoaiPhuHuynh' => 'Số điện thoại huynh',
            'DangKyDichVu' => 'Đăng ký dịch vụ',
        ];
    }
    public static function getListStudent()
    {
        return DsHocSinh::find()->all();
    }
    public static function getFullName($id)
    {
        $student = self::getStudent($id);
        if ($student != null)
            return $student->HoDem . ' ' . $student->Ten;
        else
            return 'Unknown';
    }

    /**
     * @return string
     */
    public static function getNgaySinh($id)
    {
        $student = self::getStudent($id);
        if ($student != null)
            return DSTuan::formatDate($student->NgaySinh);
        else
            return null;
    }

    /**
     * @return string
     */
    public static function getSoDienThoaiPhuHuynh($id)
    {
        $student=self::getStudent($id);
        if($student->SoDienThoaiPhuHuynh==null)
            return 'Unknown';
        else
            return $student->SoDienThoaiPhuHuynh;
    }
    public static function getStudent($id)
    {
        return $student = DsHocSinh::findOne(['MaHocSinh' => $id]);
    }
    public static function generatePassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param $date
     */
    public static function getDayOfBithToText($date)
    {
        $bith=new DateTime($date);
        return $bith->format('d').$bith->format('m').$bith->format('Y');
    }
    public static function generateArrayIdNameArray()
    {
        $arr=array();
    }
    public static function CheckRegister($username)
    {
            if(self::getStudent($username)==null)
                return false;
            else
                return true;
    }
    public static function ArrayNameAndIdStudent()
    {
        $listStudent=DsHocSinh::getListStudent();
        $arr=[];
        foreach ($listStudent as $student) {
            $item = ['MaHocSinh' => $student->MaHocSinh, 'HoVaTen' => $student->HoDem . ' ' . $student->Ten];
            array_push($arr,$item);
        }
        return $arr;
    }
}
