<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/18/2016
 * Time: 2:41 PM
 */

namespace backend\models;

use kartik\helpers\Html;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use backend\BLL\RoleBLL;
class BookElectronic
{

    public static function create($id_class,$id_Week)
    {
        //$arr=['MaHocSinh'=>'','TenHocSinh'=>'','NgaySinh'=>]
        $listStudentFollowClass=DSHocSinhTheoLop::find()->where(['MaLop'=>$id_class])->orderBy(['STT'=>SORT_ASC])->all();
        $arrStudent=[];
        for($i=0;$i<count($listStudentFollowClass);$i++)
        {
            $student=DsHocSinh::getStudent($listStudentFollowClass[$i]->MaHocSinh);
            $b=['MaHocSinh'=>$listStudentFollowClass[$i]->MaHocSinh,'TenHocSinh'=>DsHocSinh::getFullName($listStudentFollowClass[$i]),'NgaySinh'=>DsHocSinh::getNgaySinh($listStudentFollowClass[$i]->MaHocSinh),'Action'=> self::ActionCollum($id_Week,$listStudentFollowClass[$i]->MaHocSinh)];
            array_push($arrStudent,$b);
        }
        return new ArrayDataProvider([
            'allModels'=>$arrStudent,
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);
    }
    public static function chectExitsBook($id_week,$id_student)
    {

        $electric_book=SoLienLacDienTu::findOne(['MaHocSinh'=>$id_student,'MaTuan'=>$id_week,'MaNamHoc'=>DSNamHoc::getCurrentYear()]);
        if($electric_book!=null)
            return true;
        else
            return false;
    }
    public static function ActionCollum($id_week,$id_student)
    {
       if(RoleBLL::checkFunction(0)||RoleBLL::checkFunction(5))
       {
           if (!self::chectExitsBook($id_week, $id_student))
               return Html::a('<span class="fa fa-ban"></span>', '#', [
                   'title' => Yii::t('app', 'Add'),
               ]);
           else
               return Html::a('<span class=" fa  fa-eye"></span>', Url::toRoute(['/so-lien-lac-dien-tu/view', 'MaHocSinh' => $id_student, "MaTuan" => $id_week]), [
                   'title' => Yii::t('app', 'View'),
               ]);
       }
       else {
           if (!self::chectExitsBook($id_week, $id_student))
               return Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::toRoute(['/so-lien-lac-dien-tu/create', 'MaHocSinh' => $id_student, "MaTuan" => $id_week]), [
                   'title' => Yii::t('app', 'Add'),
               ]);
           else
               return Html::a('<span class=" fa  fa-eye"></span>', Url::toRoute(['/so-lien-lac-dien-tu/view', 'MaHocSinh' => $id_student, "MaTuan" => $id_week]), [
                   'title' => Yii::t('app', 'View'),
               ]) . '  ' . Html::a('<span class=" fa fa-gavel"></span>', Url::toRoute(['/so-lien-lac-dien-tu/update', 'MaHocSinh' => $id_student, "MaTuan" => $id_week]), [
                   'title' => Yii::t('app', 'Update'),
               ]) . '  ' . Html::a('<span class=" glyphicon glyphicon-trash"></span>', Url::toRoute(['/so-lien-lac-dien-tu/delete', 'MaHocSinh' => $id_student, "MaTuan" => $id_week]), [
                   'title' => Yii::t('app', 'Delete'),
               ]);
       }
    }
}