<?php

class Verify{
    private $pdo;
    private $user;
    public function __construct(){
        $this->pdo=Database::instance();
        $this->user=new User;
    }
    public static function generateLink(){
        return str_shuffle(substr(md5(time().mt_rand().time()),0,25));
    }

    public function verifyCode($targetColumn, $code){
        return $this->user->get('verification',$targetColumn,array("code"=>$code));

    }

    public function authOnly($user_id){
        $stmt=$this->pdo->prepare("SELECT * FROM `verification` WHERE user_id=:user_id ORDER BY `createdAt`");
        $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
        $stmt->execute();
        $user=$stmt->fetch(PDO::FETCH_OBJ);
        $files=array("verification.php");

        if(!$this->user->is_log_in()){
            redirect_to(url_for("index"));
        }

        if(!empty($user)){
            if ($user->status=='0' && !in_array(basename($_SERVER['SCRIPT_NAME']),$files)) {
                redirect_to(url_for('verification'));
            } else if($user->status=='1' && !in_array(basename($_SERVER['SCRIPT_NAME']),$files)){
                redirect_to(url_for('home'));
                
            }
        }else if(!in_array(basename($_SERVER['SCRIPT_NAME']), $files)){
            redirect_to(url_for('verification'));
        }

    }
    public function sendToMail($email,$message,$subject){
        $mail= new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth=true;
        $mail->SMTPDebug=0;
        $mail->Host=M_HOST;
        $mail->Username=M_USERNAME;
        $mail->Password=M_PASSWORD;
        $mail->SMTPSecure=M_SMTPSECURE;
        $mail->Port=M_PORT;

        if(isset($email) && !empty($email)){
            $mail->From="aktureference@gmail.com";
            $mail->FromName="aktureference";
            $mail->addReplyTo="no-reply@gmail.com";
            $mail->addAddress($email);

            $mail->Subject=$subject;
            $mail->Body=$message;
            $mail->AltBody=$message;
            if(!$mail->send()){
                return false;
            }else{
                return true;
            }
        }
    }

}