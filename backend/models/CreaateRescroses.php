<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 8/30/2016
 * Time: 4:34 PM
 */

namespace backend\models;


use yii\data\ArrayDataProvider;

class CreaateRescroses
{
    public static function Create($semester,$idClass,$idSubject)
    {
       /* $arr=['id'=>'','name'=>'','ngaysinh'=>'','diemmieng1'=>'','diemmieng2'=>'','diemmieng3'=>]*/
        $id_year_current=DSNamHoc::getCurrentYear();
        $id_semseter=$semester;
        $id_subject=$idSubject;

        $dsLoaiDiem=DsLoaiDiem::find()->all();

        $listStudent=DSHocSinhTheoLop::getListStudentFollowClass($idClass);
        $a=[];

            for($i=0;$i<count($listStudent);$i++)
            {
                $b=['MaHocSinh'=>$listStudent[$i]->MaHocSinh,'HoVaTen'=>DsHocSinh::getFullName($listStudent[$i]->MaHocSinh),'NgaySinh'=>DsHocSinh::getNgaySinh($listStudent[$i]->MaHocSinh)];
                foreach ($dsLoaiDiem as $item)
                {
                    $c=[];
                    for($j=1;$j<=$item->SoDiemToiDa;$j++)
                    {
                        $d=[$item->MaLoaiDiem.'_'.$j=>DsDiem::getScoresFollowStudent($listStudent[$i]->MaHocSinh,$id_year_current,$id_semseter,$id_subject,$item->MaLoaiDiem,$j)];
                        $c=array_merge($c,$d);
                    }
                    $b=array_merge($b,$c);
                }

                array_push($a,$b);
            }
            return new ArrayDataProvider([
                'allModels'=>$a,
                'pagination' => [
                    'pageSize' => 35,
                ],
            ]);


    }
}