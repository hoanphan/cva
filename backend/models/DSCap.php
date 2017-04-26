<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dscap".
 *
 * @property string $MaCap
 * @property string $TenCap
 */
class DSCap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dscap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaCap'], 'required'],
            [['MaCap'], 'string', 'max' => 8],
            [['TenCap'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaCap' => 'Ma Cap',
            'TenCap' => 'Ten Cap',
        ];
    }
    public static function getLevelFist()
    {
        $list=DSCap::find()->all();
        return $list[0]->MaCap;
    }
    public static function getName($id)
    {
        return DSCap::findOne($id)->TenCap;
    }
}
