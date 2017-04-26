<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dmhanhkiem".
 *
 * @property string $MaHanhKiem
 * @property string $TenHanhKiem
 * @property integer $MucUuTien
 */
class DMHanhKiem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dmhanhkiem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MaHanhKiem'], 'required'],
            [['MucUuTien'], 'integer'],
            [['MaHanhKiem'], 'string', 'max' => 3],
            [['TenHanhKiem'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MaHanhKiem' => 'Ma Hanh Kiem',
            'TenHanhKiem' => 'Ten Hanh Kiem',
            'MucUuTien' => 'Muc Uu Tien',
        ];
    }
    public static function getNameConduct($idConduct)
    {
        $conduct= DMHanhKiem::findOne($idConduct);
        if($conduct!=null)
            return $conduct->TenHanhKiem;
        else
            return '';

    }
    public static function getCountConductFollowClass($listStudent,$idSemseter,$idConduct)
    {
        $sl=0;
        for($i=0;$i<count($listStudent);$i++)
            if(DSTongKetTheoKy::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear(),'MaHocSinh'=>$listStudent[$i]->MaHocSinh,'MaHocKy'=>$idSemseter,'MaHanhKiem'=>$idConduct])->all()!=null)
                $sl++;
        return $sl;
    }
}
