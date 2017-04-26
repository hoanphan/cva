<?php

namespace backend\models;

use DateTime;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dstuan".
 *
 * @property integer $MaTuan
 * @property string $MaNamHoc
 * @property string $TenTuan
 * @property integer $TuanHienTai
 * @property string $BatDauTuNgay
 * @property string $KetThucNgay
 */
class DSTuan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dstuan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaTuan', 'MaNamHoc'], 'required'],
            [['MaTuan','TuanHienTai'], 'integer'],
            [['BatDauTuNgay', 'KetThucNgay'], 'safe'],
            [['MaNamHoc'], 'string', 'max' => 8],
            [['TenTuan'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaTuan' => 'Ma Tuan',
            'MaNamHoc' => 'Ma Nam Hoc',
            'TenTuan' => 'Ten Tuan',
            'BatDauTuNgay' => 'Bat Dau Tu Ngay',
            'KetThucNgay' => 'Ket Thuc Ngay',
            'TuanHienTai'=>'Tuan hien tai'
        ];
    }
    public static function formatDate($source)
    {
        $date = new DateTime($source);

        return $date->format('d-m-Y'); // 31-07-2012
    }
    public static function createArrayWeek()
    {
        $idYearCurrent = DSNamHoc::getCurrentYear();
       $arr=array();
       $listWeek=DSTuan::find()->where(['MaNamHoc' => $idYearCurrent])
            ->orderBy(['MaTuan'=>SORT_DESC])->all();
        for($i=0;$i<count($listWeek);$i++)
        {
            $tenTuan='Tuần '.$listWeek[$i]->MaTuan."  từ ngày ".self::formatDate($listWeek[$i]->BatDauTuNgay).' đến ngày '.self::formatDate($listWeek[$i]->KetThucNgay);
            $item=["MaTuan"=>$listWeek[$i]->MaTuan,"TenTuan"=>$tenTuan];
            array_push($arr,$item);
        }
        return ArrayHelper::map($arr, 'MaTuan', 'TenTuan');
    }
    public static function getWeek($idWeek)
    {
        $idYearCurrent=DSNamHoc::getCurrentYear();
        return DSTuan::findOne(['MaTuan'=>$idWeek,'MaNamHoc'=>$idYearCurrent]);
    }
    public static function getDayOffWeek($date)
    {

        $day=$date->format('d');
        $month=$date->format('m');
        $year=$date->format('y');
        $jd=gregoriantojd($month,$day,$year);
        return jddayofweek($jd,0);
    }
    public static function  addDayswithdate($date,$day){
       return date_add($date, date_interval_create_from_date_string($day.'days'));

    }
    public static function getAge($date)
    {
        $date = new DateTime($date);
        $dateCurrent=date('Y');
        $date= $date->format('Y');
        return (int)$dateCurrent-(int)$date;
    }
    public static function convertDateToString($date)
    {
        $day=$date->format('d');
        $month=$date->format('m');
        $year=$date->format('y');
        $strdate=$year.'-'.$month.'-'.$day;
        return $strdate;
    }

    /**
     * @return string
     */
    public static function getLastWeek($yearCurrent)
    {
        $tuan=DSTuan::find()->where(['MaNamHoc'=>$yearCurrent])->orderBy(['MaTuan'=>SORT_DESC])->all();
        return $tuan[0];
    }
    public static function updateListWeek()
    {
        $yearCurrent=DSNamHoc::getCurrentYear();
        $week=self::getLastWeek($yearCurrent);
        $NgayKetThucTuan=new DateTime($week->KetThucNgay);
        $dateNgayHienTai=new DateTime(date('Y-m-d'));
        $idTuan=(int)$week->MaTuan;
        while ($NgayKetThucTuan<$dateNgayHienTai)
        {

            if(DSTuan::getDayOffWeek($NgayKetThucTuan)==6)
            {
                $idTuan=$idTuan+1;
                $tuan=new DSTuan();
                $tuan->MaTuan=$idTuan;
                $tuan->TenTuan="Tuần ".$idTuan;
                $tuan->BatDauTuNgay=self::convertDateToString(DSTuan::addDayswithdate($NgayKetThucTuan,2));
                $tuan->KetThucNgay=self::convertDateToString(DSTuan::addDayswithdate($NgayKetThucTuan,5));
                $tuan->MaNamHoc=$yearCurrent;
                $tuan->TuanHienTai=$idTuan;
                $tuan->save();
            }
        }
    }
    public static function getStartDay($idWeek)
    {
        return self::formatDate(DSTuan::findOne($idWeek)->BatDauTuNgay);
    }
    public static function getEndDay($idWeek)
    {
        return self::formatDate(DSTuan::findOne($idWeek)->KetThucNgay);
    }
}
