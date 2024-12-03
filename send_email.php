<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = htmlspecialchars($_POST['fullname'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    if (empty($fullname) || empty($email) || empty($message)) {
        echo "Bitte füllen Sie alle Felder aus.";
        exit;
    }

    $to = "mail@about-elias.de";
    $subject = "Neue Nachricht von $fullname";
    $body = "Name: $fullname\nE-Mail: $email\nNachricht:\n$message";
    $headers = "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
        echo "Nachricht wurde erfolgreich gesendet!";
    } else {
        echo "Es gab ein Problem beim Senden der Nachricht.";
    }
    exit;
} else {
    echo "Ungültige Anfrage.";
}
