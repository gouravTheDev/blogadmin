<?php
function D_uid($l=10,$s='0123456789'){ $str = ""; for ($x=0;$x<$l;$x++) $str .= substr(str_shuffle($s."ABCDEFGHIJKLMAOPQRSTUVWXYZ_-abcdefghijklmnopqrstuvwxyz"), 0, 1); return $str; }
// utility function to convert base 10 integer to base 58 string
function encode58($num) {
  if(is_numeric($num)){
    $alphabet = "123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
    $base = strlen($alphabet);
    $encoded = '';
    while ($num){
      $remainder = $num % $base;
      $num = floor($num / $base);
      $encoded = $alphabet[$remainder].$encoded;
    }
  } else  $encoded="N/A";

  return $encoded;
}
function D_create_UserId(){
  $currTime = time();
  $uniqueId = encode58($currTime).D_uid(2);
  return $uniqueId;
}
function D_js_alert($txt){
    echo "
    <script>
    alert('".$txt.
    "')</script>
    ";
}
function D_js_location_href($txt){
    echo "
    <script>
    window.location.href =".$txt.
    "</script>
    ";
}
function D_js_location_replace($txt){
    echo "
    <script>
    window.location.replace =".$txt.
    "</script>
    ";
}
function DaddToBsAlert($txt){
    if(strlen($txt) >1 )
    return '
    <div class="container alert alert-warning alert-dismissible fade show" role="alert">
      <strong>'.$txt.'</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
          ';
          else return '';
    // return '
    // <h2>'.$txt.'</h2>
    //       ';
}
function D_bs_alert_info($txt){
    if(strlen($txt) >1 ) echo '
    <div class="alert alert-info alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>'.$txt.'</strong>
    </div>
          ';
}
function fileNameFromPath($Path){
  $Path = explode('/', $Path);
  $Path = end($Path);
  return $Path;
}
?>
