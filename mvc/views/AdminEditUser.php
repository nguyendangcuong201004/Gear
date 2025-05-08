<?php
// mvc/views/admin/AdminUserEdit.php
$user = $user ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tài khoản</title>
    <link rel="stylesheet" href="/Gear/public/css/adminUserEdit.css">
</head>
<body>
    <div class="header">
        <h1>ADMIN</h1>
        <div class="buttons">
            <button class="source-btn" onclick="location.href='/Gear/AdminUserController/list'">Quay về</button>
            <button class="logout-btn" onclick="location.href='/logout'">Đăng xuất</button>
        </div>
    </div>
    <div class="main-container">
        <div class="sidebar">
            <ul>
                <li><a href="/AdminController/dashboard">Tổng quan</a></li>
                <li><a href="/Gear/AdminProductController/list">Sản phẩm</a></li>
                <li><a href="/Gear/AdminOrderController/list">Đơn hàng</a></li>
                <li><a href="/Gear/AdminUserController/list">Tài khoản</a></li>
                <li><a href="/Gear/HomeAdminController">Quản lý trang chủ</a></li>
                <li><a href="/Gear/ContactAdminController">Quản lý liên hệ</a></li>
            </ul>
        </div>
        <div class="content">
            <h2>Chỉnh sửa tài khoản</h2>

            <div class="user-edit-details">
                <form method="POST" action="/Gear/AdminUserController/update/<?= $user['id'] ?? '' ?>">
                    <div class="form-group">
                        <label for="username">Tên tài khoản:</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới (không đổi để giữ nguyên)" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user_role">Vai trò:</label>
                        <select id="user_role" name="user_role" class="form-control" required>
                            <option value="user" <?= ($user['user_role'] ?? 'user') === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= ($user['user_role'] ?? 'user') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" onclick="location.href='/Gear/AdminUserController/list'">Quay lại</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>