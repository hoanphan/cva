<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "solienlacdientu".
 *
 * @property string $MaHocSinh
 * @property integer $MaTuan
 * @property string $MaNamhoc
 * @property string $NoiDung
 */
class SoLienLacDienTu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solienlacdientu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh', 'MaTuan', 'MaNamhoc'], 'required'],
            [['MaTuan'], 'integer'],
            [['NoiDung'], 'string'],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['MaNamhoc'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHocSinh' => 'Ma Hoc Sinh',
            'MaTuan' => 'Ma Tuan',
            'MaNamhoc' => 'Ma Namhoc',
            'NoiDung' => 'Noi Dung',
        ];
    }
    public function getListStudentFolowClass($idClass)
    {
       return DsHocSinh::find()->
        innerJoin('dshocsinhtheolop',['dshocsinh.MaHocSinh'=>'dshocsinhtheolop.MaHocSinh'])->where(['MaLop'=>$idClass])->all();
    }

    /**
     * @return string
     */
    public static function getNameStudent($idStdent)
    {
        return DsHocSinh::getFullName($idStdent);
    }
   /**
     * @return string
     */
    public static function getEndDay($idWeek)
    {
        return DSTuan::getEndDay($idWeek);
    }
    public static function getStartDay($idWeek)
    {
        return DSTuan::getStartDay($idWeek);
    }
}
