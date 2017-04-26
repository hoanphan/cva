<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ds_gv_chua_nhap_diem".
 *
 * @property integer $id
 * @property string $MaGiaoVien
 * @property string $TenGiaoVien
 * @property string $LopChuaNhap
 * @property string $LopDaNhap
 * @property string $sms
 * @property string $TuNgay
 * @property string $DenNgay
 * @property string $SDTGV
 */
class DsGvChuaNhapDiem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ds_gv_chua_nhap_diem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaGiaoVien', 'TenGiaoVien', 'TuNgay', 'DenNgay', 'SDTGV'], 'required'],
            [['LopChuaNhap', 'LopDaNhap', 'sms', 'SDTGV'], 'string'],
            [['TuNgay', 'DenNgay'], 'safe'],
            [['MaGiaoVien', 'TenGiaoVien'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaGiaoVien' => 'Mã giáo viên',
            'TenGiaoVien' => 'Tên giáo viên',
            'LopChuaNhap' => 'Lớp chưa nhập',
            'LopDaNhap' => 'Lớp đã nhập',
            'sms' => 'Sms',
            'TuNgay' => 'Từ ngày',
            'DenNgay' => 'Đến ngày',
            'SDTGV' => 'SDT',
        ];
    }
}
