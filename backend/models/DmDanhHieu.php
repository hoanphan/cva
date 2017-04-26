<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dmdanhhieu".
 *
 * @property string $madanhhieu
 * @property string $tendanhhieu
 * @property integer $ingiaykhen
 * @property integer $mucuutien
 */
class DmDanhHieu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dmdanhhieu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['madanhhieu'], 'required'],
            [['ingiaykhen', 'mucuutien'], 'integer'],
            [['madanhhieu'], 'string', 'max' => 3],
            [['tendanhhieu'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'madanhhieu' => 'Madanhhieu',
            'tendanhhieu' => 'Tendanhhieu',
            'ingiaykhen' => 'Ingiaykhen',
            'mucuutien' => 'Mucuutien',
        ];
    }
   public static function getNameAppellation($id)
   {
       $apellation=DmDanhHieu::findOne($id);
       if($apellation==null)
           return ' ';
       else
           return $apellation->tendanhhieu;
   }
    public static function getCountAppletionFollowClass($listStudent,$idSemseter,$idApellation)
    {
        $sl=0;
        for($i=0;$i<count($listStudent);$i++)
            if(DSTongKetTheoKy::find()->where(['MaNamHoc'=>DSNamHoc::getCurrentYear(),'MaHocSinh'=>$listStudent[$i]->MaHocSinh,'MaHocKy'=>$idSemseter,'MaDanhHieu'=>$idApellation])->all()!=null)
                $sl++;
        return $sl;
    }
    public static function getFistAppletion()
    {
        $list=DmDanhHieu::find()->all();
        return $list[0]->madanhhieu;
    }
}
