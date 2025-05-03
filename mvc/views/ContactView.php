<?php
// The settings are passed via $data, not directly as $settings
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - <?php echo isset($data['settings']['site_name']) ? $data['settings']['site_name'] : 'GearBK Store'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/contact.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-content">
                        <a class="inner-logo text-decoration-none text-dark" href="./">
                            <img src="<?php echo isset($data['settings']['logo_url']) ? $data['settings']['logo_url'] : 'public/images/LogoGearBK.webp'; ?>" alt="<?php echo isset($data['settings']['site_name']) ? $data['settings']['site_name'] : 'GearBK'; ?>">
                            <span><?php echo isset($data['settings']['site_name']) ? $data['settings']['site_name'] : 'GearBK'; ?></span>
                        </a>
                        <div class="inner-menu">
                            <ul>
                                <li>
                                    <a href="/HomeController">HOME</a>
                                </li>
                                <li>
                                    <a href="">ABOUT</a>
                                </li>
                                <li>
                                    <a href="">SHOP</a>
                                </li>
                                <li>
                                    <a href="/ContactController" class="active">CONTACT</a>
                                </li>
                                <li>
                                    <a href="">NEWS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="inner-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="inner-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Banner -->
    <div class="container-fluid py-4 py-md-5 bg-danger text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold">Liên Hệ Với Chúng Tôi</h1>
                    <p class="lead">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container py-4 py-md-5">
        <div class="row">
            <!-- Contact Form - Takes full width on mobile, 8/12 on larger screens -->
            <div class="col-12 col-lg-8 mb-4">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-3 p-md-4">
                        <h3 class="card-title mb-3 mb-md-4 fw-bold">Gửi Tin Nhắn</h3>
                        <div id="contactForm-response" class="alert d-none mb-4"></div>
                        <form id="contactForm" class="d-flex flex-column">
                            <div class="row g-3">
                                <div class="col-12 col-md-6 pt-2">
                                    <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-12 col-md-6 pt-2">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-12 col-md-6 pt-2">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-12 col-md-6 pt-2">
                                    <label for="subject" class="form-label">Chủ đề</label>
                                    <input type="text" class="form-control" id="subject" name="subject">
                                </div>
                                <div class="col-12 pt-2">
                                    <label for="message" class="form-label">Nội dung tin nhắn <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            Đăng ký nhận thông tin khuyến mãi qua email
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-muted small fst-italic">* Chúng tôi sẽ phản hồi trong vòng 24 giờ làm việc.</p>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                                        Gửi tin nhắn <i class="fas fa-paper-plane ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info - Takes full width on mobile, 4/12 on larger screens -->
            <div class="col-12 col-lg-4 d-flex flex-column">
                <div class="card shadow-sm border-0 rounded-3 mb-4 flex-grow-1">
                    <div class="card-body p-3 p-md-4">
                        <h3 class="card-title mb-3 mb-md-4 fw-bold">Thông Tin Liên Hệ</h3>
                        <p class="text-muted mb-4">Bạn có câu hỏi về sản phẩm hoặc dịch vụ của chúng tôi? Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ.</p>
                                
                        <div class="contact-info-item d-flex align-items-center mb-4">
                            <div class="icon-container me-3">
                                <i class="fas fa-map-marker-alt text-danger fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Địa Chỉ</h5>
                                <p class="text-muted mb-0"><?php echo isset($data['settings']['address']) ? $data['settings']['address'] : 'Chưa cập nhật'; ?></p>
                            </div>
                        </div>
                                
                        <div class="contact-info-item d-flex align-items-center mb-4">
                            <div class="icon-container me-3">
                                <i class="fas fa-phone-alt text-danger fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Điện Thoại</h5>
                                <p class="text-muted mb-0"><?php echo isset($data['settings']['phone']) ? $data['settings']['phone'] : 'Chưa cập nhật'; ?></p>
                            </div>
                        </div>
                                
                        <div class="contact-info-item d-flex align-items-center mb-4">
                            <div class="icon-container me-3">
                                <i class="fas fa-envelope text-danger fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p class="text-muted mb-0"><?php echo isset($data['settings']['email']) ? $data['settings']['email'] : 'Chưa cập nhật'; ?></p>
                            </div>
                        </div>
                                
                        <div class="contact-info-item d-flex align-items-start mb-4">
                            <div class="icon-container me-3">
                                <i class="fas fa-clock text-danger fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Giờ Mở Cửa</h5>
                                <table class="store-hours">
                                    <tr>
                                        <td class="pe-3">Thứ Hai - Thứ Sáu:</td>
                                        <td><?php echo isset($data['settings']['hours_weekday']) ? $data['settings']['hours_weekday'] : '08:00 - 17:30'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="pe-3">Thứ Bảy:</td>
                                        <td><?php echo isset($data['settings']['hours_saturday']) ? $data['settings']['hours_saturday'] : '08:00 - 12:00'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="pe-3">Chủ Nhật:</td>
                                        <td><?php echo isset($data['settings']['hours_sunday']) ? $data['settings']['hours_sunday'] : 'Đóng cửa'; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-3 p-md-4">
                        <h3 class="card-title mb-3 fw-bold">Theo Dõi Chúng Tôi</h3>
                        <div class="social-icons d-flex flex-wrap gap-3">
                            <a href="<?php echo isset($data['settings']['facebook_url']) ? $data['settings']['facebook_url'] : '#'; ?>" class="social-icon fs-4"><i class="fab fa-facebook-f text-primary"></i></a>
                            <a href="<?php echo isset($data['settings']['twitter_url']) ? $data['settings']['twitter_url'] : '#'; ?>" class="social-icon fs-4"><i class="fab fa-twitter text-info"></i></a>
                            <a href="<?php echo isset($data['settings']['instagram_url']) ? $data['settings']['instagram_url'] : '#'; ?>" class="social-icon fs-4"><i class="fab fa-instagram text-danger"></i></a>
                            <a href="<?php echo isset($data['settings']['youtube_url']) ? $data['settings']['youtube_url'] : '#'; ?>" class="social-icon fs-4"><i class="fab fa-youtube text-danger"></i></a>
                            <a href="<?php echo isset($data['settings']['tiktok_url']) ? $data['settings']['tiktok_url'] : '#'; ?>" class="social-icon fs-4"><i class="fab fa-tiktok text-dark"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="container-fluid p-0 my-4 my-md-5">
        <div class="map-container">
            <iframe src="<?php echo isset($data['settings']['map_embed_url']) ? $data['settings']['map_embed_url'] : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4946681015187!2d106.65718631539816!3d10.772020062162692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1650701542804!5m2!1svi!2s'; ?>" 
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mobile menu toggle
            $('.hamburger-menu').click(function() {
                $(this).toggleClass('active');
                $('.mobile-menu').toggleClass('active');
            });

            // Xử lý gửi form liên hệ
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                
                // Display loading alert
                Swal.fire({
                    title: 'Đang gửi...',
                    text: 'Vui lòng đợi trong giây lát',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/Gear/ContactController/submit',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log("Response:", response); // Debug logging
                        if (response.success) {
                            // Success alert
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Cảm ơn bạn! Tin nhắn của bạn đã được gửi thành công.',
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                            $('#contactForm')[0].reset();
                        } else {
                            // Error alert
                            Swal.fire({
                                title: 'Lỗi!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Đóng',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Debug logging
                        console.error("Response:", xhr.responseText); // Debug logging
                        
                        // Error alert
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi. Vui lòng thử lại sau. Chi tiết: ' + status,
                            icon: 'error',
                            confirmButtonText: 'Đóng',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            });
        });
    </script>

    <style>
        /* Responsive styles */
        @media (max-width: 768px) {
            .icon-container i {
                font-size: 1.5rem !important;
            }
            .store-hours {
                font-size: 0.9rem;
            }
        }

        /* Mobile menu styles */
        .hamburger-menu {
            display: none;
            cursor: pointer;
            width: 30px;
            height: 20px;
            position: relative;
            margin-left: 15px;
        }

        .hamburger-menu span {
            display: block;
            height: 2px;
            width: 100%;
            background: #000;
            position: absolute;
            left: 0;
            transition: all 0.3s;
        }

        .hamburger-menu span:first-child {
            top: 0;
        }

        .hamburger-menu span:nth-child(2) {
            top: 9px;
        }

        .hamburger-menu span:last-child {
            bottom: 0;
        }

        .hamburger-menu.active span:first-child {
            transform: rotate(45deg);
            top: 9px;
        }

        .hamburger-menu.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger-menu.active span:last-child {
            transform: rotate(-45deg);
            bottom: 9px;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            background: white;
            z-index: 1000;
            padding: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.active {
            transform: translateY(0);
            display: block;
        }

        .mobile-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-menu ul li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .mobile-menu ul li:last-child {
            border-bottom: none;
        }

        .mobile-menu ul li a {
            display: block;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            padding: 5px 15px;
        }

        .mobile-menu ul li a.active,
        .mobile-menu ul li a:hover {
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .inner-menu {
                display: none;
            }
            .hamburger-menu {
                display: block;
            }
        }

        /* Form responsive adjustments */
        @media (max-width: 576px) {
            textarea.form-control {
                min-height: 150px;
            }
        }

        /* Map responsiveness */
        .map-container {
            position: relative;
            padding-bottom: 400px;
            height: 0;
            overflow: hidden;
        }

        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        @media (max-width: 768px) {
            .map-container {
                padding-bottom: 75%;
            }
        }

        @media (max-width: 576px) {
            .map-container {
                padding-bottom: 100%;
            }
        }
    </style>
</body>

</html>
