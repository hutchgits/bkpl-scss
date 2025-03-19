<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../haah/config.php';

if (!isset($conn)) {
    die("ข้อผิดพลาด: ไม่สามารถเชื่อมต่อฐานข้อมูลได้");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // ดีบักข้อมูลที่รับมา
        echo "<pre>POST Data: ";
        var_dump($_POST);
        echo "</pre>";

        $stmt = $conn->prepare("SELECT id FROM admin_pl WHERE username = ? OR email = ?");
        if (!$stmt) {
            die("SQL Prepare Error: " . implode(", ", $conn->errorInfo()));
        }
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = "ชื่อผู้ใช้หรืออีเมลนี้มีอยู่ในระบบแล้ว";
        } else {
            $stmt = $conn->prepare("INSERT INTO admin_pl (username, email, password) VALUES (?, ?, ?)");
            if (!$stmt) {
                die("SQL Prepare Error: " . implode(", ", $conn->errorInfo()));
            }
            if ($stmt->execute([$username, $email, $password])) {
                $success = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
            } else {
                $error = "เกิดข้อผิดพลาดในการสมัคร: " . implode(", ", $stmt->errorInfo());
            }
        }
    } catch (Exception $e) {
        $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัคร Admin - Great Pool Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css"> 
</head>
<body>
    <section class="contact-us">
        <h1>สมัคร Admin</h1>
        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form class="contact-form" method="POST">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> ชื่อผู้ใช้</label>
                <input type="text" id="username" name="username" required maxlength="50">
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> อีเมล</label>
                <input type="email" id="email" name="email" required maxlength="100">
            </div>
            <div class="form-group password-wrapper">
                <label for="password"><i class="fas fa-lock"></i> รหัสผ่าน</label>
                <input type="password" id="password" name="password" required maxlength="255">
                <span class="toggle-password"><i class="fas fa-eye"></i></span>
            </div>
            <div class="form-buttons">
                <button type="submit" class="submit-btn"><i class="fas fa-user-plus"></i> สมัคร</button>
                <button type="reset" class="reset-btn"><i class="fas fa-undo"></i> รีเซ็ต</button>
            </div>
            <p>มีบัญชีแล้ว? <a href="ad_pl_login.php">เข้าสู่ระบบที่นี่</a></p>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordField = document.querySelector('#password');
            if (!togglePassword || !passwordField) {
                console.error('ไม่พบ togglePassword หรือ passwordField');
                return;
            }
            togglePassword.addEventListener('click', () => {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                togglePassword.querySelector('i').classList.toggle('fa-eye');
                togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>