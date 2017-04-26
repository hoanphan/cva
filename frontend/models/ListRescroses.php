<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/24/2016
 * Time: 2:14 AM
 */

namespace frontend\models;


use frontend\models\DsDiem;
use frontend\models\DsMonHoc;

class ListRescroses
{
    public static function getList($idStudent,$idSemester,$idClass,$idYear)
    {
        $str='';
        $listTypeRescroses=DsLoaiDiem::getListTypeScrose();
        $listSubject=DsMonHocTheoLop::find()->where(['MaNamHoc'=>$idYear,'MaLop'=>$idClass,'MaHocKy'=>$idSemester])->all();
        for($i=0;$i<count($listSubject);$i++) {
            if ($i % 2 == 0) {
                $str = $str . '<tr><td style="text-align: center">
                                ' . ($i + 1) . '</td>
                             <td style="text-align: center">
                                ' . DsMonHoc::getNameRescrose($listSubject[$i]->MaMonHoc) . '</td>
                  ';
                for ($j = 0; $j < count($listTypeRescroses); $j++) {
                    for ($k = 1; $k <= $listTypeRescroses[$j]->SoDiemToiDa; $k++) {
                        $str = $str .
                            '<td style="text-align: center">
                            ' . DsDiem::getScoresFollowStudent($idStudent, $idYear, $idSemester, $listSubject[$i]->MaMonHoc, $listTypeRescroses[$j]->MaLoaiDiem, $k) . '</td>';


                    }
                }
                $str = $str . '</tr>';
            } else {
                $str = $str . '<tr><td style="text-align: center">
                                ' . ($i + 1) . '</td>
                            <td style="text-align: center" >   ' . DsMonHoc::getNameRescrose($listSubject[$i]->MaMonHoc) . '</td>
                            ';
                for ($j = 0; $j < count($listTypeRescroses); $j++) {
                    for ($k = 1; $k <= $listTypeRescroses[$j]->SoDiemToiDa; $k++) {
                        $str = $str . '<td style="text-align: center"> ' . DsDiem::getScoresFollowStudent($idStudent, $idYear, $idSemester, $listSubject[$i]->MaMonHoc, $listTypeRescroses[$j]->MaLoaiDiem, $k) . '</td>';

                    }
                }
                $str = $str . '</tr>';
            }
        }
        return $str;
    }
    public static function getEmail($idStudent,$idSemester,$idClass,$idYear)
    {
        $str='';
        $listTypeRescroses=DsLoaiDiem::getListTypeScrose();
        $listSubject=DsMonHocTheoLop::find()->where(['MaNamHoc'=>$idYear,'MaLop'=>$idClass,'MaHocKy'=>$idSemester])->all();
        for($i=0;$i<count($listSubject);$i++) {
            if ($i % 2 == 0) {
                $str = $str . '<tr> <td style="border:solid #5b9bd5 1.0pt;text-align: center ">
                                ' . ($i + 1) . '</td>
                             <td style="text-align: center;">
                                ' . DsMonHoc::getNameRescrose($listSubject[$i]->MaMonHoc) . '</td>
                  ';
                for ($j = 0; $j < count($listTypeRescroses); $j++) {
                    for ($k = 1; $k <= $listTypeRescroses[$j]->SoDiemToiDa; $k++) {
                        $str = $str .
                            '<td style="border:solid #5b9bd5 1.0pt;text-align: center ">
                            ' . DsDiem::getScoresFollowStudentEmail($idStudent, $idYear, $idSemester, $listSubject[$i]->MaMonHoc, $listTypeRescroses[$j]->MaLoaiDiem, $k) . '</td>';


                    }
                }
                $str = $str . '</tr>';
            } else {
                $str = $str . '<tr><td style="border:solid #5b9bd5 1.0pt;text-align: center ">
                                ' . ($i + 1) . '</td>
                            <td style="border:solid #5b9bd5 1.0pt;text-align: center " >   ' . DsMonHoc::getNameRescrose($listSubject[$i]->MaMonHoc) . '</td>
                            ';
                for ($j = 0; $j < count($listTypeRescroses); $j++) {
                    for ($k = 1; $k <= $listTypeRescroses[$j]->SoDiemToiDa; $k++) {
                        $str = $str . '<td style="border:solid #5b9bd5 1.0pt;text-align: center "> ' . DsDiem::getScoresFollowStudentEmail($idStudent, $idYear, $idSemester, $listSubject[$i]->MaMonHoc, $listTypeRescroses[$j]->MaLoaiDiem, $k) . '</td>';

                    }
                }
                $str = $str . '</tr>';
            }
        }
        return $str;
    }
}