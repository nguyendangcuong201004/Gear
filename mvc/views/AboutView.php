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
    
    /* Improve headings */
    .section-title {
      color: #dc3545;
      font-weight: 600;
      margin-bottom: 30px;
      position: relative;
      padding-bottom: 15px;
      text-align: center;
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      display: block;
      width: 80px;
      height: 3px;
      background: #dc3545;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
    }
    
    /* Enhance info cards */
    .info-card {
      background-color: #ffffff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
      height: 100%;
      transition: all 0.3s ease;
    }
    
    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }
    
    /* Improve icon circles */
    .icon-circle {
      width: 60px;
      height: 60px;
      background-color: #f8d7da;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 15px;
    }
    
    .icon-circle i {
      color: #dc3545;
      font-size: 24px;
    }
    
    /* Enhance list items */
    .info-list {
      padding-left: 18px;
      list-style: none;
    }
    
    .info-list li {
      margin-bottom: 10px;
      position: relative;
      padding-left: 20px;
    }
    
    .info-list li i {
      position: absolute;
      left: 0;
      top: 4px;
      color: #dc3545;
    }
    
    /* Improve timeline */
    .timeline {
      position: relative;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .timeline::after {
      content: '';
      position: absolute;
      width: 4px;
      background-color: #dc3545;
      top: 0;
      bottom: 0;
      left: 50%;
      margin-left: -2px;
    }
    
    .timeline-item {
      position: relative;
      width: 50%;
      padding: 20px 40px;
    }
    
    .timeline-content {
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    
    .timeline-content::after {
      content: '';
      position: absolute;
      border: 10px solid #ffffff;
      top: 20px;
    }
    
    .left {
      left: 0;
    }
    
    .right {
      left: 50%;
    }
    
    .left .timeline-content::after {
      border-color: transparent transparent transparent white;
      right: -20px;
    }
    
    .right .timeline-content::after {
      border-color: transparent white transparent transparent;
      left: -20px;
    }
    
    /* Stats section improvements */
    .stats-section {
      background-color: transparent;
      padding: 40px 20px;
      border-radius: 0;
      margin-bottom: 40px;
      box-shadow: none;
    }
    
    .stat-item {
      text-align: center;
      padding: 15px 10px;
      background-color: transparent;
      border-radius: 8px;
      box-shadow: none;
      height: 100%;
      margin-bottom: 15px;
    }
    
    .stat-number {
      font-size: 36px;
      font-weight: bold;
      color: #dc3545;
      margin-bottom: 5px;
    }
    
    /* Team section improvements */
    .team-member {
      text-align: center;
    }
    
    .member-img {
      width: 120px;
      height: 120px;
      overflow: hidden;
      border-radius: 50%;
      margin: 0 auto 15px;
      border: 4px solid #f8d7da;
    }
    
    .member-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .social-links {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 15px;
    }
    
    .social-links a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      background-color: #f8d7da;
      border-radius: 50%;
      color: #dc3545;
      transition: all 0.3s ease;
    }
    
    .social-links a:hover {
      background-color: #dc3545;
      color: white;
    }
    
    /* Contact form improvements */
    .form-control {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 15px;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Hero section improvements */
    .hero-section {
      position: relative;
      padding: 100px 0;
      margin-bottom: 40px;
      border-radius: 10px;
      overflow: hidden;
    }
    
    .hero-content {
      position: relative;
      z-index: 1;
      text-align: center;
      color: white;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }
    
    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }
    
    .hero-title {
      font-size: 48px;
      font-weight: 700;
      margin-bottom: 15px;
    }
    
    .hero-subtitle {
      font-size: 20px;
      margin-bottom: 30px;
    }
    
    .btn-hero {
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      margin: 0 10px 10px;
      display: inline-block;
    }
    
    .btn-primary {
      background-color: #dc3545;
      border: none;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #e35d6a;
      transform: translateY(-3px);
    }
    
    .btn-secondary {
      background-color: transparent;
      border: 2px solid white;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: white;
      color: #dc3545;
      transform: translateY(-3px);
    }
    
    /* Product section improvements */
    .product-info {
      padding: 15px;
      background-color: white;
      border-radius: 0 0 8px 8px;
      text-align: center;
      opacity: 0; /* Hide description initially */
      transition: opacity 0.3s ease;
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      color: #dc3545; /* Set text color to red */
    }
    
    .product-info h4 {
      color: #dc3545;
      font-weight: 600;
    }
    
    .product-info p {
      color: #dc3545;
    }
    
    .swiper-slide {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      position: relative;
      height: 280px; /* Fixed height for consistent cards */
    }
    
    .swiper-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    /* Show description on hover */
    .swiper-slide:hover .product-info {
      opacity: 1;
      background-color: rgba(255, 255, 255, 0.9);
    }
    
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
      background-color: #dc3545;
      border-radius: 50%;
      box-shadow: 0 3px 6px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }
    
    .custom-nav-btn:hover {
      background-color: #e35d6a;
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
    
    /* Footer improvements */
    .copyright-footer {
      text-align: center;
      padding: 20px;
      background-color: #dc3545;
      color: white;
      margin-top: 40px;
      border-radius: 10px;
    }
    
    /* Responsive improvements */
    @media (max-width: 767px) {
      /* Timeline vertical line adjustments */
      .timeline::after {
        left: 20px;
        margin-left: 0;
      }
      
      /* Timeline item positioning and styling */
      .timeline-item {
        width: 100%;
        padding-left: 50px;
        padding-right: 15px;
        left: 0 !important;
        margin-bottom: 30px;
        animation: fadeInLeft 0.5s ease forwards !important; /* Override any other animations */
        opacity: 0;
      }
      
      /* Timeline items animation delay */
      .timeline-item:nth-child(1) { animation-delay: 0.1s !important; }
      .timeline-item:nth-child(2) { animation-delay: 0.2s !important; }
      .timeline-item:nth-child(3) { animation-delay: 0.3s !important; }
      .timeline-item:nth-child(4) { animation-delay: 0.4s !important; }
      .timeline-item:nth-child(5) { animation-delay: 0.5s !important; }
      
      /* Add circle indicators for each timeline item */
      .timeline-item::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #dc3545;
        border-radius: 50%;
        left: 10px;
        top: 20px;
        z-index: 1;
        box-shadow: 0 0 0 4px #f8d7da;
        transition: all 0.3s ease;
      }
      
      /* Subtle pulsing effect for the circle indicators */
      @keyframes pulseCircle {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
      }
      
      .timeline-item:hover::before {
        animation: pulseCircle 1s infinite;
      }
      
      /* Timeline content styling */
      .timeline-content {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        border-left: 3px solid #dc3545;
        transition: all 0.3s ease;
      }
      
      .timeline-content:hover {
        transform: translateX(5px);
      }
      
      /* Adjust pointer position */
      .left .timeline-content::after,
      .right .timeline-content::after {
        display: none; /* Remove the pointer triangles */
      }
      
      /* Year text styling */
      .timeline-content h3 {
        color: #dc3545;
        border-bottom: 1px solid #eee;
        padding-bottom: 8px;
        margin-bottom: 10px;
      }
      
      /* Description text spacing */
      .timeline-content p {
        margin-bottom: 0;
      }
      
      /* Fade in animation for timeline items */
      @keyframes fadeInLeft {
        from {
          opacity: 0;
          transform: translateX(-20px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }
    }
    
    /* Mobile menu styles */
    .mobile-menu-toggle {
      display: none;
      flex-direction: column;
      justify-content: space-between;
      width: 30px;
      height: 21px;
      cursor: pointer;
      z-index: 2000;
    }
    
    .mobile-menu-toggle span {
      display: block;
      height: 3px;
      width: 100%;
      background-color: white;
      border-radius: 3px;
      transition: all 0.3s ease;
    }
    
    /* Enhanced responsive styles for tablet and mobile */
    /* Tablet styles (768px - 992px) */
    @media (max-width: 992px) {
      .about-container {
        margin-top: 90px;
        padding: 0 15px;
      }
      
      .section-title {
        font-size: 26px;
      }
      
      .hero-title {
        font-size: 40px;
      }
      
      .hero-subtitle {
        font-size: 18px;
      }
      
      .btn-hero {
        padding: 10px 20px;
        font-size: 14px;
      }
      
      .icon-circle {
        width: 50px;
        height: 50px;
      }
      
      .icon-circle i {
        font-size: 20px;
      }
      
      .info-card {
        padding: 15px;
      }
      
      .info-card h4 {
        font-size: 18px;
      }
      
      .info-list li {
        font-size: 14px;
      }
      
      .stat-number {
        font-size: 30px;
      }
      
      .member-img {
        width: 100px;
        height: 100px;
      }
    }
    
    /* Mobile styles (up to 767px) */
    @media (max-width: 767px) {
      .about-container {
        margin-top: 80px;
        padding: 0 10px;
      }
      
      .about-section {
        padding: 20px 15px;
        margin-bottom: 30px;
      }
      
      .section-title {
        font-size: 22px;
        margin-bottom: 20px;
      }
      
      .hero-section {
        padding: 60px 0;
      }
      
      .hero-title {
        font-size: 32px;
      }
      
      .hero-subtitle {
        font-size: 16px;
        margin-bottom: 20px;
      }
      
      .btn-hero {
        padding: 8px 18px;
        margin: 0 5px 10px;
        font-size: 13px;
      }
      
      .info-card h4 {
        font-size: 16px;
      }
      
      /* Make the header menu responsive */
      .mobile-menu-toggle {
        display: flex;
      }
      
      .header-menu {
        display: none;
        position: fixed;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        padding: 15px;
        z-index: 1000;
      }
      
      .header-menu.active {
        display: block;
      }
      
      .header-menu ul {
        flex-direction: column;
        align-items: center;
      }
      
      .header-menu ul li {
        margin: 10px 0;
        width: 100%;
        text-align: center;
      }
      
      .header-menu ul li a {
        display: block;
        padding: 8px 0;
        font-size: 1rem;
      }
      
      /* Animation for hamburger to X */
      .mobile-menu-toggle.active span:nth-child(1) {
        transform: translateY(9px) rotate(45deg);
      }
      
      .mobile-menu-toggle.active span:nth-child(2) {
        opacity: 0;
      }
      
      .mobile-menu-toggle.active span:nth-child(3) {
        transform: translateY(-9px) rotate(-45deg);
      }
      
      /* Header content adjustments */
      .header-inner-content {
        flex-wrap: wrap;
        justify-content: space-between;
      }
      
      /* Timeline adjustments */
      .timeline-content {
        padding: 15px;
      }
      
      .timeline-content h3 {
        font-size: 18px;
      }
      
      /* Stats section */
      .stat-number {
        font-size: 26px;
      }
      
      .stat-item {
        margin-bottom: 20px;
      }
      
      /* Team section */
      .member-img {
        width: 90px;
        height: 90px;
      }
      
      .team-member h4 {
        font-size: 16px;
      }
      
      .team-member p {
        font-size: 14px;
      }
      
      .social-links a {
        width: 28px;
        height: 28px;
      }
      
      /* Swiper navigation */
      .custom-nav-btn {
        width: 40px !important;
        height: 40px !important;
      }
      
      .slider-navigation-container {
        gap: 20px;
      }
    }
    
    /* Small phones (up to 480px) */
    @media (max-width: 480px) {
      .about-container {
        margin-top: 70px;
      }
      
      .section-title {
        font-size: 20px;
      }
      
      .hero-title {
        font-size: 28px;
      }
      
      .hero-subtitle {
        font-size: 14px;
      }
      
      .btn-hero {
        padding: 8px 15px;
        font-size: 12px;
        width: 80%;
        margin-bottom: 10px;
      }
      
      .info-card {
        padding: 12px;
      }
      
      .info-list li {
        margin-bottom: 8px;
        font-size: 13px;
      }
      
      /* Timeline specific styles for small phones */
      .timeline::after {
        left: 15px;
      }
      
      .timeline-item {
        padding-left: 40px;
        padding-right: 10px;
        margin-bottom: 25px;
      }
      
      .timeline-item::before {
        width: 16px;
        height: 16px;
        left: 7px;
        top: 18px;
      }
      
      .timeline-content {
        padding: 15px;
      }
      
      .timeline-content h3 {
        font-size: 16px;
        padding-bottom: 6px;
        margin-bottom: 8px;
      }
      
      .timeline-content p {
        font-size: 13px;
      }
      
      .social-links-large a {
        width: 40px;
        height: 40px;
      }
      
      /* Header adjustments */
      .header-logo span {
        font-size: 16px;
      }
      
      .header-logo img {
        height: 30px;
      }
      
      .header-shop, .header-user {
        font-size: 16px;
      }
      
      .copyright-footer {
        padding: 15px;
        font-size: 14px;
      }
    }
    
    /* Enhanced social links for the Connect With Us section */
    .social-links-large a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      background-color: #f8d7da;
      border-radius: 50%;
      color: #dc3545;
      transition: all 0.3s ease;
    }
    
    .social-links-large a:hover {
      background-color: #dc3545;
      color: white;
      transform: translateY(-5px);
    }
    
    /* Core values styling */
    .info-card h5 {
      font-weight: 600;
    }
    
    .info-card p {
      color: #666;
      line-height: 1.6;
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
                    <li><a href="/Gear/contact">CONTACT</a></li>
                    <li><a href="/Gear/BlogController/list">BLOG</a></li>
                    <li><a href="/Gear/QAController/list">Q&A</a></li>
                </ul>
                </div>
                <div class="d-flex">
                <div class="header-shop"><i class="fa-solid fa-bag-shopping"></i></div>
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
        <a href="#products" class="btn-hero btn-primary">Khám phá sản phẩm</a>
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
          <img src="<?= htmlspecialchars($banner_image); ?>" alt="GearBK Store" class="img-fluid rounded">
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
                  <img src="<?= htmlspecialchars($category['image_url']); ?>" alt="<?= htmlspecialchars($category['title']); ?>">
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
                  <img src="<?= htmlspecialchars($member['image_url']); ?>" alt="Team Member">
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