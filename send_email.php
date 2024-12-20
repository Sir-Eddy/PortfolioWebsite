<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($fullname) || empty($email) || empty($message)) {
        echo "Please complete all fields.";
        exit;
    }

    if (!preg_match("/^[\p{L}\s'-]+$/u", $fullname)) {
        echo "Invalid name. Please use only letters, spaces, hyphens, or apostrophes.";
        exit;
    }    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match('/[\r\n:]/', $email)) {
        echo "Invalid email address.";
        exit;
    }

    if (strlen($message) < 10 || strlen($message) > 1000) {
        echo "A minimum of 10 and a maximum of 1000 characters are required.";
        exit;
    }
    $message = strip_tags($message);
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    $to = "mail@about-elias.de";
    $subject = "Neue Nachricht von " . htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
    $body = "Name: " . htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') . "\n"
          . "E-Mail: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\n"
          . "Nachricht:\n" . $message;
    $headers = "From: no-reply@about-elias.de\r\n"
             . "Reply-To: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\r\n"
             . "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "There was a problem sending the message.";
    }
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>
