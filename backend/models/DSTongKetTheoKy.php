<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dstongkettheoky".
 *
 * @property string $MaNamHoc
 * @property string $MaHocKy
 * @property string $MaHocSinh
 * @property double $TrungBinhChung
 * @property string $MaHanhKiem
 * @property string $MaDanhHieu
 * @property string $MaHocLuc
 * @property string $MaLenLop
 * @property integer $soBuoiNghi
 */
class DSTongKetTheoKy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dstongkettheoky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaNamHoc', 'MaHocKy', 'MaHocSinh'], 'required'],
            [['TrungBinhChung'], 'number'],
            [['soBuoiNghi'], 'integer'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['MaHocKy'], 'string', 'max' => 2],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['MaHanhKiem', 'MaDanhHieu', 'MaHocLuc', 'MaLenLop'], 'string', 'max' => 3],
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
            'MaHocSinh' => 'Mã học sinh',
            'TrungBinhChung' => 'Trung bình chung',
            'MaHanhKiem' => 'Hạnh kiểm',
            'MaDanhHieu' => 'Danh hiệu',
            'MaHocLuc' => 'Học lực',
            'MaLenLop' => 'Mã lên lớp',
            'soBuoiNghi' => 'Số buổi nghỉ',
        ];
    }
    public static function getSummary($idStudent,$idSemester,$idYear)
    {
        return DSTongKetTheoKy::findOne(['MaHocSinh'=>$idStudent,'MaHocKy'=>$idSemester,'MaNamHoc'=>$idYear]);
    }
    public static function getTextHocLuc($MaHocLuc)
    {
        if(DmHocLuc::findOne($MaHocLuc)!=null)
            return DmHocLuc::findOne($MaHocLuc)->TenHocLuc;
        else
            return "Unknown";
    }
    public static function getTextHanhKiem($MaHanhKiem)
    {
        if(DMHanhKiem::findOne($MaHanhKiem)!=null)
            return DMHanhKiem::findOne($MaHanhKiem)->TenHanhKiem;
        else
            return "Unknown";
    }
    public static function getTextDanhHieu($MaDanhHieu)
    {
        if(DmDanhHieu::findOne($MaDanhHieu)!=null)
            return DmDanhHieu::findOne($MaDanhHieu)->tendanhhieu;
        else
            return "Unknown";
    }
    public static function getFullName($id)
    {
        $student =DsHocSinh::findOne($id);
        if ($student != null)
            return $student->HoDem . ' ' . $student->Ten;
        else
            return 'Unknown';
    }

}
