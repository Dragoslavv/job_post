<?php
header('Content-type: application/json');

if(validateParams(array("username","password"),$_POST)){
    $login = new App\Controller\UserController();
    $login->login($_POST['username'],$_POST['password']);
} else {
    global $logger;
    $logger->info('missing parameter',$_POST);
    $arr = array('result' => 'false', 'message' => 'missing parameter');
    echo json_encode($arr);
}
