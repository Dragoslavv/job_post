<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

$response = array();


if(validateParams(array("title","description","email"),$_POST)){


    if( isset( $_POST['title'] ) && !empty( $_POST['title'] ) &&
        isset( $_POST['description'] ) && !empty( $_POST['description'] ) &&
        isset( $_POST['email'] ) && !empty( $_POST['email'])
    )
    {
        $title = ( preg_match('/^[a-zA-Z\-,.!? ]+$/',$_POST['title'] ) == true ) ? $_POST['title'] : false;
        $description = ( preg_match('/^[a-zA-Z0-9\-+,.!? ]+$/',$_POST['description'] ) == true ) ? $_POST['description'] : false;
        $email = (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))?$_POST['email']:false;

        if($title !== false && $description !== false && $email !== false){

            $posts = new \App\Controller\PostsController();
            $data = $posts->posts($title, $description, $email);

            $response['data'] = $data;
            $response['message'] = 'Successful created your post';

        }else {

            global $logger;
            $logger->info('Title, Description or email is not a valid ',$_POST);

            $response['data'] = false;
            $response['message'] = 'Title, Description or email is not a valid';

        }

    } else {
        global $logger;
        $logger->info('Parameters are empty ',$_POST);

        $response['data'] = false;
        $response['message'] = 'Parameters are empty';

    }

} else {

    global $logger;
    $logger->info('Missing parameter',$_POST);
    $response['data'] = false;
    $response['message'] = 'Missing parameter';

}
echo json_encode($response);
