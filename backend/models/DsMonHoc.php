<?php

namespace backend\models;

use backend\BLL\RoleBLL;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "dsmonhoc".
 *
 * @property string $MaMonHoc
 * @property string $TenMonHoc
 * @property integer $HeSo
 * @property integer $MaHinhThucDanhGia
 * @property string $HienThi
 * @property integer $XetHocLuc
 * @property string $HienThiSMS
 * @property integer $ThuTuThongKeTHCS
 * @property integer $ThuTuThongKeTHPT
 */
class DsMonHoc extends \yii\db\ActiveRecord
{
    const IS_PRIZE=2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsmonhoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaMonHoc'], 'required'],
            [['HeSo', 'MaHinhThucDanhGia', 'XetHocLuc', 'ThuTuThongKeTHCS', 'ThuTuThongKeTHPT'], 'integer'],
            [['MaMonHoc'], 'string', 'max' => 4],
            [['TenMonHoc', 'HienThi', 'HienThiSMS'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaMonHoc' => 'Mã môn học',
            'TenMonHoc' => 'Tên môn học',
            'HeSo' => 'Hệ số',
            'MaHinhThucDanhGia' => 'Mã hình thức đánh giá',
            'HienThi' => 'Hiển thị',
            'XetHocLuc' => 'Xét học lực',
            'HienThiSMS' => 'Hiển thị sms',
            'ThuTuThongKeTHCS' => 'Thứ tự thống kê',
            'ThuTuThongKeTHPT' => 'Thứ tự thống kê Thpt',
        ];
    }
    public static function getListSubjectFollowDivision($id_teacher,$id_semester,$id_class)
    {
        $id_current_year=DSNamHoc::getCurrentYear();
        return  $lisSubject=DsMonHoc::find()->innerJoin('phanconggiangday','dsmonhoc.MaMonHoc=phanconggiangday.MaMonHoc')->
                where(['MaGiaoVien'=>$id_teacher,'phanconggiangday.MaHocKy'=>$id_semester,'MaLop'=>$id_class,'MaNamHoc'=>$id_current_year])
                ->select(['*'])->all();
    }
    public static function getSubjectFollowClass($idSemester,$idClass)
    {
        $id_current_year=DSNamHoc::getCurrentYear();
        return DsMonHoc::find()->innerJoin('dsmonhoctheolop','dsmonhoctheolop.MaMonHoc=dsmonhoc.MaMonHoc')->
        where(['dsmonhoctheolop.MaHocKy'=>$idSemester,'dsmonhoctheolop.MaLop'=>$idClass,'dsmonhoctheolop.MaNamHoc'=>$id_current_year])->all();
    }
    public static function getFistSubjectFollowDivision($idTeacher,$idSemester,$idClass,$idYear)
    {
        $query=new Query();
        $query->select('MaMonHoc')->from('phanconggiangday')->where(['phanconggiangday.MaNamHoc'=>$idYear,'phanconggiangday.MaGiaoVien'=>$idTeacher, 'phanconggiangday.MaHocKy'=>$idSemester,'MaLop'=>$idClass])
            ->groupBy('phanconggiangday.MaMonHoc')->orderBy(['phanconggiangday.MaMonHoc'=>SORT_ASC])->limit(1);
        $comand=$query->createCommand();
        $data=$comand->queryAll();
        if(count($data)>0)
            return $data[0]['MaMonHoc'];
        else
            return null;
    }
    public static function getNameSubject($idSubject)
    {
        $subject=DsMonHoc::findOne($idSubject);
        if($subject==null)
            return "Unknown";
        else
            return $subject->HienThi;
    }
    public static function getNameSubjectSMS($idSubject)
    {
        $subject=DsMonHoc::findOne($idSubject);
        if($subject==null)
            return "Unknown";
        else
            return $subject->HienThiSMS;
    }
    public static function getCountRescrosesInSemester($idSubject,$idSemester,$idStudent)
    {
        $idYear=DSNamHoc::getCurrentYear();
        return DsDiem::find()->where(['MaHocSinh'=>$idStudent,'MaMonHoc'=>$idSubject,'MaHocKy'=>$idSemester,'MaNamHoc'=>$idYear])->count();
    }
    public static function getCountRescrosesInSemesterMonth($idSubject,$idSemester,$idStudent,$idMonth)
    {
        $count=0;
        $id_year=DSNamHoc::getCurrentYear();
            $list = DsDiem::find()->where(['MaHocSinh' => $idStudent, 'MaNamHoc' => $id_year,
                'MaHocKy' => $idSemester, 'MaMonHoc' => $idSubject])->all();
            /*for($i=0;$i<count($list);$i++)
            {
                if($list[$i]!=null) {
                    if ($i == count($list) - 1) {
                        $str = $str . $list[$i]->Diem . '(' . $HeSo . ')' . '\n';
                    } else
                        $str = $str . $list[$i]->Diem . '(' . $HeSo . ') ';
                }
            }*/

                for ($i = 0; $i < count($list); $i++) {
                    if ($list[$i] != null) {
                        $thang = RoleBLL::ConvertStringToMonth(substr($list[$i]->DiemCu, strripos($list[$i]->DiemCu, "#") + 1));
                        if ($idMonth == $thang&&DsLoaiDiem::findOne($list[$i]->MaLoaiDiem)->HeSo>0) {
                            $count++;
                        }
                    }
                }

        return $count;
    }
    public static function layDanhSachMonHocTheoCap($MaCap)
    {

        if($MaCap=='TTHCS')
            return DsMonHoc::find()->where(['>','ThuTuThongKeTHCS',0])->orderBy(['ThuTuThongKeTHCS'=>SORT_ASC])->all();
        elseif($MaCap=='TTHPT')
            return DsMonHoc::find()->where(['>','ThuTuThongKeTHPT',0])->orderBy(['ThuTuThongKeTHPT'=>SORT_ASC])->all();
    }
    public static function getSubjectFollowId($id)
    {
        return DsMonHoc::findOne($id);
    }
}