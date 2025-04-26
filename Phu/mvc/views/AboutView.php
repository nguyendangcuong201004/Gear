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
  <link rel="stylesheet" href="/ltw/public/css/blog.css">
  <link rel="stylesheet" href="/ltw/public/css/AboutView.css">
  <!-- CSS thêm vào file ngoài hoặc <style> -->
  <style>
    /* Custom styles for slider navigation - keep these inline for consistency */
    .slider-navigation-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
      gap: 30px;
    }
    
    .custom-nav-btn {
      position: static !important;
      margin: 0 !important;
      width: 50px !important;
      height: 50px !important;
      background-color: #6a1b9a;
      border-radius: 50%;
      box-shadow: 0 3px 6px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }
    
    .custom-nav-btn:hover {
      background-color: #9c27b0;
      transform: scale(1.1);
    }
    
    .custom-nav-btn::after {
      font-size: 20px !important;
      color: white !important;
      font-weight: bold;
    }
    
    /* Hide default Swiper button border */
    .swiper-button-next:focus,
    .swiper-button-prev:focus {
      outline: none;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="header-inner-content">
            <div class="header-logo">
              <img src="/ltw/public/images/LogoGearBK.webp" alt="Logo">
              <span>GearBK</span>
            </div>
            <div class="header-menu">
              <ul>
                <li><a href="/ltw">HOME</a></li>
                <li><a href="/ltw/AboutController/index">ABOUT</a></li>
                <li><a href="/ltw/shop">SHOP</a></li>
                <li><a href="/ltw/contact">CONTACT</a></li>
                <li><a href="/ltw/news">NEWS</a></li>
                <li><a href="/ltw/QAController/list">Q&A</a></li>
              </ul>
            </div>
            <div class="d-flex">
              <div class="header-shop"><i class="fa-solid fa-bag-shopping"></i></div>
              <div class="header-user"><i class="fa-solid fa-user"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Container -->
  <div class="about-container">
    <!-- Hero Section -->


    <section class="hero-section">
      <div class="hero-content animate__animated animate__fadeInDown">
        <h1 class="hero-title">GearBK</h1>
        <p class="hero-subtitle">Đối tác tin cậy cho mọi phụ kiện và linh kiện công nghệ cao cấp</p>
        <a href="#products" class="btn-hero btn-primary">Khám phá sản phẩm</a>
        <button id="btn-learn-more" class="btn-hero btn-secondary">Tìm hiểu thêm</button>
      </div>
    </section>

    <!-- Our Story Section -->
    <div id="our-story" class="about-section">
      <h2 class="section-title fade-in">Câu chuyện của chúng tôi</h2>
      <div class="row">
        <div class="col-lg-6 fade-in-left delay-1">
          <p>GearBK được thành lập vào năm 2025 với sứ mệnh đơn giản: cung cấp cho những người đam mê công nghệ các linh kiện và phụ kiện máy tính chất lượng cao với giá cả cạnh tranh. Bắt đầu từ một cửa hàng trực tuyến nhỏ, GearBK đã phát triển thành một thương hiệu đáng tin cậy trên thị trường công nghệ Việt Nam.</p>
          <p>Đội ngũ của chúng tôi bao gồm những người yêu công nghệ nhiệt thành, tận tụy mang đến những sản phẩm mới nhất và tuyệt vời nhất cho khách hàng. Chúng tôi tin vào sức mạnh của công nghệ trong việc thay đổi cuộc sống và doanh nghiệp, và chúng tôi cam kết trở thành một phần của sự thay đổi đó.</p>
        </div>
        <div class="col-lg-6 fade-in-right delay-2">
          <img src="/ltw/public/images/Banner.jpg" alt="GearBK Store" class="img-fluid rounded">
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
            <h4>Chất lượng là ưu tiên hàng đầu</h4>
            <ul class="info-list">
              <li><i class="fas fa-angle-right"></i>Kiểm định chất lượng nghiêm ngặt cho từng sản phẩm</li>
              <li><i class="fas fa-angle-right"></i>Tuân thủ tiêu chuẩn quốc tế và chứng nhận an toàn</li>
              <li><i class="fas fa-angle-right"></i>Bảo hành 12 tháng và hỗ trợ kỹ thuật tận tâm</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4 mb-4 fade-in delay-2">
          <div class="info-card">
            <div class="icon-circle">
              <i class="fas fa-users"></i>
            </div>
            <h4>Sự hài lòng của khách hàng</h4>
            <ul class="info-list">
              <li><i class="fas fa-angle-right"></i>Hỗ trợ tư vấn 24/7 qua nhiều kênh</li>
              <li><i class="fas fa-angle-right"></i>Chính sách đổi trả linh hoạt trong 30 ngày</li>
              <li><i class="fas fa-angle-right"></i>Khảo sát & cải tiến dựa trên phản hồi khách hàng</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4 mb-4 fade-in delay-3">
          <div class="info-card">
            <div class="icon-circle">
              <i class="fas fa-lightbulb"></i>
            </div>
            <h4>Đổi mới sáng tạo</h4>
            <ul class="info-list">
              <li><i class="fas fa-angle-right"></i>Nghiên cứu & phát triển sản phẩm mới liên tục</li>
              <li><i class="fas fa-angle-right"></i>Hợp tác cùng startup công nghệ hàng đầu</li>
              <li><i class="fas fa-angle-right"></i>Cập nhật xu hướng công nghệ mới nhất</li>
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
              <div class="swiper-slide">
                <img src="/ltw/public/images/RTX.jpg" alt="Graphics Cards">
                <div class="product-info">
                  <h4>Graphics Cards</h4>
                  <p>Latest NVIDIA and AMD GPU options</p>
                </div>
              </div>
              <div class="swiper-slide">
                <img src="/ltw/public/images/RAM.jpg" alt="Memory">
                <div class="product-info">
                  <h4>Memory</h4>
                  <p>High-performance RAM for gaming and productivity</p>
                </div>
              </div>
              <div class="swiper-slide">
                <img src="/ltw/public/images/SSD.jpg" alt="Storage">
                <div class="product-info">
                  <h4>Storage</h4>
                  <p>Fast SSDs and reliable HDDs</p>
                </div>
              </div>
              <div class="swiper-slide">
                <img src="/ltw/public/images/AMD.jpg" alt="Processors">
                <div class="product-info">
                  <h4>Processors</h4>
                  <p>Intel and AMD CPUs for every need</p>
                </div>
              </div>
              <div class="swiper-slide">
                <img src="/ltw/public/images/demo-product.webp" alt="Peripherals">
                <div class="product-info">
                  <h4>Peripherals</h4>
                  <p>Keyboards, mice, and other accessories</p>
                </div>
              </div>
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
        <div class="col-md-3 col-6">
          <div class="stat-item fade-in delay-1">
            <div class="stat-number" id="customers-count">0</div>
            <div>Khách hàng hài lòng</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-item fade-in delay-2">
            <div class="stat-number" id="products-count">0</div>
            <div>Sản phẩm</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-item fade-in delay-3">
            <div class="stat-number" id="years-count">0</div>
            <div>Năm kinh nghiệm</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-item fade-in delay-4">
            <div class="stat-number" id="awards-count">0</div>
            <div>Giải thưởng</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Timeline Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Our Journey</h2>
      <div class="timeline">
        <div class="timeline-item left fade-in-left delay-1">
          <div class="timeline-content">
            <h3>2021</h3>
            <p>GearBK was founded as a small online store selling computer parts to local enthusiasts.</p>
          </div>
        </div>
        <div class="timeline-item right fade-in-right delay-2">
          <div class="timeline-content">
            <h3>2022</h3>
            <p>Opened our first physical store in Ho Chi Minh City, expanding our reach to local customers.</p>
          </div>
        </div>
        <div class="timeline-item left fade-in-left delay-3">
          <div class="timeline-content">
            <h3>2023</h3>
            <p>Became an official partner with major brands like ASUS, MSI, and NVIDIA, offering premium products.</p>
          </div>
        </div>
        <div class="timeline-item right fade-in-right delay-4">
          <div class="timeline-content">
            <h3>2024</h3>
            <p>Expanded our operations nationwide with three new stores and an enhanced online platform.</p>
          </div>
        </div>
        <div class="timeline-item left fade-in-left delay-5">
          <div class="timeline-content">
            <h3>2025</h3>
            <p>Launched our custom PC building service and expanded into gaming peripherals and accessories.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Team Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Our Team</h2>
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4 fade-in delay-1">
          <div class="info-card">
            <div class="team-member">
              <div class="member-img">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Team Member">
              </div>
              <h4>Vo Nguyen Duc Phat</h4>
              <p>Founder & CEO</p>
              <p class="member-info">10+ years in tech, passionate about innovation.</p>
              <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 fade-in delay-2">
          <div class="info-card">
            <div class="team-member">
              <div class="member-img">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Team Member">
              </div>
              <h4>Nguyen Trung Phu</h4>
              <p>Marketing Director</p>
              <p class="member-info">Expert in digital marketing, drives brand growth.</p>
              <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 fade-in delay-3">
          <div class="info-card">
            <div class="team-member">
              <div class="member-img">
                <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Team Member">
              </div>
              <h4>Nguyen Dang Cuong</h4>
              <p>Technical Director</p>
              <p class="member-info">Leads tech innovation with 8+ years of experience.</p>
              <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 fade-in delay-4">
          <div class="info-card">
            <div class="team-member">
              <div class="member-img">
                <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Team Member">
              </div>
              <h4>Hồ Tấn Phát</h4>
              <p>Technical Director</p>
              <p class="member-info">Focuses on user-centric product development.</p>
              <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Section -->
    <div class="about-section">
      <h2 class="section-title fade-in">Get In Touch</h2>
      <div class="row">
        <div class="col-md-6 fade-in-left delay-1">
          <p><i class="fas fa-map-marker-alt" style="color: #6a1b9a; margin-right: 10px;"></i> 268 Đ. Lý Thường Kiệt, Phường 14, Quận 10, Hồ Chí Minh</p>
          <p><i class="fas fa-phone" style="color: #6a1b9a; margin-right: 10px;"></i> +84 123 456 789</p>
          <p><i class="fas fa-envelope" style="color: #6a1b9a; margin-right: 10px;"></i> info@gearbk.com</p>
          
          <div class="mt-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1959.7478390425963!2d106.6543134!3d10.7732967!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1745597886100!5m2!1svi!2s" width="100%" height="300" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        <div class="col-md-6 fade-in-right delay-2">
          <!-- Hiển thị thông báo -->
          <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'success'): ?>
              <div class="alert alert-success" role="alert">
                Message sent successfully! We'll get back to you soon.
              </div>
            <?php elseif ($_GET['status'] == 'error'): ?>
              <div class="alert alert-danger" role="alert">
                Failed to send message. Please try again later.
              </div>
            <?php endif; ?>
          <?php endif; ?>
          
          <form method="POST" action="/ltw/send_email.php">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="Your Email" required>
            </div>
            <div class="form-group">
              <input type="text" name="subject" class="form-control" placeholder="Subject" required>
            </div>
            <div class="form-group">
              <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-block" style="background-color: #6a1b9a; color: white;">Send Message</button>
          </form>
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
          animateCounter('customers-count', 5000);
          animateCounter('products-count', 1200);
          animateCounter('years-count', 8);
          animateCounter('awards-count', 15);
          
          // Ngừng theo dõi sau khi đã kích hoạt
          observer.disconnect();
        }
      });
      
      observer.observe(statsSection);
    });
  </script>
</body>
</html> 