<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 9/24/2016
 * Time: 10:02 PM
 */

namespace backend\component;
use backend\BLL\ConvertString;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DSHocSinhTheoLop;
use backend\models\DsLoaiDiem;
use backend\models\DsLop;
use backend\models\DSNamHoc;
use backend\models\DsDiem;

use backend\models\DsMonHoc;

use backend\models\DsTinNhanHocSinh;
use backend\models\DSTongKetTheoKy;
use backend\models\Loi;
use backend\models\SmsAuth;
use  frontend\models\DsMonHocTheoLop;
use yii\base\Exception;

class SmsContent
{
    public static function tittleSms($idMonth,$idStudent)
    {
        return "Điểm cập nhật tháng ".$idMonth." của học sinh: ".DsHocSinh::getFullName($idStudent)."\r\n";
    }
    public static function tittleSmsExcel($idMonth,$idStudent)
    {
        return "Diem thang ".$idMonth." cua hoc sinh: ".ConvertString::vn_str_filter(DsHocSinh::getFullName($idStudent))."\r\n";
    }
    public static function contentSms($idSemester,$idStudent,$idYear,$idMonth)
    {
        $str=self::tittleSms($idMonth,$idStudent);

            $idClassFollowStudent = DSHocSinhTheoLop::findOne(['MaHocSinh' => $idStudent])->MaLop;


        $lisSubjectFollowClass=DsMonHocTheoLop::find()->where(['MaLop'=>$idClassFollowStudent,"MaHocKy"=>$idSemester])->all();
        $listTypeScroses=DsLoaiDiem::find()->orderBy(['MaLoaiDiem'=>SORT_ASC])->all();
        for($i=0;$i<count($lisSubjectFollowClass);$i++)
        {
            if(DsMonHoc::getCountRescrosesInSemester($lisSubjectFollowClass[$i]->MaMonHoc,$idSemester,$idStudent)>0) {
                $str = $str . DsMonHoc::getNameSubject($lisSubjectFollowClass[$i]->MaMonHoc) . ' ';
                for ($j = 0; $j < count($listTypeScroses); $j++) {
                    $str = $str . DsDiem::getListScrosesFollowidScroses($idStudent, $idYear, $lisSubjectFollowClass[$i]->MaMonHoc, $idSemester, $listTypeScroses[$j]->MaLoaiDiem);
                }
                $str = $str . "\r\n";
            }
        }
       $str= $str."(Phan noi dung trong ngoac don la he so cua diem).\r\nTruy cap http://cva.namguyengt.com/daotao/ de xem diem day du.";
        return $str;
    }

    public static function contentSmsExcel($idSemester,$idStudent,$idYear,$idMonth)
    {

        $str=self::tittleSmsExcel($idMonth,$idStudent);

            $ClassFollowStudent = DSHocSinhTheoLop::findOne(['MaHocSinh' => $idStudent]);
            if($ClassFollowStudent!=null) {
                $idClassFollowStudent = $ClassFollowStudent->MaLop;
                $lisSubjectFollowClass = DsMonHocTheoLop::find()->where(['MaLop' => $idClassFollowStudent, "MaHocKy" => $idSemester,'MaNamHoc'=>$idYear])->all();
                for ($i = 0; $i < count($lisSubjectFollowClass); $i++) {
                    if (DsMonHoc::getCountRescrosesInSemesterMonth($lisSubjectFollowClass[$i]->MaMonHoc, $idSemester, $idStudent,$idMonth) > 0) {

                        $str = $str . DsMonHoc::getNameSubjectSMS($lisSubjectFollowClass[$i]->MaMonHoc) . ' ';
                        $str = $str . DsDiem::getListScrosesFollowidScroses($idStudent, $idYear, $lisSubjectFollowClass[$i]->MaMonHoc, $idSemester,$idMonth);
                        $str = $str . "\r\n";
                    }
                }
                $str = $str . "Truy cap http://cva.namnguyengt.com de xem diem day du.";
            }
            else
            {

                $loi=new Loi();
                $loi->MaHocSinh=$idStudent;
                $loi->save();
                $str="";
            }
        return $str;
    }


    /**
     * @param $idSemester
     * @param $idStudent
     * @param $idYear
     * @param $idMonth
     * @return string
     */
    public static function contentSmsExcelSummary($idSemester, $idStudent, $idYear)
    {
        if($idSemester=="K1")
            $str="Dien tong ket hoc ky 1 ";
        elseif ($idSemester=="K2")
            $str="Dien tong ket hoc ky 2 ";
        else
            $str="Diem tong ket ca nam ";
        $str.=ConvertString::vn_str_filter(DsHocSinh::getFullName($idStudent))."\\r\\n";


        $ClassFollowStudent = DSHocSinhTheoLop::findOne(['MaHocSinh' => $idStudent]);
        if($ClassFollowStudent!=null) {
            $idClassFollowStudent = $ClassFollowStudent->MaLop;
            $lisSubjectFollowClass = DsMonHocTheoLop::find()->where(['MaLop' => $idClassFollowStudent, "MaHocKy" => $idSemester])->all();
            for ($i = 0; $i < count($lisSubjectFollowClass); $i++) {

                    $str = $str . DsMonHoc::getNameSubjectSMS($lisSubjectFollowClass[$i]->MaMonHoc) . ' ';

                    $str = $str . DsDiem::getScrosesFollowidScrosesSummary($idStudent, $idYear, $lisSubjectFollowClass[$i]->MaMonHoc, $idSemester);

                    $str = $str . "\\r\\n";

            }
            $Summary=DSTongKetTheoKy::getSummary($idStudent,$idSemester,$idYear);
            $str=$str."TBC ".$Summary->TrungBinhChung."\\r\\n"."Danh hieu: ".DSTongKetTheoKy::getTextDanhHieu($Summary->MaDanhHieu)."\\r\\n Hanh kiem: ".DSTongKetTheoKy::getTextHanhKiem($Summary->MaHanhKiem)
            ."\\r\\n Hoc luc: ".DSTongKetTheoKy::getTextHocLuc($Summary->MaHocLuc);

            $str = $str . "(Phan noi dung trong ngoac don la he so cua diem).\\r\\nTruy cap http://cva.namnguyengt.com/daotao/ de xem diem day du.";
        }
        else
        {

            $loi=new Loi();
            $loi->MaHocSinh=$idStudent;
            $loi->save();
            $str="";
        }
        return ConvertString::vn_str_filter($str);
    }

