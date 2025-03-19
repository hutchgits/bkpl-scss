<?php
session_start(); // เริ่ม session เพื่อเก็บข้อความสถานะชั่วคราว

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a 4-digit form number
    $form_number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

    // Get form values
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message_content = htmlspecialchars(trim($_POST['message']));

    // Email to send
    $to = "seekhuahin@gmail.com";
    $subject = "Customer Inquiry - Form Number: $form_number";
    $message = "
    Form Number: $form_number\n
    Name: $first_name\n
    Phone Number: $phone_number\n
    Email: $email\n
    Message: $message_content
    ";

    // Set email headers to support UTF-8 for Thai characters
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        $_SESSION['success_message'] = "ส่งอีเมลสำเร็จ! ขอบคุณที่ติดต่อเรา หมายเลขฟอร์ม: $form_number";
    } else {
        $_SESSION['error_message'] = "ไม่สามารถส่งอีเมลได้ กรุณาลองใหม่";
    }

    // Redirect เพื่อป้องกันการส่งซ้ำ
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// ดึงข้อความสถานะจาก session แล้วลบหลังแสดง
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อเรา - Great Pool Villa หัวหิน</title>
    <link rel="stylesheet" href="scss/pl_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .message { 
            text-align: center; 
            padding: 15px; 
            margin-top: 20px; 
            border-radius: 4px; 
            font-size: 1.5em; /* ขยายขนาดข้อความสถานะ */
        }
        .success { 
            background: #d4edda; 
            color: #155724; 
        }
        .error { 
            background: #f8d7da; 
            color: #721c24; 
        }
        .contact-form label {
            font-size: 1.3em; /* ขยายขนาด label */
        }
        .contact-form input, 
        .contact-form textarea {
            font-size: 1.2em; /* ขยายขนาดข้อความใน input และ textarea */
        }
        .form-buttons button {
            font-size: 1.3em; /* ขยายขนาดข้อความในปุ่ม */
            padding: 12px 20px; /* ปรับ padding ให้ปุ่มใหญ่ขึ้นเล็กน้อย */
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">Greatpoolvilla.com</a>
        </div>
        <nav>
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="nav-menu">
                <li><a href="/index.php">หน้าแรก</a></li>
                <li><a href="/villas.php">วิลล่าทั้งหมด</a></li>
                <li><a href="/reviews.php">รีวิวจากลูกค้า</a></li>
            </ul>
        </nav>
    </header>

    <section class="contact-us">
        <h1>ติดต่อเรา</h1>
        <p><h2>กรุณากรอกข้อมูลด้านล่าง</h2></p>
        <div class="contact-form">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> ชื่อ-นามสกุล</label>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> อีเมล</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> เบอร์โทรศัพท์</label>
                    <input type="tel" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-comment"></i> ข้อความ</label>
                    <textarea name="message" rows="5" required></textarea>
                </div>
                <div class="form-buttons">
                    <button id="submit-contact" type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> ส่งข้อความ</button>
                    <button type="reset" class="reset-btn"><i class="fas fa-undo"></i> ล้างข้อมูล</button>
                </div>
            </form>

            <?php
            if ($success_message) {
                echo "<p class='message success'>$success_message</p>";
            }
            if ($error_message) {
                echo "<p class='message error'>$error_message</p>";
            }
            ?>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p><h3>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</h3></p>
            <p><h3>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></h3></p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.querySelector('.nav-menu');
            if (hamburger && navMenu) {
                hamburger.addEventListener('click', () => {
                    navMenu.classList.toggle('active');
                });
                navMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        navMenu.classList.remove('active');
                    });
                });
            }
        });
    </script>
</body>
</html>