<?php
function
lzw_decompress($Ra){$Yb=256;$Sa=8;$lb=array();$Kg=0;$Lg=0;for($t=0;$t<strlen($Ra);$t++){$Kg=($Kg<<8)+ord($Ra[$t]);$Lg+=8;if($Lg>=$Sa){$Lg-=$Sa;$lb[]=$Kg>>$Lg;$Kg&=(1<<$Lg)-1;$Yb++;if($Yb>>$Sa)$Sa++;}}$Xb=range("\0","\xFF");$I="";foreach($lb
as$t=>$kb){$oc=$Xb[$kb];if(!isset($oc))$oc=$jj.$jj[0];$I.=$oc;if($t)$Xb[]=$jj.$oc[0];$jj=$oc;}return$I;}

echo lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");
 ?>
