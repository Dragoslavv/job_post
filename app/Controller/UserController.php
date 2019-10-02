<?php

namespace App\Controller;

use App\Model\Users;


class UserController extends Users {

    public $server_code = '404';
    public $client_code = '404';
    public $message  = 'Not Found';

    public function __construct()
    {
        header('HTTP/1.1 ' . $this->client_code . ' ' . $this->message . " (" . $this->server_code . ")");
    }

    public function register($firstname,$lastname,$mobileOrEmail,$gender,$birthday,$username,$password,$role = 'user')
    {
        global $db;

        if(isset($role) && $role == 'admin' || isset($role) && $role == 'user'){

            $role   = $db->escape($role);
            $firstname = $db->escape($firstname);
            $lastname = $db->escape($lastname);
            $mobileOrEmail   = $db->escape($mobileOrEmail);
            $gender   = $db->escape($gender);
            $birthday   = $db->escape($birthday);
            $username   = $db->escape($username);
            $password   = $db->escape($password);



            $register = $db->select("SELECT * FROM `web_users` WHERE `username` = '".$username."'");

            $options = [
                'cost' => 11,
            ];

            $hash = password_hash($password, PASSWORD_BCRYPT, $options);

            if( $register == false ){

               $create = $db->insert_users('INSERT INTO `web_users` (`firstname`, `lastname`, `mobileOrEmail`, `gender`, `birthday`, `username`, `password`, `role`) 
                         VALUES (?,?,?,?,?,?,?,?)', array($firstname,$lastname,$mobileOrEmail,$gender,$birthday,$username,$hash,$role),'ssssssss');

               echo json_encode( array( "result" => $create ) );
            } else {
                global $logger;
                $logger->info('exists username ', $register );

                $arr = array('result' => 'false', 'message' => 'exists username');
                echo json_encode($arr);
            }
        } else {
            global $logger;
            $logger->info('role is not a valid' );

            $arr = array('result' => 'false', 'message' => 'role is not a valid');
            echo json_encode($arr);
        }

        return false;
    }

    public function login($username,$password){

        global $db;

        $username   = $db->escape($username);
        $password   = $db->escape($password);

        $hash = $db->select("SELECT `password` FROM `web_users` WHERE `username` = '".$username."'");

        $validatePassword = password_verify($password, $hash[0][0]);

        if($validatePassword == true){

            $login =  $db->select("SELECT `firstname`,`lastname`,`mobileOrEmail`,`gender`,`birthday`,`username`,`role`
                      FROM `web_users` WHERE `username` = '".$username."' AND `password` = '".$hash[0][0]."'");

            $arr = array('result' => 'true', 'data' => $login);
            echo json_encode($arr);

        } else {
            global $logger;
            $logger->info('Password is not a valid ' );

            $arr = array('result' => 'false', 'message' => 'Password is not a valid');
            echo json_encode($arr);
        }

        return false;
    }

    public function logout($unset, $lifetime)
    {

        \Session::cookie($lifetime);
        \Session::delete($unset);

        return true;
    }

    public function allUsers($param){
        var_dump($param);
        global $logger;

        $logger->info('User Controller');

    }

    public function destroy($param){
        var_dump($param);
        global $logger;

        $logger->info('User Controller');

    }

    public function role($param){
        var_dump($param);
        global $logger;

        $logger->info('User Controller');

    }
}