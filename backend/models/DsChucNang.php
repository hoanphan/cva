<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ds_chuc_nang".
 *
 * @property string $MaChucNang
 * @property string $TenChucNang
 * @property integer $ChucNang
 */
class DsChucNang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ds_chuc_nang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaChucNang', 'TenChucNang', 'ChucNang'], 'required'],
            [['ChucNang'], 'integer'],
            [['MaChucNang', 'TenChucNang'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaChucNang' => 'Ma Chuc Nang',
            'TenChucNang' => 'Ten Chuc Nang',
            'ChucNang' => 'Chuc Nang',
        ];
    }
}
