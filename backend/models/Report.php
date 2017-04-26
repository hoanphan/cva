<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/9/2016
 * Time: 9:02 AM
 */

namespace backend\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dmhocluc".
 *
 * @property string $id
 * @property string $name
 */
class Report  extends  ActiveRecord
{
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id','name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ma báo cáo',
            'name' => 'Tên báo cáo',
        ];
    }
}