<?php
namespace common\components\sms;
require_once('lib/nusoap.php');
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 3/27/2017
 * Time: 2:51 PM
 */
class SendSms
{
   public static function sendSms($phone,$content)
    {
        $params = array(
            'msisdn'            => $phone, // phone number 84 ....
            'brandname'         => \Yii::$app->params['brainame'], // brandname
            'msgbody'           => $content,  //content
            'user'              =>  \Yii::$app->params['user'],
            'pass'              => \Yii::$app->params['password']
        );

        $nameFunc = 'SendMT';

        $url = 'http://123.31.17.225:8484/AgentSMS/AntitApi?wsdl';

        $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
        $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
        $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
        $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

        $client = new \nusoap_client($url, 'wsdl',
            $proxyhost, $proxyport, $proxyusername, $proxypassword);

        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        }

        $result = $client->call($nameFunc, array('parameters' => $params), '', '', false, true);
        // Check for a fault  SendMTResult
        return $result;
    }
}