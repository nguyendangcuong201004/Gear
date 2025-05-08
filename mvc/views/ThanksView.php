<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - GearBK Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="/Gear/public/css/cart.css"> -->
    <link rel="stylesheet" href="/Gear/public/css/style.css">
    <link rel="stylesheet" href="/Gear/public/css/thank.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-content">
                        <div class="inner-logo">
                            <img src="/Gear/public/images/LogoGearBK.webp" alt="">
                            <span>GearBK</span>
                        </div>
                        <div class="inner-menu">
                            <ul>
                            <li><a href="/Gear">HOME</a></li>
        <li><a href="/Gear/AboutController/index">ABOUT</a></li>
        <li><a href="/Gear/ProductController/list">SHOP</a></li>
        <li><a href="/Gear/contact">CONTACT</a></li>
        <li><a href="/Gear/BlogController/list">NEWS</a></li>
        <?php if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] === 'admin'): ?>
            <li><a href="/Gear/AdminProductController/list">ADMIN</a></li>
        <?php endif; ?>
                            </ul>
                        </div>
                        <div class="inner-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="inner-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <main class="container my-5">
        <?php if (empty($order) || empty($order['code'])): ?>
            <div class="alert alert-warning text-center">
                Đơn hàng không tồn tại hoặc đã hết hạn. <a href="/Gear/ProductController/list" class="alert-link">Quay lại mua hàng</a>
            </div>
        <?php else: ?>
            <!-- Thank You Section -->
            <div class="thank-you-section text-center mb-5 p-4 bg-light rounded">
                    <h2 class="mb-3">🎉 Cảm ơn bạn đã đặt hàng!</h2>
                    <p class="mb-2">Mã đơn hàng của bạn là <strong><?= htmlspecialchars($order['code']) ?></strong></p>
                    <p class="mb-4">Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận và giao hàng.</p>
                    <a href="/Gear/ProductController/list" class="btn btn-primary">Tiếp tục mua sắm</a>
                </div>

            <!-- Order Information Section -->
            <div class="order-info card shadow-sm mb-5">
                    <div class="card-header">
                        <h5>Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Tên khách hàng:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                        <p><strong>Ghi chú:</strong> <?= nl2br(htmlspecialchars($order['note'] ?? 'Giao nhanh giúp mình')) ?></p>
                        <p><strong>Trạng thái đơn hàng:</strong>
                            <?php
                            $statusLabels = [
                                'pending' => 'Chờ xử lý',
                                'confirmed' => 'Đã xác nhận',
                                'shipped' => 'Đang giao',
                                'delivered' => 'Đã giao',
                                'cancelled' => 'Đã hủy'
                            ];
                            $status = $order['status'];
                            echo htmlspecialchars($statusLabels[$status] ?? $status);
                            ?>
                        </p>
                        <p class="status-message">
                            <?php
                            $statusMessages = [
                                'pending' => 'Đơn hàng của bạn đang được xử lý. Vui lòng chờ xác nhận từ chúng tôi.',
                                'confirmed' => 'Đơn hàng của bạn đã được xác nhận. Chúng tôi đang chuẩn bị giao hàng.',
                                'shipped' => 'Đơn hàng của bạn đang trên đường giao đến bạn. Vui lòng chờ nhận hàng.',
                                'delivered' => 'Đơn hàng đã được giao thành công. Cảm ơn bạn đã mua sắm tại GearBK!',
                                'cancelled' => 'Đơn hàng của bạn đã bị hủy. Vui lòng liên hệ chúng tôi nếu có thắc mắc.'
                            ];
                            echo htmlspecialchars($statusMessages[$status] ?? 'Trạng thái không xác định.');
                            ?>
                        </p>
                    </div>

            </div>
            <!-- Order Details Section -->
            <?php if (!empty($order['items'])): ?>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Chi tiết đơn hàng</h5>
                        </div>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Giảm</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($order['items'] as $item):
                                    $line = $item['price'] * $item['quantity'];
                                    $total += $line;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= (int)$item['quantity'] ?></td>
                                        <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                                        <td><?= (int)$item['discount'] ?>%</td>
                                        <td><?= number_format($line, 0, ',', '.') ?>₫</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Tổng cộng:</th>
                                    <th><?= number_format($total, 0, ',', '.') ?>₫</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
        <?php endif; ?>
    </main>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="inner-menu">
                        <ul>
                            <li>
                                <a href="/Gear">Home</a>
                            </li>
                            <li>
                                <a href="/Gear/AboutController">About</a>
                            </li>
                            <li>
                                <a href="/Gear/ProductController">Shop</a>
                            </li>
                            <li>
                                <a href="/Gear/ContactController">Contact</a>
                            </li>
                            <li>
                                <a href="/Gear/BlogController">Blogs</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <div class="inner-name">
                        GEARBK STORE
                    </div>
                </div>
                <div class="col-4">
                    <div class="inner-conpyright">
                        Copyright © 2025 GearBK Store
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script>
        function changeQty(btn, delta) {
            const input = btn.parentNode.querySelector('input[name="quantity"]');
            let v = parseInt(input.value) || 1;
            v = Math.max(1, v + delta);
            input.value = v;
            // cập nhật hidden form field nếu cần
            const slug = btn.closest('.cart-item').querySelector('form input[name="slug"]').value;
            const hidden = document.getElementById('qty-' + slug + '-form');
            if (hidden) hidden.value = v;
        }
    </script>
</body>

</html>