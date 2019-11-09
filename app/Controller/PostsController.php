<?php

namespace App\Controller;

use App\Model\Posts;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class PostsController extends Posts {


    public function posts( $title, $description, $email )
    {

        global $db;

        $title   = $db->escape( $title );
        $description   = $db->escape( $description );
        $email   = $db->escape( $email );


        if( $this->check($email) > 0 ) {

            $db->insert_users('INSERT INTO `jobs` (`title`, `description`, `status` , `email`) VALUES (?,?,?,?)', array($title, $description, "approve", $email),'ssss');

            return "approve";

        } else {

            $create_jobs = $db->insert_users('INSERT INTO `jobs` (`title`, `description`, `status` , `email`) VALUES (?,?,?,?)', array($title, $description, "spam", $email),'ssss');

            if( $create_jobs == true ) {

                if($this->checkStatus($email)[0][0] == 'spam') {

                    if(isset($title) && isset($email) && isset($description)){

                        $messageText = file_get_contents(__DIR__ . "./../View/template/temp2.html", FILE_USE_INCLUDE_PATH);
                        $messageText = str_replace('$title', $title, $messageText);
                        $messageText = str_replace('$email', $email, $messageText);
                        $messageText = str_replace('$description',  $description, $messageText);

                        $messageText2 = file_get_contents(__DIR__ . "./../View/template/temp1.html", FILE_USE_INCLUDE_PATH);
                        $messageText2 = str_replace('$title', $title, $messageText2);
                        $messageText2 = str_replace('$email', $email, $messageText2);
                        $messageText2 = str_replace('$description',  $description, $messageText2);


                    $this->sendEmail('gagipredojevic65@gmail.com','Globaltel93Gagi','Job Post',
                        'gagipredojevic65@gmail.com', 'gagipredojevic65@gmail.com','Job Post',$messageText);

                        $this->sendEmail('gagipredojevic65@gmail.com','Globaltel93Gagi','Job Post',
                            $email, $email,'Job Post',$messageText2);

                    return "spam";
                    }

                }

            }

            return false;

        }

    }

    public function check ($email) {

        global $db;

        $check = $db->select("SELECT email FROM `jobs` WHERE `email` = '".$email."' AND `status` ='approve' ");

        return $check;

    }


    public function checkStatus ($email) {

        global $db;

        $check = $db->select("SELECT status FROM `jobs` WHERE `email` = '".$email."' ");

        return $check;

    }

    public function readJob () {

        global $db;

        $check = $db->select("SELECT * FROM `jobs` WHERE `status` = 'approve' ");

        return $check;

    }

    public function updateStatus ($is_active,$email) {

        global $db;

        return  $db->update_users( "UPDATE `jobs` SET `status` = ? WHERE `email`= ? LIMIT 1",array($is_active, $email),"ss");

    }

    public function delete ($email) {

        global $db;

        $delete =  $db->remove( "DELETE FROM `jobs` WHERE `email` = ? AND `status` != 'approve'",array( $email),"s");

        if($delete){
            return true;
        }

        return false;
    }
    public function sendEmail($user,$pass,$name,$setFrom, $addAddress, $subject, $body){

        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = 'utf-8';
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->Username = $user;
            $mail->Password = $pass;
            $mail->SetFrom($setFrom);
            $mail->FromName = $name;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->addAddress($addAddress);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();

            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}