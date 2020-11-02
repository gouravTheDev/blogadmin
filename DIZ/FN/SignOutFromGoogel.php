<?php
if(isset($_POST['SignOutFromGoogle'])){
    session_unset();
    // header( "refresh:0;url=https://www.google.com/" );
    header('Location: https://www.google.com/');    //echo "<h2> Sign Out Success!";
}

?>