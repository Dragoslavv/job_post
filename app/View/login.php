<?php
header('Content-type: application/json');
Session::name("Sensations");
Session::start();

if(validateParams(array("username","password"),$_POST)){

    if( isset( $_POST['username'] ) && !empty( $_POST['username'] ) &&
        isset( $_POST['password'] ) && !empty( $_POST['password'] )
    )
    {
        $username = ( preg_match('/[A-Za-z0-9]$/',$_POST['username'] ) == true ) ? $_POST['username'] : false; //username can only have letters or number
        $password = ( preg_match('/^.*(?=.{6,10})(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9!@#$%]+$/',$_POST['password'] ) == true ) ? $_POST['password'] : false; //password can only have  1) 6-10 characters 2) At least one alpha AND one number 3) The following special chars are allowed (0 or more): !@#$%

        $login = new App\Controller\UserController();
        $login->login($username,$password);

    } else {
        global $logger;
        $logger->info('the login parameters are empty ',$_POST);

        $arr = array('result' => 'false', 'message' => 'the login parameters are empty');
        echo json_encode($arr);
    }

} else {

    global $logger;
    $logger->info('missing parameter',$_POST);
    $arr = array('result' => 'false', 'message' => 'missing parameter');
    echo json_encode($arr);
}
