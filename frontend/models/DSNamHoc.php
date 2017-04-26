<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dsnamhoc".
 *
 * @property string $MaNamHoc
 * @property string $TenNamHoc
 * @property integer $NamHienTai
 */
class DSNamHoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsnamhoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaNamHoc'], 'required'],
            [['NamHienTai'], 'integer'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['TenNamHoc'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaNamHoc' => 'Mã năm học',
            'TenNamHoc' => 'Tên năm học',
            'NamHienTai' => 'Năm hiện tại',
        ];
    }
    public static function  getCurrentYear()
    {
        return Dsnamhoc::findOne(['NamHienTai'=>1])->MaNamHoc;
    }
}
