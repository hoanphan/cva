<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dmtongiao".
 *
 * @property integer $MaTonGiao
 * @property string $TenTonGiao
 */
class DmTonGiao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dmtongiao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaTonGiao'], 'required'],
            [['MaTonGiao'], 'integer'],
            [['TenTonGiao'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaTonGiao' => 'Ma Ton Giao',
            'TenTonGiao' => 'Ten Ton Giao',
        ];
    }
}
