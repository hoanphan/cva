<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 11/10/2016
 * Time: 2:55 PM
 */

namespace backend\BLL;


use backend\models\DmDanToc;
use backend\models\DsHocSinh;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSKhoi;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DSTuan;
use frontend\models\DsMonHocTheoLop;

class DsHocSinhBLL extends DsHocSinh
{
    public static function LoadAll()
    {
        return DsHocSinh::find()->all();
    }
    /**
     * @param $MaKhoi
     * @param $idNation
     * @return int Tổng số học sinh dân tộc trong toàn bộ cấp là nữ theo dân tộc
     */
    public static function getCountNationInGruopWormenNation($MaKhoi, $idNation)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listClass = DsLop::find()->where(['MaKhoi' => $MaKhoi, 'MaNamHoc' => $idYear])->all();

        foreach ($listClass as $class) {
            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
            foreach ($listStudent as $item) {
                $student=DsHocSinh::getStudent($item->MaHocSinh);
                $idDanToc = $student->MaDanToc;
                if ($idNation==$idDanToc&&$student->GioiTinh==1)
                    $sl++;
            }
        }
        return $sl;
    }

    public static function getCountNationInGruop($MaKhoi)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listClass = DsLop::find()->where(['MaKhoi' => $MaKhoi, 'MaNamHoc' => $idYear])->all();

        foreach ($listClass as $class) {
            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
            foreach ($listStudent as $item) {

                $idDanToc = DsHocSinh::getStudent($item->MaHocSinh)->MaDanToc;
                $danToc=DmDanToc::findOne($idDanToc);
                if ($danToc!=null&&$danToc->ThongKeDanToc>0)
                    $sl++;
            }
        }
        return $sl;
    }

    /**
     * @param $MaKhoi
     * @param $idNation
     * @return int Tổng số học sinh dân tộc trong toàn bộ khối
     */
    public static function getCountNationInGruopFollowNation($MaKhoi, $idNation)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listClass = DsLop::find()->where(['MaKhoi' => $MaKhoi, 'MaNamHoc' => $idYear])->all();

        foreach ($listClass as $class) {
            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
            foreach ($listStudent as $item) {

                $idDanToc = DsHocSinh::getStudent($item->MaHocSinh)->MaDanToc;
                if ($idNation==$idDanToc)
                    $sl++;
            }
        }
        return $sl;
    }

    /**
     * @param $idLevel
     * @return int Tổng số học sinh dân tộc trong toàn bộ cấp
     */
    public static function getCountNationInAllLevel($idLevel)
    {

        $idYear = DSNamHoc::getCurrentYear();


           /* $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item) {

                    $idDanToc = DsHocSinh::getStudent($item->MaHocSinh)->MaDanToc;
                    $danToc=DmDanToc::findOne($idDanToc);
                    if ($danToc!=null&&$danToc->ThongKeDanToc>0)
                        $sl++;
                }
            }*/
         return  DSHocSinhTheoLop::find()->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dshocsinhtheolop.MaHocSinh')->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')
               ->innerJoin('dskhoi','dslop.MaKhoi=dskhoi.MaKhoi')->where(['dskhoi.MaCap'=>$idLevel,'dshocsinhtheolop.MaNamHoc'=>$idYear])->andWhere(['>','dshocsinh.MaDanToc',1])->count();


    }

    /**
     * @param $idLevel
     * @return int Tổng số học sinh dân tộc trong toàn bộ cấp là nữ
     */
    public static function getCountNationInAllLevelAndWormen($idLevel)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
       /* $listLevel = DSKhoi::find()->where(['MaCap' => $idLevel])->all();
        foreach ($listLevel as $level) {

            $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item) {
                    $student= DsHocSinh::getStudent($item->MaHocSinh);
                    $idDanToc =$student->MaDanToc;
                    $danToc=DmDanToc::findOne($idDanToc);
                    if ($student->GioiTinh==1&&$danToc!=null&&$danToc->ThongKeDanToc>0)
                        $sl++;
                }
            }
        }
        return $sl;*/
        return DSHocSinhTheoLop::find()->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dshocsinhtheolop.MaHocSinh')
            ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')
            ->where(['dshocsinhtheolop.MaNamHoc'=>$idYear,'MaCap'=>$idLevel,'GioiTinh'=>1])->andWhere(['>','MaDanToc',1])->count();
    }

    /**
     * @param $idLevel
     * @param $idNation
     * @return int Tổng số học sinh dân tộc trong toàn bộ cấp theo dân tộc và là nữ
     */
    public static function getCountNationInAllLevelAndWormenAndNation($idLevel, $idNation)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listLevel = DSKhoi::find()->where(['MaCap' => $idLevel])->all();
        foreach ($listLevel as $level) {

            $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item) {
                    $student= DsHocSinh::getStudent($item->MaHocSinh);
                    $idDanToc =$student->MaDanToc;
                    if ($student->GioiTinh==1&&$idNation==$idDanToc)
                        $sl++;
                }
            }
        }
        return $sl;
    }

    /**
     * @param $idLevel
     * @param $idNation
     * @return int Tổng số học sinh dân tộc trong toàn bộ cấp là nữ
     */
    public static function getCountNationInAllLevelFollowNation($idLevel, $idNation)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listLevel = DSKhoi::find()->where(['MaCap' => $idLevel])->all();
        foreach ($listLevel as $level) {

            $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

            foreach ($listClass as $class) {
                $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item) {

                    $idDanToc = DsHocSinh::getStudent($item->MaHocSinh)->MaDanToc;
                    if ($idNation==$idDanToc)
                        $sl++;
                }
            }
        }
        return $sl;
    }

    /**
     * @param $MaKhoi
     * @return int Tổng số học sinh dân tộc trong toàn bộ khối là nữ
     */
    public static function getCountNationInGruopWormen($MaKhoi)
    {

        $idYear = DSNamHoc::getCurrentYear();
        return DSHocSinhTheoLop::find()->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dshocsinhtheolop.MaHocSinh')
            ->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')
            ->where(['dshocsinhtheolop.MaNamHoc'=>$idYear,'MaKhoi'=>$MaKhoi,'GioiTinh'=>1])->andWhere(['>','MaDanToc',1])->count();
    }

    /**
     * @param $MaKhoi
     * @param $idNation
     * @return int Tổng số học sinh dân tộc trong toàn bộ cấp là nữ theo dân tộc
     */
    /*public static function getCountNationInGruopWormenNation($MaKhoi, $idNation)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listClass = DsLop::find()->where(['MaKhoi' => $MaKhoi, 'MaNamHoc' => $idYear])->all();

        foreach ($listClass as $class) {
            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
            foreach ($listStudent as $item) {
                $student=DsHocSinh::getStudent($item->MaHocSinh);
                $idDanToc = $student->MaDanToc;
                if ($idNation==$idDanToc&&$student->GioiTinh==1)
                    $sl++;
            }
        }
        return $sl;
    }*/

    /**
     * @return int Toàn bộ học sinh trong khối
     */
    public static function getCountStudentInAllLevel($idLevel,$wormen=null,$DoTuoi=null,$NhoHon=null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listLevel = DSKhoi::find()->where(['MaCap' => $idLevel])->all();
       //Lấy toàn bộ học sinh trong cấp
        if($wormen==null&&$DoTuoi==null) {
           return DSHocSinhTheoLop::find()->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')
               ->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')->where(['dskhoi.MaCap'=>$idLevel,'dshocsinhtheolop.MaNamHoc'=>$idYear])->count();
        }
        //Lấy toàn học sinh nữ trong cấp
        elseif($wormen!=null&&$DoTuoi==null)
        {
           /* foreach ($listLevel as $level) {

                $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                foreach ($listClass as $class) {
                   $listStudent= DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listStudent as $item)
                    {
                        $student=DsHocSinh::findOne($item->MaHocSinh);
                        if($student->GioiTinh==1)
                        {
                            $sl++;
                        }
                    }
                }
            }*/
            return DSHocSinhTheoLop::find()->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dshocsinhtheolop.MaHocSinh')->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')

                ->innerJoin('dskhoi','dskhoi.MaKhoi=dslop.MaKhoi')->where(['dskhoi.MaCap'=>$idLevel,'dshocsinhtheolop.MaNamHoc'=>$idYear,'dshocsinh.GioiTinh'=>0])->count();
        }
        //nếu độ tuổi
        elseif ($DoTuoi!=null)
        {
            // có phải lớp
            if($wormen==null) {
                // tuổi nhỏ
                if ($NhoHon == 0) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age < $DoTuoi)
                                    $sl++;
                            }
                        }
                    }
                }
                //tuổi bằng
                elseif ($NhoHon == 1) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age == $DoTuoi)
                                    $sl++;
                            }
                        }
                    }
                }
                //Tuổi lớn
                elseif ($NhoHon == 2) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age > $DoTuoi)
                                    $sl++;
                            }
                        }
                    }
                }
            }
            else
            {
                // tuổi nhỏ
                if ($NhoHon == 0) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                if($student->GioiTinh==1) {
                                    $age = DSTuan::getAge($student->NgaySinh);
                                    if ($age < $DoTuoi)
                                        $sl++;
                                }
                            }
                        }
                    }
                }
                //tuổi bằng
                elseif ($NhoHon == 1) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                if($student->GioiTinh==1) {
                                    $age = DSTuan::getAge($student->NgaySinh);
                                    if ($age == $DoTuoi)
                                        $sl++;
                                }
                            }
                        }
                    }
                }
                //Tuổi lớn
                elseif ($NhoHon == 2) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                if($student->GioiTinh==1) {
                                    $age = DSTuan::getAge($student->NgaySinh);
                                    if ($age >$DoTuoi)
                                        $sl++;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $sl;
    }

    /**
     * @param $idGruop
     * @param null $wormen
     * @param null $DoTuoi
     * @param null $NhoHon
     * @return int|string so luong hoc sinh trong 1 khoi
     */
    public static function getCountStudentInAllGruopFollowAge($idGruop, $wormen=null, $DoTuoi=null, $NhoHon=null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();

        if($wormen==null&&$DoTuoi==null) {

                $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();

                foreach ($listClass as $class) {
                    $sl += DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->count();

                }
        }
        elseif($wormen!=null&&$DoTuoi==null)
        {


                $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();

                foreach ($listClass as $class) {
                    $listStudent= DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listStudent as $item)
                    {
                        $student=DsHocSinh::findOne($item->MaHocSinh);
                        if($student->GioiTinh==1)
                        {
                            $sl++;
                        }
                    }
                }


        }
        elseif ($DoTuoi!=null)
        {
            if($wormen==null) {
                //tuổi nhỏ
                if ($NhoHon == 0) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            $age = DSTuan::getAge($student->NgaySinh);
                            if ($age < $DoTuoi)
                                $sl++;
                        }
                    }

                }
                //Tuổi ==
                if ($NhoHon == 1) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            $age = DSTuan::getAge($student->NgaySinh);
                            if ($age == $DoTuoi)
                                $sl++;
                        }
                    }
                }
                //Tuổi >
                if ($NhoHon == 2) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            $age = DSTuan::getAge($student->NgaySinh);
                            if ($age > $DoTuoi)
                                $sl++;
                        }
                    }
                }
            }
            else
            {
                //tuổi nhỏ
                if ($NhoHon == 0) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            if($student->GioiTinh==1) {
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age < $DoTuoi)
                                    $sl++;
                            }
                        }
                    }

                }
                //Tuổi ==
                if ($NhoHon == 1) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            if($student->GioiTinh==1) {
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age == $DoTuoi)
                                    $sl++;
                            }
                        }
                    }
                }
                //Tuổi >
                if ($NhoHon == 2) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            if($student->GioiTinh==1) {
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age > $DoTuoi)
                                    $sl++;
                            }
                        }
                    }
                }
            }
        }
        return $sl;
    }

    /**
     * @param $idGruop
     * @return int|string Tổng số học sinh trong khối
     */
    public static function getCountStudentInAllGruop($idGruop,$wormen=null)
    {

        $idYear = DSNamHoc::getCurrentYear();

            if($wormen==null)
                return DSHocSinhTheoLop::find()->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->where(['MaKhoi'=>$idGruop])->count();
            else
              return DSHocSinhTheoLop::find()->innerJoin('dshocsinh','dshocsinh.MaHocSinh=dshocsinhtheolop.MaHocSinh')->innerJoin('dslop','dslop.MaLop=dshocsinhtheolop.MaLop')->where(['MaKhoi'=>$idGruop,'GioiTinh'=>1,'dshocsinhtheolop.MaNamHoc'=>$idYear])->count();


    }
    /**
     * @param $idGruop
     * @return int|string Tổng số học sinh trong khối là dân tộc
     */
    public static function getCountStudentInAllGruopNation($idGruop,$wormen=null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
        if($wormen==null)
            foreach ($listClass as $class) {
                $listStudent= DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item)
                {
                    $student=DsHocSinh::findOne($item->MaHocSinh);
                    if($student->MaDanToc!=1)
                    {
                        $sl++;
                    }
                }
            }
        else
            foreach ($listClass as $class) {
                $listStudent= DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                foreach ($listStudent as $item)
                {
                    $student=DsHocSinh::findOne($item->MaHocSinh);
                    if($student->GioiTinh==1)
                    {
                        $sl++;
                    }
                }
            }

        return $sl;
    }
    /**
     * Lấy Toàn bộ học sinh dân tộc trong cấp
     * @param $idLevel
     * @param null $DoTuoi
     * @param null $NhoHon
     * @return int
     */
    public static function getCountStudentInAllLevelFollowNation($idLevel, $DoTuoi=null, $NhoHon=null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();
        $listLevel = DSKhoi::find()->where(['MaCap' => $idLevel])->all();

        //nếu độ tuổi
        if ($DoTuoi!=null)
        {

                // tuổi nhỏ
                if ($NhoHon == 0) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                if($student->MaDanToc>1) {
                                    $age = DSTuan::getAge($student->NgaySinh);
                                    if ($age < $DoTuoi)
                                        $sl++;
                                }
                            }
                        }
                    }
                }
                //tuổi bằng
                elseif ($NhoHon == 1) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                if($student->MaDanToc>1) {
                                    $age = DSTuan::getAge($student->NgaySinh);
                                    if ($age == $DoTuoi)
                                        $sl++;
                                }
                            }
                        }
                    }
                }
                //Tuổi lớn
                elseif ($NhoHon == 2) {
                    foreach ($listLevel as $level) {

                        $listClass = DsLop::find()->where(['MaKhoi' => $level->MaKhoi, 'MaNamHoc' => $idYear])->all();

                        foreach ($listClass as $class) {
                            $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                            foreach ($listStudent as $item) {
                                $student = DsHocSinh::findOne($item->MaHocSinh);
                                if($student->MaDanToc!=1) {
                                    $age = DSTuan::getAge($student->NgaySinh);
                                    if ($age >$DoTuoi)
                                        $sl++;
                                }
                            }
                        }
                    }
                }

        }
        return $sl;
    }

    /**
     * Laays dan toc theo do tuoi
     * @param $idGruop
     * @param null $DoTuoi
     * @param null $NhoHon
     * @return int
     */
    public static function getCountStudentInAllGruopFollowNation($idGruop, $DoTuoi=null, $NhoHon=null)
    {
        $sl = 0;
        $idYear = DSNamHoc::getCurrentYear();

        if ($DoTuoi!=null)
        {

                //tuổi nhỏ
                if ($NhoHon == 0) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            if($student->MaDanToc>1) {
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age < $DoTuoi)
                                    $sl++;
                            }
                        }
                    }

                }
                //Tuổi ==
                if ($NhoHon == 1) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            if($student->MaDanToc>1) {
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age == $DoTuoi)
                                    $sl++;
                            }
                        }
                    }
                }
                //Tuổi >
                if ($NhoHon == 2) {
                    $listClass = DsLop::find()->where(['MaKhoi' => $idGruop, 'MaNamHoc' => $idYear])->all();
                    foreach ($listClass as $class) {
                        $listStudent = DSHocSinhTheoLop::find()->where(['MaLop' => $class->MaLop, 'MaNamHoc' => $idYear])->all();
                        foreach ($listStudent as $item) {
                            $student = DsHocSinh::findOne($item->MaHocSinh);
                            if($student->MaDanToc>1) {
                                $age = DSTuan::getAge($student->NgaySinh);
                                if ($age > $DoTuoi)
                                    $sl++;
                            }
                        }
                    }
                }

        }
        return $sl;
    }

}
