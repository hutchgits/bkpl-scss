<?php
// ad_pl_login.php
session_start();
require_once '../haah/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin_pl WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Great Pool Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css">
</head>
<body>
    <section class="contact-us">
        <h1>เข้าสู่ระบบ Admin</h1>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form class="contact-form" method="POST">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> ชื่อผู้ใช้</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group password-wrapper">
                <label for="password"><i class="fas fa-lock"></i> รหัสผ่าน</label>
                <input type="password" id="password" name="password" required>
                <span class="toggle-password"><i class="fas fa-eye"></i></span>
            </div>
            <div class="form-buttons">
                <button type="submit" class="submit-btn"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</button>
            </div>
            <p>ยังไม่มีบัญชี? <a href="ad_pl_register.php">สมัครที่นี่</a></p>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordField = document.querySelector('#password');
            if (togglePassword && passwordField) {
                togglePassword.addEventListener('click', () => {
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    togglePassword.querySelector('i').classList.toggle('fa-eye');
                    togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>