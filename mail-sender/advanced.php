<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

Dotenv::createImmutable(__DIR__)->safeLoad();

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function envValue(string $key, string $default = ''): string
{
    return trim((string) ($_ENV[$key] ?? $_SERVER[$key] ?? $default));
}

/**
 * Tách danh sách email bằng dấu phẩy, chấm phẩy hoặc xuống dòng.
 */
function parseEmailList(string $input): array
{
    $items = preg_split('/[,;\r\n]+/', $input) ?: [];
    $emails = [];

    foreach ($items as $item) {
        $email = trim($item);

        if ($email === '') {
            continue;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                "Địa chỉ email không hợp lệ: {$email}"
            );
        }

        $emails[strtolower($email)] = $email;

        if (count($emails) > 50) {
            throw new InvalidArgumentException(
                'Mỗi trường CC/BCC chỉ được tối đa 50 địa chỉ email.'
            );
        }
    }

    return array_values($emails);
}

function htmlToPlainText(string $html): string
{
    $text = preg_replace(
        ['/<\s*br\s*\/?\s*>/i', '/<\/\s*(p|div|h[1-6]|li)\s*>/i'],
        "\n",
        $html
    ) ?? $html;

    return trim(html_entity_decode(
        strip_tags($text),
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    ));
}

$to = '';
$cc = '';
$bcc = '';
$subject = '';
$content = '';
$format = 'html';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = trim((string) ($_POST['to'] ?? ''));
    $cc = trim((string) ($_POST['cc'] ?? ''));
    $bcc = trim((string) ($_POST['bcc'] ?? ''));
    $subject = trim((string) ($_POST['subject'] ?? ''));
    $content = (string) ($_POST['content'] ?? '');
    $format = (string) ($_POST['format'] ?? 'html');

    try {
        $submittedToken = (string) ($_POST['csrf_token'] ?? '');

        if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
            throw new RuntimeException(
                'Phiên gửi biểu mẫu không hợp lệ. Hãy tải lại trang.'
            );
        }

        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Vui lòng nhập địa chỉ email người nhận hợp lệ.'
            );
        }

        if ($subject === '') {
            throw new InvalidArgumentException(
                'Vui lòng nhập tiêu đề email.'
            );
        }

        if (mb_strlen($subject, 'UTF-8') > 200) {
            throw new InvalidArgumentException(
                'Tiêu đề không được vượt quá 200 ký tự.'
            );
        }

        if (trim($content) === '') {
            throw new InvalidArgumentException(
                'Vui lòng nhập nội dung email.'
            );
        }

        if (strlen($content) > 200 * 1024) {
            throw new InvalidArgumentException(
                'Nội dung email không được vượt quá 200 KB.'
            );
        }

        if (!in_array($format, ['html', 'text'], true)) {
            throw new InvalidArgumentException(
                'Định dạng email không hợp lệ.'
            );
        }

        $ccEmails = parseEmailList($cc);
        $bccEmails = parseEmailList($bcc);

        $smtpHost = envValue('MAIL_HOST', 'smtp.gmail.com');
        $smtpPort = (int) envValue('MAIL_PORT', '587');
        // Port 465 uses implicit TLS; port 587 uses STARTTLS.
        $smtpEncryption = match ($smtpPort) {
            465 => 'ssl',
            587 => 'tls',
            default => ''
        };
        $smtpUsername = envValue('MAIL_USERNAME');
        $smtpPassword = envValue('MAIL_PASSWORD');
        $fromEmail = envValue('MAIL_FROM', $smtpUsername);
        $fromName = envValue('MAIL_FROM_NAME', 'Mail Studio');

        if (
            $smtpUsername === '' ||
            $smtpPassword === '' ||
            !filter_var($fromEmail, FILTER_VALIDATE_EMAIL)
        ) {
            throw new RuntimeException(
                'Thiếu cấu hình SMTP. Hãy kiểm tra file .env.'
            );
        }

        if ($smtpEncryption === '') {
            throw new RuntimeException(
                'MAIL_PORT chỉ hỗ trợ 465 (SMTPS) hoặc 587 (STARTTLS).'
            );
        }

        if ($smtpPort < 1 || $smtpPort > 65535) {
            throw new RuntimeException('MAIL_PORT không hợp lệ.');
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = $smtpEncryption === 'ssl'
            ? PHPMailer::ENCRYPTION_SMTPS
            : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpPort;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->Timeout = 20;

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);

        foreach ($ccEmails as $email) {
            $mail->addCC($email);
        }

        foreach ($bccEmails as $email) {
            $mail->addBCC($email);
        }

        $mail->Subject = $subject;
        $mail->isHTML($format === 'html');

        if ($format === 'html') {
            $mail->Body = $content;
            $mail->AltBody = htmlToPlainText($content);
        } else {
            $mail->Body = $content;
            $mail->AltBody = '';
        }

        $mail->send();

        $success = 'Email đã được gửi thành công.';
        $to = $cc = $bcc = $subject = $content = '';
        $format = 'html';

        // Tạo token mới sau khi gửi thành công.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (InvalidArgumentException | RuntimeException $ex) {
        $error = $ex->getMessage();
    } catch (Exception $ex) {
        error_log('PHPMailer error: ' . $ex->getMessage());

        $error = 'Không thể gửi email. Hãy kiểm tra cấu hình SMTP '
            . 'và thông tin đăng nhập trong file .env.';
    } catch (Throwable $ex) {
        error_log('Mail application error: ' . $ex->getMessage());

        $error = 'Đã xảy ra lỗi hệ thống. Hãy kiểm tra nhật ký PHP.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Studio</title>

    <style>
        :root {
            color-scheme: light;
            --bg: #f5f6f8;
            --panel: #ffffff;
            --panel-2: #f0f2f5;
            --border: #dce1e8;
            --text: #202631;
            --muted: #697586;
            --accent: #dc4545;
            --accent-hover: #c93636;
            --success: #16834f;
            --danger: #c93636;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        .container {
            width: min(1440px, 100%);
            margin: 0 auto;
            padding: 32px 24px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--accent);
            color: white;
            font-size: 21px;
            font-weight: 800;
        }

        h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: -0.6px;
        }

        .subtitle {
            margin: 2px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 12px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
        }

        .notice {
            margin-bottom: 20px;
            padding: 13px 16px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--panel);
        }

        .notice.success {
            color: var(--success);
            border-color: #a8dfc2;
        }

        .notice.error {
            color: var(--danger);
            border-color: #efb7b7;
        }

        .workspace {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 0.9fr);
            gap: 20px;
            align-items: start;
        }

        .panel {
            min-width: 0;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--panel);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h2 {
            margin: 0;
            font-size: 15px;
            font-weight: 650;
        }

        .panel-body {
            padding: 20px;
        }

        .field {
            margin-bottom: 18px;
        }

        .field:last-child {
            margin-bottom: 0;
        }

        .field-label {
            display: block;
            margin-bottom: 7px;
            color: #384252;
            font-size: 12px;
            font-weight: 650;
        }

        .required {
            color: var(--accent);
        }

        input,
        textarea,
        select {
            width: 100%;
            min-width: 0;
            padding: 11px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            background: var(--bg);
            color: var(--text);
            transition: border-color .15s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--accent);
        }

        input::placeholder,
        textarea::placeholder {
            color: #8993a2;
        }

        textarea {
            resize: vertical;
        }

        #content {
            min-height: 245px;
            line-height: 1.7;
        }

        .hint {
            margin-top: 6px;
            color: var(--muted);
            font-size: 11px;
        }

        .optional-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        details {
            margin-bottom: 18px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 11px 12px;
        }

        summary {
            cursor: pointer;
            color: #384252;
            font-size: 12px;
            font-weight: 650;
        }

        details .field {
            margin-top: 14px;
            margin-bottom: 0;
        }

        .format-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .format-row .field-label {
            margin-bottom: 0;
        }

        .format-row select {
            width: 170px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            min-height: 42px;
            padding: 10px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--panel-2);
            color: var(--text);
            font-weight: 650;
            transition: background .15s, border-color .15s;
        }

        .btn:hover {
            border-color: #aeb8c6;
        }

        .btn-primary {
            border-color: var(--accent);
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            border-color: var(--accent-hover);
            background: var(--accent-hover);
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: .6;
        }

        .preview-meta {
            color: var(--muted);
            font-size: 11px;
        }

        .preview-subject {
            padding: 15px 18px;
            border-bottom: 1px solid var(--border);
        }

        .preview-subject small {
            display: block;
            margin-bottom: 4px;
            color: var(--muted);
        }

        .preview-subject strong {
            overflow-wrap: anywhere;
            font-size: 14px;
        }

        .preview-frame {
            display: block;
            width: 100%;
            height: 430px;
            border: 0;
            background: white;
        }

        .preview-empty {
            display: grid;
            place-items: center;
            min-height: 430px;
            padding: 24px;
            color: #788394;
            text-align: center;
        }

        .preview-footer {
            padding: 10px 16px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 11px;
        }

        .footer {
            margin-top: 24px;
            color: #7a8493;
            font-size: 11px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .workspace {
                grid-template-columns: 1fr;
            }

            .preview-frame,
            .preview-empty {
                height: 360px;
                min-height: 360px;
            }
        }

        @media (max-width: 560px) {
            .container {
                padding: 20px 12px;
            }

            .header {
                align-items: flex-start;
            }

            .status {
                display: none;
            }

            .panel-body {
                padding: 15px;
            }

            .optional-fields {
                grid-template-columns: 1fr;
            }

            .actions .btn {
                flex: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="brand">
                <div class="brand-icon" aria-hidden="true">M</div>
                <div>
                    <h1>Mail Studio</h1>
                    <p class="subtitle">Soạn thảo và gửi email</p>
                </div>
            </div>

            <div class="status">
                <span class="status-dot"></span>
                <span>Giao diện gửi thư</span>
            </div>
        </header>

        <?php if ($success !== ''): ?>
            <div class="notice success" role="status">
                <?= e($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="notice error" role="alert">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <main class="workspace">
            <section class="panel">
                <div class="panel-header">
                    <h2>Soạn email</h2>
                    <span class="preview-meta">SMTP · PHPMailer</span>
                </div>

                <div class="panel-body">
                    <form method="post" id="mailForm">
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= e($_SESSION['csrf_token']) ?>">

                        <div class="field">
                            <label class="field-label" for="to">
                                Người nhận <span class="required">*</span>
                            </label>
                            <input
                                type="email"
                                id="to"
                                name="to"
                                placeholder="recipient@example.com"
                                value="<?= e($to) ?>"
                                maxlength="254"
                                autocomplete="email"
                                required>
                        </div>

                        <details>
                            <summary>CC / BCC (tùy chọn)</summary>

                            <div class="optional-fields">
                                <div class="field">
                                    <label class="field-label" for="cc">
                                        CC
                                    </label>
                                    <textarea
                                        id="cc"
                                        name="cc"
                                        rows="3"
                                        placeholder="email1@example.com, email2@example.com"><?= e($cc) ?></textarea>
                                    <p class="hint">
                                        Nhiều địa chỉ: dấu phẩy, chấm phẩy
                                        hoặc xuống dòng.
                                    </p>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="bcc">
                                        BCC
                                    </label>
                                    <textarea
                                        id="bcc"
                                        name="bcc"
                                        rows="3"
                                        placeholder="email1@example.com&#10;email2@example.com"><?= e($bcc) ?></textarea>
                                    <p class="hint">
                                        Người nhận khác không thấy danh sách BCC.
                                    </p>
                                </div>
                            </div>
                        </details>

                        <div class="field">
                            <label class="field-label" for="subject">
                                Tiêu đề <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                placeholder="Nhập tiêu đề email..."
                                value="<?= e($subject) ?>"
                                maxlength="200"
                                required>
                        </div>

                        <div class="field format-row">
                            <label class="field-label" for="format">
                                Định dạng nội dung
                            </label>

                            <select id="format" name="format">
                                <option
                                    value="html"
                                    <?= $format === 'html' ? 'selected' : '' ?>>
                                    HTML
                                </option>
                                <option
                                    value="text"
                                    <?= $format === 'text' ? 'selected' : '' ?>>
                                    Văn bản thuần
                                </option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="field-label" for="content">
                                Nội dung <span class="required">*</span>
                            </label>
                            <textarea
                                id="content"
                                name="content"
                                maxlength="204800"
                                placeholder="Nhập nội dung email tại đây..."
                                required><?= e($content) ?></textarea>

                            <div class="hint" id="characterCount">
                                0 ký tự
                            </div>

                            <p class="hint" id="formatHint">
                                Chế độ HTML: có thể nhập các thẻ HTML.
                                Bản xem trước tự cập nhật khi bạn nhập.
                            </p>
                        </div>

                        <div class="actions">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="sendButton">
                                Gửi email
                            </button>

                            <button
                                type="button"
                                class="btn"
                                id="clearButton">
                                Xóa nội dung
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Xem trước email</h2>
                    <span class="preview-meta" id="previewStatus">
                        Cập nhật trực tiếp
                    </span>
                </div>

                <div class="preview-subject">
                    <small>Tiêu đề</small>
                    <strong id="previewSubject">Chưa có tiêu đề</strong>
                </div>

                <div id="previewContainer">
                    <iframe
                        id="previewFrame"
                        class="preview-frame"
                        title="Bản xem trước nội dung email"
                        sandbox=""
                        referrerpolicy="no-referrer"></iframe>
                </div>

                <div class="preview-footer">
                    Bản xem trước chỉ hiển thị nội dung. Email thực tế
                    có thể khác tùy ứng dụng nhận thư.
                </div>
            </section>
        </main>

        <footer class="footer">
            Mail Studio · PHP + PHPMailer
        </footer>
    </div>

    <script>
        'use strict';

        const contentInput = document.getElementById('content');
        const subjectInput = document.getElementById('subject');
        const formatSelect = document.getElementById('format');
        const characterCount = document.getElementById('characterCount');
        const previewSubject = document.getElementById('previewSubject');
        const previewFrame = document.getElementById('previewFrame');
        const previewStatus = document.getElementById('previewStatus');
        const formatHint = document.getElementById('formatHint');
        const mailForm = document.getElementById('mailForm');
        const clearButton = document.getElementById('clearButton');
        const sendButton = document.getElementById('sendButton');

        function updateCharacterCount() {
            characterCount.textContent =
                `${contentInput.value.length.toLocaleString('vi-VN')} ký tự`;
        }

        function updatePreviewSubject() {
            previewSubject.textContent =
                subjectInput.value.trim() || 'Chưa có tiêu đề';
        }

        /**
         * Đưa nội dung vào iframe có sandbox để cách ly bản xem trước.
         * HTML do người dùng nhập vẫn có thể chứa nội dung gây hiểu nhầm,
         * vì vậy chỉ xem trước nội dung do chính bạn kiểm soát.
         */
        function previewHTML() {
            const content = contentInput.value;
            const isHTML = formatSelect.value === 'html';

            const previewContent = isHTML ?
                content :
                escapeHTML(content).replace(/\r\n|\r|\n/g, '<br>');

            const documentHTML = `<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body {
        margin: 0;
        padding: 20px;
        color: #222;
        background: #fff;
        font: 14px/1.7 Arial, Helvetica, sans-serif;
        overflow-wrap: anywhere;
    }
    img { max-width: 100%; height: auto; }
    table { max-width: 100%; }
    pre { white-space: pre-wrap; }
</style>
</head>
<body>${previewContent}</body>
</html>`;

            previewFrame.srcdoc = documentHTML;
            previewStatus.textContent = 'Cập nhật trực tiếp';
        }

        function escapeHTML(value) {
            return value.replace(/[&<>"']/g, character => {
                const entities = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };

                return entities[character];
            });
        }

        function updateFormatUI() {
            if (formatSelect.value === 'html') {
                formatHint.textContent =
                    'Chế độ HTML: có thể nhập các thẻ HTML. Bản xem trước tự cập nhật khi bạn nhập.';
            } else {
                formatHint.textContent =
                    'Chế độ văn bản thuần: nội dung được hiển thị như văn bản, không xử lý thẻ HTML.';
            }

            previewHTML();
        }

        contentInput.addEventListener('input', () => {
            updateCharacterCount();
            previewHTML();
        });

        subjectInput.addEventListener('input', updatePreviewSubject);

        formatSelect.addEventListener('change', updateFormatUI);

        clearButton.addEventListener('click', () => {
            contentInput.value = '';
            subjectInput.value = '';

            updateCharacterCount();
            updatePreviewSubject();
            previewHTML();

            contentInput.focus();
        });

        mailForm.addEventListener('submit', () => {
            sendButton.disabled = true;
            sendButton.textContent = 'Đang gửi...';
        });

        // Khởi tạo bản xem trước ngay khi mở trang
        updateCharacterCount();
        updatePreviewSubject();
        updateFormatUI();
    </script>
</body>

</html>
