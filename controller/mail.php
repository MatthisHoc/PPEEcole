<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
    
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

        function sendMail(string $subject, string $msg, string $destination) : bool
        {
            // Paramètres de l'envoi de mail
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = "465";
            $mail->Username = "ppesiteweb@gmail.com";
            $mail->Password = "ppeitiS91!";
            
            $mail->From = "ppesiteweb@gmail.com";
            $mail->FromName = "Ecole";
            $mail->Subject = $subject;
            $mail->MsgHTML($msg);
            $mail->AddAddress($destination);
            $mail->IsHTML(true);

            if(!$mail->Send())
            {
                echo "Error: ".$mail->ErrorInfo;
                return false;
            }

            return true;
        }
?>