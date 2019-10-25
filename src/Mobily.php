<?php
namespace abdullahobaid\mobilywslaraval;

use App\Http\Controllers\Controller;
use Str;

class Mobily extends Controller
{
    protected static $sender;
    protected static $timeSend;
    protected static $dateSend;
    protected static $deleteKey;
    protected static $resultType;
    protected static $viewResult;
    protected static $userAccount;
    protected static $passAccount;
    protected static $MsgID;

    public static function run()
    {
        static::$sender = config('mobilysms.sender');
        static::$deleteKey = config('mobilysms.deleteKey');
        static::$resultType = config('mobilysms.resultType');
        static::$viewResult = config('mobilysms.viewResult');
        static::$MsgID = config('mobilysms.MsgID');
        static::$userAccount = config('mobilysms.mobile');
        static::$passAccount = config('mobilysms.password');
    }

    public static function Balance()
    {
        static::run();
        $url = "http://www.mobily.ws/api/balance.php";
        $stringToPost = "mobile=" . static::$userAccount . "&password=" . static::$passAccount;
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

    public static function Send($numbers, $msg, $dateSend = 0, $timeSend = 0,$senderName=false)
    {
        static::run();
        $numbers = self::format_numbers($numbers);
        $url = "www.mobily.ws/api/msgSend.php";
        $applicationType = "68";
		if($senderName)
			$sender = urlencode($senderName);
		else
			$sender = urlencode(static::$sender);
        $stringToPost = "mobile=" . static::$userAccount . "&password=" . static::$passAccount . "&numbers=" . $numbers . "&sender=" . $sender . "&msg=" . $msg . "&timeSend=" . $timeSend . "&dateSend=" . $dateSend . "&applicationType=" . $applicationType . "&domainName=" . $url . "&msgId=" . static::$MsgID . "&deleteKey=" . static::$deleteKey . "&lang=3";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
        $result = curl_exec($ch);

        if ($result == 1) {
            return true;
        }
        elseif ($result == 5) {
            return trans('mobily.wrondpassword');
        } elseif ($result == 4) {
            return trans('mobily.null_user_or_mobile');
        } elseif ($result == 3) {
            return trans('mobily.no_charge');
        } elseif ($result == 2) {
            return trans('mobily.no_charge_zeor');
        } elseif ($result == 6) {
            return trans('mobily.try_later');
        } elseif ($result == 10) {
            return trans('mobily.not_equeal');
        } elseif ($result == 13) {
            return trans('mobily.sender_not_approval');
        } elseif ($result == 14) {
            return trans('mobily.empty_sender');
        } elseif ($result == 15) {
            return trans('mobily.empty_numbers');
        } elseif ($result == 16) {
            return trans('mobily.empty_sender2');
        } elseif ($result == 17) {
            return trans('mobily.message_not_encoding');
        } elseif ($result == 18) {
            return trans('mobily.service_stoped');
        } elseif ($result == 19) {
            return trans('mobily.app_error');
        }
    }

    public static function format_numbers($numbers)
    {
        if (!is_array($numbers))
            return self::format_number($numbers);
        $numbers_array = array();
        foreach ($numbers as $number) {
            $n = self::format_numbers($number);
            array_push($numbers_array, $n);
        }
        return implode(',', $numbers_array);
    }

    public static function format_number($number)
    {
        if (strlen($number) == 10 && Str::startsWith($number, '05'))
            return preg_replace('/^0/', '966', $number);
        elseif (Str::startsWith($number, '00'))
            return preg_replace('/^00/', '', $number);
        elseif (Str::startsWith($number, '+'))
            return preg_replace('/^+/', '', $number);
        return $number;
    }

    public static function count_messages($text)
    {
        $length = mb_strlen($text);
        if ($length <= 70)
            return 1;
        else
            return ceil($length / 67);
    }

}
