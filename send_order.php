<?php

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);


use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_ENV['FASTMAIL_USERNAME'], $_ENV['FASTMAIL_PASSWORD'])) {
    die('Missing mail configuration');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request');
}

if (
    !isset($_FILES['enrolment_certificate']) ||
    $_FILES['enrolment_certificate']['error'] !== UPLOAD_ERR_OK
) {
    exit('Please upload your enrollment certificate.');
}

$tmpFile = $_FILES['enrolment_certificate']['tmp_name'];

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($tmpFile);

if ($mime !== 'application/pdf') {
    exit('The enrollment certificate must be a PDF.');
}
if ($_FILES['enrolment_certificate']['size'] > 5 * 1024 * 1024) {
    exit('PDF is too large (max 5 MB).');
}

$name = htmlspecialchars($_POST['name'] ?? '');

$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$amount = '0.00 EUR (September sale)';
$message = htmlspecialchars($_POST['message'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Invalid email address');
}


function configureMailer(PHPMailer $mail): void
{
    $mail->isSMTP();

    $mail->Host = 'smtp.fastmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['FASTMAIL_USERNAME'];
    $mail->Password = $_ENV['FASTMAIL_PASSWORD'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom(
        'conveniencecard@vjbe.net',
        'Convenience Card'
    );
}


try {

    /*
     * Send confirmation to customer
     */
    $customerMail = new PHPMailer(true);

    configureMailer($customerMail);

    $customerMail->addAddress(
        $email,
        $name
    );

    $customerMail->Subject = "Your Unofficial Convenience Card";

    $customerMail->Body =
        "Hi $name,

Thank you for your request for an Unofficial Convenience Card!

We have received your order details and your enrollment certificate.

Your card is free during our September sale. I will review your certificate
and get in touch to arrange printing and handover.

Thank you!

Unofficial Convenience Card
";

    $customerMail->send();


    /*
     * Send notification to store owner
     */
    $storeMail = new PHPMailer(true);

    configureMailer($storeMail);

    $storeMail->addAddress(
        'martenitsi@vjbe.net'
    );

    $storeMail->addReplyTo(
        $email,
        $name
    );

    $storeMail->addAttachment(
        $tmpFile,
        $_FILES['enrolment_certificate']['name']
    );

    $storeMail->Subject = "New Convenience Card Reservation";

    $storeMail->Body =
        "New reservation received

Name:
$name

Email:
$email

Amount:
$amount

Message:
$message
";

    $storeMail->send();


    echo "
<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Thank you - Unofficial Convenience Card</title>
    <link rel=\"stylesheet\" href=\"style.css\">
</head>

<body>

<div class=\"container thank-you\">
    <h1>Thank you!</h1>

    <p class=\"intro\">
        Your request for an Unofficial Convenience Card has been received.
    </p>

    <p>
    Your card is free during our September sale. I will review your enrollment
    certificate and get in touch to arrange printing and handover.
</p>

    <p>
        You can safely close this page.
    </p>
    <img class=\"thank-you-image\" src=\"https://img.vjbe.net/thumbs-up-nerd-image-short-sleeved-shirt-giving-273236103-1834129865.webp\" alt=\"thumbs up guy\" />
</div>

</body>
</html>
";


} catch (Exception $e) {

    error_log($e->getMessage());

    echo "
    <h1>Error</h1>
    <p>Sorry, your reservation could not be sent. Please try again later.</p>
    ";
}
