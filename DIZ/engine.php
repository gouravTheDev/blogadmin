<?php
session_start();
$url = explode('/', $_SERVER['REQUEST_URI']);
$FormReply= new stdClass();
$Notify= new stdClass();
// if($_SERVER['SERVER_NAME']===DOMAIN_NAME) include "CONFIG/config.php"; else include "CONFIG/config-local.php";
$origin = $_SERVER['SERVER_NAME'];
$domain_names = [
    'franchisee.beanstalkedu.com',
    'frp.teenybeans.in'
];
if (in_array($origin, $domain_names)){
  include "CONFIG/config.php";
}else{
  include "CONFIG/config-local.php";
}

$GLOBALS['alert_info']="";$GLOBALS['post_info']="";
$_SESSION['s_Hash'] = md5(session_id());

foreach (glob("DIZ/FN/*.php") as $filename) include $filename; //to include DIZ-PHP's built-in functions
foreach (glob("CONTENT/FN_C/*.php") as $filename) include $filename; //to include this APP's functions
include "EXECUTE_LAST.php";
if(!isset($_SESSION['LoggedIn'])) $_SESSION['LoggedIn']=false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['FORM_NAME']) && $_POST['FORM_NAME']!==""){
      // Some security implementation needed
      $form_processor="CONTENT/POST_ACTION/".$_POST['FORM_NAME'].".php";
      if(file_exists($form_processor)) include $form_processor; else { $FormReply->info = "Form handler not found !"; }//Ajax Form Notification
  }else {$FormReply->info = "Form handler not Defiened !";}
}

function DgetBrowser() // uc like ... N/A and isset a varible
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'N/A';
    $platform = 'N/A'; $P_Mob = 'Non Mobile';
    $version= "";

    //First get the platform?
    if     (preg_match('/Mobile/i', $u_agent)) { $P_Mob = 'Mobile';    }
	  if     (preg_match('/Android/i', $u_agent) || (preg_match('/Adr/i', $u_agent)&&preg_match('/UCBrowser/i',$u_agent)) ) { $platform = 'Android';    }
    elseif (preg_match('/linux/i', $u_agent)) { $platform = 'linux';    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac';    }
    //elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows';    }
    elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'Windows';
    if     (preg_match('/NT 6.2/i', $u_agent)) { $platform .= ' 8'; }
    elseif (preg_match('/NT 6.4/i', $u_agent)) { $platform .= ' 10'; }
    elseif (preg_match('/NT 6.3/i', $u_agent)) { $platform .= ' 8.1'; }
    elseif (preg_match('/NT 6.1/i', $u_agent)) { $platform .= ' 7'; }
    elseif (preg_match('/NT 6.0/i', $u_agent)) { $platform .= ' Vista'; }
    elseif (preg_match('/NT 5.1/i', $u_agent)) { $platform .= ' XP'; }
    elseif (preg_match('/NT 5.0/i', $u_agent)) { $platform .= ' 2000'; }
    if (preg_match('/WOW64/i', $u_agent) || preg_match('/x64/i', $u_agent)) { $platform .= ' (x64)'; }
    }
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';  $ub = "MSIE";
    }
  	elseif(preg_match('/OPR/i',$u_agent))     { $bname = 'Opera Mini'; $ub = "Opera"; }
  	elseif(preg_match('/UCBrowser/i',$u_agent))     { $bname = 'UCBrowser'; $ub = "Webkit"; }
  	elseif(preg_match('/Firefox/i',$u_agent))     { $bname = 'Mozilla Firefox'; $ub = "Firefox"; }
    elseif(preg_match('/Chrome/i',$u_agent))     { $bname = 'Google Chrome'; $ub = "Chrome"; }
    elseif(preg_match('/Mobile Safari/i',$u_agent))     { $bname = 'Mobile-Safari'; $ub = "Webkit"; } // Mobile Safari=> Android 4+ built in brawser
	  elseif(preg_match('/Safari/i',$u_agent))     { $bname = 'Apple Safari'; $ub = "Safari"; }
    elseif(preg_match('/Opera/i',$u_agent))     { $bname = 'Opera'; $ub = "Opera"; }
    elseif(preg_match('/Netscape/i',$u_agent))     { $bname = 'Netscape'; $ub = "Netscape"; } //else $ub='N/A';
    if($bname == 'Apple Safari' && $platform = 'Android') $bname = 'Android Safari';  //differentiate we named as Android-safari
    // finally get the correct version number
    $known = array('Version', $ub, 'UCBrowser', 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= isset($matches['version'][0]) ? $matches['version'][0]: null;
        }
        else {
            $version= isset($matches['version'][1]) ? $matches['version'][1]: null;
        }
    }
    else {
        $version= isset($matches['version'][0]) ? $matches['version'][0]: null;
    }

  // check if we have a number
  if ($u_agent==null || $u_agent=="") {$u_agent="N/A";}
	if ($bname==null || $bname=="") {$bname="N/A";}
	if ($version==null || $version=="") {$version="N/A";}
	if ($platform==null || $platform=="") {$platform="N/A";}

   return array(
    //'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'Device'  	=> $P_Mob,
    //'pattern'   => $pattern
    'U_PuIP'		=>$_SERVER['REMOTE_ADDR'],
    'U_Port'		=>$_SERVER['REMOTE_PORT'],

    );
	//return json_encode(array);
	//$en=json_encode($ua);
	//return $ua;
	//$res=json_decode($ua); echo $res;
}

