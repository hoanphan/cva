<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/14/2016
 * Time: 8:48 PM
 */

namespace backend\BLL;


use backend\models\DMHanhKiem;
use backend\models\DsHocSinh;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DSTongKetTheoKy;

class HanhKiemHocLucBLL
{
    public static function getSLHocLucHanhKiem($idGroup, $idSemester, $idtype, $type = null)
    {

        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listClass = DsLop::find()->where(['MaKhoi' => $idGroup, 'MaNamHoc' => $idYear])->all();
        if ($type == null) {
            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item) {
                    if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHanhKiem' => $idtype])->all() != null)
                        $sl++;
                }
            }
        } else {
            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();

                foreach ($listStudent as $item) {
                    if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHocLuc' => $idtype])->all() != null)
                        $sl++;
                }
            }
        }
        return $sl;

    }

    public static function getSLHocLucHanhKiemNation($idGroup, $idSemester, $idtype, $type = null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listClass = DsLop::find()->where(['MaKhoi' => $idGroup, 'MaNamHoc' => $idYear])->all();
        if ($type == null) {
            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item) {
                    $student = DsHocSinh::getStudent($item->MaHocSinh);
                    if ($student->MaDanToc != 1) {
                        if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHanhKiem' => $idtype])->all() != null)
                            $sl++;
                    }
                }
            }
        } else {
            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item) {
                    $student = DsHocSinh::getStudent($item->MaHocSinh);
                    if ($student->MaDanToc != 1) {
                        if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHocLuc' => $idtype])->all() != null)
                            $sl++;
                    }
                }
            }
        }
        return $sl;

    }

    /**
     * @param $idLevel
     * @param $idSemester
     * @param $idtype
     * @param null $type du lieu vao la hoc luc hoac hanh kiem
     * @return int so luong hanh kiem hoc luc
     */
    public static function getSLHocLucHanhKiemAllLevel($idLevel, $idSemester, $idtype, $type = null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $lisKhoi = DSKhoi::find()->where(['MaCap' => $idLevel])->all();
      /*  foreach ($lisKhoi as $khoi) {
            $listClass = DsLop::find()->where(['MaKhoi' => $khoi->MaKhoi, 'MaNamHoc' => $idYear])->all();*/
            if ($type == null) {
                /*foreach ($listClass as $class) {
                    $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listStudent as $item) {
                        if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHanhKiem' => $idtype])->all() != null)
                            $sl++;
                    }
                }*/
               return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')
                    ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                    ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHocKy'=>$idSemester,'dstongkettheoky.MaHanhKiem'=>$idtype,'MaCap'=>$idLevel])->count();
            } else {
                return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')
                    ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                    ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHocKy'=>$idSemester,'dstongkettheoky.MaHocLuc'=>$idtype,'MaCap'=>$idLevel])->count();
            }
       // }


    }

    /**
     * @param $idLevel
     * @param $idSemester
     * @param $idtype
     * @param null $type
     * @return int tong so hoc sinh dan toc theo hoc luc hoac hanh kiem
     */
    public static function getSLHocLucHanhKiemAllLevelNation($idLevel, $idSemester, $idtype, $type = null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $lisKhoi = DSKhoi::find()->where(['MaCap' => $idLevel])->all();
        foreach ($lisKhoi as $khoi) {
            $listClass = DsLop::find()->where(['MaKhoi' => $khoi->MaKhoi, 'MaNamHoc' => $idYear])->all();
            if ($type == null) {
                foreach ($listClass as $class) {
                    $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listStudent as $item) {
                        $student = DsHocSinh::findOne($item->MaHocSinh);
                        if ($student->MaDanToc != 1)
                            if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHanhKiem' => $idtype])->all() != null)
                                $sl++;
                    }
                }
            } else {
                foreach ($listClass as $class) {
                    $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();

                    foreach ($listStudent as $item) {
                        $student = DsHocSinh::findOne($item->MaHocSinh);
                        if ($student->MaDanToc != 1)
                            if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHocLuc' => $idtype])->all() != null)
                                $sl++;
                    }
                }
            }
        }
        return $sl;

    }

    /**
     * @param $idLevel
     * @param $idSemester
     * @param $idtype
     * @param null $type du lieu vao la hoc luc hoac hanh kiem
     * @return int so luong hanh kiem hoc luc
     */
    public static function getSLHocLucHanhKiemAllLevelWoman($idLevel, $idSemester, $idtype, $type = null)
    {

        $idYear = DSNamHoc::getCurrentYear();
      /*  $lisKhoi = DSKhoi::find()->where(['MaCap' => $idLevel])->all();*/

            if ($type == null) {
               /* foreach ($listClass as $class) {
                    $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listStudent as $item) {
                        $student = DsHocSinh::getStudent($item->MaHocSinh);
                        if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHanhKiem' => $idtype])->all() != null)
                            if ($student->GioiTinh == 1)
                                $sl++;
                    }
                }*/
              return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                   ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                   ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHanhKiem'=>$idtype,'MaHocKy'=>$idSemester,'MaCap'=>$idLevel,'GioiTinh'=>1])->count();
            } else {
                return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                    ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                    ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHocLuc'=>$idtype,'MaHocKy'=>$idSemester,'MaCap'=>$idLevel,'GioiTinh'=>1])->count();
            }



    }

    public static function getSLHocLucHanhKiemAllGruopWoman($idGruop, $idSemester, $idtype, $type = null)
    {

        $idYear = DSNamHoc::getCurrentYear();

        if ($type == null) {
            return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')
                ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHanhKiem'=>$idtype,'MaHocKy'=>$idSemester,'MaKhoi'=>$idGruop,'GioiTinh'=>1])->count();
        } else {
            return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')
                ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHocLuc'=>$idtype,'MaHocKy'=>$idSemester,'MaKhoi'=>$idGruop,'GioiTinh'=>1])->count();
        }


    }
    public static function getSLHocLucHanhKiemNationWormen($idGroup, $idSemester, $idtype, $type = null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();

        if ($type == null) {
            return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')
                ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHanhKiem'=>$idtype,'MaHocKy'=>$idSemester,'MaKhoi'=>$idGroup,'GioiTinh'=>1])->andWhere(['>','MaDanToc',1])->count();
        } else {
            return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')
                ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHocLuc'=>$idtype,'MaHocKy'=>$idSemester,'MaKhoi'=>$idGroup,'GioiTinh'=>1])->andWhere(['>','MaDanToc',1])->count();
        }

    }
    public static function getSLHocLucHanhKiemAllLevelNationWormen($idLevel, $idSemester, $idtype, $type = null)
    {

        $idYear = DSNamHoc::getCurrentYear();
        /*  $lisKhoi = DSKhoi::find()->where(['MaCap' => $idLevel])->all();*/

        if ($type == null) {
            /* foreach ($listClass as $class) {
                 $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                 foreach ($listStudent as $item) {
                     $student = DsHocSinh::getStudent($item->MaHocSinh);
                     if (DSTongKetTheoKy::find()->where(['MaHocSinh' => $item->MaHocSinh, 'MaNamHoc' => $idYear, 'MaHocKy' => $idSemester, 'MaHanhKiem' => $idtype])->all() != null)
                         if ($student->GioiTinh == 1)
                             $sl++;
                 }
             }*/
            return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHanhKiem'=>$idtype,'MaHocKy'=>$idSemester,'MaCap'=>$idLevel,'GioiTinh'=>1])->andWhere(['>','MaDanToc',1])->count();
        } else {
            return DSTongKetTheoKy::find()->innerJoin('dshocsinhtheolop','dshocsinhtheolop.MaHocSinh=dstongkettheoky.MaHocSinh')->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dstongkettheoky.MaHocSinh')
                ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
                ->where(['dstongkettheoky.MaNamHoc'=>$idYear,'MaHocLuc'=>$idtype,'MaHocKy'=>$idSemester,'MaCap'=>$idLevel,'GioiTinh'=>1])->andWhere(['>','MaDanToc',1])->count();
        }

    }
}