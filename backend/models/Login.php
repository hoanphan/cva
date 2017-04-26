<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "login".
 *
 * @property integer $id
 * @property string $TaiKhoan
 * @property string $QuyenDangNhap
 * @property integer $ThanhCong
 * @property string $IpLan
 * @property string $MacAddress
 * @property string $OperatingSystem
 * @property string $ThoiGianDangNhap
 * @property string $Use
 */
class Login extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Use'], 'required'],
            [['id', 'ThanhCong'], 'integer'],
            [['ThoiGianDangNhap'], 'safe'],
            [['Use'], 'string'],
            [['TaiKhoan', 'QuyenDangNhap', 'IpLan', 'MacAddress', 'OperatingSystem'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'TaiKhoan' => 'Tai Khoan',
            'QuyenDangNhap' => 'Quyen Dang Nhap',
            'ThanhCong' => 'Thanh Cong',
            'IpLan' => 'Ip Lan',
            'MacAddress' => 'Mac Address',
            'OperatingSystem' => 'Operating System',
            'ThoiGianDangNhap' => 'Thoi Gian Dang Nhap',
            'Use' => 'Use',
        ];
    }
}
