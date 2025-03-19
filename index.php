<?php
require_once '../haah/config.php';

// กำหนดภาพพื้นหลังตามวัน
$hero_images = [
    'Mon' => '/images/hero/poolvilla-monday.webp',
    'Tue' => '/images/hero/poolvilla-tuesday.webp',
    'Wed' => '/images/hero/poolvilla-wednesday.webp',
    'Thu' => '/images/hero/poolvilla-thursday.webp',
    'Fri' => '/images/hero/poolvilla-friday.webp',
    'Sat' => '/images/hero/poolvilla-saturday.webp',
    'Sun' => '/images/hero/poolvilla-sunday.webp'
];
$today = date('D');
$hero_image = $hero_images[$today] ?? '/images/hero/poolvilla-sunday.webp';

try {
    // ดึงวิลล่าแนะนำ (เปลี่ยนจาก LIMIT 3 เป็น LIMIT 9)
    $stmt = $conn->query("SELECT id, villa_code, title, bedrooms, bathrooms, capacity, price, pet_allowed, location, image FROM villas WHERE status = 'available' LIMIT 6");
    $villas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log($e->getMessage());
    $villas = [];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Great Pool Villa หัวหิน - พูลวิลล่าสุดหรู</title>
    <link rel="stylesheet" href="scss/pl_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Header และ Hamburger Menu */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #007EBA;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo a {
            font-size: 1.5rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
        }
        nav {
            display: flex;
            align-items: center;
        }
        .hamburger {
            font-size: 1.5rem;
            cursor: pointer;
            color: #fff;
            display: none;
        }
        .nav-menu {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        .nav-menu li {
            margin-left: 20px;
        }
        .nav-menu li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s;
        }
        .nav-menu li a:hover {
            color: #e0f7ff;
        }
        .nav-menu.active {
            display: flex !important;
            flex-direction: column;
            position: absolute;
            top: 60px;
            right: 20px;
            background: #007EBA;
            padding: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }
        .nav-menu.active li {
            margin: 10px 0;
        }
        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }
            .nav-menu {
                display: none;
                width: 200px;
            }
            .nav-menu.active {
                display: flex;
            }
        }

        /* ปรับแต่ง Hero */
        .hero {
            position: relative;
            height: 100vh;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            image-rendering: optimizeQuality; /* ปรับให้ภาพชัดขึ้น */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-bottom: 50px;
        }
        .hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.6));
        }
        .hero .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 30px;
            color: #fff;
            width: 100%;
        }
        .hero .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }
        .hero .hero-content p {
            font-size: 1.4rem;
            font-weight: 300;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto 40px auto;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }
        @media (max-width: 768px) {
            .hero {
                height: 80vh;
            }
            .hero .hero-content h1 {
                font-size: 2.5rem;
            }
            .hero .hero-content p {
                font-size: 1.1rem;
            }
        }

        /* Filter Form */
        .filter-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .filter-section h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }
        .filter-section p {
            font-size: 1rem;
            color: #555;
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            justify-content: center;
            animation: slideUp 0.8s ease-out;
        }
        .input-group {
            position: relative;
            flex: 1;
            min-width: 200px;
        }
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #007EBA;
            font-size: 1.2rem;
        }
        .input-group input, .input-group select {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
            outline: none;
            transition: border-color 0.3s;
            font-family: 'Prompt', sans-serif;
        }
        .input-group input:focus, .input-group select:focus {
            border-color: #007EBA;
        }
        .search-btn {
            padding: 12px 25px;
            background: #007EBA;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            font-family: 'Prompt', sans-serif;
        }
        .search-btn:hover {
            background: #005f8c;
        }
        .search-btn i {
            margin-right: 5px;
        }
        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
            }
            .input-group {
                min-width: 100%;
            }
        }

        .featured-villas {
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 40px auto;
            animation: slideUp 0.8s ease-out 0.2s backwards;
        }
        .featured-villas h1 {
            font-size: 2rem;
            color: #007EBA;
            margin-bottom: 15px;
            text-align: center;
        }
        .featured-villas p {
            font-size: 1rem;
            color: #555;
            text-align: center;
            margin-bottom: 20px;
        }
        .villa-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 0;
        }
        .villa-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }
        .villa-card:hover {
            transform: translateY(-5px);
        }
        .villa-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            image-rendering: optimizeQuality; /* ปรับให้ภาพในการ์ดชัดขึ้นด้วย */
        }
        .content {
            padding: 15px;
        }
        .content h3 {
            font-size: 1.2rem;
            color: #007EBA;
            margin-bottom: 10px;
        }
        .details p {
            font-size: 0.9rem;
            color: #555;
            margin: 5px 0;
        }
        .details i {
            margin-right: 5px;
            color: #007EBA;
        }
        .room-group, .pet-sea-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .price {
            font-size: 1rem;
            color: #333;
            margin: 10px 0;
        }
        .price i {
            margin-right: 5px;
            color: #007EBA;
        }
        .content button {
            width: 100%;
            padding: 10px;
            background: #007EBA;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .content button:hover {
            background: #005f8c;
        }
        @media (max-width: 768px) {
            .featured-villas {
                padding: 15px;
            }
            .villa-grid {
                grid-template-columns: 1fr;
            }
            .room-group, .pet-sea-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }

        /* Animation */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"><a href="/index.php">Greatpoolvilla.com</a></div>
        <nav>
            <div class="hamburger"><i class="fas fa-bars"></i></div>
            <ul class="nav-menu"> 
			<li><a href="#">หน้าแรก</a></li>
                <li><a href="/villas.php">วิลล่าทั้งหมด</a></li>
                <li><a href="/reviews.php">รีวิวจากลูกค้า</a></li>
                <li><a href="/contactus.php">ติดต่อเรา</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero" style="background-image: url('<?php echo htmlspecialchars($hero_image); ?>');">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>พูลวิลล่า ชะอำ หัวหิน ปราณบุรี</h1>
            <p>พักผ่อนกับวิวทะเลสุดอลังการที่พูลวิลล่าติดชายหาดใน ชะอำ | หัวหิน | ปราณบุรี สระส่วนตัวพร้อมพื้นที่กว้างขวางสำหรับทุกกิจกรรมของคุณ จัดปาร์ตี้ริมสระ หรือสัมผัสความเงียบสงบท่ามกลางความงามของธรรมชาติ เพลิดเพลินกับวันหยุดที่ไม่เหมือนใคร</p>
        </div>
    </section>

    <!-- ระบบค้นหา (อยู่ใต้ Hero) -->
    <section class="filter-section">
        <h1>ค้นหาวิลล่าในฝันของคุณ</h1>
        <p><h2>กรองวิลล่าตามความต้องการของคุณ แล้วเลือกที่พักที่ใช่ !</h2></p>
        <form class="filter-form" method="GET" action="/villas.php">
            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="location" placeholder="ตำแหน่ง (เช่น หัวหิน)" value="">
            </div>
            <div class="input-group">
                <i class="fas fa-users"></i>
                <input type="number" name="guests" min="1" placeholder="จำนวนผู้เข้าพัก" value="">
            </div>
            <div class="input-group">
                <i class="fas fa-bed"></i>
                <input type="number" name="bedrooms" min="1" placeholder="จำนวนห้องนอน" value="">
            </div>
            <div class="input-group">
                <i class="fas fa-tag"></i>
                <select name="price_range">
                    <option value="">เรทราคา (ทั้งหมด)</option>
                    <option value="0-5000">0 - 5,000 บาท</option>
                    <option value="5000-10000">5,000 - 10,000 บาท</option>
                    <option value="10000-15000">10,000 - 15,000 บาท</option>
                    <option value="15000-20000">15,000 - 20,000 บาท</option>
                    <option value="20000-30000">20,000 - 30,000 บาท</option>
                    <option value="30000-40000">30,000 - 40,000 บาท</option>
                    <option value="40000-50000">40,000 - 50,000 บาท</option>
                    <option value="50000-70000">50,000 - 70,000 บาท</option>
                    <option value="70000-90000">70,000 - 90,000 บาท</option>
                    <option value="90000+">90,000+ บาท</option>
                </select>
            </div>
            <div class="input-group">
                <i class="fas fa-paw"></i>
                <select name="pet_allowed">
                    <option value="-1">สัตว์เลี้ยง (ทั้งหมด)</option>
                    <option value="1">รับสัตว์เลี้ยง</option>
                    <option value="0">ไม่รับสัตว์เลี้ยง</option>
                </select>
            </div>
            <div class="input-group">
                <i class="fas fa-water"></i>
                <select name="sea_proximity">
                    <option value="">ระยะห่างทะเล (ทั้งหมด)</option>
                    <option value="beachfront">ติดทะเล</option>
                    <option value="near_sea">ใกล้ทะเล</option>
                    <option value="far_from_sea">ห่างทะเล</option>
                </select>
            </div>
            <button type="submit" class="search-btn"><i class="fas fa-search"></i> ค้นหา</button>
        </form>
    </section>

    <!-- วิลล่าแนะนำ (ปรับให้แสดง 9 บ้านพัก) -->
    <section class="featured-villas">
        <h1>วิลล่าแนะนำ</h1>
         <p><h2>ติดต่อสอบถามที่พักได้ที่ คุณเมย์ โทร. <a href="tel:0899422914">089-9422914</a> หรือ <a href="/contactus.php">แบบฟอร์มติดต่อ</a></h2></p>
        <div class="villa-grid">
            <?php foreach ($villas as $index => $villa): ?>
                <div class="villa-card" data-delay="<?php echo $index * 0.2; ?>">
                    <img src="<?php echo htmlspecialchars($villa['image'] ?? '/images/villa1.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($villa['title']); ?>" 
                         loading="lazy">
                    <div class="content">
                        <h3>
                            <?php echo htmlspecialchars($villa['villa_code'] . ' ' . $villa['title'] . ' - ' . $villa['location']); ?>
                        </h3>
                        <div class="details">
                            <div class="room-group">
                                <p><i class="fas fa-bed"></i> <?php echo $villa['bedrooms']; ?> ห้องนอน</p>
                                <p><i class="fas fa-bath"></i> <?php echo $villa['bathrooms']; ?> ห้องน้ำ</p>
                                <p><i class="fas fa-users"></i> <?php echo $villa['capacity']; ?> ท่าน</p>
                            </div>
                            <div class="pet-sea-group">
                                <p>
                                    <i class="fas fa-paw"></i> 
                                    <?php echo $villa['pet_allowed'] ? 'รับสัตว์เลี้ยง' : 'ไม่รับสัตว์เลี้ยง'; ?>
                                </p>
                                <p>
                                    <i class="fas fa-water"></i> 
                                    <?php echo stripos($villa['location'], 'หาด') !== false ? 'ใกล้ทะเล' : 'ไกลทะเล'; ?>
                                </p>
                            </div>
                        </div>
                        <div class="price"><i class="fas fa-tag"></i>เริ่มต้น ฿<?php echo number_format($villa['price'], 0); ?> / คืน</div>
                        <button onclick="bookVilla('<?php echo $villa['id']; ?>')">จองเลย</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p>© 2025 Great Pool Villa. สงวนลิขสิทธิ์.</p>
            <p>ติดต่อเรา: <a href="mailto:info@greatpoolvilla.com">info@greatpoolvilla.com</a> | โทร. <a href="tel:0899422914">089-9422914</a></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function bookVilla(villaId) {
            alert('ระบบจองยังอยู่ในระหว่างการพัฒนา กรุณาติดต่อ โทร.098 462 2914 คุณเมย์');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Hamburger Menu
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

            // Villa Cards Animation
            const villaCards = document.querySelectorAll('.villa-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const card = entry.target;
                        const delay = card.getAttribute('data-delay') || '0';
                        card.style.animation = `slideUp 0.8s ease-out ${delay}s forwards`;
                        observer.unobserve(card);
                    }
                });
            }, { threshold: 0.2 });
            villaCards.forEach(card => observer.observe(card));

            // Animation Keyframes
            const styleSheet = document.createElement('style');
            styleSheet.textContent = `
                @keyframes slideUp {
                    from { opacity: 0; transform: translateY(50px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(styleSheet);
        });
    </script>
</body>
</html>