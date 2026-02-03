<?php

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// SMTP Configuration
/*define('MAIL_DRIVER', 'smtp');
define('MAIL_HOST', '212.28.183.181');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'info@theprojectcompanyllc.com');
define('MAIL_PASSWORD', 'test@123@#');
define('MAIL_ENCRYPTION', 'null');
define('MAIL_FROM_ADDRESS', 'info@theprojectcompanyllc.com');
define('MAIL_FROM_NAME', 'relevantmanagement.');*/


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    // Get form data
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $company = $_POST['company'] ?? '';
    $service_of_interest = $_POST['service_of_interest'] ?? '';
    $message = $_POST['message'] ?? '';
    $terms = isset($_POST['terms']);

    
    // Basic validation
    if (empty($full_name) || empty($email) || empty($phone) || empty($message)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please fill in all required fields.',
                confirmButtonColor: '#d33'
            });
        </script>";
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#d33'
            });
        </script>";
        exit;
    }
    
    if (!$terms) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Privacy Policy Agreement Required!',
                html: 'You must agree to our <a href=\"privacy-policy.php\" target=\"_blank\" style=\"color: #007bff; text-decoration: underline;\">Privacy Policy</a> to submit this form.',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'I Understand'
            });
        </script>";
        exit;
    }
    
    // hCaptcha validation
    if (empty($_POST['h-captcha-response'])) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please complete the captcha verification.',
                confirmButtonColor: '#d33'
            });
        </script>";
        exit;
    }
    
    // Verify hCaptcha using cURL
    // $hcaptcha_secret = 'ES_0114ceb415b247a0a208c71ffbfe2dd8';
    // $hcaptcha_response = $_POST['h-captcha-response'];
    // $hcaptcha_remoteip = $_SERVER['REMOTE_ADDR'];
    
    $hcaptcha_url = 'https://hcaptcha.com/siteverify';
    $hcaptcha_data = array(
        'secret' => $hcaptcha_secret,
        'response' => $hcaptcha_response,
        'remoteip' => $hcaptcha_remoteip
    );
    
    // Use cURL for hCaptcha verification
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
    
    // Check for cURL errors
    if ($curl_error) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Connection Error!',
                text: 'Unable to verify captcha. Please try again later.',
                confirmButtonColor: '#d33'
            });
        </script>";
        exit;
    }
    
    $hcaptcha_response_data = json_decode($hcaptcha_result);
    
    if (!$hcaptcha_response_data || !$hcaptcha_response_data->success) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Captcha verification failed. Please try again.',
                confirmButtonColor: '#d33'
            });
        </script>";
        exit;
    }
    
    // Function to create PHPMailer instance with SMTP settings
    function createMailer() {
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = MAIL_PORT;
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );
            
            // Enable verbose debug output (disable in production)
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            
            return $mail;
        } catch (Exception $e) {
            throw new Exception("Mailer setup failed: {$mail->ErrorInfo}");
        }
    }
    
    // Admin email configuration
    $admin_email = 'support@theprojectcompanyllc.com';
    $admin_subject = 'New Contact Form Submission - ' . $full_name;
    
    // Admin email body
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
    
    // User email configuration
    $user_subject = 'Thank you for contacting relevantmanagement - We\'ll be in touch soon!';
    
    // User email body
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
                // Send admin notification email
        $adminMail = createMailer();
        $adminMail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $adminMail->addAddress($admin_email);
        $adminMail->addReplyTo($email, $full_name);
        $adminMail->isHTML(true);
        $adminMail->Subject = $admin_subject;
        $adminMail->Body = $admin_body;
        $adminMail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );
        
        $admin_sent = $adminMail->send();
        
    } catch (Exception $e) {
        $error_message .= "Admin email error: {$adminMail->ErrorInfo}. ";
    }
    
    try {
        // Send user confirmation email
        $userMail = createMailer();
        $userMail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $userMail->addAddress($email, $full_name);
        $userMail->addReplyTo(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $userMail->isHTML(true);
        $userMail->Subject = $user_subject;
        $userMail->Body = $user_body;
        $userMail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );
        
        $user_sent = $userMail->send();
        
    } catch (Exception $e) {
        $error_message .= "User email error: {$userMail->ErrorInfo}. ";
    }
    
    // Check if both emails were sent successfully
    if ($admin_sent && $user_sent) {
        echo "<script>
        // Detect mobile using JavaScript
        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        if (isMobile) {
            window.location.href = 'success.php';
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Thank you for your message. We have sent you a confirmation email and will get back to you soon!',
                confirmButtonColor: '#28A745'
            }).then(function() {
                document.getElementById('contactForm').reset();
            });
        }
    </script>";
    } elseif ($admin_sent && !$user_sent) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Partially Sent',
                text: 'Your message was received, but we couldn\\'t send you a confirmation email. We will still get back to you soon!',
                confirmButtonColor: '#ffc107'
            }).then(function() {
                document.getElementById('contactForm').reset();
            });
        </script>";
    } elseif (!$admin_sent && $user_sent) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Partially Sent',
                text: 'We sent you a confirmation email, but there was an issue with our internal notification. Please call us if urgent.',
                confirmButtonColor: '#ffc107'
            }).then(function() {
                document.getElementById('contactForm').reset();
            });
        </script>";
    } else {
        //var_dump($error_message);
        exit();
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Sorry, there was an error sending your message. Please try again later or contact us directly.',
                confirmButtonColor: '#d33'
            });
        </script>";
        
        // Log error for debugging (optional)
        if (!empty($error_message)) {
            error_log("Contact form email errors: " . $error_message);
        }
    }
}
?>
