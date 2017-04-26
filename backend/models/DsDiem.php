<?php

namespace backend\models;


use backend\BLL\DSLoaiDiemBLL;
use backend\BLL\DSMonHocBLL;
use backend\BLL\RoleBLL;

use kartik\switchinput\SwitchInput;
use Yii;
use yii\db\Query;


/**
 * This is the model class for table "dsdiem".
 *
 * @property string $MaHocSinh
 * @property string $MaNamHoc
 * @property string $MaHocKy
 * @property string $MaMonHoc
 * @property string $MaLoaiDiem
 * @property integer $STTDiem
 * @property double $Diem
 * @property string $DiemCu
 * @property integer $ChoPhepDang
 * @property integer $KhoaSo
 * @property integer $ChoPhepSua
 */
class DsDiem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsdiem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh', 'MaNamHoc', 'MaHocKy', 'MaMonHoc', 'MaLoaiDiem', 'STTDiem'], 'required'],
            [['STTDiem', 'ChoPhepDang', 'KhoaSo', 'ChoPhepSua'], 'integer'],
            [['Diem'], 'number'],
            [['DiemCu'], 'string'],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaHocKy'], 'string', 'max' => 2],
            [['MaMonHoc'], 'string', 'max' => 4],
            [['MaLoaiDiem'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHocSinh' => 'Mã học sinh',
            'MaNamHoc' => 'Mã năm học',
            'MaHocKy' => 'Mã học kỳ',
            'MaMonHoc' => 'Mã môn học',
            'MaLoaiDiem' => 'Mã loại điểm',
            'STTDiem' => 'Số thứ tự điểm',
            'Diem' => 'Điểm',
            'DiemCu' => 'Điểm cũ',
            'ChoPhepDang' => 'Cho phép đăng',
            'KhoaSo' => 'Khóa sổ',
            'ChoPhepSua' => 'Cho phép sửa',
        ];
    }

    /**
     * @param $idStudent
     * @param $idYear
     * @param $idSemester
     * @param $idObject
     * @param $idTypeScores
     * @param $serial
     * @return float|string
     */
    public static function getScoresFollowStudent($idStudent, $idYear, $idSemester, $idObject, $idTypeScores, $serial)
    {

        $scocres = DsDiem::findOne(['MaHocSinh' => $idStudent, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester,
            'MaMonHoc' => $idObject, 'MaLoaiDiem' => $idTypeScores, 'STTDiem' => $serial]);
        if ($scocres == null) {
            return '-';
        } else {
            return $scocres->Diem;
        }

    }

    public static function getScoresNumberFollowStudent($idStudent, $idYear, $idSemester, $idObject, $idTypeScores, $serial)
    {

        $scocres = DsDiem::findOne(['MaHocSinh' => $idStudent, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester,
            'MaMonHoc' => $idObject, 'MaLoaiDiem' => $idTypeScores, 'STTDiem' => $serial]);
        if ($scocres == null) {
            return 0;
        } else {
            return $scocres->Diem;
        }

    }

    public static function getScoresFollowStudentReport($idStudent, $idYear, $idSemester, $idObject, $idTypeScores, $serial)
    {

        $scocres = DsDiem::findOne(['MaHocSinh' => $idStudent, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester,
            'MaMonHoc' => $idObject, 'MaLoaiDiem' => $idTypeScores, 'STTDiem' => $serial]);
        if ($scocres == null) {
            return '';
        } elseif ($scocres->Diem == -2) {

            return 'Đ';
        } elseif ($scocres->Diem == -3)
            return 'CĐ';
        else
            return $scocres->Diem;

    }

    /**
     * @param $id_student
     * @param $id_year
     * @param $id_subject
     * @param $id_semester
     * @param $id_scroses
     * @return string
     */
    public static function getListScrosesFollowidScroses($id_student, $id_year, $id_subject, $id_semester, $month)
    {

        $str = "";
        $list = DsDiem::find()->where(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
            'MaHocKy' => $id_semester, 'MaMonHoc' => $id_subject])->all();
        /*for($i=0;$i<count($list);$i++)
        {
            if($list[$i]!=null) {
                if ($i == count($list) - 1) {
                    $str = $str . $list[$i]->Diem . '(' . $HeSo . ')' . '\n';
                } else
                    $str = $str . $list[$i]->Diem . '(' . $HeSo . ') ';
            }
        }*/
        foreach ($list as $item) {

            $thang = (int)RoleBLL::ConvertStringToMonth(substr($item->DiemCu, strripos($item->DiemCu, "#") + 1));
            if ($month == $thang && DsLoaiDiem::findOne($item->MaLoaiDiem)->HeSo > 0) {
                if ($item->Diem >= 0) {
                    $str = $str . $item->Diem . '(' . DsLoaiDiem::findOne($item->MaLoaiDiem)->HeSo . ')' . ' ';
                } else {
                    if ($item->Diem == -2)
                        $str = $str . 'Dat(' . DsLoaiDiem::findOne($item->MaLoaiDiem)->HeSo . ')' . ' ';
                    elseif ($item->Diem == -3)
                        $str = $str . 'Chua Dat(' . DsLoaiDiem::findOne($item->MaLoaiDiem)->HeSo . ')' . ' ';
                }
            }
        }

        return $str;
    }

    /**
     * @param $id_student
     * @param $id_year
     * @param $id_subject
     * @param $id_semester
     * @param $month
     * @return string
     */
    public static function getScrosesFollowidScrosesSummary($id_student, $id_year, $id_subject, $id_semester)
    {
        $idScrose = DsLoaiDiem::LoadLoaiDiemTongHop();
        $str = "";
        $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
            'MaHocKy' => $id_semester, 'MaMonHoc' => $id_subject, 'MaLoaiDiem' => $idScrose]);
        /*for($i=0;$i<count($list);$i++)
        {
            if($list[$i]!=null) {
                if ($i == count($list) - 1) {
                    $str = $str . $list[$i]->Diem . '(' . $HeSo . ')' . '\n';
                } else
                    $str = $str . $list[$i]->Diem . '(' . $HeSo . ') ';
            }
        }*/
        if ($scrose != null)
            if ($scrose->Diem > 0) {
                $str = $scrose->Diem;
            } else {
                if ($scrose->Diem == -2)
                    $str = "Đạt";
                else
                    $str = "Chưa đạt";
            }
        return $str;
    }

    /**
     * @param $id_student
     * @param $id_year
     * @param $id_subject
     * @param $id_semester
     * @param $id_scroses
     * @param $serial
     * @param $tabindex
     * @param $backgruond
     * @return string
     */
    public static function findSocrose($id_student, $id_year, $id_subject, $id_semester, $id_scroses, $serial, $tabindex, $backgruond)
    {
        $idClass = DSHocSinhTheoLop::getClassFollowClass($id_student);
        $division = PhanCongGiangDay::findOne(['MaNamHoc' => DSNamHoc::getCurrentYear(), 'MaHocKy' => $id_semester,
            'MaGiaoVien' => Yii::$app->user->id, 'MaMonHoc' => $id_subject, 'MaLop' => $idClass]);
        if ($division == null) {
            if (self::LaChoDiem($id_subject) == true) {
                $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                    'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
                if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                    if ($scrose == null)
                        return '<td style="padding: 0px; color:black;background-color:' . $backgruond . ';text-align: center">-</td>';
                    else {
                        return '<td style="padding: 0px; color:black;background-color:' . $backgruond . ';text-align: center">' . $scrose->Diem . '</td>';
                    }
                } else {
                    if ($scrose == null)
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold" >' . $scrose->Diem . '</td>';
                    }
                }
            } else {
                $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                    'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
                if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                    if ($scrose == null)
                        return '<td style="padding: 0px; color:black;background-color:' . $backgruond . ';text-align: center">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold" >' . self::DiemDanhGia($scrose->Diem) . '</td>';
                    }
                } else {
                    if ($scrose == null)
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold" >' . self::DiemDanhGia($scrose->Diem) . '</td>';
                    }
                }
            }
        } else {
            if (self::LaChoDiem($id_subject) == true) {
                $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                    'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
                if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                    if ($scrose == null)
                        return '<td style="padding: 0px;"><input tabindex="' . $tabindex . '" value="-" id="' . $id_student . '_' . $id_scroses . '_' . $serial . '" type="text" class="form-control" style="text-align: center;color:black;  background-color:' . $backgruond . '"/></td>';
                    else {
                        if ($scrose->ChoPhepSua == 1)
                            return '<td style="padding: 0px" ><input tabindex="' . $tabindex . '" value="' . $scrose->Diem . '" id="' . $id_student . '_' . $id_scroses . '_' . $serial . '" class="form-control" style="text-align: center;color:black; background-color:' . $backgruond . '" disabled="disabled"/></td>';
                        else
                            return '<td style="padding: 0px" ><input tabindex="' . $tabindex . '" value="' . $scrose->Diem . '" id="' . $id_student . '_' . $id_scroses . '_' . $serial . '" type="text" class="form-control" style="text-align: center;color:black;background-color:' . $backgruond . '" /></td>';
                    }
                } else {
                    if ($scrose == null)
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold" >' . $scrose->Diem . '</td>';
                    }
                }
            } else {
                $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                    'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
                if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                    if ($scrose == null)
                        return '<td style="padding: 0px;"><input tabindex="' . $tabindex . '" value="-" id="' . $id_student . '_' . $id_scroses . '_' . $serial . '" type="text" class="form-control" style="text-align: center;color:black;  background-color:' . $backgruond . '"/></td>';
                    else {
                        if ($scrose->ChoPhepSua == 1)
                            return '<td style="padding: 0px" ><input tabindex="' . $tabindex . '" value="' . self::DiemDanhGia($scrose->Diem) . '" id="' . $id_student . '_' . $id_scroses . '_' . $serial . '" class="form-control" style="text-align: center;color:black; background-color:' . $backgruond . '" disabled="disabled"/></td>';
                        else
                            return '<td style="padding: 0px" ><input tabindex="' . $tabindex . '" value="' . self::DiemDanhGia($scrose->Diem) . '" id="' . $id_student . '_' . $id_scroses . '_' . $serial . '" type="text" class="form-control" style="text-align: center;color:black;background-color:' . $backgruond . '" /></td>';
                    }
                } else {
                    if ($scrose == null)
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; font-weight: bold" >' . self::DiemDanhGia($scrose->Diem) . '</td>';
                    }
                }
            }
        }

    }

    /**
     * Lấy ra điểm trung bình cộng của học sinh
     **/
    public static function findScoresSummary($id_student, $id_subject)
    {
        $maHocKy = 'K1';
        $id_year = DSNamHoc::getCurrentYear();
        $idTypeScores = DSLoaiDiemBLL::LoadMaLoaiDiemTongHop();
        $scores = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year, 'MaHocKy' => $maHocKy, 'MaMonHoc' => $id_subject, 'MaLoaiDiem' => $idTypeScores, 'STTDiem' => 1]);

        if ($scores != null) {
            if (DSMonHocBLL::LaChoDiem($id_subject) != DsMonHoc::IS_PRIZE)
                return '<td style="padding: 0px; text-align: center"> '.$scores->Diem.' </td>';
            else
                return '<td style="padding: 0px; text-align: center"> '.DsDiem::DiemDanhGia($scores->Diem).' </td>';
        } else
            if (DSMonHocBLL::LaChoDiem($id_subject) != DsMonHoc::IS_PRIZE)
                return '<td style="padding: 0px;"><input  value="-" id="' . $id_student . '_' . $id_subject . '" type="text" class="form-control" style="text-align: center;color:black;"/></td>';
            else
                return '<td><select class="form-control" id="' . $id_student . '_' . $id_subject . '">
    <option value="-2">Đ</option>
    <option value="-3">CĐ</option>
  </select></td>';
    }

    public static function findScroseReport($id_student, $id_year, $id_subject, $id_semester, $id_scroses, $serial)
    {

        $idClass = DSHocSinhTheoLop::getClassFollowClass($id_student);
        $division = PhanCongGiangDay::findOne(['MaNamHoc' => DSNamHoc::getCurrentYear(), 'MaHocKy' => $id_semester,
            'MaGiaoVien' => Yii::$app->user->id, 'MaMonHoc' => $id_subject, 'MaLop' => $idClass]);

        if ($division != null || RoleBLL::checkFunction(0) || RoleBLL::checkFunction(3)) {
            if (self::LaChoDiem($id_subject) == true) {
                $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                    'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
                if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                    if ($scrose == null)
                        return '<td style="padding: 0px; color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">-</td>';
                    else {
                        return '<td style="padding: 0px; color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">' . $scrose->Diem . '</td>';
                    }
                } else {
                    if ($scrose == null)
                        return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black ">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black" >' . $scrose->Diem . '</td>';
                    }
                }
            } else {
                $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                    'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
                if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                    if ($scrose == null)
                        return '<td style="padding: 0px;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black" >' . self::DiemDanhGia($scrose->Diem) . '</td>';
                    }
                } else {
                    if ($scrose == null)
                        return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">-</td>';
                    else {
                        return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black" >' . self::DiemDanhGia($scrose->Diem) . '</td>';
                    }
                }
            }
        }

    }

    public static function findScroseReport2($id_student, $id_year, $id_subject, $id_semester, $id_scroses, $serial)
    {
        if (self::LaChoDiem($id_subject) == true) {
            $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
            if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                if ($scrose == null)
                    return '<td style="padding: 0px; color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">-</td>';
                else {
                    return '<td style="padding: 0px; color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">' . $scrose->Diem . '</td>';
                }
            } else {
                if ($scrose == null)
                    return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black ">-</td>';
                else {
                    return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black" >' . $scrose->Diem . '</td>';
                }
            }
        } else {
            $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
                'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
            if (!DsLoaiDiem::KiemTraTongHop($id_scroses)) {
                if ($scrose == null)
                    return '<td style="padding: 0px;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">-</td>';
                else {
                    return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black" >' . self::DiemDanhGia($scrose->Diem) . '</td>';
                }
            } else {
                if ($scrose == null)
                    return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black">-</td>';
                else {
                    return '<td style="padding: 0px;color:black;text-align: center; border-right: 1px solid black;border-bottom: solid 1px black" >' . self::DiemDanhGia($scrose->Diem) . '</td>';
                }
            }
        }
    }


    /**
     * @param $scrose
     * @return string
     */
    public static function DiemDanhGia($scrose)
    {
        if ($scrose == -2)
            return "Đ";
        else
            return "CĐ";
    }

    /**
     * @param $idSubject
     * @return int
     */
    public static function LaChoDiem($idSubject)
    {
        $maHinhThucDanhGia = DsMonHoc::findOne($idSubject)->MaHinhThucDanhGia;
        return DsHinhThucDanhGia::findOne($maHinhThucDanhGia)->TinhDiem;
    }


    /**
     * @param $id_student
     * @param $id_year
     * @param $id_Subject
     * @param $id_semester
     * @param $id_scroses
     * @param $serial
     * @param $scroses
     * @return bool
     */
    private static function updateScroses($id_student, $id_year, $id_Subject, $id_semester, $id_scroses, $serial, $scroses)
    {
        $scrose = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
            'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_Subject]);
        $scrose->Diem = $scroses;
        $scrose->DiemCu = $scroses . '#' . date('Y-m-d') . '#' . $scrose->DiemCu;
        $scrose->ChoPhepSua = 1;
        if ($scrose->save())
            return true;
        else
            return false;
    }

    /**
     * @param $id_student
     * @param $id_year
     * @param $id_semester
     * @param $id_subject
     * @param $id_scroses
     * @param $serial
     * @param $scrose1
     * @return bool
     */
    private static function addScrose($id_student, $id_year, $id_semester, $id_subject, $id_scroses, $serial, $scrose1)
    {
        $scrose = new DsDiem();
        $scrose->MaMonHoc = $id_subject;
        $scrose->MaHocSinh = $id_student;
        $scrose->MaNamHoc = $id_year;
        $scrose->MaHocKy = $id_semester;
        $scrose->MaLoaiDiem = $id_scroses;
        $scrose->STTDiem = $serial;
        $scrose->Diem = $scrose1;
        $scrose->DiemCu = $scrose1 . '#' . date('Y-m-d');
        $scrose->ChoPhepSua = 1;
        $scrose->ChoPhepDang = 0;
        $scrose->KhoaSo = 0;
        if ($scrose->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id_student
     * @param $id_year
     * @param $id_semester
     * @param $id_subject
     * @param $id_scroses
     * @param $serial
     * @param $scrose1
     * @return bool
     */
    public static function change($id_student, $id_year, $id_semester, $id_subject, $id_scroses, $serial, $scrose1)
    {
        if ($scrose1 == "D")
            $scrose1 = -2;
        elseif ($scrose1 == "CD")
            $scrose1 = -3;
        $Scoses = DsDiem::findOne(['MaHocSinh' => $id_student, 'MaNamHoc' => $id_year,
            'MaHocKy' => $id_semester, 'MaLoaiDiem' => $id_scroses, 'STTDiem' => $serial, 'MaMonHoc' => $id_subject]);
        if ($Scoses != null) {

            if (self::updateScroses($id_student, $id_year, $id_subject, $id_semester, $id_scroses, $serial, $scrose1))
                return true;
            else
                return false;

        } else
            if (self:: addScrose($id_student, $id_year, $id_semester, $id_subject, $id_scroses, $serial, $scrose1)) {
                return true;
            } else
                return false;

    }

    /**
     * @param $id_semester
     * @return bool
     */
    public static function SemesterBlock($id_semester)
    {
        $id_year = DSNamHoc::getCurrentYear();
        if (DsDiem::find()->where(['MaHocKy' => $id_semester, 'MaNamHoc' => $id_year, 'KhoaSo' => 1])->count() > 0)
            return true;
        else
            return false;
    }

    /**
     * @param $idSemester
     * @param $idSubject
     * @param $idStudent
     * @param $idTypeScroses
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function LoadListScores($idSemester, $idSubject, $idStudent, $idTypeScroses)
    {
        $idYearCurrent = DSNamHoc::getCurrentYear();
        return DsDiem::find()->where(['MaNamHoc' => $idYearCurrent, 'MaMonHoc' => $idSubject, 'MaHocKy' => $idSemester,
            'MaHocSinh' => $idStudent, 'MaLoaiDiem' => $idTypeScroses,])->all();
    }

    public static function LoadListScoresTongHop($idSemester, $idStudent, $idTypeScroses)
    {
        $idYearCurrent = DSNamHoc::getCurrentYear();
        return DsDiem::find()->where(['MaNamHoc' => $idYearCurrent, 'MaHocKy' => $idSemester,
            'MaHocSinh' => $idStudent, 'MaLoaiDiem' => $idTypeScroses,])->all();
    }

    /**
     * @param $idSemester
     * @param $idSubject
     * @param $idStudent
     * @param $idTypeScroses
     * @return mixed
     */
    public static function getSumListScores($idSemester, $idSubject, $idStudent, $idTypeScroses)
    {
        $idYearCurrent = DSNamHoc::getCurrentYear();
        $dsdiem = DsDiem::find()->where(['MaNamHoc' => $idYearCurrent, 'MaHocKy' => $idSemester, 'MaMonHoc' => $idSubject,
            'MaHocSinh' => $idStudent, 'MaLoaiDiem' => $idTypeScroses])->sum('Diem');
        return $dsdiem;

    }

    /**
     * @param $idSemester
     * @param $idSubject
     * @param $idStudent
     * @param $idTypeScroses
     * @return int|string
     */
    public static function getCountListScores($idSemester, $idSubject, $idStudent, $idTypeScroses)
    {
        $idYearCurrent = DSNamHoc::getCurrentYear();
        return DsDiem::find()->where(['MaNamHoc' => $idYearCurrent, 'MaMonHoc' => $idSubject, 'MaHocKy' => $idSemester,
            'MaHocSinh' => $idStudent, 'MaLoaiDiem' => $idTypeScroses,])->count();
    }


}