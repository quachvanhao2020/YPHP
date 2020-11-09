<?php
namespace YPHP;

class SERVER{

    public static function ROOT_URL(string $append = null){
        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        if($append) return $root.$append;
        return $root;
    }

    public static function FILES_UPLOAD(){

        $files = $_FILES;
        $files2 = [];
        foreach ($files as $input => $infoArr) {
            $filesByInput = [];
            foreach ($infoArr as $key => $valueArr) {
                if (is_array($valueArr)) { // file input "multiple"
                    foreach($valueArr as $i=>$value) {
                        $filesByInput[$i][$key] = $value;
                    }
                }
                else { // -> string, normal file input
                    $filesByInput[] = $infoArr;
                    break;
                }
            }
            $files2 = array_merge($files2,$filesByInput);
        }
        $files3 = [];
        foreach($files2 as $file) { // let's filter empty & errors
            if (!$file['error']) $files3[] = $file;
        }
        return $files3;

    }

    public static function HTTP_HOST(){

        return $_SERVER['HTTP_HOST'];
    
    }

    public static function HTTP_COOKIE(){

        return $_SERVER['HTTP_COOKIE'];
    
    }

    public static function HTTP_USER_AGENT(){

        return $_SERVER['HTTP_USER_AGENT'];
    
    }

    public static function HTTP_AUTHORIZATION(){

        return $_SERVER['HTTP_AUTHORIZATION'];
    
    }

    public static function GET_IP_ADDRESS() {

        if (!empty($_SERVER['HTTP_CLIENT_IP']) && 
        self::VALIDATE_IP($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
    
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (self::VALIDATE_IP($ip))
                        return $ip;
                }
            }
            else {
                if (self::VALIDATE_IP($_SERVER['HTTP_X_FORWARDED_FOR']))
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED']) && self::VALIDATE_IP($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && self::VALIDATE_IP($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && self::VALIDATE_IP($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        if (!empty($_SERVER['HTTP_FORWARDED']) && self::VALIDATE_IP($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];
    
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function VALIDATE_IP($ip) {

        if (strtolower($ip) === 'unknown')
            return false;
    
        // Generate IPv4 network address
        $ip = ip2long($ip);
    
        // If the IP address is set and not equivalent to 255.255.255.255
        if ($ip !== false && $ip !== -1) {
            // Make sure to get unsigned long representation of IP address
            // due to discrepancies between 32 and 64 bit OSes and
            // signed numbers (ints default to signed in PHP)
            $ip = sprintf('%u', $ip);
    
            // Do private network range checking
            if ($ip >= 0 && $ip <= 50331647)
                return false;
            if ($ip >= 167772160 && $ip <= 184549375)
                return false;
            if ($ip >= 2130706432 && $ip <= 2147483647)
                return false;
            if ($ip >= 2851995648 && $ip <= 2852061183)
                return false;
            if ($ip >= 2886729728 && $ip <= 2887778303)
                return false;
            if ($ip >= 3221225984 && $ip <= 3221226239)
                return false;
            if ($ip >= 3232235520 && $ip <= 3232301055)
                return false;
            if ($ip >= 4294967040)
                return false;
        }
        return true;
    }

}