<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập - GearBK Store</title>
  <!-- Bootstrap CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
    crossorigin="anonymous"
  >
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Animate.css for animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="/Gear/public/css/login.css">
  <link rel="stylesheet" href="/Gear/public/css/login2.css">
  <link rel="stylesheet" href="/Gear/public/css/login3.css">
  <!-- Inline CSS -->
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    html, body {
  height: auto;
  min-height: 100%;
  overflow-x: hidden;
  overflow-y: auto;
}

    body {
      font-family: 'Montserrat', sans-serif;
      background: url('/Gear/public/images/background_login.webp') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      overflow-y: auto;
      flex-direction: column;
    }
    
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
      color: #6a1b9a !important;
      transition: color 0.3s ease;
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
      animation: fadeIn 0.5s;
    }
    
    .alert-custom.hide {
      opacity: 0;
      top: 60px;
      transition: opacity 0.5s ease, top 0.5s ease;
    }
    
    /* Form styling */
    .form-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 1;
      padding-top: 80px;
      padding-bottom: 30px;
    }
    
    .form-container {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      animation: fadeIn 0.6s;
      border-left: 5px solid #6a1b9a;
    }
    
    .form-container h2 {
      color: #4a0072;
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
      position: relative;
      padding-bottom: 10px;
    }
    
    .form-container h2:after {
      content: '';
      position: absolute;
      width: 60px;
      height: 3px;
      background: #6a1b9a;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      font-weight: 500;
      color: #555;
      margin-bottom: 6px;
      display: block;
    }
    
    .form-control {
      border-radius: 8px;
      padding: 12px 15px;
      border: 1px solid #ddd;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      border-color: #6a1b9a;
      box-shadow: 0 0 0 0.2rem rgba(106, 27, 154, 0.25);
    }
    
    .form-check-label {
      color: #555;
      font-size: 0.9em;
    }
    
    /* Button styles */
    .btn-purple {
      background-color: #6a1b9a;
      color: #fff;
      border: none;
      border-radius: 30px;
      padding: 12px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
      width: 100%;
      margin-top: 10px;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
    }
    
    .btn-purple:hover {
      background-color: #4a0072;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      color: #fff;
    }
    
    .text-purple {
      color: #6a1b9a;
    }
    
    .form-container a {
      color: #6a1b9a;
      font-weight: 500;
      transition: all 0.3s;
    }
    
    .form-container a:hover {
      color: #4a0072;
      text-decoration: none;
    }
    
    /* Icon styling */
    .input-icon {
      position: relative;
    }
    
    .input-icon i {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      left: 15px;
      color: #6a1b9a;
    }
    
    .input-icon input {
      padding-left: 45px;
    }
    
    .form-switch-text {
      text-align: center;
      margin-top: 20px;
      color: #666;
    }
    
    .form-divider {
      display: flex;
      align-items: center;
      margin: 20px 0;
    }
    
    .form-divider:before,
    .form-divider:after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #ddd;
    }
    
    .form-divider span {
      padding: 0 10px;
      color: #888;
      font-size: 0.9em;
    }
    
    /* Copyright */
    .copyright {
      text-align: center;
      color: white;
      margin-top: 20px;
      margin-bottom: 10px;
      font-size: 0.9em;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }
    
  </style>
  <script src="/Gear/public/js/login.js" defer></script>
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

  <!-- Navbar -->
  <header class="site-header">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="header-inner-content d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <img src="/Gear/public/images/LogoGearBK.webp" alt="GearBK Logo" style="height:40px;">
              <span class="ml-2">GearBK</span>
            </div>
            <nav>
              <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="/Gear">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="/Gear/AboutController/index">ABOUT</a></li>
                <li class="nav-item"><a class="nav-link" href="/Gear/ProductController/list">SHOP</a></li>
                <li class="nav-item"><a class="nav-link" href="/Gear/contact">CONTACT</a></li>
                <li class="nav-item"><a class="nav-link" href="/Gear/BlogController/list">BLOG</a></li>
                <li class="nav-item"><a class="nav-link" href="/Gear/QAController/list">Q&A</a></li>
              </ul>
            </nav>
            <div>
              <a href="/Gear/cart" class="text-white mr-3"><i class="fa-solid fa-bag-shopping fa-lg"></i></a>
              <a href="/Gear/index.php?url=AuthController/login" class="text-white"><i class="fa-solid fa-user fa-lg"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="form-wrapper">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <!-- Form Đăng nhập -->
          <div class="form-container animate__animated animate__fadeIn" id="login-form" style="<?= !empty($showRegister) ? 'display:none;' : '' ?>">
            <h2>Đăng nhập</h2>
            <form action="/Gear/index.php?url=AuthController/login" method="post">
              <div class="form-group">
                <div class="input-icon">
                  <i class="fas fa-user"></i>
                  <input type="text" id="username" name="username" class="form-control" placeholder="Tên đăng nhập" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-icon">
                  <i class="fas fa-lock"></i>
                  <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                </div>
              </div>
              <!-- <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
              </div> -->
              <button type="submit" class="btn btn-purple">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập
              </button>
              
              <div class="form-divider">
                <span>hoặc</span>
              </div>
              
              <div class="form-switch-text">
                Chưa có tài khoản? <a href="#" id="show-register-form">Đăng ký ngay</a>
              </div>
            </form>
          </div>

          <!-- Form Đăng ký -->
          <div class="form-container animate__animated animate__fadeIn" id="register-form" style="<?= empty($showRegister) ? 'display:none;' : '' ?>">
            <h2>Đăng ký tài khoản</h2>
            <form action="/Gear/index.php?url=AuthController/login" method="post">
              <div class="form-group">
                <label for="register-fullname">Họ và tên</label>
                <div class="input-icon">
                  <i class="fas fa-user-circle"></i>
                  <input type="text" id="register-fullname" name="register-fullname" class="form-control" placeholder="Nhập họ và tên" required>
                </div>
              </div>
              
              <div class="form-group">
                <label for="register-username">Tên đăng nhập</label>
                <div class="input-icon">
                  <i class="fas fa-user"></i>
                  <input type="text" id="register-username" name="register-username" class="form-control" placeholder="Nhập tên đăng nhập" required>
                </div>
              </div>
              
              <div class="form-group">
                <label for="register-password">Mật khẩu</label>
                <div class="input-icon">
                  <i class="fas fa-lock"></i>
                  <input type="password" id="register-password" name="register-password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>
              </div>
              
              <div class="form-group">
                <label for="register-email">Email</label>
                <div class="input-icon">
                  <i class="fas fa-envelope"></i>
                  <input type="email" id="register-email" name="register-email" class="form-control" placeholder="Nhập địa chỉ email" required>
                </div>
              </div>
              
              <div class="form-group">
                <label for="register-dob">Ngày sinh</label>
                <div class="input-icon">
                  <i class="fas fa-calendar-alt"></i>
                  <input type="date" id="register-dob" name="register-dob" class="form-control">
                </div>
              </div>
              
              <div class="form-group">
                <label for="register-address">Địa chỉ</label>
                <div class="input-icon">
                  <i class="fas fa-map-marker-alt"></i>
                  <input type="text" id="register-address" name="register-address" class="form-control" placeholder="Nhập địa chỉ">
                </div>
              </div>
              
              
              <button type="submit" class="btn btn-purple">
                <i class="fas fa-user-plus"></i> Đăng ký
              </button>
              
              <div class="form-divider">
                <span>hoặc</span>
              </div>
              
              <div class="form-switch-text">
                Đã có tài khoản? <a href="#" id="show-login-form">Đăng nhập</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="copyright">
    © <?= date('Y') ?> GearBK Store. All Rights Reserved.
  </div>

  <!-- JS libraries -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Form switching script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loginForm = document.getElementById('login-form');
      const registerForm = document.getElementById('register-form');
      const showRegisterFormBtn = document.getElementById('show-register-form');
      const showLoginFormBtn = document.getElementById('show-login-form');
      
      showRegisterFormBtn.addEventListener('click', function(e) {
        e.preventDefault();
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        registerForm.classList.add('animate__fadeIn');
      });
      
      showLoginFormBtn.addEventListener('click', function(e) {
        e.preventDefault();
        registerForm.style.display = 'none';
        loginForm.style.display = 'block';
        loginForm.classList.add('animate__fadeIn');
      });
      
      // Password strength validation
      const passwordInput = document.getElementById('register-password');
      if (passwordInput) {
        passwordInput.addEventListener('input', function() {
          const value = this.value;
          let strength = 0;
          
          if (value.length >= 8) strength++;
          if (/[A-Z]/.test(value)) strength++;
          if (/[0-9]/.test(value)) strength++;
          if (/[^A-Za-z0-9]/.test(value)) strength++;
          
          let feedback = '';
          let color = '';
          
          switch(strength) {
            case 0:
            case 1:
              feedback = 'Yếu';
              color = '#dc3545';
              break;
            case 2:
              feedback = 'Trung bình';
              color = '#ffc107';
              break;
            case 3:
              feedback = 'Khá mạnh';
              color = '#28a745';
              break;
            case 4:
              feedback = 'Rất mạnh';
              color = '#28a745';
              break;
          }
          
          const feedbackElement = document.getElementById('password-strength');
          if (!feedbackElement) {
            const element = document.createElement('div');
            element.id = 'password-strength';
            element.style.fontSize = '0.8em';
            element.style.marginTop = '5px';
            element.style.fontWeight = '500';
            passwordInput.parentNode.insertAdjacentElement('afterend', element);
          }
          
          document.getElementById('password-strength').textContent = `Độ mạnh mật khẩu: ${feedback}`;
          document.getElementById('password-strength').style.color = color;
        });
      }
    });
  </script>
</body>
</html>