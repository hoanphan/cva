<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dsloaidiem".
 *
 * @property string $MaLoaiDiem
 * @property string $TenLoaiDiem
 * @property integer $SoDiemToiDa
 * @property integer $HeSo
 * @property string $HienThi
 * @property integer $ChoPhepChinhSua
 * @property integer $TinhToan
 * @property integer $TongHop
 * @property integer $LaHocKy
 */
class DsLoaiDiem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsloaidiem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaLoaiDiem'], 'required'],
            [['SoDiemToiDa', 'HeSo', 'ChoPhepChinhSua', 'TinhToan', 'TongHop', 'LaHocKy'], 'integer'],
            [['MaLoaiDiem'], 'string', 'max' => 3],
            [['TenLoaiDiem', 'HienThi'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaLoaiDiem' => 'Mã lọa điểm',
            'TenLoaiDiem' => 'Tên loại điểm',
            'SoDiemToiDa' => 'Số điểm tối đa',
            'HeSo' => 'Hệ số',
            'HienThi' => 'Hiển thị',
            'ChoPhepChinhSua' => 'Cho phép chỉnh sửa',
            'TinhToan' => 'Tính toán',
            'TongHop' => 'Tổng hợp',
            'LaHocKy' => 'Là học kỳ',
        ];
    }

    /**
     * @param $idType
     * @return bool
     */
    public static function KiemTraTongHop($idType)
    {
        if(Dsloaidiem::findOne($idType)->TongHop==1)
            return true;
        else
            return false;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAll()
    {
        return DsLoaiDiem::find()->all();
    }
    public static function LoadLoaiDiemTongHop()
    {
        return DsLoaiDiem::findOne(['TinhToan'=>0])->MaLoaiDiem;
    }
}
