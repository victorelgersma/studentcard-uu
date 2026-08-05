<?php

require __DIR__ . '/vendor/autoload.php';

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

$name = htmlspecialchars($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$amount = htmlspecialchars($_POST['amount'] ?? '');
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
        'martenitsi@vjbe.net',
        'Martenitsi Store'
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

    $customerMail->Subject = "Your martenitsi reservation";

    $customerMail->Body =
"Hi $name,

Thank you for your martenitsi reservation!

We have received your request for:

Amount:
$amount martenitsi

$message

We will contact you shortly with the final details, including shipping costs.

Thank you!
Martenitsi Store
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

    $storeMail->Subject = "New Martenitsi reservation";

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
    <h1>Thank you!</h1>
    <p>Your reservation has been received.</p>
    <p>We will contact you shortly with the next steps.</p>
    ";


} catch (Exception $e) {

    error_log($e->getMessage());

    echo "
    <h1>Error</h1>
    <p>Sorry, your reservation could not be sent. Please try again later.</p>
    ";
}