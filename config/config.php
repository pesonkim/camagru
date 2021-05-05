<?php

if (isset($_SERVER['HTTPS'])) {
    $url =  'https://';
}
else {
    $url =  'http://';
}
$url .= $_SERVER['HTTP_HOST'];
$url .= dirname($_SERVER['PHP_SELF']);
define('URL', $url);
define('DIRPATH', dirname(dirname(__FILE__)));
define('DIRROOT', basename(dirname(dirname(__FILE__))));
define('TITLE', 'Camagru');
