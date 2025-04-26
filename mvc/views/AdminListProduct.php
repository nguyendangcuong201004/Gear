<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý sản phẩm</title>
  <link rel="stylesheet" href="/public/css/admitlistproduct.css">
</head>

<body>
  <div class="header">
    <h1>ADMIN</h1>
    <div class="buttons">
      <button class="source-btn">Nguyen Dang Cuong</button>
      <button class="logout-btn">Đăng xuất</button>
    </div>
  </div>
  <div class="main-container">
    <div class="sidebar">
      <ul>
        <li><a href="/AdminProductController/dashboard">Tổng quan</a></li>
        <li><a href="/AdminProductController/list">Sản phẩm</a></li>
        <li><a href="/AdminOrderController/list">Đơn hàng</a></li>
        <li><a href="#">Nhóm quyền</a></li>
        <li><a href="#">Phân quyền</a></li>
        <li><a href="#">Tài khoản</a></li>
        <li><a href="#">Cài đặt chung</a></li>
      </ul>
    </div>
    <div class="content">
      <h2>Quản lý sản phẩm</h2>
      <div class="search-bar d-flex align-items-center mb-3">
        <input
          type="text"
          id="searchInput"
          name="search"
          placeholder="Tìm kiếm sản phẩm..."
          class="form-control me-2">
        <button type="button" id="searchBtn" class="btn btn-primary me-2" style="margin-left: -800px;">Tìm kiếm</button>
        <a href="/AdminProductController/create" class="btn btn-success"><button>Thêm sản phẩm</button></a>
      </div>
      <script>
        function slugify(str) {
          return str.normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd').replace(/Đ/g, 'D')
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
        }
        document.getElementById('searchBtn').addEventListener('click', function() {
          var term = document.getElementById('searchInput').value.trim();
          var slug = slugify(term);
          var base = '/AdminProductController/home';
          if (slug) {
            window.location.href = base + '/search=' + encodeURIComponent(slug);
          } else {
            window.location.href = base;
          }
        });
        document.getElementById('searchInput').addEventListener('keydown', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('searchBtn').click();
          }
        });
      </script>
      <table id="productTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Giảm giá (%)</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody id="productTableBody">
          <?php if (empty($listProducts)): ?>
            <tr>
              <td colspan="7" class="text-center">Không có sản phẩm nào</td>
            </tr>
          <?php else: ?>
            <?php foreach ($listProducts as $i => $p): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= number_format($p['price'], 0, ',', '.') ?>₫</td>
                <td><?= $p['discount'] ?>%</td>
                <td><?= $p['quantity'] ?></td>
                <td>
                  <?= htmlspecialchars($p['status']) === 'active' ? 'Hoạt động' : 'Dừng hoạt động' ?>
                </td>
                <td class="action-buttons">
                  <a href="/AdminProductController/edit/<?= $p['id'] ?>" style="text-decoration: none;">
                    <button class="edit-btn">Sửa</button>
                  </a>
                  <a href="/AdminProductController/delete/<?= $p['id'] ?>" onclick="return confirm('Xác nhận xóa sản phẩm này?')"><button class="delete-btn">Xóa</button></a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>