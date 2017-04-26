<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ds_tin_nhan_xuat_excel".
 *
 * @property integer $id
 * @property string $MaHocSinh
 * @property string $TenHocSinh
 * @property integer $Thang
 * @property string $Ky
 * @property string $SDT
 * @property string $NoiDung
 */
class DsTinNhanXuatExcel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ds_tin_nhan_xuat_excel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh', 'TenHocSinh', 'Thang', 'Ky', 'SDT', 'NoiDung'], 'required'],
            [['Thang'], 'integer'],
            [['NoiDung'], 'string'],
            [['MaHocSinh', 'Ky'], 'string', 'max' => 7],
            [['TenHocSinh'], 'string', 'max' => 255],
            [['SDT'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'MaHocSinh' => 'Mã học sinh',
            'TenHocSinh' => 'Tên học sinh',
            'Thang' => 'Tháng',
            'Ky' => 'Kì',
            'SDT' => 'Số điện thoại',
            'NoiDung' => 'Nội dung',
        ];
    }
}
