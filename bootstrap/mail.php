<?php

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
$mail->Username = '311454a76f78ef';
$mail->Password = '00f1205146552c';
$mail->setFrom('auth@localhost/7auth', '7Auth Project');
$mail->isHtml(true);