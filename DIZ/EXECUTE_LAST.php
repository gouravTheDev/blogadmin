<?php
if(isset($_SESSION['redirectOnNextLoad']) && $_SESSION['redirectOnNextLoad'] !=""){
  $protocol=strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
  if($_SESSION['redirectOnNextLoad']=="/") $newLocation=$protocol.'://'.$_SERVER['HTTP_HOST']; else $newLocation=$_SESSION['redirectOnNextLoad'];
  $redirectTO='Location: '.$newLocation;
  $_SESSION['redirectOnNextLoad'] ="";
  header($redirectTO);
}
if(isset($_SESSION['SignOut']) && $_SESSION['SignOut'] !=""){
  session_destroy();
  header($_SESSION['SignOut']);
}

?>
