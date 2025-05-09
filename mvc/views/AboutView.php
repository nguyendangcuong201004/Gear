<?php
// Kết nối database với MySQLi
$host = 'localhost';
$dbname = 'gear';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hàm lấy nội dung đơn lẻ từ page_content
function getContent($conn, $section_name, $key) {
    $section_name = $conn->real_escape_string($section_name);
    $key = $conn->real_escape_string($key);
    
    $query = "
        SELECT pc.content 
        FROM page_content pc
        JOIN page_sections ps ON pc.section_id = ps.id
        WHERE ps.name = '$section_name' AND pc.`key` = '$key'
    ";
    
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['content'];
    }
    return '';
}

// Lấy dữ liệu cho Our Story
$our_story_paragraph_1 = getContent($conn, 'our_story', 'paragraph_1');
$our_story_paragraph_2 = getContent($conn, 'our_story', 'paragraph_2');
$banner_image = getContent($conn, 'our_story', 'banner_image');

// Lấy dữ liệu cho Mission & Values
$mission_quality_title = getContent($conn, 'mission_values', 'quality_title');
$mission_quality_item_1 = getContent($conn, 'mission_values', 'quality_item_1');
$mission_quality_item_2 = getContent($conn, 'mission_values', 'quality_item_2');
$mission_quality_item_3 = getContent($conn, 'mission_values', 'quality_item_3');
$mission_satisfaction_title = getContent($conn, 'mission_values', 'satisfaction_title');
$mission_satisfaction_item_1 = getContent($conn, 'mission_values', 'satisfaction_item_1');
$mission_satisfaction_item_2 = getContent($conn, 'mission_values', 'satisfaction_item_2');
$mission_satisfaction_item_3 = getContent($conn, 'mission_values', 'satisfaction_item_3');
$mission_innovation_title = getContent($conn, 'mission_values', 'innovation_title');
$mission_innovation_item_1 = getContent($conn, 'mission_values', 'innovation_item_1');
$mission_innovation_item_2 = getContent($conn, 'mission_values', 'innovation_item_2');
$mission_innovation_item_3 = getContent($conn, 'mission_values', 'innovation_item_3');

// Lấy dữ liệu cho Our Product Categories
$query = "
    SELECT pc.* 
    FROM product_categories pc
    JOIN page_sections ps ON pc.section_id = ps.id
    WHERE ps.name = 'product_categories'
    ORDER BY pc.display_order ASC
";
$result = $conn->query($query);
$product_categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_categories[] = $row;
    }
}

// Lấy dữ liệu cho Stats Section
$query = "
    SELECT s.* 
    FROM stats s
    JOIN page_sections ps ON s.section_id = ps.id
    WHERE ps.name = 'stats'
    ORDER BY s.display_order ASC
";
$result = $conn->query($query);
$stats = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stats[] = $row;
    }
}

// Lấy dữ liệu cho Our Journey
$query = "
    SELECT ji.* 
    FROM journey_items ji
    JOIN page_sections ps ON ji.section_id = ps.id
    WHERE ps.name = 'journey'
    ORDER BY ji.display_order ASC
";
$result = $conn->query($query);
$journey_items = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $journey_items[] = $row;
    }
}

// Lấy dữ liệu cho Our Team
$query = "
    SELECT tm.* 
    FROM team_members tm
    JOIN page_sections ps ON tm.section_id = ps.id
    WHERE ps.name = 'team'
    ORDER BY tm.display_order ASC
";
$result = $conn->query($query);
$team_members = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $team_members[] = $row;
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us - GearBK Store</title>
  <!-- Bootstrap CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
    crossorigin="anonymous"
  >
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Animate.css for basic animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Swiper for sliders -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <!-- Khác với trang trước, chỉ sử dụng Animate.css và không dùng AOS để đơn giản hóa -->
  <!-- <link rel="stylesheet" href="/Gear/public/css/blog.css"> -->
  <link rel="stylesheet" href="/Gear/public/css/AboutView.css">
  <!-- CSS thêm vào file ngoài hoặc <style> -->
  <style>
    body {
      background-color: #ffffff;
      color: #333333;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    /* Improve readability with better spacing */
    .about-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      margin-top: 60px; /* Add space between header and content */
    }
    
    /* Enhance section distinction */
    .about-section {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      padding: 30px;
      margin-bottom: 40px;
    }
    
    
  </style>
