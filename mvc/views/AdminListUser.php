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
    <link rel="stylesheet" href="/public/css/adminListUser.css">
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
                <li><a href="/AdminProductController/list">Sản phẩm</a></li>
                <li><a href="/AdminOrderController/list">Đơn hàng</a></li>
                <li><a href="#">Nhóm quyền</a></li>
                <li><a href="#">Phân quyền</a></li>
                <li><a href="/AdminUserController/list">Tài khoản</a></li>
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
                                    <a href="/AdminUserController/edit/<?= $user['id'] ?>" class="btn btn-sm btn-info"><button class="details-btn">Sửa</button></a>
                                    <form method="POST" action="/AdminUserController/delete/<?= $user['id'] ?>" class="d-inline" onsubmit="return confirm('Xác nhận xóa tài khoản này?')">
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function goSearch() {
            var term = document.getElementById('searchInput').value.trim();
            var slug = term.toLowerCase().replace(/\s+/g, '-');
            var url = '/AdminUserController/list';
            if (slug) url += '/search=' + encodeURIComponent(slug);
            window.location.href = url;
        }
        function onSearch(event) {
            event.preventDefault();
            goSearch();
        }
    </script>
</body>
</html>
