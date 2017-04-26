<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dshocsinhchuyentruong".
 *
 * @property string $MaNamHoc
 * @property string $MaHocKy
 * @property string $MaHocSinh
 * @property integer $ChuyenDi
 * @property string $NoiChuyen
 * @property integer $HevNen
 */
class DsHocSinhChuyenTruong extends \yii\db\ActiveRecord
{
    const IS_HEVNEN=1;
    const IS_TRASFER=1;
     public $TRANSFER=[0=>'Chuyển đến',1=>'Chuyển đi'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocsinhchuyentruong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaNamHoc', 'MaHocKy', 'MaHocSinh'], 'required'],
            [['ChuyenDi', 'HevNen'], 'integer'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaHocKy'], 'string', 'max' => 2],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['NoiChuyen'], 'string', 'max' => 200],
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
            'ChuyenDi' => 'Chuyen Di',
            'NoiChuyen' => 'Noi Chuyen',
            'HevNen' => 'Hev Nen',
        ];
    }
}
