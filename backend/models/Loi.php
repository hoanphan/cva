<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "loi".
 *
 * @property integer $id
 * @property integer $MaHocSinh
 */
class Loi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh'], 'required'],
            [['MaHocSinh'], 'string','max'=>11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'MaHocSinh' => 'Ma Hoc Sinh',
        ];
    }
}
