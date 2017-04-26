<?php

namespace backend\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "dslop".
 *
 * @property string $MaLop
 * @property string $TenLop
 * @property string $MaGVCN
 * @property string $MaNamHoc
 * @property string $MaKhoi
 */
class DsLop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dslop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaLop'], 'required'],
            [['MaLop'], 'string', 'max' => 4],
            [['TenLop'], 'string', 'max' => 50],
            [['MaGVCN'], 'string', 'max' => 5],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaKhoi'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaLop' => 'Mã lớp',
            'TenLop' => 'Tên lớp',
            'MaGVCN' => 'Mã giáo viên chủ nghiệm',
            'MaNamHoc' => 'Mã năm học',
            'MaKhoi' => 'Mã khối',
        ];
    }

    /**
     * @param $id_class
     * @return string name class
     */
    public static function getNameClass($id_class)
    {
        $class= DsLop::findOne($id_class);
        if($class!=null)
             return $class->TenLop;
        else
            return "Unknown";
    }

    /**
     * @param $id_teacher
     * @param $id_semester
     * @param $id_gruop
     * @return array
     */
    public static function getListClassFlollowDivisionAndGruopClass($id_teacher, $id_semester, $id_gruop)
    {
        $id_current_year=DSNamHoc::getCurrentYear();
        $list_id_class=  PhanCongGiangDay::find()->rightJoin('dslop','dslop.MaLop=phanconggiangday.MaLop')
            ->where(['MaGiaoVien'=>$id_teacher,'phanconggiangday.MaHocKy'=>$id_semester,'MaKhoi'=>$id_gruop,'phanconggiangday.MaNamHoc'=>$id_current_year])->groupBy('dslop.MaLop')->select('*')->all();
        $list_class=array();
        foreach ($list_id_class as $id_class)
        {
            array_push($list_class,['id'=>$id_class->MaLop,'name'=>self::getNameClass($id_class->MaLop)]);
        }
        return $list_class;
    }
    public static function getListClassFlollowGruopClass($id_gruop)
    {
        $listClass=DsLop::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear(),'MaKhoi'=>$id_gruop])->all();
        $list_class=array();
        foreach ($listClass as $class)
        {
            array_push($list_class,['id'=>$class->MaLop,'name'=>$class->TenLop]);
        }
        return $list_class;
    }
    public static  function getFistClassFlollowDivisionAndGruopClass($idTeacher,$idYear ,$idSemester, $idGruop)
    {
        $query=new Query();
        $query->select('dslop.MaLop')->from('phanconggiangday')->innerJoin('dslop','dslop.MaLop=phanconggiangday.MaLop')->
        where(['phanconggiangday.MaNamHoc'=>$idYear, 'phanconggiangday.MaGiaoVien'=>$idTeacher,'phanconggiangday.MaHocKy'=>$idSemester])
            ->andWhere(['MaKhoi'=>$idGruop])
            ->groupBy('dslop.MaLop')->orderBy(['dslop.MaLop'=>SORT_ASC])->limit(1);
        $command=$query->createCommand();
        $data=$command->queryAll();
        if(count($data)>0)
             return $data[0]['MaLop'];
        else
            return null;
    }
    public static function getClassFollowTeacher($idTeacher)
    {
        $idYear=DSNamHoc::getCurrentYear();
        return DsLop::findOne(['MaGVCN'=>$idTeacher,'MaNamHoc'=>$idYear]);
    }
    public static function isHomeroomTeacher($idTeacher)
    {
        if(self::getClassFollowTeacher($idTeacher)!=null)
            return true;
        else
            return false;
    }
    public static function tongSoHocSinhTrongKhoi($MaKhoi)
    {
        $sl=0;
        $idYear=DSNamHoc::getCurrentYear();
        $listLop=DsLop::find()->where(['MaKhoi'=>$MaKhoi,'MaNamHoc'=>$idYear])->all();
        foreach ($listLop as $item)
        {
            $sl+=DSHocSinhTheoLop::find()->where(['MaLop'=>$item->MaLop,'MaNamHoc'=>$idYear])->count();
        }
        return $sl;
    }
    public static function getHomeroomTeacher($idClass)
    {
        return DsGiaoVien::getFullName(DsLop::findOne($idClass)->MaGVCN);
    }
}
