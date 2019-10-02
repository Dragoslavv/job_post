<?php

header('Content-type: application/json; charset=utf-8');
Session::name("SENSATIONS");
Session::start();

$session = (isset($_SESSION) && isset($_SESSION['session_tokens']) && !empty($_SESSION['session_tokens'])) ? $_SESSION['session_tokens'] : NULL;

$login = new App\Controller\UserController();

if($login->logout($session,3600)){
    $response['status'] = true;
    $response['session_tokens'] = $session;
    echo json_encode($response);
}