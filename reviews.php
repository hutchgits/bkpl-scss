<?php
require_once '../haah/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // ใช้ session เพื่อแจ้งเตือน

// ตัวแปรสำหรับฟอร์ม
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    try {
        $villa_id = isset($_POST['villa_id']) ? (int)$_POST['villa_id'] : NULL;
        $customer_name = trim($_POST['customer_name']);
        $rating = (int)$_POST['rating'];
        $comment = trim($_POST['comment']);

        // ตรวจสอบข้อมูล
        if (empty($customer_name) || $rating < 1 || $rating > 5 || empty($comment)) {
            throw new Exception('กรุณากรอกข้อมูลให้ครบและถูกต้อง (คะแนน 1-5)');
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        $sql = "INSERT INTO reviews (villa_id, customer_name, rating, comment) VALUES (:villa_id, :customer_name, :rating, :comment)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':villa_id' => $villa_id,
            ':customer_name' => $customer_name,
            ':rating' => $rating,
            ':comment' => $comment
        ]);

        // เก็บข้อความสำเร็จใน session และ redirect
        $_SESSION['success_message'] = 'บันทึกรีวิวสำเร็จ! ขอบคุณสำหรับความคิดเห็นของคุณ';
        header('Location: reviews.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
        header('Location: reviews.php');
        exit;
    }
}

