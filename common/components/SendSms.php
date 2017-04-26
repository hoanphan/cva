<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 3/27/2017
 * Time: 8:49 AM
 */

namespace common\components;


use backend\models\DsEmailSmsGuiToanBo;

class SendSms
{
    /**
     * @var DsEmailSmsGuiToanBo $sms
     **/
    public static function sendSms(DsEmailSmsGuiToanBo $sms)
    {
        if (strlen($sms->NoiDungSms) <= 500) {
            if($sms->SoDienThoaiPhuHuynh!=null) {
                if (\common\components\sms\SendSms::sendSms($sms->SoDienThoaiPhuHuynh, $sms->NoiDungSms)['return'] == "200")
                    $sms->DaGuiSms = DsEmailSmsGuiToanBo::STATUS_COMPLETE;
                else
                    $sms->DaGuiSms = DsEmailSmsGuiToanBo::STATUS_FAIL;
            }
            else
                $sms->DaGuiSms=DsEmailSmsGuiToanBo::STATUS_COMPLETE;
            $sms->save();
        } else {
            $sms->DaGuiSms = DsEmailSmsGuiToanBo::STATUS_MAX_LENG;
            $sms->save();
        }
    }

    public static function checkSms(DsEmailSmsGuiToanBo $sms)
    {
        return 1;
    }
    public static function sendTuDo($phone,$content)
    {
       echo 'gui cho '.$phone.'ket qua'.\common\components\sms\SendSms::sendSms($phone, $content)['return']."\n";
    }


}