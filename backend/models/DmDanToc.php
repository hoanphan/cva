<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dmdantoc".
 *
 * @property integer $MaDanToc
 * @property string $TenDanToc
 * @property integer $ThongKeDanToc
 */
class DmDanToc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dmdantoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaDanToc', 'TenDanToc'], 'required'],
            [['MaDanToc', 'ThongKeDanToc'], 'integer'],
            [['TenDantToc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaDanToc' => 'Madantoc',
            'TenDanToc' => 'Tendantoc',
            'ThongKeDanToc' => 'Thongkedantoc',
        ];
    }
}
