<?php

namespace frontend\models;

use frontend\models\DsMonHocTheoLop;
use Yii;

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
            'MaMonHoc' => 'Ma Mon Hoc',
            'TenMonHoc' => 'Ten Mon Hoc',
            'HeSo' => 'He So',
            'MaHinhThucDanhGia' => 'Ma Hinh Thuc Danh Gia',
            'HienThi' => 'Hien Thi',
            'XetHocLuc' => 'Xet Hoc Luc',
            'HienThiSMS' => 'Hien Thi Sms',
            'ThuTuThongKeTHCS' => 'Thu Tu Thong Ke Thcs',
            'ThuTuThongKeTHPT' => 'Thu Tu Thong Ke Thpt',
        ];
    }
    public static function findRescrose($id)
    {
        return DsMonHoc::findOne($id);
    }
    public static function getNameRescrose($id)
    {
        $subject=self::findRescrose($id);
        if($subject!=null)
        {
           return $subject->HienThi;
        }
        else
            return 'Unknown name';
    }

}
