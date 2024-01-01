<?php

define("MAIN_PATH",dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define("URL","http://127.0.0.1/my-projects/hr-sys");
session_start();
require_once MAIN_PATH."config/db.php";
require_once MAIN_PATH."core/functions.php";
echo "hi config";