<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "solienlacdientulop".
 *
 * @property integer $MaTuan
 * @property string $MaNam
 * @property string $MaLop
 * @property string $NoiDung
 */
class SoLienLacDienTuLop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solienlacdientulop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaTuan', 'MaNam', 'MaLop', 'NoiDung'], 'required'],
            [['MaTuan'], 'integer'],
            [['NoiDung'], 'string'],
            [['MaNam'], 'string', 'max' => 8],
            [['MaLop'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaTuan' => 'Ma Tuan',
            'MaNam' => 'Ma Nam',
            'MaLop' => 'Ma Lop',
            'NoiDung' => 'Noi Dung',
        ];
    }
    public static function findToId($idClass,$idWeek)
    {
        $elecClass=SoLienLacDienTuLop::findOne(['MaLop'=>$idClass,'MaNam'=>DSNamHoc::getCurrentYear(),'MaTuan'=>$idWeek]);
        if($elecClass!=null)
            return true;
        else
            return false;
    }
}
