<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dshocsinhthoihoc".
 *
 * @property string $MaNamHoc
 * @property string $MaHocKy
 * @property string $MaHocSinh
 * @property integer $BuocThoiHoc
 * @property string $LiDo
 */
class DsHocSinhThoiHoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocsinhthoihoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaNamHoc', 'MaHocKy', 'MaHocSinh'], 'required'],
            [['BuocThoiHoc'], 'integer'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaHocKy'], 'string', 'max' => 2],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['LiDo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaNamHoc' => 'Ma Nam Hoc',
            'MaHocKy' => 'Ma Hoc Ky',
            'MaHocSinh' => 'Ma Hoc Sinh',
            'BuocThoiHoc' => 'Buoc Thoi Hoc',
            'LiDo' => 'Li Do',
        ];
    }
}
