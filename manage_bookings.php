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

// ดึงรายการการจองทั้งหมด
$stmt = $conn->query("SELECT b.*, v.title AS villa_title, v.villa_code FROM bookings b LEFT JOIN villas v ON b.villa_id = v.id ORDER BY b.id DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// อัปเดตสถานะการจอง
if (isset($_GET['update_status']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $status = $_GET['update_status'];
    $stmt = $conn->prepare("UPDATE bookings SET status = :status WHERE id = :id");
    if ($stmt->execute([':status' => $status, ':id' => $id])) {
        $success = "อัปเดตสถานะสำเร็จ!";
        header("Refresh:2");
    } else {
        $error = "เกิดข้อผิดพลาด: " . implode(", ", $stmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการการจอง - Great Pool Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="scss/pl_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>จัดการการจอง</h1>
        <a href="admin_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> กลับไปที่แดชบอร์ด</a>
    </header>

    <section class="manage-section">
        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <h2>รายการการจอง</h2>
        <table class="manage-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>รหัสวิลล่า</th>
                    <th>ชื่อวิลล่า</th>
                    <th>วันที่เช็คอิน</th>
                    <th>วันที่เช็คเอาท์</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['villa_code']); ?></td>
                        <td><?php echo htmlspecialchars($booking['villa_title']); ?></td>
                        <td><?php echo htmlspecialchars($booking['checkin_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['checkout_date']); ?></td>
                        <td><?php echo $booking['status'] === 'pending' ? 'รอ確認' : ($booking['status'] === 'confirmed' ? 'ยืนยันแล้ว' : 'ยกเลิก'); ?></td>
                        <td>
                            <a href="?update_status=confirmed&id=<?php echo $booking['id']; ?>" class="edit-btn"><i class="fas fa-check"></i> ยืนยัน</a>
                            <a href="?update_status=cancelled&id=<?php echo $booking['id']; ?>" class="delete-btn"><i class="fas fa-times"></i> ยกเลิก</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>