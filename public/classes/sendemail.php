<?php

include "send_mail.php";

//$sender = $_POST['nombre'].' <'.$_POST['email'].'>';
$sender = $_POST['email'];
$receiver = 'mail@pajarraco.com;admision@ciucuracao.info';
$subject = 'Información de Planilla';

$rp = $_GET["rp"];

if ($rp == "2") {
    $message_back = '<html><head><title>Bienvenido a la Caribbean International University</title></head><body><h1>Bienvenido a la Caribbean International University</h1><p>Gracias por tomarse un tiempo para introducir sus datos, usted eligió el curso de (debe aparecer el curso que el eligió), una persona de nuestro personal de Admisión se comunicar a con usted a las tal horas (lo que el indicó), por favor haga todo lo posible para atender dicha llamada, recuerde que se le harán una serie de preguntas para seguir el proceso de inscripción.</p><p><strong>Gracias y hasta luego</strong></p></body></html>';
    $message = '<html><head><title>Información de Planilla Primera Parte</title></head><body><p>Información de la persona:</p>';
    foreach ($_POST as $campo => $valor) {
        $message .= $campo . '= ' . $valor . '<br>';
    }
    $message .='<p></p></body></html>';
} else {
    $message_back = '<html><head><title>Información CIU Curacao</title></head><body><p>Su informacion se ha enviado con exito</p><div align="center"><strong>Muchas Gracias!</strong><br /><br /><strong> Nos pondremos en contacto con usted a la brevedad.</strong></body></html>';
    $message = '<html><head><title>Información de Planilla Segunda Parte</title></head><body><p>Información de la persona:</p>';
    foreach ($_POST as $campo => $valor) {
        $message .= $campo . '= ' . $valor . '<br>';
    }
    $message .='<p></p></body></html>';
}

//$message = 'hola';
//$message_back = 'hola back';
$send_mail = new SendMail($sender, $receiver, $subject, $message, $message_back);
$send_mail->send_mail();

$action = "ok";

$goTo = "http://lab.pajarraco.com/ciu/academico/inscripcion/panilla3.html?action=" . $action;

header(sprintf("Location: %s", $goTo));
?>