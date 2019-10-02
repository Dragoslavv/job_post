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

    public function register( $firstname, $lastname, $mobileOrEmail, $gender, $birthday, $username, $password, $role = 'user' )
    {
        global $db;

        if( isset( $role ) && $role == 'admin' || $role == 'user')
        {

            $role       = $db->escape( $role );
            $firstname  = $db->escape( $firstname );
            $lastname   = $db->escape( $lastname );
            $mobileOrEmail   = $db->escape( $mobileOrEmail );
            $gender     = $db->escape( $gender );
            $birthday   = $db->escape( $birthday );
            $username   = $db->escape( $username );
            $password   = $db->escape( $password );

            $register = $db->select("SELECT * FROM `web_users` WHERE `username` = '".$username."'");

            $options = [
                'cost' => 11,
            ];

            $hash = password_hash( $password, PASSWORD_BCRYPT, $options );

            if( $register == false )
            {

               $create = $db->insert_users('INSERT INTO `web_users` (`firstname`, `lastname`, `mobileOrEmail`, `gender`, `birthday`, `username`, `password`, `role`) 
                         VALUES (?,?,?,?,?,?,?,?)', array($firstname, $lastname, $mobileOrEmail, $gender, $birthday, $username, $hash, $role),'ssssssss');

               echo json_encode( array( "result" => $create ) );
            } else {
                global $logger;
                $logger->info('exists username ', $register );

                $arr = array('result' => 'false', 'message' => 'exists username');
                echo json_encode( $arr );
            }
        } else {
            global $logger;
            $logger->info('role is not a valid' );

            $arr = array('result' => 'false', 'message' => 'role is not a valid');
            echo json_encode($arr);
        }

        return false;
    }

    public function login( $username, $password, $session_token )
    {

        global $db;

        $username   = $db->escape( $username );
        $password   = $db->escape( $password );
        $session_token   = $db->escape( $session_token );

        $hash = $db->select("SELECT `username`,`password` FROM `web_users` WHERE `username` = '".$username."'");

        $validatePassword = password_verify( $password, $hash[0][1] );

        if( $validatePassword == true && $hash[0][0] == $username )
        {

            $login =  $db->select("SELECT `firstname`,`lastname`,`mobileOrEmail`,`gender`,`birthday`,`username`,`role`,`session_tokens`
                      FROM `web_users` WHERE `username` = '".$username."' AND `password` = '".$hash[0][1]."'");

            $db->update_users( "UPDATE web_users SET session_tokens = ? WHERE username= ? LIMIT 1",array($session_token, $hash[0][0]),"ss");

            \Session::cookie( 3600 ); //lifetime cookie
            \Session::setOneParam('session_tokens', $session_token);

            $data = array("firstname" => $login[0][0],"lastname" => $login[0][1] ,"mobileOrEmail" => $login[0][2] ,"gender" => $login[0][3] ,"birthday" => $login[0][4]
            ,"username" => $login[0][5] ,"role" => $login[0][6], "session_tokens" => $session_token);

            $arr = array('result' => 'true', 'data' => $data);
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
}