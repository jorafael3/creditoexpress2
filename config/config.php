<?php
// $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$u = "$_SERVER[HTTP_HOST]";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $_SERVER['HTTPS'] = 'on';
    $http = "https://";
} else {
    $http = "http://";
}
// echo $u;
define('URL',$http.$u.'/creditoexpress2/');// ip local:puerto
// define('HOST', '10.5.1.86');
// define('DB', 'CARTIMEX');
// define('USER', 'jalvarado');
// define('PASSWORD', 'jorge123');
// define('CHARSET', 'utf8mb4');


define('HOST', '127.0.0.1');
define('DB', 'crediweb');
define('USER', 'root');
define('PASSWORD', '');
define('CHARSET', 'utf8mb4');

// define('HOST', '10.5.1.86');
// define('USER', 'jalvarado');
// define('PASSWORD', 'jorge123');
