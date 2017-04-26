<?php

namespace backend\models;

use backend\BLL\ConvertString;
use Yii;

/**
 * This is the model class for table "dsemailsmsguitoanbo".
 *
 * @property integer $id
 * @property string $MaHocSinh
 * @property string $EmailPhuHuynh
 * @property string $SoDienThoaiPhuHuynh
 * @property string $NoiDungEmail
 * @property string $NoiDungSms
 * @property integer $DaGuiEmail
 * @property integer $DaGuiSms
 * @property string $TieuDeEmail
 */
class DsEmailSmsGuiToanBo extends \yii\db\ActiveRecord
{
    /**
     * TODO Hoan trang thai tin nhan chua duoc gui
    */
    const STATUS_NOT_SENDING =0;
    // trang thai tin nhan gui loi
    const STATUS_FAIL =3;
    // trang thai tin nhan gui thanh cong
    const STATUS_COMPLETE =2;
    // trang thai dang gui cho kiem tra xac thuc
    const STATUS_SENDING =1;
    // trang thai qua do dai tin nhan
    const STATUS_MAX_LENG=4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsemailsmsguitoanbo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocSinh'], 'required'],
            [['NoiDungEmail', 'NoiDungSms', 'TieuDeEmail'], 'string'],
            [['DaGuiEmail', 'DaGuiSms'], 'integer'],
            [['MaHocSinh'], 'string', 'max' => 7],
            [['EmailPhuHuynh'], 'string', 'max' => 100],
            [['SoDienThoaiPhuHuynh'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'MaHocSinh' => 'Ma Hoc Sinh',
            'EmailPhuHuynh' => 'Email Phu Huynh',
            'SoDienThoaiPhuHuynh' => 'So Dien Thoai Phu Huynh',
            'NoiDungEmail' => 'Noi Dung Email',
            'NoiDungSms' => 'Noidung Sms',
            'DaGuiEmail' => 'Da Gui Email',
            'DaGuiSms' => 'Da Gui Sms',
            'TieuDeEmail' => 'Tieu De Email',
        ];
    }
    function getTextHocSinh($idStudent)
    {
        return DsHocSinh::getFullName($idStudent);
    }
    function getSubText($str)
    {
        return ConvertString::SubString($str,100);
    }
}
