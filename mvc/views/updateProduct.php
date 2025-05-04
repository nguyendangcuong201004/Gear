<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/updateProduct.css">
</head>

<body>
    <div class="header">
        <h1>ADMIN</h1>
        <div class="buttons">
            <button class="source-btn">Nguồn Dàng Cường</button>
            <button class="logout-btn">Đăng xuất</button>
        </div>
    </div>
    <div class="main-container">
        <div class="sidebar">
            <ul>
                <li><a href="/AdminController/dashboard">Tổng quan</a></li>
                <li><a href="/AdminProductController/list">Sản phẩm</a></li>
                <li><a href="/AdminOrderController/list">Đơn hàng</a></li>
                <li><a href="#">Nhóm quyền</a></li>
                <li><a href="#">Phân quyền</a></li>
                <li><a href="/AdminUserController/list">Tài khoản</a></li>
            </ul>
        </div>
        <div class="content">
            <h2>Cập nhật sản phẩm</h2>
            <div class="form-container">
                <?php if (!empty($error)): ?>
                    <h2 class="alert alert-danger" style=""><?= htmlspecialchars($error) ?></h2>
                <?php endif; ?>
                <form
                    id="updateProductForm"
                    action="/AdminProductController/update/<?= $product['id'] ?>"
                    method="POST">
                    <label for="name">Tên sản phẩm</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= htmlspecialchars($product["name"]) ?>"
                        required>

                    <label for="code">Mã sản phẩm</label>
                    <input
                        type="text"
                        id="code"
                        name="code"
                        value="<?= htmlspecialchars($product["code"] ?? '') ?>">

                    <label for="images">Link ảnh online</label>
                    <textarea
                        id="images"
                        name="images"><?= htmlspecialchars($product["images"]) ?></textarea>

                    <label for="price">Giá bán</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        min="0"
                        value="<?= (int)$product["price"] ?>"
                        required>

                    <label for="discount">Giảm giá (%)</label>
                    <input
                        type="number"
                        id="discount"
                        name="discount"
                        min="0"
                        value="<?= (int)$product["discount"] ?>">

                    <label for="description">Mô tả chi tiết</label>
                    <textarea
                        id="description"
                        name="description"><?= htmlspecialchars($product["description"]) ?></textarea>

                    <label for="quantity">Số lượng tồn kho</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="0"
                        value="<?= (int)$product["quantity"] ?>"
                        required>

                    <label for="status">Trạng thái</label>
                    <select id="status" name="status" required>
                        <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="inactive" <?= $product['status'] === 'inactive' ? 'selected' : '' ?>>Dừng hoạt động</option>
                    </select>

                    <label for="slug">Tên SEO</label>
                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        value="<?= htmlspecialchars($product["slug"]) ?>"
                        readonly>

                    <div class="buttons">
                        <button type="submit" class="save-btn">Lưu</button>
                        <button type="button" class="cancel-btn" onclick="window.history.back()">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>