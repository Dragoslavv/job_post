<?php
header('Content-type: application/json');

if(validateParams(array("firstname","lastname","mobileOrEmail","gender","birthday","username","password"),$_POST)){

    if( isset( $_POST['firstname'] ) && !empty( $_POST['firstname'] ) &&
        isset( $_POST['lastname'] ) && !empty( $_POST['lastname'] ) &&
        isset( $_POST['mobileOrEmail'] ) && !empty( $_POST['mobileOrEmail'] ) &&
        isset( $_POST['gender'] ) && !empty( $_POST['gender'] ) &&
        isset( $_POST['birthday'] ) && !empty( $_POST['birthday'] ) &&
        isset( $_POST['username'] ) && !empty( $_POST['username'] ) &&
        isset( $_POST['password'] ) && !empty( $_POST['password'] )
    )
    {
        $firstname = ( preg_match('/[A-Za-z]$/',$_POST['firstname'] ) == true ) ? $_POST['firstname'] : false; //firstname can only have letters
        $lastname = ( preg_match('/[A-Za-z]$/',$_POST['lastname'] ) == true ) ? $_POST['lastname'] : false; //lastname can only have letters
        $mobileOrEmail = ( filter_var( $_POST['mobileOrEmail'], FILTER_VALIDATE_EMAIL) == true || is_numeric( $_POST['mobileOrEmail']) && strlen( $_POST['mobileOrEmail'] ) <= 10 ) ? $_POST['mobileOrEmail'] : false; //mobileOrEmail checks email and checks phone, phone can only 10 numbers
        $gender = ($_POST['gender'] === 'Female' || $_POST['gender'] === 'Male' || $_POST['gender'] === 'Custom') ? $_POST['gender'] : false;
        $strSystemMaxDate = date('d-m').'-'.(date('Y') - 18); // Minimum old 18 years
        $birthday = ( preg_match("/(\d{2})\/(\d{2})\/(\d{4})$/",$_POST['birthday'] ) == true ) ? $_POST['birthday'] : false; // checks data format

        $validateBDay = ( strtotime( $birthday ) < strtotime( $strSystemMaxDate ) ) ? $birthday : false ;

        $username = ( preg_match('/[A-Za-z0-9]$/',$_POST['username'] ) == true ) ? $_POST['username'] : false; //username can only have letters or number
        $password = ( preg_match('/^.*(?=.{6,10})(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9!@#$%]+$/',$_POST['password'] ) == true ) ? $_POST['password'] : false; //password can only have  1) 6-10 characters 2) At least one alpha AND one number 3) The following special chars are allowed (0 or more): !@#$%

        if($firstname == true && $lastname == true && $mobileOrEmail == true && $gender == true && $validateBDay == true && $username == true && $password == true){
            $login = new App\Controller\UserController();
            $login->register($firstname,$lastname,$mobileOrEmail,$gender,$validateBDay,$username,$password);
        } else {
            global $logger;
            $logger->info('the registration parameters is not a valid ',$_POST);

            $arr = array('result' => 'false', 'message' => 'the registration parameters is not a valid');
            echo json_encode($arr);
        }

    } else {
        global $logger;
        $logger->info('the registration parameters are empty ',$_POST);

        $arr = array('result' => 'false', 'message' => 'the registration parameters are empty');
        echo json_encode($arr);
    }
} else {
    global $logger;
    $logger->info('the registration parameters are missing',$_POST);

    $arr = array('result' => 'false', 'message' => 'the registration parameters are missing');
    echo json_encode($arr);
}
