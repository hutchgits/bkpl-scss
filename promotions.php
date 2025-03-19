<?php
require_once '../haah/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// สมมติมีตาราง promotions ในอนาคต (ตอนนี้ใช้ข้อมูลคงที่)
$promotions = [
    [
        'title' => 'โปรโมชันวันหยุดยาว',
        'discount' => 'ลด 20% สำหรับการจอง 3 คืนขึ้นไป',
    ],
    [
        'title' => 'โปรโมชันสำหรับครอบครัว',
        'discount' => 'ลด 15% เมื่อจองวิลล่าสำหรับ 4 คน',
    ]
];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรโมชัน - Great Pool Villa</title>
    <link rel="stylesheet" href="scss/pl_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo"><a href="/index.php">Greatpoolvilla.com</a></div>
        <nav>
            <div class="hamburger"><i class="fas fa-bars"></i></div>
            <ul class="nav-menu">
                <li><a href="/index.php">หน้าแรก</a></li>
                <li><a href="/villas.php">วิลล่าทั้งหมด</a></li>
                <li><a href="/promotions.php">โปรโมชัน</a></li>
                <li><a href="/reviews.php">รีวิวจากลูกค้า</a></li>
                <li><a href="/contactus.php">ติดต่อเรา</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="promotion-section">
            <h1>โปรโมชันพิเศษ</h1>
            <?php foreach ($promotions as $promo): ?>
                <div class="promotion-card">
                    <h2 class="title"><?php echo htmlspecialchars($promo['title']); ?></h2>
                    <p class="discount"><?php echo htmlspecialchars($promo['discount']); ?></p>
                    <button class="book-now" onclick="alert('ระบบจองยังอยู่ในระหว่างการพัฒนา')">จองเลย</button>
                </div>
            <?php endforeach; ?>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <p>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</p>
            <p>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></p>
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