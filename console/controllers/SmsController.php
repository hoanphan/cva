<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 3/26/2017
 * Time: 9:55 PM
 */

namespace console\controllers;


use backend\component\ContentGmail;
use backend\component\SmsContent;
use backend\models\DsEmailSmsGuiToanBo;
use backend\models\DSHocKy;
use backend\models\DsHocSinh;
use backend\models\DSHocSinhTheoLop;
use backend\models\DSNamHoc;
use backend\models\DsThang;
use backend\models\DsTinNhanHocSinh;
use common\components\SendSms;
use yii\console\Controller;

class SmsController extends Controller
{
    public function actionIndex()
    {
        $arr=array('HS00480','HS00470','HS00477','HS00462','HS00459','HS00521','HS00531','HS00530','HS00516','HS00498',
            'HS00249','HS00222','HS00235','HS00206','HS00198','HS00145','HS00168','HS00473');
        $content='Trường CVA thong bao toi cac PH ve chuyen di HN cua HS: 13h00 chieu thu 6(07.4.2017) HS tap trung o truong de xuat phat .Kinh phi: 1.500.000d/HS nop cho bac Sau truoc khi xuat phat. Chi phi cu the nha trg se gui thong bao sau khi doan ve den sla.';
        $content=$this->convert_vi_to_en($content);
        echo count($arr);
      foreach ($arr as  $item)
        {
            $student=DsHocSinh::findOne($item);
            if($student!=null)
            {
                SendSms::sendTuDo($student->SoDienThoaiPhuHuynh,$content);
                echo "da gui cho ".$student->SoDienThoaiPhuHuynh."\n";
            }
        }
       /*$content= DsEmailSmsGuiToanBo::findOne(5670);
        SendSms::sendSms($content);
        echo "Da gui cho " . $content->SoDienThoaiPhuHuynh . "\n";*/
    }

    public function actionCreate()
    {
        $month = date('m');
        $idMonth = 'T' . $month;
        $month = DsThang::findOne($idMonth);
        $timeZone= new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
        $dateTimeZone=explode(" ",$timeZone->format('Y-m-d H:i:00 a'));
        $dateCurrent = $dateTimeZone[0];
        $date = explode(" ", $month->ThoiGianGui)[0];
        $status=$dateTimeZone[2];
        echo $dateCurrent;
        if ($date == $dateCurrent&&$status=='am') {
            echo "vao roi";
            if ($month->DaGui == DsThang::STATUS_NOT_SENDING) {
                $month->DaGui = DsThang::STATUS_CREATE_CONTENT;
                $month->update();
                /**
                 * @var DsHocSinh[] $listStudent
                 */
                $listStudent = DSHocSinhTheoLop::find()->all();
                $semester = DSHocKy::getSemesterCurent();
                $idYear = DSNamHoc::getCurrentYear();
                $db = \Yii::$app->db->beginTransaction();
                foreach ($listStudent as $item) {
                    $student = DsHocSinh::findOne($item->MaHocSinh);
                    $sms = new DsEmailSmsGuiToanBo();
                    $sms->MaHocSinh = $student->MaHocSinh;
                    $contentMail = ContentGmail::sendText($item->MaHocSinh, $semester->MaHocKy, $month->STTThang);
                    $contentSms = SmsContent::contentSmsExcel($semester->MaHocKy, $item->MaHocSinh, $idYear, $month->STTThang);
                    $sms->EmailPhuHuynh = $student->EmailPhuHuynh;
                    $sms->SoDienThoaiPhuHuynh = $student->SoDienThoaiPhuHuynh;
                    $sms->NoiDungEmail = $contentMail;
                    $sms->NoiDungSms = $contentSms;
                    $sms->DaGuiEmail = 0;
                    $sms->DaGuiSms = 0;
                    $sms->TieuDeEmail = 'Trường TH, THCS, THPT Chu Văn An kính gửi tới quý phụ huynh kết quả học tập của học sinh trong tháng' . $month->STTThang;
                    $sms->save();
                    echo $sms->MaHocSinh . "\n";
                    echo $sms->NoiDungSms . "\n";
                }
                $month->DaGui = DsThang::STATUS_EX;
                $month->save();
                $db->commit();
            } else {
                echo "Đã có hàng chờ hoặc đã gửi";
            }
        }
    }

