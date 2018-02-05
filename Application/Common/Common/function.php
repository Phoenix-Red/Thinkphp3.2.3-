<?php

function getpage($count, $pagesize = 8) {
	$p = new Think\Page($count, $pagesize);
	$p -> setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
	$p -> setConfig('prev', '上一页');
	$p -> setConfig('next', '下一页');
	$p -> setConfig('last', '末页');
	$p -> setConfig('first', '首页');
	$p -> setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	$p -> lastSuffix = false;
	return $p;
}


function tranTime($time) { 
    $rtime = date("Y-m-d H:i", $time); 
    $htime = date("H:i", $time); 
    $time = time() - $time; 
    if ($time < 60) { 
        $str = '刚刚'; 
    } elseif ($time < 60 * 60) { 
        $min = floor($time / 60); 
        $str = $min . '分钟前'; 
    } elseif ($time < 60 * 60 * 24) { 
        $h = floor($time / (60 * 60)); 
        $str = $h . '小时前 ' . $htime; 
    } elseif ($time < 60 * 60 * 24 * 3) { 
        $d = floor($time / (60 * 60 * 24)); 
        if ($d == 1) 
            $str = '昨天 ' . $htime; 
        else 
            $str = '前天 ' . $htime; 
    } 
    else { 
        $str = $rtime; 
    } 
    return $str; 
}	


// 获取ip地址
	
function getIpaddr($ip,$newIP){
    if(!isset($newIP)){
    	$newIP = new \Org\Util\IP();
	}
    if ($ip == '127.0.0.1' || $ip == '0.0.0.0')
    	$data = '本机地址';
    else
    {
        $ip = $newIP -> find($ip);
        for ($i=1; $i < count($ip) ; $i++) {
            if($ip[$i] != $ip[$i-1])$data  = $data .$ip[$i];
        }
    }
    return $data;
}
// 获取操作系统
function getOS() {
	$os = '';
	$Agent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('win', $Agent) && strpos($Agent, '95')) {
		$os = 'Win 95';
	} elseif (preg_match('win 9x', $Agent) && strpos($Agent, '4.90')) {
		$os = 'Win ME';
	} elseif (preg_match('win', $Agent) && preg_match('98', $Agent)) {
		$os = 'Win 98';
	} elseif (preg_match('win', $Agent) && preg_match('nt 5.0', $Agent)) {
		$os = 'Win 2000';
	} elseif (preg_match('win', $Agent) && preg_match('nt 6.0', $Agent)) {
		$os = 'Win Vista';
	} elseif (preg_match('win', $Agent) && preg_match('nt 6.1', $Agent)) {
		$os = 'Win 7';
	} elseif (preg_match('win', $Agent) && preg_match('nt 5.1', $Agent)) {
		$os = 'Win XP';
	} elseif (preg_match('win', $Agent) && preg_match('nt 6.2', $Agent)) {
		$os = 'Win 8';
	} elseif (preg_match('win', $Agent) && preg_match('nt 6.3', $Agent)) {
		$os = 'Win 8.1';
	} elseif (preg_match('win', $Agent) && preg_match('nt 10', $Agent)) {
		$os = 'Win 10';
	} elseif (preg_match('win', $Agent) && preg_match('nt', $Agent)) {
		$os = 'Win NT';
	} elseif (preg_match('win', $Agent) && preg_match('32', $Agent)) {
		$os = 'Win 32';
	} elseif (preg_match('Mi', $Agent)) {
		$os = '小米';
	} elseif (preg_match('Android', $Agent) && preg_match('LG', $Agent)) {
		$os = 'LG';
	} elseif (preg_match('Android', $Agent) && preg_match('M1', $Agent)) {
		$os = '魅族';
	} elseif (preg_match('Android', $Agent) && preg_match('MX4', $Agent)) {
		$os = '魅族4';
	} elseif (preg_match('Android', $Agent) && preg_match('M3', $Agent)) {
		$os = '魅族';
	} elseif (preg_match('Android', $Agent) && preg_match('M4', $Agent)) {
		$os = '魅族';
	} elseif (preg_match('Android', $Agent) && preg_match('Huawei', $Agent)) {
		$os = '华为';
	} elseif (preg_match('Android', $Agent) && preg_match('HM201', $Agent)) {
		$os = '红米';
	} elseif (preg_match('Android', $Agent) && preg_match('KOT', $Agent)) {
		$os = '红米4G版';
	} elseif (preg_match('Android', $Agent) && preg_match('NX5', $Agent)) {
		$os = '努比亚';
	} elseif (preg_match('Android', $Agent) && preg_match('vivo', $Agent)) {
		$os = 'Vivo';
	} elseif (preg_match('Android', $Agent)) {
		$os = 'Android';
	} elseif (preg_match('linux', $Agent)) {
		$os = 'Linux';
	} elseif (preg_match('unix', $Agent)) {
		$os = 'Unix';
	} elseif (preg_match('iPhone', $Agent)) {
		$os = '苹果';
	} else if (preg_match('sun', $Agent) && preg_match('os', $Agent)) {
		$os = 'SunOS';
	} elseif (preg_match('ibm', $Agent) && preg_match('os', $Agent)) {
		$os = 'IBM OS/2';
	} elseif (preg_match('Mac', $Agent) && preg_match('PC', $Agent)) {
		$os = 'Macintosh';
	} elseif (preg_match('PowerPC', $Agent)) {
		$os = 'PowerPC';
	} elseif (preg_match('AIX', $Agent)) {
		$os = 'AIX';
	} elseif (preg_match('HPUX', $Agent)) {
		$os = 'HPUX';
	} elseif (preg_match('NetBSD', $Agent)) {
		$os = 'NetBSD';
	} elseif (preg_match('BSD', $Agent)) {
		$os = 'BSD';
	} elseif (preg_match('OSF1', $Agent)) {
		$os = 'OSF1';
	} elseif (preg_match('IRIX', $Agent)) {
		$os = 'IRIX';
	} elseif (preg_match('FreeBSD', $Agent)) {
		$os = 'FreeBSD';
	} elseif ($os == '') {
		$os = 'Unknown';
	}
	return $os;
}