</head>
<body class="bg-light">
  <!-- Header -->
  <header>
        <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="header-inner-content">
                <div class="header-logo">
                <img src="/Gear/public/images/LogoGearBK.webp" alt="Logo">
                <span>GearBK</span>
                </div>
                <div class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="header-menu" id="header-menu">
                <ul>
                    <li><a href="/Gear">HOME</a></li>
                    <li><a href="/Gear/AboutController/index">ABOUT</a></li>
                    <li><a href="/Gear/ProductController/list">SHOP</a></li>
                    <li><a href="/Gear/ContactController">CONTACT</a></li>
                    <li><a href="/Gear/BlogController/list">BLOG</a></li>
                    <li><a href="/Gear/QAController/list">Q&A</a></li>
                </ul>
                </div>
                <div class="d-flex">
                <a href="/Gear/ProductController/list" class="header-shop"><i class="fa-solid fa-bag-shopping"></i></a>
                <?php if(isset($_COOKIE['access_token'])): ?>
                  <div class="header-user">
                    <a href="/Gear/AuthController/profile" title="Thông tin cá nhân" style="color: white; text-decoration: none;">
                      <i class="fa-solid fa-user"></i>
                    </a>
                  </div>
                  <div class="header-logout ml-3">
                    <a href="/Gear/AuthController/logout" title="Đăng xuất" style="color: white; text-decoration: none;">
                      <i class="fa-solid fa-sign-out-alt"></i> Đăng xuất
                    </a>
                  </div>
                <?php else: ?>
                  <div class="header-user">
                    <a href="/Gear/AuthController/login" title="Đăng nhập" style="color: white; text-decoration: none;">
                      <i class="fa-solid fa-user"></i>
                    </a>
                  </div>
                <?php endif; ?>
                </div>
            </div>
            </div>
        </div>
        </div>
    </header>

  <!-- Main Container -->
  <div class="about-container">
    <!-- Hero Section -->
    <section class="hero-section" style="background-image: url('/Gear/public/images/bgr_about.png') !important; background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; position: relative;">
      <!-- Direct image as backup -->
      <img src="/Gear/public/images/bgr_about.png" alt="Background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2; opacity: 0.8;">
      <div class="hero-content animate__animated animate__fadeInDown">
        <h1 class="hero-title">GearBK</h1>
        <p class="hero-subtitle">Đối tác tin cậy cho mọi phụ kiện và linh kiện công nghệ cao cấp</p>
        <a href="/Gear/ProductController/list" class="btn-hero btn-primary">Khám phá sản phẩm</a>
        <button id="btn-learn-more" class="btn-hero btn-secondary">Tìm hiểu thêm</button>
      </div>
    </section>

    <!-- Our Story Section -->
    <div id="our-story" class="about-section">
      <h2 class="section-title fade-in">Câu chuyện của chúng tôi</h2>
      <div class="row">
        <div class="col-lg-6 fade-in-left delay-1">
          <p><?= htmlspecialchars($our_story_paragraph_1); ?></p>
          <p><?= htmlspecialchars($our_story_paragraph_2); ?></p>
        </div>
        <div class="col-lg-6 fade-in-right delay-2">
          <img src="/Gear/<?= htmlspecialchars($banner_image); ?>" alt="GearBK Store" class="img-fluid rounded">
        </div>
      </div>
    </div>

    <!-- Mission Values Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Sứ mệnh & Giá trị</h2>
      <div class="row">
        <div class="col-md-4 mb-4 fade-in delay-1">
          <div class="info-card">
            <div class="icon-circle">
              <i class="fas fa-thumbs-up"></i>
            </div>
            <h4><?= htmlspecialchars($mission_quality_title); ?></h4>
            <ul class="info-list">
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_quality_item_1); ?></li>
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_quality_item_2); ?></li>
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_quality_item_3); ?></li>
            </ul>
          </div>
        </div>
        <div class="col-md-4 mb-4 fade-in delay-2">
          <div class="info-card">
            <div class="icon-circle">
              <i class="fas fa-users"></i>
            </div>
            <h4><?= htmlspecialchars($mission_satisfaction_title); ?></h4>
            <ul class="info-list">
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_satisfaction_item_1); ?></li>
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_satisfaction_item_2); ?></li>
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_satisfaction_item_3); ?></li>
            </ul>
          </div>
        </div>
        <div class="col-md-4 mb-4 fade-in delay-3">
          <div class="info-card">
            <div class="icon-circle">
              <i class="fas fa-lightbulb"></i>
            </div>
            <h4><?= htmlspecialchars($mission_innovation_title); ?></h4>
            <ul class="info-list">
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_innovation_item_1); ?></li>
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_innovation_item_2); ?></li>
              <li><i class="fas fa-angle-right"></i><?= htmlspecialchars($mission_innovation_item_3); ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Product Showcase Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Our Product Categories</h2>
      <div class="row">
        <div class="col-12 fade-in delay-1">
          <!-- Slider đơn giản hơn -->
          <div class="swiper productSwiper">
            <div class="swiper-wrapper">
              <?php foreach ($product_categories as $category): ?>
                <div class="swiper-slide">
                  <img src="/Gear/<?= htmlspecialchars($category['image_url']); ?>" alt="<?= htmlspecialchars($category['title']); ?>">
                  <div class="product-info">
                    <h4><?= htmlspecialchars($category['title']); ?></h4>
                    <p><?= htmlspecialchars($category['description']); ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <!-- Navigation buttons below the slider -->
          <div class="slider-navigation-container">
            <div class="swiper-button-prev custom-nav-btn"></div>
            <div class="swiper-button-next custom-nav-btn"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
      <div class="row">
        <?php foreach ($stats as $index => $stat): ?>
          <div class="col-md-3 col-6">
            <div class="stat-item fade-in delay-<?= $index + 1; ?>">
              <div class="stat-number" id="stat-<?= $index; ?>-count">0</div>
              <div><?= htmlspecialchars($stat['label']); ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Timeline Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Our Journey</h2>
      <div class="timeline">
        <?php foreach ($journey_items as $index => $item): ?>
          <div class="timeline-item <?= ($index % 2 == 0) ? 'left' : 'right'; ?> fade-in-<?= ($index % 2 == 0) ? 'left' : 'right'; ?> delay-<?= $index + 1; ?>">
            <div class="timeline-content">
              <h3><?= htmlspecialchars($item['year']); ?></h3>
              <p><?= htmlspecialchars($item['description']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Team Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Our Team</h2>
      <div class="row">
        <?php foreach ($team_members as $index => $member): ?>
          <div class="col-lg-3 col-md-6 mb-4 fade-in delay-<?= $index + 1; ?>">
            <div class="info-card">
              <div class="team-member">
                <div class="member-img">
                  <img src="/Gear/<?= htmlspecialchars($member['image_url']); ?>" alt="Team Member">
                </div>
                <h4><?= htmlspecialchars($member['name']); ?></h4>
                <p><?= htmlspecialchars($member['role']); ?></p>
                <p class="member-info"><?= htmlspecialchars($member['info']); ?></p>
                <div class="social-links">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Contact Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Connect With Us</h2>
      <div class="row">
        <div class="col-md-6 fade-in-left delay-1">
          <p><i class="fas fa-map-marker-alt" style="color: #dc3545; margin-right: 10px;"></i> 268 Đ. Lý Thường Kiệt, Phường 14, Quận 10, Hồ Chí Minh</p>
          <p><i class="fas fa-phone" style="color: #dc3545; margin-right: 10px;"></i> +84 123 456 789</p>
          <p><i class="fas fa-envelope" style="color: #dc3545; margin-right: 10px;"></i> info@gearbk.com</p>
          
          <div class="mt-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1959.7478390425963!2d106.6543134!3d10.7732967!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1745597886100!5m2!1svi!2s" width="100%" height="300" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        <div class="col-md-6 fade-in-right delay-2">
          <div class="info-card h-100">
            <h3 class="mb-4 text-center" style="color: #dc3545;">Our Core Values</h3>
            
            <div class="mb-4">
              <h5 style="color: #dc3545;"><i class="fas fa-star mr-2"></i> Excellence in Everything</h5>
              <p>We strive for excellence in every product and service we deliver, ensuring our customers receive only the best.</p>
            </div>
            
            <div class="mb-4">
              <h5 style="color: #dc3545;"><i class="fas fa-handshake mr-2"></i> Customer Partnership</h5>
              <p>We consider our customers as partners in our journey, working together to achieve mutual success.</p>
            </div>
            
            <div class="mb-4">
              <h5 style="color: #dc3545;"><i class="fas fa-shield-alt mr-2"></i> Trust & Reliability</h5>
              <p>Building trust through reliable products, honest communication, and exceptional service.</p>
            </div>
            
            <div class="social-links-large text-center mt-5">
              <h5 style="color: #dc3545;">Follow Us</h5>
              <div class="d-flex justify-content-center mt-3">
                <a href="#" class="mx-2" style="font-size: 24px;"><i class="fab fa-facebook"></i></a>
                <a href="#" class="mx-2" style="font-size: 24px;"><i class="fab fa-twitter"></i></a>
                <a href="#" class="mx-2" style="font-size: 24px;"><i class="fab fa-instagram"></i></a>
                <a href="#" class="mx-2" style="font-size: 24px;"><i class="fab fa-youtube"></i></a>
                <a href="#" class="mx-2" style="font-size: 24px;"><i class="fab fa-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Footer giống trang Q&A -->
    <div class="copyright-footer">
      <p>Copyright © <?= date('Y'); ?> GearBK</p>
    </div>
  </div>

  <!-- JS libraries -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script>
    // Code JavaScript đơn giản hơn
    document.addEventListener('DOMContentLoaded', function() {
      // Scroll to Our Story
      const btn = document.getElementById('btn-learn-more');
      btn.addEventListener('click', () => {
        const headerHeight = document.querySelector('header').offsetHeight;
        const target = document.getElementById('our-story').offsetTop - headerHeight;
        window.scrollTo({ top: target, behavior: 'smooth' });
      });
      
      // Khởi tạo Swiper cho sản phẩm
      var productSwiper = new Swiper(".productSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
          nextEl: '.custom-nav-btn.swiper-button-next',
          prevEl: '.custom-nav-btn.swiper-button-prev',
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
          },
          768: {
            slidesPerView: 3,
          },
          1024: {
            slidesPerView: 4,
          },
        },
        autoplay: {
          delay: 3000,
        },
        loop: true
      });
      
      // Hàm đếm số cho phần thống kê
      function animateCounter(elementId, targetNumber) {
        const element = document.getElementById(elementId);
        let currentNumber = 0;
        const increment = Math.ceil(targetNumber / 50); // Đếm nhanh hơn
        
        const interval = setInterval(() => {
          currentNumber += increment;
          
          if (currentNumber >= targetNumber) {
            element.textContent = targetNumber;
            clearInterval(interval);
          } else {
            element.textContent = currentNumber;
          }
        }, 50);
      }
      
      // Tạo một đối tượng IntersectionObserver đơn giản để kích hoạt đếm
      const statsSection = document.querySelector('.stats-section');
      
      // Chỉ theo dõi phần stats-section
      const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
          // Bắt đầu đếm khi phần tử hiển thị trong viewport
          <?php foreach ($stats as $index => $stat): ?>
            animateCounter('stat-<?= $index; ?>-count', <?= $stat['number']; ?>);
          <?php endforeach; ?>
          
          // Ngừng theo dõi sau khi đã kích hoạt
          observer.disconnect();
        }
      });
      
      observer.observe(statsSection);
      
      // Mobile menu toggle functionality
      const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
      const headerMenu = document.getElementById('header-menu');
      
      if (mobileMenuToggle && headerMenu) {
        mobileMenuToggle.addEventListener('click', function() {
          this.classList.toggle('active');
          headerMenu.classList.toggle('active');
        });
        
        // Close menu when clicking on a link
        const menuLinks = headerMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
          link.addEventListener('click', function() {
            mobileMenuToggle.classList.remove('active');
            headerMenu.classList.remove('active');
          });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
          const isClickInsideMenu = headerMenu.contains(event.target);
          const isClickOnToggle = mobileMenuToggle.contains(event.target);
          
          if (!isClickInsideMenu && !isClickOnToggle && headerMenu.classList.contains('active')) {
            mobileMenuToggle.classList.remove('active');
            headerMenu.classList.remove('active');
          }
        });
      }
    });
  </script>
</body>
</html>