<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dsmonhoctheolop".
 *
 * @property string $MaNamHoc
 * @property string $MaLop
 * @property string $MaMonHoc
 * @property string $MaHocKy
 * @property string $MaGiaoVien
 */
class DsMonHocTheoLop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsmonhoctheolop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaLop', 'MaMonHoc', 'MaHocKy'], 'required'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaLop', 'MaMonHoc'], 'string', 'max' => 4],
            [['MaHocKy'], 'string', 'max' => 2],
            [['MaGiaoVien'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaNamHoc' => 'Ma Nam Hoc',
            'MaLop' => 'Ma Lop',
            'MaMonHoc' => 'Ma Mon Hoc',
            'MaHocKy' => 'Ma Hoc Ky',
            'MaGiaoVien' => 'Ma Giao Vien',
        ];
    }
}
