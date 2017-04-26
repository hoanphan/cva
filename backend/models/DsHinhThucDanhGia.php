<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dshinhthucdanhgia".
 *
 * @property integer $MaHinhThucDanhGia
 * @property string $TenHinhThucDanhGia
 * @property integer $TinhDiem
 */
class DsHinhThucDanhGia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshinhthucdanhgia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHinhThucDanhGia'], 'required'],
            [['MaHinhThucDanhGia', 'TinhDiem'], 'integer'],
            [['TenHinhThucDanhGia'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHinhThucDanhGia' => 'Ma Hinh Thuc Danh Gia',
            'TenHinhThucDanhGia' => 'Ten Hinh Thuc Danh Gia',
            'TinhDiem' => 'Tinh Diem',
        ];
    }
}
