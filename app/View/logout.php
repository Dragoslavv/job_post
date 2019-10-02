<?php

header('Content-type: application/json; charset=utf-8');
Session::name("Sensations");
Session::start();

$session = (isset($_SESSION) && isset($_SESSION['tokens']) && !empty($_SESSION['tokens'])) ? $_SESSION['tokens'] : NULL;

$login = new App\Controller\UserController();

if($login->logout($session,3600)){
    $response['status'] = true;
    $response['tokens'] = $session;
    echo json_encode($response);
}