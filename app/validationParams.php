<?php

function validateParams($name_array, $request){

    foreach ($name_array as $param){
        if(!isset($request[$param])){
            return false;
        }
    }
    return true;
}