<?php
header('Content-type: application/json');

if(validateParams(array("test"),$_GET)){
    global $logger;
    $logger->info('info',$_GET);
    $d = new App\Controller\UserController();
    $d->login($_GET['test']);
} else {
    $arr = array('result' => 'false', 'message' => 'missing parameter');
    echo json_encode($arr);
}
