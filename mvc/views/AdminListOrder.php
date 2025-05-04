<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="/public/css/adminOrder.css">
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
                <li><a href="/AdminProductController/list">Sản phẩm</a></li>
                <li><a href="/AdminOrderController/list">Đơn hàng</a></li>
                <li><a href="#">Nhóm quyền</a></li>
                <li><a href="#">Phân quyền</a></li>
                <li><a href="/AdminUserController/list">Tài khoản</a></li>
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
                    var url = '/AdminOrderController/list';
                    if (slug) url += '/search=' + encodeURIComponent(slug);
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
                                    <form method="POST" action="/AdminOrderController/updateStatus/<?= $o['id'] ?>" class="d-inline">
                                        <select name="status" onchange="this.form.submit()">
                                            <?php foreach (['pending' => 'Chờ xử lý', 'confirmed' => 'Đã xác nhận', 'shipped' => 'Đang giao', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'] as $key => $label): ?>
                                                <option value="<?= $key ?>" <?= $o['status'] === $key ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                                <td class="action-buttons">
                                    <a
                                        href="/AdminOrderController/detail/<?= $o['id'] ?>"
                                        class="btn btn-sm btn-info"><button class="details-btn">Chi tiết</button></a>
                                    <form
                                        method="POST"
                                        action="/AdminOrderController/delete/<?= $o['id'] ?>"
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
        </div>
    </div>
</body>

</html>