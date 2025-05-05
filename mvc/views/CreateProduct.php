<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="/Gear/public/css/updateProduct.css">
</head>

<body>
    <div class="header">
        <h1>ADMIN</h1>
        <div class="buttons">
            <button class="source-btn">Nguyen Dang Cuong</button>
            <button class="logout-btn" onclick="location.href='/logout'">Đăng xuất</button>
        </div>
    </div>
    <div class="main-container">
        <div class="sidebar">
            <ul>
                <li><a href="/AdminController/dashboard">Tổng quan</a></li>
                <li><a href="/Gear/AdminProductController/list">Sản phẩm</a></li>
                <li><a href="/Gear/AdminOrderController/list">Đơn hàng</a></li>
                <li><a href="#">Nhóm quyền</a></li>
                <li><a href="#">Phân quyền</a></li>
                <li><a href="/Gear/AdminUserController/list">Tài khoản</a></li>
                <li><a href="/Gear/HomeAdminController">Quản lý trang chủ</a></li>
                <li><a href="/Gear/ContactAdminController">Quản lý liên hệ</a></li>
                <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
    <li><a href="/Gear/AdminProductController/list">ADMIN</a></li>
            </ul>
        </div>
        <div class="content">
            <h2>Thêm mới sản phẩm</h2>
            <div class="form-container">
                <?php if (!empty($error)): ?>
                    <h2 class="alert alert-danger"><?= htmlspecialchars($error) ?></h2>
                <?php endif; ?>
                <form action="/Gear/AdminProductController/store" method="POST" id="createProductForm">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>

                    <label for="code">Mã sản phẩm</label>
                    <input type="text" id="code" name="code" value="<?= htmlspecialchars($product['code'] ?? '') ?>">

                    <label for="images">Link ảnh online (JSON)</label>
                    <textarea id="images" name="images"><?= htmlspecialchars($product['images'] ?? '') ?></textarea>

                    <label for="price">Giá bán</label>
                    <input type="number" id="price" name="price" value="<?= (int)($product['price'] ?? 0) ?>" min="0" required>

                    <label for="discount">Giảm giá (%)</label>
                    <input type="number" id="discount" name="discount" min="0" value="<?= (int)($product['discount'] ?? 0) ?>">

                    <label for="description">Mô tả chi tiết</label>
                    <textarea id="description" name="description"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

                    <label for="quantity">Số lượng tồn kho</label>
                    <input type="number" id="quantity" name="quantity" min="0" value="<?= (int)($product['quantity'] ?? 0) ?>" required>

                    <label for="status">Trạng thái</label>
                    <select id="status" name="status" required>
                        <option value="active" <?= ($product['status'] ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="inactive" <?= ($product['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Dừng hoạt động</option>
                    </select>

                    <div class="buttons">
                        <button type="submit" class="save-btn">Lưu</button>
                        <button type="button" class="cancel-btn" onclick="history.back()">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>