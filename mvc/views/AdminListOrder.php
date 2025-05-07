<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="/Gear/public/css/adminOrder.css">
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
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
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
            <button class="source-btn">Nguồn Dàng Cường</button>
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
            </ul>
        </div>

        <div class="content">
            <h2>Quản lý đơn hàng</h2>

            <form id="search-form" onsubmit="searchOrders(event)" class="search-bar mb-3">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Tìm kiếm đơn hàng theo số điện thoại..."
                    class="form-control"
                    style="max-width:300px; display:inline-block;">
                <button type="submit" class="btn btn-primary ms-2">Tìm kiếm</button>
            </form>
            <script>
                function searchOrders(e) {
                    e.preventDefault();
                    var term = document.getElementById('searchInput').value.trim();
                    var slug = term.replace(/\s+/g, '-');
                    var url = '/Gear/AdminOrderController/list';
                    if (slug) url += '/search=' + encodeURIComponent(slug);
                    // Reset về trang 1 khi tìm kiếm mới
                    url += '/page=1';
                    window.location.href = url;
                }
            </script>

            <table id="orderTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>SĐT</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listorders)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có đơn hàng nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listorders as $i => $o): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($o['code']) ?></td>
                                <td><?= htmlspecialchars($o['full_name']) ?></td>
                                <td><?= htmlspecialchars($o['phone']) ?></td>
                                <td><?= number_format($o['total'], 0, ',', '.') ?>₫</td>
                                <td>
                                    <form method="POST" action="/Gear/AdminOrderController/updateStatus/<?= $o['id'] ?>" class="d-inline">
                                        <select name="status" onchange="this.form.submit()">
                                            <?php foreach (['pending' => 'Chờ xử lý', 'confirmed' => 'Đã xác nhận', 'shipped' => 'Đang giao', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'] as $key => $label): ?>
                                                <option value="<?= $key ?>" <?= $o['status'] === $key ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                                <td class="action-buttons">
                                    <a
                                        href="/Gear/AdminOrderController/detail/<?= $o['id'] ?>"
                                        class="btn btn-sm btn-info"><button class="details-btn">Chi tiết</button></a>
                                    <form
                                        method="POST"
                                        action="/Gear/AdminOrderController/delete/<?= $o['id'] ?>"
                                        class="d-inline"
                                        onsubmit="return confirm('Xác nhận xóa đơn hàng này?')">
                                        <button type="submit" class="delete-btn">Xóa</button>
                                    </form>
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
                        <a href="/Gear/AdminOrderController/list<?= isset($search) && $search ? '/search=' . $search : '' ?>/page=<?= $currentPage - 1 ?>" class="page-link">&laquo; Trang trước</a>
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
                        <a href="/Gear/AdminOrderController/list<?= isset($search) && $search ? '/search=' . $search : '' ?>/page=<?= $i ?>" 
                           class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
                           <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="/Gear/AdminOrderController/list<?= isset($search) && $search ? '/search=' . $search : '' ?>/page=<?= $currentPage + 1 ?>" class="page-link">Trang sau &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>