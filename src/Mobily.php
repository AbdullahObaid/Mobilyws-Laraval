<?php
namespace abdullahobaid\mobilywslaraval;
use App\Http\Controllers\Controller; 
class Mobily extends Controller
{
 protected static  $sender;                    
 protected static  $timeSend; 
 protected static  $dateSend;                             
 protected static  $deleteKey;                                                 
 protected static  $resultType;                  
 protected static  $viewResult;                  
 protected static  $userAccount;                  
 protected static  $passAccount;                  
 protected static  $MsgID;      

public static  function run()
{
 static::$sender      = config('mobilysms.sender');                                              
 static::$deleteKey   = config('mobilysms.deleteKey');                                                 
 static::$resultType  = config('mobilysms.resultType');                  
 static::$viewResult  = config('mobilysms.viewResult');        
 static::$MsgID       = config('mobilysms.MsgID');             
 static::$userAccount = config('mobilysms.mobile');                  
 static::$passAccount = config('mobilysms.password');  
}

public function Balance()
{
    static::run();
    $url = "http://www.mobily.ws/api/balance.php";
    $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
    $result = curl_exec($ch);
    return $result;
 }

public static function Send($numbers,$msg,$dateSend=0,$timeSend=0)
{
	static::run();
    $url = "www.mobily.ws/api/msgSend.php";
    $applicationType = "68";  
	$msgs         = $msg;
    $sender       = urlencode(static::$sender);
    $domainName   = $_SERVER['SERVER_NAME'];
    $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&numbers=".$numbers."&sender=".$sender."&msg=".$msgs."&timeSend=".$timeSend."&dateSend=".$dateSend."&applicationType=".$applicationType."&domainName=".$url."&msgId=".static::$MsgID."&deleteKey=".static::$deleteKey."&lang=3";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
    $result = curl_exec($ch);

    if($result == 5)
    {
    	return trans('mobily.wrondpassword');
    }elseif($result == 4)
    {
    	return trans('mobily.null_user_or_mobile');
    }elseif($result == 3)
    {
    	return trans('mobily.no_charge');
    }elseif($result == 2)
    {
    	return trans('mobily.no_charge_zeor');
    }elseif($result == 6)
    {
    	return trans('mobily.try_later');
    }elseif($result == 10)
    {
    	return trans('mobily.not_equeal');
    }elseif($result == 13)
    {
    	return trans('mobily.sender_not_approval');
    }elseif($result == 14)
    {
    	return trans('mobily.empty_sender');
    }elseif($result == 15)
    {
    	return trans('mobily.empty_numbers');
    }elseif($result == 16)
    {
    	return trans('mobily.empty_sender2');
    }elseif($result == 17)
    {
    	return trans('mobily.message_not_encoding');
    }elseif($result == 18)
    {
    	return trans('mobily.service_stoped');
    }elseif($result == 19)
    {
    	return trans('mobily.app_error');
    }elseif($result == 1){
    	return true;
    }
}

 
}
