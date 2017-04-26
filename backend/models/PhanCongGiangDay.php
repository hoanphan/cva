<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "phanconggiangday".
 *
 * @property string $MaNamHoc
 * @property string $MaHocKy
 * @property string $MaGiaoVien
 * @property string $MaMonHoc
 * @property string $MaLop
 */
class PhanCongGiangDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phanconggiangday';
    }

    /**
     * @return string
     */
    public function getMaGiaoVien()
    {
        return $this->MaGiaoVien;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaNamHoc', 'MaHocKy', 'MaGiaoVien', 'MaMonHoc', 'MaLop'], 'required'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaHocKy'], 'string', 'max' => 2],
            [['MaGiaoVien'], 'string', 'max' => 5],
            [['MaMonHoc', 'MaLop'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaNamHoc' => 'Mã năm học',
            'MaHocKy' => 'Mã học kỳ',
            'MaGiaoVien' => 'Mã giáo viên',
            'MaMonHoc' => 'Mã môn học',
            'MaLop' => 'Mã lớp',
        ];
    }
    public function getTextYear($idYear)
    {
        $year=DSNamHoc::findOne($idYear);
        if($year==null)
            return "Unknown";
        else
            return $year->TenNamHoc;
    }
    public function getTextSemester($idSemester)
    {
        $semester=DSHocKy::findOne($idSemester);
        if($semester==null)
            return "Unknown";
        else
            return $semester->TenHocKy;
    }
    public function getTextTeacher($idTeacher)
    {
        return DsGiaoVien::getFullName($idTeacher);
    }
    public function getTextSubject($idSubject)
    {
        return DsMonHoc::getNameSubject($idSubject);
    }
    public function getTextClass($idClass)
    {
        return DsLop::getNameClass($idClass);
    }
    public static function getTeacherFollowSubject($Subject,$Class,$Semester)
    {
        $idYearCurrent=DSNamHoc::getCurrentYear();
        Return PhanCongGiangDay::findOne(['MaNamHoc'=>$idYearCurrent,'MaHocKy'=>$Semester,'MaLop'=>$Class,'MaMonHoc'=>$Subject])->MaGiaoVien;
    }
}
