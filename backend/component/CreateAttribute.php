<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 8/30/2016
 * Time: 10:23 PM
 */

namespace backend\component;


use backend\models\DsDiem;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsLoaiDiem;
use backend\models\DSNamHoc;
use Faker\Provider\uk_UA\Text;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\widgets\SwitchInput;
use yii\web\Session;

class CreateAttribute
{

    public static function checkRestrict($listRestrict,$typeScroses,$serrial)
    {
        $check=true;
        foreach ($listRestrict as $item)
        {
            if($item==$typeScroses.'_'.$serrial)
                $check= false;

        }
        return $check;
    }
    public static function SumInput()
    {
        return  $sum = Dsloaidiem::find()->where(['TongHop'=>0])->sum('SoDiemToiDa');


    }
    public static function listRestrict($semester,$subject,$class)
    {
        $idCurrentYear=DSNamHoc::getCurrentYear();
        $arrRestrict=array();
        $lisScrose= Dsloaidiem::find()->all();
        $getFistStudentInClass=DSHocSinhTheoLop::findOne(['MaLop'=>$class])->MaHocSinh;
        foreach ($lisScrose as $item)
        {
            if($item->TongHop==1) {
                for ($i = 1; $i <= $item->SoDiemToiDa; $i++) {
                    array_push($arrRestrict, $item->MaLoaiDiem . '_' . $i);
                }
            }
            else
            {
                for ($i = 1; $i <= $item->SoDiemToiDa; $i++) {
                    $scrose=Dsdiem::find()->where(['MaHocSinh'=>$getFistStudentInClass,'MaNamHoc'=>$idCurrentYear,
                            'MaHocKy'=>$semester,'MaMonHoc'=>$subject,
                            'MaLoaiDiem'=>$item->MaLoaiDiem,'STTDiem'=>$i])->sum('ChoPhepSua');
                    if($scrose>0)
                    {
                        array_push($arrRestrict, $item->MaLoaiDiem . '_' . $i);
                    }
                }
            }
        }
        return $arrRestrict;

    }
    public static function createAttribs($semester,$subject,$class)
    {
        $a=[
            // primary key column

            'MaHocSinh'=>[
                'type'=>TabularForm::INPUT_HIDDEN_STATIC,
                'label'=>'Mã học sinh',
                'columnOptions'=>['hidden'=>false,],
            ],
            'HoVaTen'=>[
                'type'=>TabularForm::INPUT_HIDDEN_STATIC,
                'label'=>'Họ và tên',
                'columnOptions'=>['hidden'=>false],
            ],
            'NgaySinh'=>[
                'type'=>TabularForm::INPUT_HIDDEN_STATIC,
                'label'=>'Ngày sinh',
                'columnOptions'=>['hidden'=>false],
                'width'=>'70px'
            ],

        ];
        $listRetrict=self::listRestrict($semester,$subject,$class);
        $listTypeScrores=Dsloaidiem::find()->all();
        for ($i=0;$i<count($listTypeScrores);$i++)
        {
            for($j=1;$j<=$listTypeScrores[$i]->SoDiemToiDa;$j++) {
                $b=[];
                if(self::checkRestrict($listRetrict,$listTypeScrores[$i]->MaLoaiDiem,$j)) {
                    $b = [
                        $listTypeScrores[$i]->MaLoaiDiem . '_' . $j => [
                            'type' => TabularForm::INPUT_WIDGET,
                            'widgetClass'=>SwitchInput::className(),
                            'label' => $listTypeScrores[$i]->HienThi . ' ' . $j,
                            'columnOptions'=>['width'=>'50px']
                        ],
                    ];
                }
                else
                {
                    $b = [
                        $listTypeScrores[$i]->MaLoaiDiem . '_' . $j => [
                            'type' => TabularForm::INPUT_HIDDEN_STATIC,
                            'label' => $listTypeScrores[$i]->HienThi . ' ' . $j,

                        ],
                    ];
                }

                $a=array_merge($a,$b);
                }
        }
        return $a;
    }
}