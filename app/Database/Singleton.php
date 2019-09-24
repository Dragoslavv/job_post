<?php
namespace App\Database;

abstract class Singleton {
    protected static $_instance;

    public static function getInstance() {
        if(!isset(self::$_instance)) { // If no instance then make one
            self::$_instance = new Database();
        }
        return self::$_instance;
    }
}