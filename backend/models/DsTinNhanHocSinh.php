<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dstinnhanhocsinh".
 *
 * @property integer $id
 * @property integer $idSms
 * @property string $MaHocSinh
 * @property string $SddtPhuHuynh
 * @property string $NoiDung
 * @property integer $CacLanCoGangGui
 * @property integer $Thang
 * @property integer $TrangThai
 * @property string $LoiPhatSinh
 */
class DsTinNhanHocSinh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dstinnhanhocsinh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idSms', 'MaHocSinh', 'SddtPhuHuynh', 'NoiDung', 'CacLanCoGangGui', 'Thang', 'TrangThai'], 'required'],
            [['idSms', 'CacLanCoGangGui', 'Thang', 'TrangThai'], 'integer'],
            [['NoiDung'], 'string'],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['SddtPhuHuynh'], 'string', 'max' => 11],
            [['LoiPhatSinh'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idSms' => 'Id Sms',
            'MaHocSinh' => 'Ma Hoc Sinh',
            'SddtPhuHuynh' => 'Sddt Phu Huynh',
            'NoiDung' => 'Noi Dung',
            'CacLanCoGangGui' => 'Cac Lan Co Gang Gui',
            'Thang' => 'Thang',
            'TrangThai' => 'Trang Thai',
            'LoiPhatSinh' => 'Loi Phat Sinh',
        ];
    }
}
