<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dshocky".
 *
 * @property string $MaHocKy
 * @property string $TenHocKy
 * @property integer $HeSo
 * @property integer $TongHop
 * @property integer $KiHienTai
 */
class DsHocKy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocKy'], 'required'],
            [['HeSo', 'TongHop', 'KiHienTai'], 'integer'],
            [['MaHocKy'], 'string', 'max' => 2],
            [['TenHocKy'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHocKy' => 'Ma Hoc Ky',
            'TenHocKy' => 'Ten Hoc Ky',
            'HeSo' => 'He So',
            'TongHop' => 'Tong Hop',
            'KiHienTai' => 'Ki Hien Tai',
        ];
    }
}
