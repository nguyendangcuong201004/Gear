<?php
// mvc/views/admin/AdminUserList.php
$listUsers = $listUsers ?? [];
$searchTerm = $search ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tài khoản</title>
    <link rel="stylesheet" href="/Gear/public/css/adminListUser.css">
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
            <button class="source-btn" onclick="location.href='/AdminController/dashboard'">Nguyen Dang Cuong</button>
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
            <h2>Danh sách tài khoản</h2>

            <!-- Search Bar -->
            <form id="searchForm" class="search-bar mb-3 d-flex align-items-center" onsubmit="onSearch(event)">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Tìm kiếm tài khoản..."
                    value="<?= htmlspecialchars($searchTerm) ?>"
                    class="form-control me-2"
                    style="max-width:300px;"
                />
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>

            <!-- User Table -->
            <table id="userTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên tài khoản</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listUsers)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Không có tài khoản nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listUsers as $i => $user): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['user_role']) ?></td>
                                <td><?= htmlspecialchars($user['created_at']) ?></td>
                                <td class="action-buttons">
                                    <a href="/Gear/AdminUserController/edit/<?= $user['id'] ?>" class="btn btn-sm btn-info"><button class="details-btn">Sửa</button></a>
                                    <form method="POST" action="/Gear/AdminUserController/delete/<?= $user['id'] ?>" class="d-inline" onsubmit="return confirm('Xác nhận xóa tài khoản này?')">
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <?php if (isset($currentPage) && isset($totalPages) && $totalPages > 0): ?>
                <div class="pagination">
                    <div class="pagination-info">
                        Trang <?= $currentPage ?> / <?= $totalPages ?>
                    </div>
                    <div class="pagination-links">
                        <?php
                        // URL cho các liên kết phân trang, giữ nguyên tham số tìm kiếm nếu có
                        $urlPrefix = '/Gear/AdminUserController/list';
                        $searchParam = isset($search) && $search ? '/search=' . urlencode($search) : '';
                        
                        // Liên kết trang trước
                        if ($currentPage > 1): ?>
                            <a href="<?= $urlPrefix . $searchParam . '/page=' . ($currentPage - 1) ?>" class="page-link">&laquo; Trước</a>
                        <?php endif; ?>
                        
                        <?php
                        // Hiển thị các liên kết số trang
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);
                        
                        for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <a href="<?= $urlPrefix . $searchParam . '/page=' . $i ?>" 
                               class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <!-- Liên kết trang sau -->
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="<?= $urlPrefix . $searchParam . '/page=' . ($currentPage + 1) ?>" class="page-link">Sau &raquo;</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function goSearch() {
            var term = document.getElementById('searchInput').value.trim();
            var slug = term.toLowerCase().replace(/\s+/g, '-');
            var url = '/Gear/AdminUserController/list';
            if (slug) url += '/search=' + encodeURIComponent(slug);
            // Khi tìm kiếm, luôn bắt đầu từ trang 1
            url += '/page=1';
            window.location.href = url;
        }
        function onSearch(event) {
            event.preventDefault();
            goSearch();
        }
    </script>
</body>
</html>
