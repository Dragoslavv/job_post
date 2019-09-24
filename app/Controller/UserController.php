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


    public function login($param){
        var_dump($param);
        global $logger;

        $logger->info('User Controller');

    }

    public function logout($param){
        var_dump($param);
        global $logger;

        $logger->info('User Controller');

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