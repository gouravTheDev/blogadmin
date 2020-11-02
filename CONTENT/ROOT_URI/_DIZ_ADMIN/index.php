<?php //var_dump($url);echo "<br>FD=",F_D,"<br>lnk=",$lnk,"<br>"; //phpinfo();
$lnk2 = explode('?', $lnk);

include("_header.php");
// var_dump($lnk2);

 if($lnk=="" || $lnk2[0]=="") include("_home.php");
   elseif(file_exists(__DIR__."/".$lnk.".php"))  include($lnk.".php");
   elseif(isset($lnk2[1]) && file_exists(__DIR__."/".$lnk2[0].".php") ) include($lnk[0].".php");
   else include("_404.php");
include("_footer.php");

?>
