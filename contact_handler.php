<?php
require_once 'config.php';
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $company = $_POST['company'] ?? '';
    $service_of_interest = $_POST['service_of_interest'] ?? '';
    $message = $_POST['message'] ?? '';
    $terms = isset($_POST['terms']);

    $hcaptcha_secret = HCAPTCHA_SECRET;
    $admin_email = ADMIN_EMAIL;

    if (empty($full_name) || empty($email) || empty($phone) || empty($message)) {
        $_SESSION['form_error'] = 'Please fill in all required fields.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['form_error'] = 'Please enter a valid email address.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (!$terms) {
        $_SESSION['form_error'] = 'terms';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (empty($_POST['h-captcha-response'])) {
        $_SESSION['form_error'] = 'Please complete the captcha verification.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    $hcaptcha_response = $_POST['h-captcha-response'];
    $hcaptcha_remoteip = $_SERVER['REMOTE_ADDR'];

    $hcaptcha_url = 'https://hcaptcha.com/siteverify';
    $hcaptcha_data = array(
        'secret' => $hcaptcha_secret,
        'response' => $hcaptcha_response,
        'remoteip' => $hcaptcha_remoteip
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $hcaptcha_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($hcaptcha_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $hcaptcha_result = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        $_SESSION['form_error'] = 'Unable to verify captcha. Please try again later.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    $hcaptcha_response_data = json_decode($hcaptcha_result);

    if (!$hcaptcha_response_data || !$hcaptcha_response_data->success) {
        $_SESSION['form_error'] = 'Captcha verification failed. Please try again.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    function createMailer() {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION ?: '';
            $mail->Port       = MAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );

            return $mail;
        } catch (Exception $e) {
            throw new Exception("Mailer setup failed: {$mail->ErrorInfo}");
        }
    }

    $admin_subject = 'New Contact Form Submission - ' . $full_name;

    $admin_body = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
            .content { background-color: #ffffff; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
            .field { margin-bottom: 15px; padding: 10px; background-color: #f9f9f9; border-radius: 3px; }
            .label { font-weight: bold; color: #555; margin-bottom: 5px; }
            .value { color: #333; }
            .footer { margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2 style='color: #333; margin: 0;'>🔔 New Contact Form Submission</h2>
                <p style='margin: 10px 0 0 0; color: #666;'>You have received a new message from your website</p>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>👤 Full Name:</div>
                    <div class='value'>" . htmlspecialchars($full_name) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>📧 Email Address:</div>
                    <div class='value'>" . htmlspecialchars($email) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>📱 Phone Number:</div>
                    <div class='value'>" . htmlspecialchars($phone) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>🏢 Company Name:</div>
                    <div class='value'>" . htmlspecialchars($company ?: 'Not provided') . "</div>
                </div>
                <div class='field'>
                    <div class='label'>🏢 Service of Interest:</div>
                    <div class='value'>" . htmlspecialchars($service_of_interest) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>💬 Message:</div>
                    <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>🕒 Submitted on:</div>
                    <div class='value'>" . date('Y-m-d H:i:s T') . "</div>
                </div>
            </div>
            <div class='footer'>
                <p>This email was automatically generated from your website contact form.</p>
                <p>Reply directly to this email to respond to " . htmlspecialchars($full_name) . ".</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $user_subject = 'Thank you for contacting relevantmanagement - We\'ll be in touch soon!';

    $user_body = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px 20px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
            .content { background-color: #ffffff; padding: 30px 20px; border: 1px solid #ddd; border-radius: 5px; }
            .highlight-box { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #667eea; }
            .contact-info { background-color: #f1f3f4; padding: 20px; border-radius: 5px; margin: 20px 0; }
            .footer { margin-top: 20px; padding: 20px; background-color: #f8f9fa; border-radius: 5px; font-size: 14px; color: #666; text-align: center; }
            .button { display: inline-block; padding: 12px 24px; background-color: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
            h1, h2, h3 { color: #333; }
            .summary { background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0; border: 1px solid #ffeaa7; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1 style='margin: 0; font-size: 28px;'>✅ Message Received!</h1>
                <p style='margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;'>Thank you for reaching out to The Project Company L.L.C-FZ</p>
            </div>

            <div class='content'>
                <h2>Hello " . htmlspecialchars($full_name) . ",</h2>

                <p>Thank you for contacting <strong>The Project Company L.L.C-FZ</strong>! We have successfully received your message and appreciate you taking the time to reach out to us.</p>

                <div class='highlight-box'>
                    <h3>🚀 What happens next?</h3>
                    <ul>
                        <li><strong>Review:</strong> Our team will carefully review your inquiry</li>
                        <li><strong>Response:</strong> We'll get back to you within 24-48 hours</li>
                        <li><strong>Solutions:</strong> We'll provide tailored solutions for your needs</li>
                    </ul>
                </div>

                <div class='summary'>
                    <h3>📋 Your Message Summary:</h3>
                    <p><strong>Name:</strong> " . htmlspecialchars($full_name) . "</p>
                    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                    <p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>
                    " . ($company ? "<p><strong>Company:</strong> " . htmlspecialchars($company) . "</p>" : "") . "
                    <p><strong>Service of Interest:</strong> " . htmlspecialchars($service_of_interest) . "</p>
                    <p><strong>Message:</strong> " . htmlspecialchars(substr($message, 0, 200)) . (strlen($message) > 200 ? '...' : '') . "</p>
                    <p><strong>Submitted:</strong> " . date('F j, Y \a\t g:i A T') . "</p>
                </div>

                <div class='contact-info'>
                    <h3>📞 Need immediate assistance?</h3>
                    <p><strong>Email:</strong> Contact@relevantmanagement.com</p>
                    <p><strong>Address:</strong> Relevant Management FZCO, Unit 78340-001, Building A1, IFZA<br>Business Park, Dubai Digital Park, Dubai Silicon Oasis, Dubai, UAE</p>
                </div>

                <p>We're excited to learn more about your project and explore how The Relevant Management  can help transform your back-office operations for lasting success.</p>

                <p>Best regards,<br>
                <strong>relevantmanagement Team</strong></p>
            </div>

            <div class='footer'>
                <p>This is an automated confirmation email. Please do not reply to this message.</p>
                <p>If you have any questions, please contact us at <a href='mailto:Contact@relevantmanagement.com'>Contact@relevantmanagement.com</a></p>
                <p style='margin-top: 15px; font-size: 12px;'>
                    © 2026 relevantmanagement. All rights reserved.<br>
                </p>
            </div>
        </div>
    </body>
    </html>
    ";

    $admin_sent = false;
    $user_sent = false;
    $error_message = '';

    try {
        $adminMail = createMailer();
        $adminMail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $adminMail->addAddress($admin_email);
        $adminMail->addReplyTo($email, $full_name);
        $adminMail->isHTML(true);
        $adminMail->Subject = $admin_subject;
        $adminMail->Body = $admin_body;

        $admin_sent = $adminMail->send();

    } catch (Exception $e) {
        $admin_error = $adminMail->ErrorInfo;
        error_log("Admin email error: " . $admin_error);
    }

    try {
        $userMail = createMailer();
        $userMail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $userMail->addAddress($email, $full_name);
        $userMail->addReplyTo(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $userMail->isHTML(true);
        $userMail->Subject = $user_subject;
        $userMail->Body = $user_body;

        $user_sent = $userMail->send();

    } catch (Exception $e) {
        $user_error = $userMail->ErrorInfo;
        error_log("User email error: " . $user_error);
    }

    if ($admin_sent && $user_sent) {
        $_SESSION['form_success'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif ($admin_sent && !$user_sent) {
        $_SESSION['form_warning'] = 'partial_user';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (!$admin_sent && $user_sent) {
        $_SESSION['form_warning'] = 'partial_admin';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        if (!empty($error_message)) {
            error_log("Contact form email errors: " . $error_message);
        }
        $_SESSION['form_error'] = 'Sorry, there was an error sending your message. Please try again later or contact us directly.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>