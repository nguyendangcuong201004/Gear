<?php
// View file for user profile

// Check if user is logged in
if (!isset($_COOKIE['access_token'])) {
    header("Location: http://localhost/Gear/AuthController/login");
    exit;
}

$username = $_COOKIE['user_name'] ?? '';
$error = $message = '';

if (isset($updateSuccess)) {
    $message = "Thông tin cá nhân đã được cập nhật thành công!";
} else if (isset($passwordSuccess)) {
    $message = "Mật khẩu đã được thay đổi thành công!";
} else if (isset($updateError)) {
    $error = $updateError;
} else if (isset($passwordError)) {
    $error = $passwordError;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">

    <link rel="stylesheet" href="/Gear/public/css/header.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: url('/Gear/public/images/background_login.webp') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        
        
        
        .profile-container {
            max-width: 800px;
            margin: 120px auto 40px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-out forwards;
            transition: transform 0.3s ease;
        }
        
        .profile-container:hover {
            transform: translateY(-5px);
        }
        
        .profile-header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            position: relative;
        }
        
        .profile-header h2 {
            color: #4a0072;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .profile-header h2 i {
            color: #6a1b9a;
            font-size: 1.5em;
        }
        
        .profile-header:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background: #6a1b9a;
            bottom: 0;
            left: 0;
        }
        
        .profile-tabs {
            margin-bottom: 25px;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #e0e0e0;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #666;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 0;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover {
            color: #6a1b9a;
        }
        
        .nav-tabs .nav-link.active {
            color: #6a1b9a;
            background: transparent;
            border: none;
        }
        
        .nav-tabs .nav-link.active:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #6a1b9a;
        }
        
        .tab-content {
            padding: 20px 5px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #555;
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 0.2rem rgba(106, 27, 154, 0.25);
        }
        
        .form-control[readonly] {
            background-color: #f8f9fa;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }
        
        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }
        
        .btn-update {
            background: #6a1b9a;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-update:hover {
            background: #4a0072;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
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
                            <img src="/Gear/public/images/LogoGearBK.webp" alt="Logo">
                            <span>GearBK</span>
                        </div>
                        <div class="header-menu">
                            <ul>
                                <li><a href="/Gear">HOME</a></li>
                                <li><a href="/Gear/AboutController/index">ABOUT</a></li>
                                <li><a href="/Gear/shop">SHOP</a></li>
                                <li><a href="/Gear/contact">CONTACT</a></li>
                                <li><a href="/Gear/news">NEWS</a></li>
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

    <div class="container profile-container">
        <div class="profile-header">
            <h2><i class="fas fa-user-circle"></i> Thông tin cá nhân</h2>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="profile-tabs">
            <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Thông tin cá nhân</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">Đổi mật khẩu</button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="profileTabsContent">
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <form action="http://localhost/Gear/AuthController/updateProfile" method="post">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập:</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($userInfo['username'] ?? $username); ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($userInfo['email'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fullname">Họ và tên:</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo htmlspecialchars($userInfo['fullname'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="dob">Ngày sinh:</label>
                        <input type="date" id="dob" name="dob" class="form-control" value="<?php echo htmlspecialchars($userInfo['date_of_birth'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <textarea id="address" name="address" class="form-control" rows="2"><?php echo htmlspecialchars($userInfo['address'] ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save"></i> Cập nhật thông tin
                    </button>
                </form>
            </div>
            
            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                <form action="http://localhost/Gear/AuthController/updatePassword" method="post">
                    <div class="form-group">
                        <label for="current_password">Mật khẩu hiện tại:</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">Mật khẩu mới:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn-update">
                        <i class="fas fa-key"></i> Đổi mật khẩu
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Initialize Bootstrap tabs
        document.addEventListener('DOMContentLoaded', function() {
            var triggerTabList = [].slice.call(document.querySelectorAll('#profileTabs button'));
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl);
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });
            
            // Password validation
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordForm = document.querySelector('#password form');
            
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    if (newPassword.value !== confirmPassword.value) {
                        e.preventDefault();
                        alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
                        confirmPassword.focus();
                    }
                    
                    if (newPassword.value.length < 6) {
                        e.preventDefault();
                        alert('Mật khẩu phải có ít nhất 6 ký tự!');
                        newPassword.focus();
                    }
                });
            }
            
            // Autohide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html> 