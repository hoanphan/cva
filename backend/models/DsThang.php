<?php

namespace backend\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "dsthang".
 *
 * @property string $MaThang
 * @property string $TenThang
 * @property integer $STTThang
 * @property string $ThoiGianGui
 * @property string $MaHocKy
 * @property integer $DaGui
 */
class DsThang extends \yii\db\ActiveRecord
{
    /**TODO cac trang thai kiem tra tin nhan*/
    /*Chưa gửi tin nhắn*/
    const  STATUS_NOT_SENDING=0;
    /*Khởi tạo tin nhắn*/
    const  STATUS_CREATE_CONTENT=1;
    /*đã khởi tạo xong cho phép gửi*/
    const STATUS_EX=2;
    /*Đang gửi*/
    const STATUS_PENDING=3;
    /**Trang thai gui song lan 1*/
    const STATUS_SENDING_FIST=4;
    /*
     * Đã gửi xong
     * */
    const STATUS_COMPLATE=4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dsthang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaThang'], 'required'],
            [['STTThang', 'DaGui'], 'integer'],
            [['ThoiGianGui'], 'safe'],
            [['MaThang'], 'string', 'max' => 3],
            [['TenThang'], 'string', 'max' => 50],
            [['MaHocKy'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaThang' => 'Ma Thang',
            'TenThang' => 'Tên tháng',
            'STTThang' => 'Sttthang',
            'ThoiGianGui' => 'Thoi Gian Gui',
            'MaHocKy' => 'Ma Hoc Ky',
            'DaGui' => 'Da Gui',
        ];
    }

    /**
     * @return bool|string
     */
    public static function getMonthCurrent()
    {
        return date('m');
    }

    /**
     * @param $str
     * @return $this
     */
    public static function getMonthFromString($str)
    {
        $date = explode('-', $str);
        return $date[1];
    }
}
