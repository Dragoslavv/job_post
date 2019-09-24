<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//autoload
require_once "vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use App\Database\Database as Database;

// Create the logger
$logger = new Logger('sensations-logger');

$logger->pushHandler(new StreamHandler('/var/log/sensations_debug.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());

//DB instance
$db = Database::getInstance();

//controller
if(isset($_GET['url']) && !empty($_GET['url'])){
    if(file_exists('app/View/'.$_GET['url'].'.php')){
        require_once 'app/View/'.$_GET['url'].'.php';
    } else {
        header('X-PHP-Response-Code: 500', true, 500);
        exit;
    }
} else {
    header('X-PHP-Response-Code: 500', true, 500);
    exit;
}