    public function actionSendSms()
    {
        $month = date('m');
        $idMonth = 'T' . $month;
        $month = DsThang::findOne($idMonth);
        $date = explode(" ", $month->ThoiGianGui)[0];
        $time = explode(" ", $month->ThoiGianGui)[1];
        $timeZone= new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh'));
        $dateTimeZone=explode(" ",$timeZone->format('Y-m-d H:i:00 a'));
        $dateCurrent = $dateTimeZone[0];
        $timeCurent=$dateTimeZone[1];
        $status=$dateTimeZone[2];
        echo $time.' '.$timeCurent.' \n';
        if ($dateCurrent == $date) {
            if($time==$timeCurent) {
                echo "da vao \n".$month->DaGui;
                /**
                 * @var DsEmailSmsGuiToanBo[] $listEmailAndSms
                 * @var DsEmailSmsGuiToanBo $item
                 * @var DsEmailSmsGuiToanBo $email
                 **/
                if ($month->DaGui == DsThang::STATUS_EX) {
                    $month->DaGui = DsThang::STATUS_PENDING;
                    echo "da vao 2 \n";

                    $month->save();
                    $listEmailAndSms = DsEmailSmsGuiToanBo::find()->where(['DaGuiSms' => DsEmailSmsGuiToanBo::STATUS_NOT_SENDING])->all();
                    foreach ($listEmailAndSms as $item) {
                        if($item->SoDienThoaiPhuHuynh!=null) {
                            SendSms::sendSms($item);
                            echo "Da gui cho " . $item->SoDienThoaiPhuHuynh . "\n";
                        }
                      /*  if ($item->EmailPhuHuynh != null) {
                            $arrEmail = explode(",", $item->EmailPhuHuynh);
                            foreach ($arrEmail as $email) {
                                \Yii::$app->mailer->compose()->setFrom('truongcvadhtb@gmail.com')->
                                   setTo($email)->setSubject($item->TieuDeEmail)
                                       ->setHtmlBody($item->NoiDungEmail)->send();
                            }
                        }*/
                        //$item->DaGuiEmail = DsEmailSmsGuiToanBo::STATUS_COMPLETE;
                        $item->update();
                    }
                }
                echo "da ket thuc";
            }
        }
    }

    public function actionCheckSendSms()
    {
        $db=\Yii::$app->db->beginTransaction();
        for($i=0;$i<6;$i++)
        {
            /**
             * @var DsEmailSmsGuiToanBo[] $list sms
            **/
            $list=DsEmailSmsGuiToanBo::find()->where(['DaGuiSms'=>DsEmailSmsGuiToanBo::STATUS_SENDING])->all();
            foreach ($list as $item)
            {
                echo 'check sms'.$item->MaHocSinh.'/n';
                if(SendSms::checkSms($item))
                {
                    $item->DaGuiSms=DsEmailSmsGuiToanBo::STATUS_COMPLETE;
                }
                else
                if($i==5)
                {
                    $item->DaGuiSms=DsEmailSmsGuiToanBo::STATUS_FAIL;
                }
                $item->save();
            }
        }
        $db->commit();
    }
    function convert_vi_to_en($str) {
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
  $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
  $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
  $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
  $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
  $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
  $str = preg_replace('/(đ)/', 'd', $str);
  $str = preg_replace('/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/', 'A', $str);
  $str = preg_replace('/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/', 'E', $str);
  $str = preg_replace('/(Ì|Í|Ị|Ỉ|Ĩ)/', 'I', $str);
  $str = preg_replace('/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/', 'O', $str);
  $str = preg_replace('/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/', 'U', $str);
  $str = preg_replace('/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/', 'Y', $str);
  $str = preg_replace('/(Đ)/', 'D', $str);
  //$str = str_replace(' ', '-', str_replace('&*#39;','",$str));
  return $str;
  }

}