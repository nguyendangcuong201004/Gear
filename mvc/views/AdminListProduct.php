<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý sản phẩm</title>
  <link rel="stylesheet" href="/Gear/public/css/admitlistproduct.css">
  <style>
    /* CSS cho phân trang */
    .pagination {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .pagination-info {
      margin-bottom: 10px;
      font-size: 14px;
      color: #666;
    }
    
    .pagination-links {
      display: flex;
      gap: 5px;
    }
    
    .page-link {
      display: inline-block;
      padding: 8px 12px;
      background-color: #f5f5f5;
      border: 1px solid #ddd;
      color: #333;
      text-decoration: none;
      border-radius: 4px;
      transition: all 0.3s;
    }
    
    .page-link:hover {
      background-color: #e0e0e0;
    }
    
    .page-link.active {
      background-color: #007bff;
      color: white;
      border-color: #007bff;
    }
  </style>
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
        <li><a href="#">Tổng quan</a></li>
        <li><a href="/Gear/AdminProductController/list">Sản phẩm</a></li>
        <li><a href="/Gear/AdminOrderController/list">Đơn hàng</a></li>
        <li><a href="#">Nhóm quyền</a></li>
        <li><a href="#">Phân quyền</a></li>
        <li><a href="/Gear/AdminUserController/list">Tài khoản</a></li>
        <li><a href="/Gear/HomeAdminController">Quản lý trang chủ</a></li>
        <li><a href="/Gear/ContactAdminController">Quản lý liên hệ</a></li>
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
        <a href="/Gear/AdminProductController/create" class="btn btn-success"><button>Thêm sản phẩm</button></a>
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
          var base = '/Gear/AdminProductController/list';
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
                  <a href="/Gear/AdminProductController/edit/<?= $p['id'] ?>" style="text-decoration: none;">
                    <button class="edit-btn">Sửa</button>
                  </a>
                  <a href="/Gear/AdminProductController/delete/<?= $p['id'] ?>" onclick="return confirm('Xác nhận xóa sản phẩm này?')"><button class="delete-btn">Xóa</button></a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
      
      <!-- Phân trang -->
      <?php if (isset($totalPages) && $totalPages > 1): ?>
      <div class="pagination">
        <div class="pagination-info">
          Trang <?= $currentPage ?> / <?= $totalPages ?>
        </div>
        <div class="pagination-links">
          <?php if ($currentPage > 1): ?>
            <a href="/Gear/AdminProductController/list<?= isset($search) && $search ? '/search=' . $search : '' ?>/page=<?= $currentPage - 1 ?>" class="page-link">&laquo; Trang trước</a>
          <?php endif; ?>
          
          <?php
          // Hiển thị các nút số trang
          $startPage = max(1, $currentPage - 2);
          $endPage = min($totalPages, $currentPage + 2);
          
          // Nếu đang ở gần cuối, hiển thị thêm các trang đầu
          if ($endPage - $startPage < 4 && $startPage > 1) {
              $startPage = max(1, $endPage - 4);
          }
          
          // Nếu đang ở gần đầu, hiển thị thêm các trang cuối
          if ($endPage - $startPage < 4 && $endPage < $totalPages) {
              $endPage = min($totalPages, $startPage + 4);
          }
          
          for ($i = $startPage; $i <= $endPage; $i++): 
          ?>
            <a href="/Gear/AdminProductController/list<?= isset($search) && $search ? '/search=' . $search : '' ?>/page=<?= $i ?>" 
               class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
          
          <?php if ($currentPage < $totalPages): ?>
            <a href="/Gear/AdminProductController/list<?= isset($search) && $search ? '/search=' . $search : '' ?>/page=<?= $currentPage + 1 ?>" class="page-link">Trang sau &raquo;</a>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
      
    </div>
  </div>

</body>

</html>