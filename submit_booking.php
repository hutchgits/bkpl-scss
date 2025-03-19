<?php
require_once 'config.php';
require 'vendor/autoload.php'; // ติดตั้ง PHPMailer ผ่าน Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// รับข้อมูลจากฟอร์ม
$villa_id = $_POST['villa_id'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$number_of_guests = (int)$_POST['number_of_guests'];
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$message = htmlspecialchars($_POST['message']);

// ดึงข้อมูลวิลล่า
$stmt = $conn->prepare("SELECT title FROM villas WHERE id = :id");
$stmt->execute([':id' => $villa_id]);
$villa = $stmt->fetch(PDO::FETCH_ASSOC);
$villa_title = $villa['title'] ?? 'ไม่พบวิลล่า';

// สร้าง HTML สำหรับอีเมล
$email_body = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; }
        h2 { color: #333; }
        .info { margin: 10px 0; }
        .info label { font-weight: bold; }
    </style>
</head>
<body>
    <div class='container'>
        <h2>คำขอจองใหม่ - $villa_title</h2>
        <div class='info'><label>วันที่เช็คอิน:</label> $check_in_date</div>
        <div class='info'><label>วันที่เช็คเอาท์:</label> $check_out_date</div>
        <div class='info'><label>จำนวนผู้เข้าพัก:</label> $number_of_guests ท่าน</div>
        <div class='info'><label>ชื่อ-นามสกุล:</label> $name</div>
        <div class='info'><label>อีเมล:</label> $email</div>
        <div class='info'><label>เบอร์โทร:</label> $phone</div>
        <div class='info'><label>ข้อความเพิ่มเติม:</label> " . nl2br($message) . "</div>
    </div>
</body>
</html>";

// ส่งอีเมลด้วย PHPMailer
$mail = new PHPMailer(true);
try {
    // ตั้งค่าเซิร์ฟเวอร์ SMTP (ตัวอย่างใช้ Gmail)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com'; // อีเมลของคุณ
    $mail->Password = 'your_app_password'; // App Password จาก Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // ผู้ส่งและผู้รับ
    $mail->setFrom('your_email@gmail.com', 'Great Pool Villa');
    $mail->addAddress('your_email@gmail.com', 'ตัวแทน Great Pool Villa'); // อีเมลของคุณ

    // เนื้อหาอีเมล
    $mail->isHTML(true);
    $mail->Subject = "คำขอจองใหม่: $villa_title";
    $mail->Body = $email_body;
    $mail->CharSet = 'UTF-8';

    $mail->send();

    // ส่ง LINE Notify (ถ้าต้องการแจ้งเตือนเพิ่ม)
    $line_token = 'YOUR_LINE_NOTIFY_TOKEN';
    $line_message = "คำขอจองใหม่\nวิลล่า: $villa_title\nวันที่: $check_in_date ถึง $check_out_date\nชื่อ: $name\nเบอร์: $phone";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $line_token]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "message=" . urlencode($line_message));
    curl_exec($ch);
    curl_close($ch);

    // แสดงข้อความสำเร็จ
    echo "<script>alert('ส่งคำขอจองสำเร็จ! ทางเราจะติดต่อกลับโดยเร็วที่สุด'); window.location.href='villas_detail.php?id=$villa_id';</script>";
} catch (Exception $e) {
    echo "<script>alert('เกิดข้อผิดพลาดในการส่งคำขอจอง: {$mail->ErrorInfo}'); window.history.back();</script>";
}
?>