<?php
namespace backend\BLL;
use backend\models\Login;
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 10/11/2016
 * Time: 2:16 AM
 */
class LogBLL
{
    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
    function GetMAC(){
        ob_start();
        system('getmac');
        $Content = ob_get_contents();
        ob_clean();
        return substr($Content, strpos($Content,'\\')-20, 17);
    }
    function getOS() {

        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }

        }

        return $os_platform;

    }
    public function Add(Login $login)
    {
       $log=new Login();
        $log->TaiKhoan=$login->TaiKhoan;
        $log->QuyenDangNhap=$login->QuyenDangNhap;
        $log->ThanhCong=$login->ThanhCong;
        $log->IpLan=$this->get_client_ip_env();
        $log->MacAddress="unknown";
        $log->OperatingSystem=$this->getOS();
        $log->ThoiGianDangNhap=date('Y-m-d H:i:s');
        $log->Use=$log->ThoiGianDangNhap.": Đăng nhập \n";
        if($log->save())
            return true;
        else
            return false;
    }
    public function getLastListLoginFollowId()
    {

        if(Login::findOne(['TaiKhoan'=>\Yii::$app->user->id,'ThanhCong'=>1])==null) {
            $log = new Login();
            $log->TaiKhoan =\Yii::$app->user->id;
            $log->QuyenDangNhap = "Đã đăng nhập";
            $log->ThanhCong =1;
            $log->IpLan = $this->get_client_ip_env();
            $log->MacAddress ="unknown";
            $log->OperatingSystem = $this->getOS();
            $log->ThoiGianDangNhap = date('Y-m-d H:i:s');
            $log->Use = $log->ThoiGianDangNhap . ": Đăng nhập \n";
            $log->save();
        }
            return Login::find()->where(['TaiKhoan'=>\Yii::$app->user->id,'ThanhCong'=>1])->max('id');

    }
    public function update($action)
    {
        $log=Login::findOne($this->getLastListLoginFollowId());
        $log->Use=$log->Use.date('Y-m-d H:i:s')." ".$action."\n";
        $log->save();
    }
}