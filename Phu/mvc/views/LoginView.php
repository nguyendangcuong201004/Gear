<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shop - GearBK Store</title>
  <!-- Bootstrap CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
    crossorigin="anonymous"
  >
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="/ltw/public/css/login.css">
  <link rel="stylesheet" href="/ltw/public/css/login2.css">
  <link rel="stylesheet" href="/ltw/public/css/login3.css">
  <!-- Inline CSS -->
  <style>
    /* Header full-width transparent black */
    header.site-header {
      background-color: rgba(0, 0, 0, 0.7);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }
    .header-inner-content {
      padding: 10px 0;
    }

    .header-inner-content .nav-link,
    .header-inner-content .header-logo span,
    .header-inner-content i {
      color: #fff !important;
    }
    .header-inner-content .nav-link:hover {
      color: #ddd !important;
    }
    /* Toast Popup */
    .alert-custom {
      position: fixed;
      top: 80px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 2000;
      max-width: 400px;
      text-align: center;
      font-weight: 500;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .alert-custom.hide {
      opacity: 0;
      top: 60px;
      transition: opacity 0.5s ease, top 0.5s ease;
    }
    /* Purple buttons */
    .btn-purple {
      background-color: #4a0072;
      color: #fff;
      border: none;
    }
    .btn-purple:hover {
      background-color: #6a1b9a;
      color: #fff;
    }
    .form-container {
        margin-left: 70px;
    }
    .ml-2 {
        color: white;
    }
    /* Center form vertically & horizontally under header */
    .form-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      height: calc(100vh - 60px);
      padding-top: 60px;
    }
  </style>
  <script src="/ltw/public/js/login.js" defer></script>
</head>
<body>
  <!-- Toast Popup -->
  <?php if (!empty($loginError) || !empty($registerError) || !empty($registerSuccess)): ?>
    <div id="toast" class="alert <?= !empty($registerSuccess) ? 'alert-success' : 'alert-danger' ?> alert-custom" role="alert">
      <?= htmlspecialchars($registerError ?? $loginError ?? $registerSuccess) ?>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast');
        setTimeout(() => {
          toast.classList.add('hide');
          setTimeout(() => toast.remove(), 500);
        }, 3000);
      });
    </script>
  <?php endif; ?>

  <!-- Navbar gốc -->
  <header class="site-header">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="header-inner-content d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="/ltw/public/images/LogoGearBK.webp" alt="GearBK Logo" style="height:40px;">
              <span class="ml-2">GearBK</span>
            </div>
            <nav>
              <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="/ltw">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="/ltw/AboutController/index">ABOUT</a></li>
                <li class="nav-item"><a class="nav-link" href="/ltw/shop">SHOP</a></li>
                <li class="nav-item"><a class="nav-link" href="/ltw/contact">CONTACT</a></li>
                <li class="nav-item"><a class="nav-link" href="/ltw/news">NEWS</a></li>
              </ul>
            </nav>
            <div>
              <a href="/ltw/cart" class="text-white mr-3"><i class="fa-solid fa-bag-shopping fa-lg"></i></a>
              <a href="/ltw/index.php?url=AuthController/login" class="text-white"><i class="fa-solid fa-user fa-lg"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="form-wrapper">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- Form Đăng nhập -->
          <div class="form-container" id="login-form" style="<?= !empty($showRegister) ? 'display:none;' : '' ?>">
            <h2 class="text-center mb-4 text-purple">Đăng nhập</h2>
            <form action="/ltw/index.php?url=AuthController/login" method="post">
              <div class="form-group">
                <input type="text" id="username" name="username" class="form-control" placeholder="Tên đăng nhập" required>
              </div>
              <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" required>
              </div>
              <button type="submit" class="btn btn-purple btn-block">Đăng nhập</button>
              <p class="text-center mt-3 text-red">Chưa có tài khoản? <a href="#" id="show-register-form">Đăng ký</a></p>
            </form>
          </div>

          <!-- Form Đăng ký -->
          <div class="form-container" id="register-form" style="<?= empty($showRegister) ? 'display:none;' : '' ?>">
            <h2 class="text-center mb-4 text-purple">Đăng ký</h2>
            <form action="/ltw/index.php?url=AuthController/login" method="post">
              <div class="form-group">
                <input type="text" id="register-username" name="register-username" class="form-control" placeholder="Tên đăng nhập" required>
              </div>
              <div class="form-group">
                <input type="password" id="register-password" name="register-password" class="form-control" placeholder="Mật khẩu" required>
              </div>
              <div class="form-group">
                <input type="email" id="register-email" name="register-email" class="form-control" placeholder="Email" required>
              </div>
              <button type="submit" class="btn btn-purple btn-block">Đăng ký</button>
              <p class="text-center mt-3 text-red">Đã có tài khoản? <a href="#" id="show-login-form">Đăng nhập</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS libraries -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>