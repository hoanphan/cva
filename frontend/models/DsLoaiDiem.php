<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dsloaidiem".
 *
 * @property string $MaLoaiDiem
 * @property string $TenLoaiDiem
 * @property integer $SoDiemToiDa
 * @property integer $HeSo
 * @property string $HienThi
 * @property integer $ChoPhepChinhSua
 * @property integer $TinhToan
 * @property integer $TongHop
 * @property integer $LaHocKy
 */
class DsLoaiDiem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsloaidiem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaLoaiDiem'], 'required'],
            [['SoDiemToiDa', 'HeSo', 'ChoPhepChinhSua', 'TinhToan', 'TongHop', 'LaHocKy'], 'integer'],
            [['MaLoaiDiem'], 'string', 'max' => 3],
            [['TenLoaiDiem', 'HienThi'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaLoaiDiem' => 'Ma Loai Diem',
            'TenLoaiDiem' => 'Ten Loai Diem',
            'SoDiemToiDa' => 'So Diem Toi Da',
            'HeSo' => 'He So',
            'HienThi' => 'Hien Thi',
            'ChoPhepChinhSua' => 'Cho Phep Chinh Sua',
            'TinhToan' => 'Tinh Toan',
            'TongHop' => 'Tong Hop',
            'LaHocKy' => 'La Hoc Ky',
        ];
    }
    public static function getListTypeScrose()
    {
        return DsLoaiDiem::find()->orderBy(['MaLoaiDiem'=>SORT_ASC])->all();
    }
}