try {
    $per_page = 6;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $per_page;

    // ดึงรายการบ้านพักสำหรับ Dropdown
    $villas_sql = "SELECT id, villa_code, title FROM villas WHERE status = 'available'";
    $villas_stmt = $conn->prepare($villas_sql);
    $villas_stmt->execute();
    $villas = $villas_stmt->fetchAll(PDO::FETCH_ASSOC);

    // นับจำนวนรีวิว
    $count_sql = "SELECT COUNT(*) FROM reviews";
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->execute();
    $total_reviews = $count_stmt->fetchColumn();
    $total_pages = ceil($total_reviews / $per_page);

    // ดึงข้อมูลรีวิว
    $sql = "SELECT r.id, r.villa_id, r.customer_name, r.rating, r.comment, r.review_date, v.title AS villa_title, v.image AS villa_image 
            FROM reviews r 
            LEFT JOIN villas v ON r.villa_id = v.id 
            ORDER BY r.review_date DESC 
            LIMIT $offset, $per_page";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ดึงข้อความจาก session
    if (isset($_SESSION['success_message'])) {
        $success_message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        $error_message = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }
} catch(PDOException $e) {
    echo "ขออภัย ขณะนี้ระบบฐานข้อมูลมีปัญหา: " . $e->getMessage();
    error_log($e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="อ่านและกรอกรีวิวจากลูกค้าที่เข้าพักที่ Great Pool Villa หัวหิน">
    <meta name="robots" content="index, follow">
    <title>รีวิวจากลูกค้า - Great Pool Villa หัวหิน</title>
    <link rel="stylesheet" href="scss/pl_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* ทั่วไป */
        body {
            font-family: 'Prompt', sans-serif;
            background: linear-gradient(to bottom, #f0f4f8, #e0e7ef);
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, #007EBA, #004a72);
            padding: 15px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo a {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 700;
            text-decoration: none;
            margin-left: 30px;
            letter-spacing: 1px;
        }
        nav {
            float: right;
            margin-right: 30px;
        }
        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .nav-menu li {
            margin-left: 25px;
        }
        .nav-menu a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-menu a:hover {
            color: #ffd700;
        }
        .hamburger {
            display: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Review Form Section */
        .review-form-section {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .review-form-section h2 {
            font-size: 2.5rem;
            color: #87CEEB;
            margin-bottom: 15px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            background: linear-gradient(90deg, #87CEEB, #ADD8E6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .review-form-section p {
            font-size: 1.2rem;
            color: #4682B4;
            margin-bottom: 30px;
            font-style: italic;
        }
        .review-form {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(135, 206, 235, 0.7));
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15), 0 0 15px rgba(135, 206, 235, 0.2);
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            animation: floatIn 1s ease-out forwards;
            border: 1px solid rgba(135, 206, 235, 0.3);
        }
        .review-form::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(135, 206, 235, 0.1) 0%, transparent 70%);
            animation: sparkle 5s infinite ease-in-out;
            pointer-events: none;
        }
        .review-form:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2), 0 0 20px rgba(135, 206, 235, 0.3);
        }
        .input-group {
            position: relative;
            flex: 1;
            min-width: 250px;
        }
        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #87CEEB;
            font-size: 1.4rem;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .input-group input, .input-group select, .input-group textarea {
            width: 100%;
            padding: 15px 20px 15px 55px;
            border: 2px solid rgba(135, 206, 235, 0.3);
            border-radius: 12px;
            font-size: 1rem;
            color: #333;
            background: rgba(255, 255, 255, 0.95);
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .input-group input:focus, .input-group select:focus, .input-group textarea:focus {
            border-color: #87CEEB;
            box-shadow: 0 0 12px rgba(135, 206, 235, 0.3);
            transform: translateY(-2px);
        }
        .input-group input:focus + i, .input-group select:focus + i, .input-group textarea:focus + i {
            color: #4682B4;
            transform: translateY(-50%) scale(1.1);
        }
        .rating-group {
            flex: 1;
            min-width: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .rating-group label {
            font-size: 1rem;
            color: #333;
            margin-right: 15px;
            font-weight: 500;
        }
        .rating-group select {
            padding: 15px;
            width: 120px;
            border-radius: 12px;
            border: 2px solid rgba(135, 206, 235, 0.3);
        }
        .submit-btn {
            padding: 15px 40px;
            background: linear-gradient(135deg, #87CEEB, #ADD8E6);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(135, 206, 235, 0.3);
        }
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        .submit-btn:hover::before {
            left: 100%;
        }
        .submit-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(135, 206, 235, 0.4);
        }
        .submit-btn i {
            margin-right: 10px;
        }
        .message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-size: 1rem;
            font-weight: 500;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Review Grid */
        .review-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 30px;
            padding: 30px;
        }
        .review-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            border: 1px solid #e5e5e5;
        }
        .review-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        .review-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 4px solid #87CEEB;
            transition: transform 0.3s ease;
        }
        .review-card:hover img {
            transform: scale(1.05);
        }
        .review-content {
            padding: 25px;
        }
        .review-content h3 {
            font-size: 1.4rem;
            color: #87CEEB;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }
        .review-content h3 span {
            font-size: 0.9rem;
            color: #777;
            font-weight: 400;
        }
        .rating {
            margin-bottom: 15px;
        }
        .rating i {
            color: #ffd700;
            font-size: 1.2rem;
            margin-right: 3px;
        }
        .rating i.far {
            color: #ddd;
        }
        .review-content p {
            font-size: 1rem;
            color: #555;
            line-height: 1.7;
            margin-bottom: 15px;
        }
        .review-content .user {
            font-size: 0.95rem;
            color: #87CEEB;
            font-weight: 600;
            text-align: right;
        }

        /* Pagination */
        .pagination {
            max-width: 1200px;
            margin: 40px auto;
            text-align: center;
            padding: 15px;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 12px 18px;
            margin: 0 6px;
            color: #87CEEB;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }
        .pagination a:hover {
            background: #87CEEB;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(135, 206, 235, 0.3);
        }
        .pagination .active {
            background: #87CEEB;
            color: #fff;
            border-color: #87CEEB;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #333, #444);
            color: #fff;
            padding: 25px 0;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        .footer-content a {
            color: #87CEEB;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer-content a:hover {
            color: #fff;
            text-decoration: underline;
        }

        /* Animations */
        @keyframes floatIn {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes sparkle {
            0% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .review-form-section h2 {
                font-size: 1.8rem;
            }
            .review-form {
                flex-direction: column;
                padding: 25px;
            }
            .input-group, .rating-group {
                min-width: 100%;
            }
            .review-grid {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            .review-card img {
                height: 180px;
            }
            .review-content {
                padding: 20px;
            }
            .nav-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                right: 0;
                background: #007EBA;
                width: 200px;
                padding: 15px 0;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }
            .nav-menu.active {
                display: flex;
            }
            .nav-menu li {
                margin: 10px 0;
                text-align: center;
            }
            .hamburger {
                display: block;
                margin-right: 20px;
            }
            .pagination a, .pagination span {
                padding: 10px 14px;
                margin: 0 4px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"><a href="/index.php">Greatpoolvilla.com</a></div>
        <nav>
            <div class="hamburger"><i class="fas fa-bars"></i></div>
            <ul class="nav-menu">
                <li><a href="/index.php">หน้าแรก</a></li>
                <li><a href="/villas.php">วิลล่าทั้งหมด</a></li>
                <li><a href="/reviews.php">รีวิวจากลูกค้า</a></li>
                <li><a href="/contactus.php">ติดต่อเรา</a></li>
            </ul>
        </nav>
    </header>

    <section class="review-form-section">
        <h2>กรอกความคิดเห็นของคุณ</h2>
        <p>แบ่งปันประสบการณ์การเข้าพักของคุณกับเรา!</p>
        <?php if ($success_message): ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form class="review-form" method="POST" action="">
            <div class="input-group">
                <i class="fas fa-home"></i>
                <select name="villa_id" required>
                    <option value="">เลือกบ้านพัก</option>
                    <?php foreach ($villas as $villa): ?>
                        <option value="<?php echo $villa['id']; ?>">
                            <?php echo htmlspecialchars($villa['villa_code'] . ' - ' . $villa['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="customer_name" placeholder="ชื่อของคุณ" value="" required>
            </div>
            <div class="rating-group">
                <label for="rating">คะแนน:</label>
                <select name="rating" id="rating" required>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?> ดาว</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="input-group">
                <i class="fas fa-comment"></i>
                <textarea name="comment" placeholder="ความคิดเห็นของคุณ" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_review" class="submit-btn"><i class="fas fa-paper-plane"></i> ส่งรีวิว</button>
        </form>
    </section>

    <section class="review-grid">
        <?php if (empty($reviews)): ?>
            <p style="text-align: center; padding: 20px; font-size: 1.1rem; color: #777;">ยังไม่มีรีวิวในขณะนี้ กลับมาใหม่ในภายหลัง!</p>
        <?php else: ?>
            <?php foreach ($reviews as $index => $review): ?>
                <div class="review-card" data-delay="<?php echo $index * 0.2; ?>">
                    <img src="<?php echo htmlspecialchars($review['villa_image'] ?? '/images/villa1.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($review['villa_title'] ?? 'วิลล่า'); ?>" 
                         loading="lazy">
                    <div class="review-content">
                        <h3>
                            <?php echo htmlspecialchars($review['villa_title'] ?? 'วิลล่า'); ?>
                            <span><?php echo date('d M Y', strtotime($review['review_date'])); ?></span>
                        </h3>
                        <div class="rating">
                            <?php
                            $rating = (int)$review['rating']; // แก้ไขให้ใช้ $review['rating']
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="fas fa-star"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                        </div>
                        <p><?php echo htmlspecialchars($review['comment']); ?></p>
                        <p class="user">โดย: <?php echo htmlspecialchars($review['customer_name']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!-- Pagination -->
    <?php if (!empty($reviews) && $total_pages > 1): ?>
        <div class="pagination">
            <?php
            $query_params = http_build_query(array_filter($_GET, function($key) {
                return $key !== 'page';
            }, ARRAY_FILTER_USE_KEY));
            $base_url = "/reviews.php?" . $query_params . ($query_params ? "&" : "");

            // ปุ่ม Previous
            if ($page > 1) {
                echo "<a href='{$base_url}page=" . ($page - 1) . "'><i class='fas fa-chevron-left'></i> ก่อนหน้า</a>";
            }

            // ลิงก์เลขหน้า
            $range = 2;
            $start = max(1, $page - $range);
            $end = min($total_pages, $page + $range);

            for ($i = $start; $i <= $end; $i++) {
                $active = $i === $page ? 'active' : '';
                echo "<a href='{$base_url}page=$i' class='$active'>$i</a>";
            }

            // ปุ่ม Next
            if ($page < $total_pages) {
                echo "<a href='{$base_url}page=" . ($page + 1) . "'>ถัดไป <i class='fas fa-chevron-right'></i></a>";
            }
            ?>
        </div>
    <?php endif; ?>

    <footer>
        <div class="footer-content">
            <p>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</p>
            <p>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            const reviewCards = document.querySelectorAll('.review-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const card = entry.target;
                        const delay = card.getAttribute('data-delay') || '0';
                        card.style.animation = `fadeInUp 0.8s ease-out ${delay}s forwards`;
                        observer.unobserve(card);
                    }
                });
            }, { threshold: 0.2 });
            reviewCards.forEach(card => observer.observe(card));

            // Animation Keyframes
            const styleSheet = document.createElement('style');
            styleSheet.textContent = `
                @keyframes fadeInUp {
                    from { opacity: 0; transform: translateY(40px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(styleSheet);
        });
    </script>
</body>
</html>