/**
 * 验证码检查
 */
function check_verify($code, $id = "") {
	$verify = new \Think\Verify();
	return $verify -> check($code, $id);
}

/**
 * 获取当前日期
 */
function getNowDate() {
	return date("Y-m-d");
}

/**
 * 手机号码
 */
function isPhone($val) {

	if (preg_match("^1[1-9][0-9]{9}$", $val))
		return true;
	return false;

}

/*
 * 获取浏览器信息
 */
function getUserBrowser() {
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Maxthon')) {
		$browser = 'Maxthon';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 12.0')) {
		$browser = 'IE12.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 11.0')) {
		$browser = 'IE11.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10.0')) {
		$browser = 'IE10.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) {
		$browser = 'IE9.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) {
		$browser = 'IE8.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
		$browser = 'IE7.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) {
		$browser = 'IE6.0';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'NetCaptor')) {
		$browser = 'NetCaptor';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
		$browser = 'Netscape';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Lynx')) {
		$browser = 'Lynx';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
		$browser = 'Opera';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
		$browser = 'Chrome';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
		$browser = 'Firefox';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
		$browser = 'Safari';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iphone') || strpos($_SERVER['HTTP_USER_AGENT'], 'ipod')) {
		$browser = 'iphone';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
		$browser = 'iphone';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'android')) {
		$browser = 'android';
	} else {
		$browser = 'other';
	}
	return $browser;
}

function getAgent() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	return $agent;
}



function is_ip($str) {
	$ip = explode('.', $str);
	for ($i = 0; $i < count($ip); $i++) {
		if ($ip[$i] > 255) {
			return false;
		}
	}
	return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
}



/**
 * 字符串截取，支持中文和其他编码
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
	if (function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
	elseif (function_exists('iconv_substr')) {
		$slice = iconv_substr($str, $start, $length, $charset);
		if (false === $slice) {
			$slice = '';
		}
	} else {
		$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("", array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice . '...' : $slice;
}

/*
 * 删除缓存方法
 */
function delFileByDir($dir) {
	$dh = opendir($dir);
	while ($file = readdir($dh)) {
		if ($file != "." && $file != "..") {

			$fullpath = $dir . "/" . $file;
			if (is_dir($fullpath)) {
				delFileByDir($fullpath);
			} else {
				unlink($fullpath);
			}
		}
	}
	closedir($dh);
}
?>