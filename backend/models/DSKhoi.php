<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "dskhoi".
 *
 * @property string $MaKhoi
 * @property string $TenKhoi
 * @property string $MaCap
 */
class DSKhoi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dskhoi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaKhoi'], 'required'],
            [['MaKhoi'], 'string', 'max' => 3],
            [['TenKhoi'], 'string'],
            [['MaCap'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaKhoi' => 'Mã khối',
            'TenKhoi' => 'Tên khối',
            'MaCap' => 'Mã cấp',
        ];
    }
    public static function  getAllGruop()
    {
       return DSKhoi::find()->all();
    }
    public static  function  getListGruopClassFollowDivision($idTeacher,$idSemester)
    {
        $id_current_year = DSNamHoc::getCurrentYear();
        return DSKhoi::find()->innerJoin('dslop', 'dslop.MaKhoi=dskhoi.MaKhoi')->
        innerJoin('phanconggiangday', 'phanconggiangday.MaLop=dslop.MaLop')->select(['*'])
            ->where(['MaHocky' => $idSemester, 'MaGiaoVien' => $idTeacher, 'phanconggiangday.MaNamHoc' => $id_current_year])
            ->select(['dskhoi.MaKhoi', 'TenKhoi'])->groupBy('MaKhoi')->all();
    }

    public static function getGruopFistFollowDivision($idTeacher, $idSemsester, $idYear)
    {
        $query=new Query();
        $query->select('MaKhoi')->from('phanconggiangday')->innerJoin('dslop','dslop.MaLop=phanconggiangday.MaLop')->
        where(['phanconggiangday.MaNamHoc'=>$idYear, 'phanconggiangday.MaGiaoVien'=>$idTeacher,'phanconggiangday.MaHocKy'=>$idSemsester])
            ->groupBy('MaKhoi')->orderBy(['MaKhoi'=>SORT_ASC])->limit(1);
        $command=$query->createCommand();
        $data=$command->queryAll();
        if(count($data)>0)
            return $data[0]['MaKhoi'];
        else
            return null;
    }
    public static function getNameGruop($idGruop)
    {
        $gruop=DSKhoi::findOne($idGruop);
        if($gruop!=null)
            return $gruop->TenKhoi;
        else
            return "Unknow";
    }
}