function Dget_client_ip_address() {
    // check for shared internet/ISP IP
    //$_SERVER[HTTP_X_REAL_IP]
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}

//function to perform DreportLog(Report_Type,File & Details)
function DreportLog($Report_Type,$Details,$File)
{
  $dir=__DIR__."/LOG";//echo $dir;
  if(!is_dir($dir))mkdir($dir);if(!is_dir($dir."/".$Report_Type))mkdir($dir."/".$Report_Type); //die($Report_Type);
  $report_info=new stdClass();
  $report_info -> Type= $Report_Type;
  $report_info -> Details= $Details;
  $report_info -> File= $File;
  if(isset($_SERVER['HTTP_USER_AGENT']))$report_info -> HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
  if(isset($_SERVER['REQUEST_URI']))$report_info -> REQUEST_URI = $_SERVER['REQUEST_URI'];
  if(isset($_SERVER['HTTP_REFERER']))$report_info -> HTTP_REFERER = $_SERVER['HTTP_REFERER'];
    // $ip="";
    //   if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    //     $ip = $_SERVER['HTTP_CLIENT_IP'];
    // } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    // } else {
    //     $ip = $_SERVER['REMOTE_ADDR'];
    // }

  $report_info -> ip= Dget_client_ip_address();
  $myfile = fopen(__DIR__."/LOG/".$Report_Type."/".time()."-".rand(100,999).".log", "w") or die("Unable to open file!");
  $txt = json_encode($report_info);
  fwrite($myfile, $txt);
  fclose($myfile);
}

if(isset($url[F_D+2]) && file_exists("CONTENT/ROOT_URI/".$url[F_D+1]."/index.php")) {$inc=$url[F_D+1];
  if(isset($url[F_D+3]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+2]."/index.php")) {$inc=$inc."/".$url[F_D+2];
    if(isset($url[F_D+4]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+3]."/index.php")) {$inc=$inc."/".$url[F_D+3];
      if(isset($url[F_D+5]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+4]."/index.php")) {$inc=$inc."/".$url[F_D+4];
        if(isset($url[F_D+6]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+5]."/index.php")) {$inc=$inc."/".$url[F_D+5];
          if(isset($url[F_D+7]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+6]."/index.php")) {$inc=$inc."/".$url[F_D+6];
            if(isset($url[F_D+8]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+7]."/index.php")) {$inc=$inc."/".$url[F_D+7];
              if(isset($url[F_D+9]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+8]."/index.php")) {$inc=$inc."/".$url[F_D+8];
                if(isset($url[F_D+10]) && file_exists("CONTENT/ROOT_URI/".$inc."/".$url[F_D+9]."/index.php")) {$inc=$inc."/".$url[F_D+9];
                  $lnk=$url[F_D+10];
                  include "CONTENT/ROOT_URI/".$inc."/index.php";
                  }
                else {$lnk=$url[F_D+9];include "CONTENT/ROOT_URI/".$inc."/index.php";}
              }
              else {$lnk=$url[F_D+8];include "CONTENT/ROOT_URI/".$inc."/index.php";}
            }
            else {$lnk=$url[F_D+7];include "CONTENT/ROOT_URI/".$inc."/index.php";}
          }
          else {$lnk=$url[F_D+6];include "CONTENT/ROOT_URI/".$inc."/index.php";}
        }
        else {$lnk=$url[F_D+5];include "CONTENT/ROOT_URI/".$inc."/index.php";}
      }
      else {$lnk=$url[F_D+4];include "CONTENT/ROOT_URI/".$inc."/index.php";}
    }
    else {$lnk=$url[F_D+3];include "CONTENT/ROOT_URI/".$inc."/index.php";}
  }
  else {$lnk=$url[F_D+2];include "CONTENT/ROOT_URI/".$inc."/index.php";}
}
else {$lnk=$url[F_D+1];include "CONTENT/ROOT_URI/index.php";}

?>
