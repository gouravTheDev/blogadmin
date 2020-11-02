<?php
/*if(isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)=="siliconpin.com" && isset($_POST['SILICONID'])){
$_SESSION['EMAIL']=$_POST['EMAIL'];
}
elseif(isset($_POST['e']) && $_POST['e']=="app" && isset($_POST['SILICONID'])){

}*/
if(isset($_POST['e']) && $_POST['e']=="app" && isset($_POST['SILICONID']) && isset($_POST['EMAIL'])){
    setcookie('EMAIL', $_POST['EMAIL'], time() + (86400 * 30), "/"); // 86400 = 1 day
    }
elseif(isset($_POST['SILICONID']) && isset($_POST['EMAIL'])){
    $_SESSION['EMAIL']=$_POST['EMAIL'];

}

if(isset($_POST['SignOut'])){
session_unset();
}
