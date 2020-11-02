<?php

define("APP_PATH", getcwd());
define("APP_DIR", __DIR__);
$url = explode('/', $_SERVER['REQUEST_URI']);
include('CONFIG/settings.php');
include('DIZ/engine.php');

// echo APP_DIR,$inc;
 ?>
