<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ds_quyen_chuc_nang".
 *
 * @property string $MaQuyen
 * @property string $MaChucNang
 */
class DsQuyenChucNang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ds_quyen_chuc_nang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaQuyen', 'MaChucNang'], 'required'],
            [['MaQuyen', 'MaChucNang'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaQuyen' => 'Ma Quyen',
            'MaChucNang' => 'Ma Chuc Nang',
        ];
    }
}
