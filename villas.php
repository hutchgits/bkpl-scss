<?php
require_once '../haah/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
    $checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
    $guests = isset($_GET['guests']) ? (int)$_GET['guests'] : 0;
    $bedrooms = isset($_GET['bedrooms']) ? (int)$_GET['bedrooms'] : 0;
    $price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
    $location = isset($_GET['location']) ? $_GET['location'] : '';
    $pet_allowed = isset($_GET['pet_allowed']) ? (int)$_GET['pet_allowed'] : -1;
    $sea_proximity = isset($_GET['sea_proximity']) ? $_GET['sea_proximity'] : '';

    // การตั้งค่าสำหรับ Pagination
    $per_page = 9; // จำนวนวิลล่าต่อหน้า
    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $per_page;

    $sql = "SELECT id, villa_code, title, bedrooms, bathrooms, price, capacity, image, location, pet_allowed, sea_proximity 
            FROM villas WHERE status = 'available'";
    $count_sql = "SELECT COUNT(*) FROM villas WHERE status = 'available'";
    $params = []; // เก็บค่าพารามิเตอร์

    if ($guests > 0) {
        $sql .= " AND capacity >= ?";
        $count_sql .= " AND capacity >= ?";
        $params[] = $guests;
    }
    if ($bedrooms > 0) {
        $sql .= " AND bedrooms >= ?";
        $count_sql .= " AND bedrooms >= ?";
        $params[] = $bedrooms;
    }
    if ($price_range) {
        if ($price_range === '0-5000') {
            $sql .= " AND price BETWEEN 0 AND 5000";
            $count_sql .= " AND price BETWEEN 0 AND 5000";
        } elseif ($price_range === '5000-10000') {
            $sql .= " AND price BETWEEN 5000 AND 10000";
            $count_sql .= " AND price BETWEEN 5000 AND 10000";
        } elseif ($price_range === '10000-15000') {
            $sql .= " AND price BETWEEN 10000 AND 15000";
            $count_sql .= " AND price BETWEEN 10000 AND 15000";
        } elseif ($price_range === '15000-20000') {
            $sql .= " AND price BETWEEN 15000 AND 20000";
            $count_sql .= " AND price BETWEEN 15000 AND 20000";
        } elseif ($price_range === '20000-30000') {
            $sql .= " AND price BETWEEN 20000 AND 30000";
            $count_sql .= " AND price BETWEEN 20000 AND 30000";
        } elseif ($price_range === '30000-40000') {
            $sql .= " AND price BETWEEN 30000 AND 40000";
            $count_sql .= " AND price BETWEEN 30000 AND 40000";
        } elseif ($price_range === '40000-50000') {
            $sql .= " AND price BETWEEN 40000 AND 50000";
            $count_sql .= " AND price BETWEEN 40000 AND 50000";
        } elseif ($price_range === '50000-70000') {
            $sql .= " AND price BETWEEN 50000 AND 70000";
            $count_sql .= " AND price BETWEEN 50000 AND 70000";
        } elseif ($price_range === '70000-90000') {
            $sql .= " AND price BETWEEN 70000 AND 90000";
            $count_sql .= " AND price BETWEEN 70000 AND 90000";
        } elseif ($price_range === '90000+') {
            $sql .= " AND price >= 90000";
            $count_sql .= " AND price >= 90000";
        }
    }
    if ($location) {
        $sql .= " AND location = ?";
        $count_sql .= " AND location = ?";
        $params[] = $location;
    }
    if ($pet_allowed !== -1) {
        $sql .= " AND pet_allowed = ?";
        $count_sql .= " AND pet_allowed = ?";
        $params[] = $pet_allowed;
    }
    if ($sea_proximity) {
        $sql .= " AND sea_proximity = ?";
        $count_sql .= " AND sea_proximity = ?";
        $params[] = $sea_proximity;
    }

    // นับจำนวนวิลล่าทั้งหมดสำหรับการคำนวณหน้า
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->execute($params);
    $total_villas = $count_stmt->fetchColumn();
    $total_pages = ceil($total_villas / $per_page);

    // ดึงข้อมูลวิลล่าตามหน้า (ใช้ LIMIT ด้วยตัวเลขโดยตรง)
    $sql .= " LIMIT $offset, $per_page"; // ใช้ตัวเลขแทน placeholder
    $stmt = $conn->prepare($sql);
    $stmt->execute($params); // ส่ง $params เฉพาะเงื่อนไข ไม่รวม offset, per_page
    $villas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($villas as &$villa) {
        $villa['display_name'] = preg_replace('/^' . preg_quote($villa['villa_code'], '/') . '\s*/', '', $villa['title']);
        $villa['sea_proximity_text'] = $villa['sea_proximity'] === 'beachfront' ? 'ติดทะเล' : ($villa['sea_proximity'] === 'near_sea' ? 'ใกล้ทะเล' : 'ห่างทะเล');
    }
    unset($villa);
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
    <meta name="description" content="ค้นหาพูลวิลล่าสุดหรูที่ Great Pool Villa หัวหินตามความต้องการของคุณ">
    <meta name="robots" content="index, follow">
    <title>รายการวิลล่า - Great Pool Villa หัวหิน</title>
    <link rel="stylesheet" href="scss/pl_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Filter Form */
        .filter-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
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
        }
        .search-btn:hover {
            background: #005f8c;
        }
        .search-btn i {
            margin-right: 5px;
        }

        /* Villa Grid */
        .villa-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
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
            image-rendering: optimizeQuality;
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

        /* Pagination */
        .pagination {
            max-width: 1200px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 5px;
            color: #007EBA;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
        }
        .pagination a:hover {
            background: #007EBA;
            color: #fff;
        }
        .pagination .active {
            background: #007EBA;
            color: #fff;
            border-color: #007EBA;
        }

        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
            }
            .input-group {
                min-width: 100%;
            }
            .villa-grid {
                grid-template-columns: 1fr;
            }
            .room-group, .pet-sea-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            .pagination a, .pagination span {
                padding: 6px 10px;
                margin: 0 3px;
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
    <section class="filter-section"><br><br>
        <h1>ค้นหาวิลล่าในฝันของคุณ</h1>
        <p>กรองวิลล่าตามความต้องการของคุณ แล้วเลือกที่พักที่ใช่!</p>
        <form class="filter-form" method="GET">
            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="location" placeholder="ตำแหน่ง (เช่น หัวหิน)" value="<?php echo htmlspecialchars($location); ?>">
            </div>
            <div class="input-group">
                <i class="fas fa-users"></i>
                <input type="number" name="guests" min="1" placeholder="จำนวนผู้เข้าพัก" value="<?php echo $guests > 0 ? $guests : ''; ?>">
            </div>
            <div class="input-group">
                <i class="fas fa-bed"></i>
                <input type="number" name="bedrooms" min="1" placeholder="จำนวนห้องนอน" value="<?php echo $bedrooms > 0 ? $bedrooms : ''; ?>">
            </div>
            <div class="input-group">
                <i class="fas fa-tag"></i>
                <select name="price_range">
                    <option value="" <?php echo !$price_range ? 'selected' : ''; ?>>เรทราคา (ทั้งหมด)</option>
                    <option value="0-5000" <?php echo $price_range === '0-5000' ? 'selected' : ''; ?>>0 - 5,000 บาท</option>
                    <option value="5000-10000" <?php echo $price_range === '5000-10000' ? 'selected' : ''; ?>>5,000 - 10,000 บาท</option>
                    <option value="10000-15000" <?php echo $price_range === '10000-15000' ? 'selected' : ''; ?>>10,000 - 15,000 บาท</option>
                    <option value="15000-20000" <?php echo $price_range === '15000-20000' ? 'selected' : ''; ?>>15,000 - 20,000 บาท</option>
                    <option value="20000-30000" <?php echo $price_range === '20000-30000' ? 'selected' : ''; ?>>20,000 - 30,000 บาท</option>
                    <option value="30000-40000" <?php echo $price_range === '30000-40000' ? 'selected' : ''; ?>>30,000 - 40,000 บาท</option>
                    <option value="40000-50000" <?php echo $price_range === '40000-50000' ? 'selected' : ''; ?>>40,000 - 50,000 บาท</option>
                    <option value="50000-70000" <?php echo $price_range === '50000-70000' ? 'selected' : ''; ?>>50,000 - 70,000 บาท</option>
                    <option value="70000-90000" <?php echo $price_range === '70000-90000' ? 'selected' : ''; ?>>70,000 - 90,000 บาท</option>
                    <option value="90000+" <?php echo $price_range === '90000+' ? 'selected' : ''; ?>>90,000+ บาท</option>
                </select>
            </div>
            <div class="input-group">
                <i class="fas fa-paw"></i>
                <select name="pet_allowed">
                    <option value="-1" <?php echo $pet_allowed == -1 ? 'selected' : ''; ?>>สัตว์เลี้ยง (ทั้งหมด)</option>
                    <option value="1" <?php echo $pet_allowed == 1 ? 'selected' : ''; ?>>รับสัตว์เลี้ยง</option>
                    <option value="0" <?php echo $pet_allowed == 0 ? 'selected' : ''; ?>>ไม่รับสัตว์เลี้ยง</option>
                </select>
            </div>
            <div class="input-group">
                <i class="fas fa-water"></i>
                <select name="sea_proximity">
                    <option value="" <?php echo !$sea_proximity ? 'selected' : ''; ?>>ระยะห่างทะเล (ทั้งหมด)</option>
                    <option value="beachfront" <?php echo $sea_proximity === 'beachfront' ? 'selected' : ''; ?>>ติดทะเล</option>
                    <option value="near_sea" <?php echo $sea_proximity === 'near_sea' ? 'selected' : ''; ?>>ใกล้ทะเล</option>
                    <option value="far_from_sea" <?php echo $sea_proximity === 'far_from_sea' ? 'selected' : ''; ?>>ห่างทะเล</option>
                </select>
            </div>
            <button type="submit" class="search-btn"><i class="fas fa-search"></i> ค้นหา</button>
        </form>
        <?php if ($checkin || $checkout || $guests || $bedrooms || $price_range || $location || $pet_allowed !== -1 || $sea_proximity): ?>
            <p style="text-align: center; margin-top: 15px;">ผลการค้นหาสำหรับ: 
                <?php echo "วันที่ " . ($checkin ?: 'ไม่ระบุ') . " ถึง " . ($checkout ?: 'ไม่ระบุ') . ", " . 
                           ($guests ?: 'ไม่ระบุ') . " ผู้เข้าพัก, " . 
                           ($bedrooms ?: 'ไม่ระบุ') . " ห้องนอน, " . 
                           ($price_range ? str_replace('-', ' - ', $price_range) . " บาท" : 'ราคาไม่ระบุ') . ", " . 
                           ($location ?: 'ตำแหน่งไม่ระบุ') . ", " . 
                           ($pet_allowed == 1 ? 'รับสัตว์เลี้ยง' : ($pet_allowed == 0 ? 'ไม่รับสัตว์เลี้ยง' : 'สัตว์เลี้ยงไม่ระบุ')) . ", " . 
                           ($sea_proximity ? ($sea_proximity === 'beachfront' ? 'ติดทะเล' : ($sea_proximity === 'near_sea' ? 'ใกล้ทะเล' : 'ห่างทะเล')) : 'ระยะห่างไม่ระบุ'); ?>
            </p>
        <?php endif; ?>
    </section>

    <section class="villa-grid">
        <?php if (empty($villas)): ?>
            <p style="text-align: center; padding: 20px;">ไม่มีวิลล่าที่ตรงกับเงื่อนไข กรุณาลองค้นหาใหม่ที่ <a href="/index.php">หน้าแรก</a></p>
        <?php else: ?>
            <?php foreach ($villas as $index => $villa): ?>
                <div class="villa-card" data-delay="<?php echo $index * 0.2; ?>">
                    <img src="<?php echo htmlspecialchars($villa['image'] ?? '/images/villa1.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($villa['title']); ?>" 
                         loading="lazy">
                    <div class="content">
                        <h3><?php echo htmlspecialchars($villa['villa_code'] . ' - ' . $villa['display_name'] . ' ' . ($villa['location'] ?? 'ไม่ระบุ')); ?></h3>
                        <div class="details">
                            <p class="room-group">
                                <span><i class="fas fa-bed"></i> <?php echo htmlspecialchars($villa['bedrooms'] ?? 'ไม่ระบุ'); ?> ห้องนอน</span>
                                <span><i class="fas fa-bath"></i> <?php echo htmlspecialchars($villa['bathrooms'] ?? 'ไม่ระบุ'); ?> ห้องน้ำ</span>
                            </p>
                            <p><i class="fas fa-users"></i> สูงสุด <?php echo htmlspecialchars($villa['capacity'] ?? 'ไม่ระบุ'); ?> ท่าน</p>
                            <p class="pet-sea-group">
                                <span><i class="fas fa-paw"></i> <?php echo $villa['pet_allowed'] ? 'รับสัตว์เลี้ยง' : 'ไม่รับสัตว์เลี้ยง'; ?></span>
                                <span><i class="fas fa-water"></i> <?php echo $villa['sea_proximity_text']; ?></span>
                            </p>
                        </div>
                        <div class="price"><i class="fas fa-tag"></i>เริ่มต้น ฿<?php echo number_format($villa['price'], 0); ?> / คืน</div>
                        <button onclick="bookVilla('<?php echo htmlspecialchars($villa['id']); ?>')">ดูรายละเอียด</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!-- Pagination -->
    <?php if (!empty($villas) && $total_pages > 1): ?>
        <div class="pagination">
            <?php
            $query_params = http_build_query(array_filter($_GET, function($key) {
                return $key !== 'page';
            }, ARRAY_FILTER_USE_KEY));
            $base_url = "/villas.php?" . $query_params . ($query_params ? "&" : "");

            // ปุ่ม Previous
            if ($page > 1) {
                echo "<a href='{$base_url}page=" . ($page - 1) . "'><i class='fas fa-chevron-left'></i> ก่อนหน้า</a>";
            }

            // ลิงก์เลขหน้า
            $range = 2; // จำนวนหน้าแสดงรอบ ๆ หน้าปัจจุบัน
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
        function bookVilla(villaId) {
            window.location.href = `/villas_detail.php?id=${villaId}`;
        }

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