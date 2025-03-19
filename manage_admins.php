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

// ดึงรายการแอดมินทั้งหมด
$stmt = $conn->query("SELECT id, username, email FROM admin_pl ORDER BY id DESC");
$admins = $stmt->fetchAll();

// ลบแอดมิน
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id === $_SESSION['admin_id']) {
        $error = "คุณไม่สามารถลบตัวเองได้!";
    } else {
        $stmt = $conn->prepare("DELETE FROM admin_pl WHERE id = ?");
        if ($stmt->execute([$id])) {
            $success = "ลบแอดมินสำเร็จ!";
            header("Refresh:2");
        } else {
            $error = "เกิดข้อผิดพลาด: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการแอดมิน - Great Pool Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>จัดการแอดมิน</h1>
        <a href="admin_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> กลับไปที่แดชบอร์ด</a>
    </header>

    <main class="manage-section">
        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <h2>รายการแอดมิน</h2>
        <table class="manage-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>อีเมล</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['id']); ?></td>
                        <td><?php echo htmlspecialchars($admin['username']); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td>
                            <a href="?delete=<?php echo $admin['id']; ?>" class="delete-btn" onclick="return confirm('แน่ใจหรือไม่ว่าต้องการลบ?')"><i class="fas fa-trash"></i> ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="ad_pl_register.php">เพิ่มแอดมินใหม่</a></p>
    </main>
</body>
</html>