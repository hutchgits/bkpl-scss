<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ad_pl_login.php");
    exit();
}

require_once '../haah/config.php';

if (!isset($conn)) {
    die("ข้อผิดพลาด: ไม่สามารถเชื่อมต่อฐานข้อมูลได้");
}

// ดึงข้อมูลแอดมิน
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT username, email FROM admin_pl WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

if (!$admin) {
    session_destroy();
    header("Location: ad_pl_login.php");
    exit();
}

// ดึงข้อมูลพื้นฐาน
$villa_count = $conn->query("SELECT COUNT(*) FROM villas")->fetchColumn();
$booking_count = $conn->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แดชบอร์ดแอดมิน - Great Pool Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>แดชบอร์ดแอดมิน</h1>
        <div class="admin-info">
            <span>ยินดีต้อนรับ, <?php echo htmlspecialchars($admin['username']); ?></span>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
        </div>
    </header>

    <main class="dashboard-content">
        <h2>ภาพรวมระบบ</h2>
        <div class="dashboard-cards">
            <div class="card">
                <i class="fas fa-home"></i>
                <h3>จำนวนพูลวิลล่า</h3>
                <p><?php echo $villa_count; ?> หลัง</p>
            </div>
            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>จำนวนการจอง</h3>
                <p><?php echo $booking_count; ?> รายการ</p>
            </div>
        </div>

        <h2>เมนูการจัดการ</h2>
        <div class="dashboard-menu">
            <a href="manage_villas.php" class="menu-item"><i class="fas fa-home"></i> จัดการพูลวิลล่า</a>
            <a href="add_villas.php" class="menu-item"><i class="fas fa-plus-circle"></i> เพิ่มพูลวิลล่าใหม่</a>
            <a href="manage_bookings.php" class="menu-item"><i class="fas fa-calendar-check"></i> จัดการการจอง</a>
            <a href="manage_admins.php" class="menu-item"><i class="fas fa-users"></i> จัดการแอดมิน</a>
        </div>
    </main>

    <footer class="admin-footer">
        <p>© 2025 Great Pool Villa. All rights reserved.</p>
    </footer>
</body>
</html>