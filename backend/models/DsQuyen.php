<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ds_quyen".
 *
 * @property string $MaQuyen
 * @property string $TenQuyen
 */
class DsQuyen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ds_quyen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaQuyen', 'TenQuyen'], 'required'],
            [['MaQuyen', 'TenQuyen'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaQuyen' => 'Ma Quyen',
            'TenQuyen' => 'Ten Quyen',
        ];
    }
}
