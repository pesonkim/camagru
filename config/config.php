<?php

require_once 'database.php';

date_default_timezone_set('Europe/Helsinki');
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
define('RESTRICTED', true);
define('TITLE', 'Camagru');
define('MB', 1000000);
define('ADMIN', $DB_USER);
define('PSWD', $DB_PASSWORD);
