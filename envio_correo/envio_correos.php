<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


//Instantiation and passing `true` enables exceptions

class EnvioEmails
{
    function enviar($to, $to2 = '', $file = '', $from = '', $asunto = '', $body = '', $directorio = '', $to3 = array())
    {

        try {
            $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = 0;                             //Enable verbose debug output 2
            $mail->isSMTP();                                      //Send using SMTP
            $mail->SMTPAuth   = true;                             //Enable SMTP authentication
            $mail->SMTPSecure = 'tls';
            $mail->CharSet = 'UTF-8';
            $mail->Host       = 'smtp.office365.com';               //Set the SMTP server to send through smtp.gmail.com
            $mail->Username   = 'digital@acycia.com';               //SMTP username
            $mail->Password   = 'ACada@21';                         //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   //Enable tls encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587; //25                        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above     
            $mail->SMTPKeepAlive = true;
            $mail->Mailer = "smtp";


            //Recipients
            $mail->setFrom('digital@acycia.com', $from);
            $mail->addAddress($to, 'Sistemas');     //Si quiero enviar a otros email simplemente copio esta linea
            if ($to2 != '') {
                $mail->addAddress($to2, 'Ventas');
            }
            
            if(sizeof($to3) > 0){
                foreach ($to3 as $value) {
                    $mail->addAddress($value, 'Ventas');
                }
            }
            /* $mail->addAddress('robinrt144@gmail.com');               //Name is optional
            $mail->addReplyTo('info@acycia.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            //Attachments
            $directorio = ROOT . $directorio . $file;

            if ($file != '') {
                $mail->addAttachment($directorio);         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name  
            }

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = $body . ' 
            <br><br>
            <br><br>
            <br><br>
            <br><br>
            POLITICA DE PROTECCION DE DATOS. <br><br>
            Con el propósito de dar cumplimiento a las disposiciones consagradas en la Ley 1581 de 2012 y Decreto Reglamentario de 2013 y las demás normas que les sean complementarias y un adecuado tratamiento a sus datos y de la Entidad que representa, agradecemos por este medio nos autorice de manera libre y voluntaria para realizar el tratamiento de datos, consulta SARLAFT y continuar contactándolo con fines comerciales. En el evento que no desee que sus datos y los de su organización sean tratados por favor comunicarlo por este medio para ser retirado de nuestra base de datos.<br><br>
            
            Consulta nuestra política de protección de datos personales en www.acycia.com y tenga  presente que segun sus derechos de habeas data a consultar, actualizar, corregir, rectificar, suprimir sus datos o revocar su autorización, tenemos a su disposición el correo electrónico info@acycia.com <br>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';         

            $confirmacion = $mail->send();
            return $confirmacion;
            //echo 'El mensaje ha sido enviado'; 
        } catch (Exception $e) {
            return $e;
            echo "El mensaje no se ha podido enviar, error:  {$mail->ErrorInfo}";
        }
    }
}
