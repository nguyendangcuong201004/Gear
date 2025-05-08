<?php
// mvc/views/admin/AdminDetailOrder.php
$order = $order ?? [];
$items = $items ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng <?= htmlspecialchars($order['code'] ?? '') ?></title>
    <link rel="stylesheet" href="/Gear/public/css/adminOrderDetail.css">
</head>

<body>
    <div class="header">
        <h1>ADMIN</h1>
        <div class="buttons">
            <button class="source-btn">Nguồn Dàng Cường</button>
            <button class="logout-btn" onclick="window.history.back()">Quay lại</button>
            <button class="logout-btn" onclick="location.href='/logout'">Đăng xuất</button>
        </div>
    </div>
    <div class="main-container">
        <div class="sidebar">
            <ul>
                <li><a href="#">Tổng quan</a></li>
                <li><a href="/Gear/AdminProductController/list">Sản phẩm</a></li>
                <li><a href="/Gear/AdminOrderController/list">Đơn hàng</a></li>
                <li><a href="">Nhóm quyền</a></li>
                <li><a href="#">Phân quyền</a></li>
                <li><a href="/Gear/AdminUserController/list">Tài khoản</a></li>
            </ul>
        </div>
        <div class="content">
            <h2>Chi tiết đơn hàng</h2>
            <div class="order-details">
                <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($order['code']) ?></p>
                <p><strong>Tên khách hàng:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                <p><strong>SĐT:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p><strong>Ghi chú:</strong> <?= nl2br(htmlspecialchars($order['note'] ?? '')) ?></p>
                <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
                <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Giảm giá (%)</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item):
                            $price = (int)$item['price'];
                            $discount = (int)$item['discount'];
                            $qty = (int)$item['quantity'];
                            $priceAfter = $price * (100 - $discount) / 100;
                            $subtotal = $priceAfter * $qty;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $qty ?></td>
                                <td><?= number_format($price, 0, ',', '.') ?>₫</td>
                                <td><?= $discount ?>%</td>
                                <td><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
                $total = array_reduce($items, function ($sum, $it) {
                    $p = (int)$it['price'];
                    $d = (int)$it['discount'];
                    $q = (int)$it['quantity'];
                    return $sum + ($p * (100 - $d) / 100) * $q;
                }, 0);
                ?>
                <p class="total">Tổng tiền: <?= number_format($total, 0, ',', '.') ?>₫</p>
            </div>
            <button class="back-btn" onclick="window.history.back()">Quay lại</button>
        </div>
    </div>
</body>

</html>