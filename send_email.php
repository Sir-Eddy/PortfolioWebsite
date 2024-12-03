<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic input validation
    if (empty($fullname) || empty($email) || empty($message)) {
        echo "Please complete all fields.";
        exit;
    }

    // Validate full name: Only letters and spaces
    if (!preg_match("/^[A-Za-z\s]+$/", $fullname)) {
        echo "Invalid name. Please use only letters and spaces.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Limit message length and sanitize
    if (strlen($message) > 1000) {
        echo "The message is too long. A maximum of 1000 characters is allowed.";
        exit;
    }
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    // Secure email headers to prevent injection
    $to = "mail@about-elias.de";
    $subject = "Neue Nachricht von " . htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
    $body = "Name: " . htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') . "\n"
          . "E-Mail: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\n"
          . "Nachricht:\n" . $message;
    $headers = "From: no-reply@about-elias.de\r\n"
             . "Reply-To: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\r\n"
             . "X-Mailer: PHP/" . phpversion();

    // Use mail function with validation
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