    public static function XacDinhLoi($case)
    {
        switch ($case)
        {
            case "103":
                return "103";
            break;
            case "101":
                return "101";
                break;

            case "102":
                return "102";
                break;
            case "104":
                return "104";
                break;
            case "118":
                return "118";
                break;
            case "119":
                return "119";
                break;
            case "131":
                return "131";
                break;
            case "132":
                return "132";
                break;
            case "99":
                return "99";
                break;
            case "100":
                return "100";
        }
    }
    public static function checkSendSms($idSms)
    {

        $sms=SmsAuth::findOne(['status'=>1]);
        $APIKey=$sms->API_Key;
        $SecretKey=$sms->Secrect_Key;

        $ch = curl_init();
        $SampleXml="<RQST>
        
         <APIKEY>".$APIKey."</APIKEY>
    
         <SECRETKEY>".$SecretKey."</SECRETKEY>
    
         <SMSID>".$idSms."</SMSID>
    
        </RQST>";


        /* curl_setopt($ch, CURLOPT_URL,            "http://api.esms.vn/MainService.svc/xml/SendMultipleMessage_V2/" );*/
        curl_setopt($ch, CURLOPT_URL,            "http://api.esms.vn/MainService.svc/xml/GetSmsStatus/" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $SampleXml );
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

        $result=curl_exec ($ch);
        $xml = simplexml_load_string($result);

        if ($xml === false) {
            return 'Error parsing XML';
        }

        //now we can loop through the xml structure
        //Tham khao them ve SMSTYPE de gui tin nhan hien thi ten cong ty hay gui bang dau so 8755... tai day :http://esms.vn/SMSApi/ApiSendSMSNormal

     return $xml->StatusCode ;
    }
    public static function sendSms($numberPhone,$content,$idStudent,$month)
    {
        $sms=SmsAuth::findOne(['status'=>1]);
        $APIKey=$sms->API_Key;
        $SecretKey=$sms->Secrect_Key;
        $BrandName=$sms->Brandname;
        $ch = curl_init();


       $SampleXml = "<RQST>"
            . "<APIKEY>". $APIKey ."</APIKEY>"
            . "<SECRETKEY>". $SecretKey ."</SECRETKEY>"
            ."<BRANDNAME>".$BrandName."</BRANDNAME>

             <SMSTYPE>2</SMSTYPE> "
            . "<CONTENT>".$content." </CONTENT>"
            . "<CONTACTS>"
            . "<CUSTOMER>"
            . "<PHONE>". $numberPhone ."</PHONE>"
            . "</CUSTOMER>"
            . "</CONTACTS>"
            . "</RQST>";


        curl_setopt($ch, CURLOPT_URL,            "http://api.esms.vn/MainService.svc/xml/SendMultipleSMSBrandname/" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $SampleXml );
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

        $result=curl_exec ($ch);
        $xml = simplexml_load_string($result);


            $tinNhan = new DsTinNhanHocSinh();
            $tinNhan->MaHocSinh = $idStudent;
            $tinNhan->NoiDung = $content;
            $tinNhan->SddtPhuHuynh = $numberPhone;
            $tinNhan->Thang = $month;

        if ($xml === false) {
            $tinNhan->LoiPhatSinh="400";
        }

        else {
            $loi = self::XacDinhLoi($xml->CodeResult);
            if ($xml->CodeResult == "100") {
                $tinNhan->idSms = $xml->SMSID;
                $tinNhan->TrangThai = 1;
                $tinNhan->CacLanCoGangGui = 1;
                $tinNhan->LoiPhatSinh = "100";
            } else {
                $tinNhan->idSms = -1;
                $tinNhan->TrangThai = 1;
                $tinNhan->CacLanCoGangGui = 1;
                $tinNhan->LoiPhatSinh = $loi;
            }

            $tinNhan->idSms = "null";
              $tinNhan->TrangThai = 0;
              $tinNhan->CacLanCoGangGui = 1;
              $tinNhan->LoiPhatSinh=$xml->ErrorMessage;

        }

        if($tinNhan->save())
            return "ok";
        else
            return "false";
        echo $content;
    }
    public static function contentSmsInformation($idStudent)
    {
        $student=DsHocSinh::findOne($idStudent);
        $student->MatKhau=DsHocSinh::generatePassword(DsHocSinh::getDayOfBithToText($student->NgaySinh));
        $student->save();
        $str="Truong Tieu hoc, THCS, THPT Chu Van An Thong bao: de kiem tra tinh hinh hoc tap cua con em minh. Quy phu huynh truy cap dia chi sau:\\r\\n";
        $str=$str."cva.namnguyengt.com \\r\\n";
        $str=$str."Sau do nhap Ten dang nhap:".$idStudent." \\r\\nMat khau:".DsHocSinh::getDayOfBithToText($student->NgaySinh);
        return $str;
    }


}