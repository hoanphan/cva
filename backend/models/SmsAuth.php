<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sms_auth".
 *
 * @property string $API_Key
 * @property string $Secrect_Key
 * @property string $Brandname
 * @property integer $status
 */
class SmsAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['API_Key', 'Secrect_Key','Brandname', 'status'], 'required'],
            [['status'], 'integer'],
            [['API_Key'], 'string', 'max' => 15],
            [[ 'Secrect_Key','Brandname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'API_Key' => 'Api  Key',
            'Secrect_Key' => 'Secrect  Key',
            'Brandname'=>'',
            'status' => 'Status',
        ];
    }
}
