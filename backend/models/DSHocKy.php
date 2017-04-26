<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dshocky".
 *
 * @property string $MaHocKy
 * @property string $TenHocKy
 * @property integer $HeSo
 * @property integer $TongHop
 * @property integer $KiHienTai
 */
class DSHocKy extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dshocky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocKy'], 'required'],
            [['HeSo', 'TongHop', 'KiHienTai'], 'integer'],
            [['MaHocKy'], 'string', 'max' => 2],
            [['TenHocKy'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHocKy' =>'Mã học học kỳ',
            'TenHocKy' => 'Tên học kỳ',
            'HeSo' => 'Hệ số',
            'TongHop' => 'Tổng hợp',
            'KiHienTai' => 'Kỳ hiện tại',
        ];
    }
    public static function getSemesterCurent()
    {
        return DSHocKy::findOne(['KiHienTai'=>1]);
    }
    public static function getSemesterSummary()
    {
        return DSHocKy::findOne(['TongHop'=>1]);
    }
    public static function getSemester()
    {
       $list= [['id' => 'K1', 'name' => 'K1']
       ,['id' => 'K2', 'name' => 'Ky 2']];
        $list1=['id' => 'K1', 'name' => 'K5'];
        $list2=['id' => 'K2', 'name' => 'Ky 2'];
        array_push($list,$list1);
        array_push($list,$list2);
        return $list;
    }
    public static function getNameSemester($idSemester)
    {
       return DSHocKy::findOne(['MaHocKy'=>$idSemester])->TenHocKy;
    }
    public static function getFistSemeter()
    {
        $list=DSHocKy::find()->all();
        return $list[0]->MaHocKy;
    }
}
