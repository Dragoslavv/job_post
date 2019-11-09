<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
$response = array();

$posts = new \App\Controller\PostsController();
$data = $posts->readJob();

if($data == false){
    $response['data'] = array();

} else {
    $response['data'] = $data;

}


echo json_encode($response);
