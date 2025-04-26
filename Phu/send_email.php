<?php
// Sử dụng PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include các file cần thiết của PHPMailer từ thư mục controllers/PHPMailer
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Kiểm tra nếu form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Kiểm tra dữ liệu đầu vào
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Nếu thiếu dữ liệu, chuyển hướng về trang About với thông báo lỗi
        header("Location: /ltw/AboutController/index?status=error&reason=missing_data");
        exit;
    }

    // Kiểm tra tính hợp lệ của email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Nếu email không hợp lệ, chuyển hướng về trang About với thông báo lỗi
        header("Location: /ltw/AboutController/index?status=error&reason=invalid_email");
        exit;
    }

    // Khởi tạo PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Cấu hình máy chủ SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'trungphugt@gmail.com';
        $mail->Password = 'tbsuncvzffbpyqhg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Bật debug
        $mail->SMTPDebug = 0; // 2: Hiển thị chi tiết debug, 0: Tắt debug

        // Cấu hình email
        $mail->setFrom('trungphugt@gmail.com', 'Your Website Contact Form');
        $mail->addAddress('trungphugt@gmail.com');
        $mail->addReplyTo($email, $name);

        // Nội dung email
        $mail->isHTML(false);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body = "You have received a new message from your website contact form.\n\n";
        $mail->Body .= "Name: $name\n";
        $mail->Body .= "Email: $email\n";
        $mail->Body .= "Subject: $subject\n";
        $mail->Body .= "Message:\n$message\n";

        // Gửi email
        $mail->send();
        header("Location: /ltw/AboutController/index?status=success");
    } catch (Exception $e) {
        // Hiển thị lỗi nếu debug không đủ
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
        exit;
        // header("Location: /AboutController/index?status=error");
    }
} else {
    header("Location: /ltw/AboutController/index");
}
exit;
?>