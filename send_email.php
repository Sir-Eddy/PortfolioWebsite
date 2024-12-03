<?php
$messageStatus = ""; // Variable für Statusmeldungen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formularfelder abrufen und validieren
    $fullname = htmlspecialchars($_POST['fullname']); // Name des Absenders
    $email = htmlspecialchars($_POST['email']); // E-Mail-Adresse des Absenders
    $message = htmlspecialchars($_POST['message']); // Nachricht

    // Überprüfen, ob die Felder ausgefüllt sind
    if (empty($fullname) || empty($email) || empty($message)) {
        $messageStatus = "Bitte füllen Sie alle Felder aus.";
    } else {
        // Empfängeradresse und Betreff
        $to = "mail@about-elias.de"; // Zieladresse
        $subject = "Neue Nachricht von $fullname"; // Betreff

        // Nachricht formatieren
        $body = "
            Name: $fullname\n
            E-Mail: $email\n
            Nachricht:\n$message
        ";

        // Header setzen
        $headers = "From: $email\r\n" .
                   "Reply-To: $email\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // E-Mail senden
        if (mail($to, $subject, $body, $headers)) {
            $messageStatus = "Nachricht wurde erfolgreich gesendet!";
        } else {
            $messageStatus = "Es gab ein Problem beim Senden der Nachricht.";
        }
    }
}
?>