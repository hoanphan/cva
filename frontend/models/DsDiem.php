<?php

namespace frontend\models;

use backend\models\DsThang;
use Yii;

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
            'MaHocSinh' => 'Ma Hoc Sinh',
            'MaNamHoc' => 'Ma Nam Hoc',
            'MaHocKy' => 'Ma Hoc Ky',
            'MaMonHoc' => 'Ma Mon Hoc',
            'MaLoaiDiem' => 'Ma Loai Diem',
            'STTDiem' => 'Sttdiem',
            'Diem' => 'Diem',
            'DiemCu' => 'Diem Cu',
            'ChoPhepDang' => 'Cho Phep Dang',
            'KhoaSo' => 'Khoa So',
            'ChoPhepSua' => 'Cho Phep Sua',
        ];
    }
    public function checkScoresInMonth($DiemCu)
    {

    }
    public static function getScoresFollowStudent($idStudent, $idYear, $idSemester, $idObject, $idTypeScores, $serial)
    {

        $scocres = DsDiem::findOne(['MaHocSinh' => $idStudent, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester,
            'MaMonHoc' => $idObject, 'MaLoaiDiem' => $idTypeScores, 'STTDiem' => $serial]);
        if ($scocres == null) {
            return ' ';
        } else {
            if($scocres->Diem<0)
            {
                if($scocres->Diem==-2)
                    return '<a>Đạt</a>';
                elseif ($scocres->Diem==-3)
                    return '<a style="color: red">Chưa đạt</a>';
                else
                    return '<a style="color: red">Unknown</a>';
            }
            elseif($scocres->Diem>=5)
            return '<a>'.$scocres->Diem.'</a>';
            else
                return '<a style="color: red">'.$scocres->Diem.'</a>';
        }

    }
    public static function getScoresFollowStudentEmail($idStudent, $idYear, $idSemester, $idObject, $idTypeScores, $serial)
    {
        $month=DsThang::getMonthCurrent();
        $scocres = DsDiem::findOne(['MaHocSinh' => $idStudent, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester,
            'MaMonHoc' => $idObject, 'MaLoaiDiem' => $idTypeScores, 'STTDiem' => $serial]);


        if ($scocres == null) {
            return ' ';
        } else {
            $date = DsThang::getMonthFromString(substr($scocres->DiemCu, strripos($scocres->DiemCu, "#") + 1));

                if($date!=$month) {
                    if ($scocres->Diem < 0) {

                        if ($scocres->Diem == -2)
                            return '<a>Đạt</a>';
                        elseif ($scocres->Diem == -3)
                            return '<a style="color: red">Chưa đạt</a>';
                        else
                            return '<a style="color: red">Unknown</a>';
                    } elseif ($scocres->Diem >= 5)
                        return '<a>' . $scocres->Diem . '</a>';
                    else
                        return '<a style="color: red">' . $scocres->Diem . '</a>';
                }
                else
                {
                    if ($scocres->Diem < 0) {

                        if ($scocres->Diem == -2)
                            return '<a>Đạt</a>';
                        elseif ($scocres->Diem == -3)
                            return '<a style="color: orange">Chưa đạt</a>';
                        else
                            return '<a style="color: orange">Unknown</a>';
                    } elseif ($scocres->Diem >= 5)
                        return '<a>' . $scocres->Diem . '</a>';
                    else
                        return '<a style="color: orange">' . $scocres->Diem . '</a>';
                }

        }

    }
}
