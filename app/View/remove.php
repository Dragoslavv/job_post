<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
$response = array();


if(validateParams(array("email"),$_GET)) {


    $posts = new \App\Controller\PostsController();
    $data = $posts->delete($_GET['email']);

    if($data == true){
        header("Location: http://localhost:34409/view-job");
    }else {

        $response['data'] = false;

    }

} else {

    global $logger;
    $logger->info('Missing parameter',$_POST);
    $response['data'] = false;
    $response['message'] = 'Missing parameter';

}
echo json_encode($response);
