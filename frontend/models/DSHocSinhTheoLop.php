<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dshocsinhtheolop".
 *
 * @property string $MaHocSinh
 * @property string $MaLop
 * @property integer $STT
 */
class DSHocSinhTheoLop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocsinhtheolop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh'], 'required'],
            [['STT'], 'integer'],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['MaLop'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHocSinh' => 'Mã học sinh',
            'MaLop' => 'Mã lớp',
            'STT' => 'STT',
        ];
    }
    public static function getListStudentFollowClass($id)
    {
        return DSHocSinhTheoLop::find()->where(['MaLop'=>$id])->orderBy(['STT'=>SORT_ASC])->all();
    }
    public static function getClassFollowStudent($id)
    {
        return DSHocSinhTheoLop::findOne(['MaHocSinh'=>$id])->MaLop;
    }
}
