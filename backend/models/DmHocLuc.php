<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dmhocluc".
 *
 * @property string $MaHocLuc
 * @property string $TenHocLuc
 * @property double $DiemMocTren
 * @property double $DiemMocDuoi
 * @property integer $MucUuTien
 */
class DmHocLuc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dmhocluc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHocLuc'], 'required'],
            [['DiemMocTren', 'DiemMocDuoi'], 'number'],
            [['MucUuTien'], 'integer'],
            [['MaHocLuc'], 'string', 'max' => 3],
            [['TenHocLuc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHocLuc' => 'Ma Hoc Luc',
            'TenHocLuc' => 'Ten Hoc Luc',
            'DiemMocTren' => 'Diem Moc Tren',
            'DiemMocDuoi' => 'Diem Moc Duoi',
            'MucUuTien' => 'Muc Uu Tien',
        ];
    }
    public static function GetLearningCapacity($idCapacity)
    {
        $capacity= DmHocLuc::findOne($idCapacity);
        if($capacity==null)
            return 'Chưa có';
        else
            return $capacity->TenHocLuc;
    }
    public static function getCountCaptionFollowClass($listStudent,$idSemseter,$idCaption)
    {
        $sl=0;
        for($i=0;$i<count($listStudent);$i++)
          if(DSTongKetTheoKy::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear(),'MaHocSinh'=>$listStudent[$i]->MaHocSinh,'MaHocKy'=>$idSemseter,'MaHocLuc'=>$idCaption])->all()!=null)
              $sl++;
        return $sl;
    }
}
