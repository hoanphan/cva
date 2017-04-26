<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dmtinhtrangsuckhoe".
 *
 * @property integer $MaTinhTrangSucKhoe
 * @property string $TenTinhTrangSucKhoe
 */
class DMTinhTrangSucKhoe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dmtinhtrangsuckhoe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaTinhTrangSucKhoe'], 'required'],
            [['MaTinhTrangSucKhoe'], 'integer'],
            [['TenTinhTrangSucKhoe'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaTinhTrangSucKhoe' => 'Ma Tinh Trang Suc Khoe',
            'TenTinhTrangSucKhoe' => 'Ten Tinh Trang Suc Khoe',
        ];
    }
}
