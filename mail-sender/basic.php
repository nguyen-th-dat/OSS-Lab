
<?php

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$status = '';
$statusType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $to = trim($_POST['to'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate input
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $status = 'Email người nhận không hợp lệ.';
        $statusType = 'error';
    } elseif ($subject === '' || $message === '') {
        $status = 'Vui lòng nhập đầy đủ thông tin.';
        $statusType = 'error';
    } elseif (
        mb_strlen($subject) > 200 ||
        mb_strlen($message) > 10000
    ) {
        $status = 'Tiêu đề hoặc nội dung quá dài.';
        $statusType = 'error';
    } else {
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];

            $mail->Port = (int) $_ENV['MAIL_PORT'];

            // Select encryption based on SMTP port
            $mail->SMTPSecure = match ($mail->Port) {
                465 => PHPMailer::ENCRYPTION_SMTPS,
                587 => PHPMailer::ENCRYPTION_STARTTLS,
                default => throw new Exception('SMTP port không được hỗ trợ.')
            };

            // Email encoding
            $mail->CharSet = 'UTF-8';

            // Sender and recipient
            $mail->setFrom(
                $_ENV['MAIL_FROM'],
                $_ENV['MAIL_FROM_NAME']
            );

            $mail->addAddress($to);

            // Email content
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Send email
            $mail->send();

            $status = 'Gửi email thành công!';
            $statusType = 'success';

        } catch (Exception $e) {
            error_log('PHPMailer Error: ' . $mail->ErrorInfo);

            $status = 'Gửi email thất bại. Vui lòng thử lại.';
            $statusType = 'error';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
</head>

<body>

    <h2>Send Email</h2>

    <?php if ($status !== ''): ?>
        <p>
            <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <p>
            <label for="to">To:</label><br>
            <input
                type="email"
                id="to"
                name="to"
                value="<?= htmlspecialchars($_POST['to'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >
        </p>

        <p>
            <label for="subject">Subject:</label><br>
            <input
                type="text"
                id="subject"
                name="subject"
                maxlength="200"
                required
            >
        </p>

        <p>
            <label for="message">Message:</label><br>
            <textarea
                id="message"
                name="message"
                rows="5"
                maxlength="10000"
                required
            ></textarea>
        </p>

        <button type="submit">Send Email</button>

    </form>

</body>

</html>
