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
    <link rel="stylesheet" href="../../public/css/cart.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-content">
                        <div class="inner-logo">
                            <img src="../../public/images/LogoGearBK.webp" alt="">
                            <span>GearBK</span>
                        </div>
                        <div class="inner-menu">
                            <ul>
                                <li>
                                    <a href="">HOME</a>
                                </li>
                                <li>
                                    <a href="">ABOUT</a>
                                </li>
                                <li>
                                    <a href="">SHOP</a>
                                </li>
                                <li>
                                    <a href="">CONTACT</a>
                                </li>
                                <li>
                                    <a href="">NEWS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="inner-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="inner-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="container my-5">
        <?php if (empty($order)) { ?>
            <div class="alert alert-info text-center">
                Giỏ hàng trống. <a href="/ProductController/list" class="alert-link">Quay lại trang mua sắm</a>
            </div>
        <?php } else { ?>
            <!-- Cart Section -->
            <div class="cart-section mb-4">
                <h2>Giỏ hàng:</h2>

                <?php foreach ($order as $item):
                    $slug = htmlspecialchars($item['slug']);
                ?>
                    <div class="cart-item border rounded p-3 mb-3 d-flex align-items-start"
                        data-slug="<?= $slug ?>"
                        data-price="<?= (int)$item['price'] ?>">

                        <!-- Ảnh sản phẩm -->
                        <img src="<?= htmlspecialchars($item['images']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>"
                            class="me-3"
                            style="width:120px; height:auto;">

                        <div class="cart-item-details flex-grow-1">
                            <!-- Tên -->
                            <h3><?= htmlspecialchars($item['name']) ?></h3>

                            <!-- Giá gốc & giá sale -->
                            <p class="price mb-2">
                                Giá gốc:
                                <span class="original-price text-muted text-decoration-line-through me-2">
                                    <?= number_format(
                                        $item['price'] / (1 - ($item['discount'] ?? 0) / 100),
                                        0,
                                        ',',
                                        '.'
                                    ) ?>₫
                                </span>
                                <span class="discounted-price fw-bold">
                                    <?= number_format($item['price'], 0, ',', '.') ?>₫
                                </span>
                            </p>

                            <!-- Số lượng -->
                            <div class="quantity-selector d-flex align-items-center mb-2">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary me-2"
                                    onclick="changeQty('<?= $slug ?>', -1)">−</button>
                                <input
                                    type="number"
                                    id="qty-<?= $slug ?>"
                                    class="form-control text-center qty-input"
                                    style="width:80px;"
                                    value="<?= (int)$item['quantity'] ?>"
                                    min="1"
                                    oninput="onQtyInput('<?= $slug ?>')">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary ms-2"
                                    onclick="changeQty('<?= $slug ?>', 1)">+</button>
                            </div>

                            <!-- Nút Cập nhật -->
                            <form action="/OrderController/update" method="POST" class="d-inline">
                                <input type="hidden" name="slug" value="<?= $slug ?>">
                                <input
                                    type="hidden"
                                    name="quantity"
                                    id="hidden-qty-<?= $slug ?>"
                                    value="<?= (int)$item['quantity'] ?>">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Cập nhật
                                </button>
                            </form>

                            <!-- Nút Xóa -->
                            <form action="/OrderController/remove" method="POST" class="d-inline ms-2">
                                <input type="hidden" name="slug" value="<?= htmlspecialchars($slug) ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>

                            <!-- Thành tiền -->
                            <p class="mt-2">
                                Thành tiền:
                                <span class="fw-bold subtotal-<?= $slug ?>">
                                    <?= number_format((int)$item['subtotal'], 0, ',', '.') ?>₫
                                </span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>



                <script>
                    // Thay đổi số lượng qua nút +/- 
                    function changeQty(slug, delta) {
                        const inp = document.getElementById('qty-' + slug);
                        let v = Math.max(1, parseInt(inp.value, 10) + delta);
                        inp.value = v;
                        document.getElementById('hidden-qty-' + slug).value = v;
                        recalcLine(slug, v);
                    }

                    // Khi gõ tay vào input
                    function onQtyInput(slug) {
                        const inp = document.getElementById('qty-' + slug);
                        let v = Math.max(1, parseInt(inp.value, 10) || 1);
                        inp.value = v;
                        document.getElementById('hidden-qty-' + slug).value = v;
                        recalcLine(slug, v);
                    }

                    // Tính lại thành tiền dòng đó (client-side)
                    function recalcLine(slug, qty) {
                        const itemEl = document.querySelector('.cart-item[data-slug="' + slug + '"]');
                        const price = parseInt(itemEl.dataset.price, 10);
                        const subtotal = price * qty;
                        document.querySelector('.subtotal-' + slug).textContent =
                            subtotal.toLocaleString('vi-VN') + '₫';
                    }

                    // Bạn có thể thêm recalcTotal() tương tự để cập nhật tổng, nếu cần
                </script>

            </div>

            <!-- Order Summary Section -->
            <div class="order-summary border rounded p-4">
                <h2>Thông tin đơn hàng</h2>
                <form id="checkoutForm" action="/OrderController/checkout" method="POST">
                    <!-- Customer Information -->
                    <div class="customer-info mb-4">
                        <div class="form-group">
                            <label for="full_name">Tên khách hàng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Nhập tên của bạn" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required pattern="[0-9]{10}" title="Số điện thoại phải có 10 chữ số">
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="order-notes mb-4">
                        <label for="order-notes">Ghi chú đơn hàng</label>
                        <textarea id="order-notes" class="form-control" name="note" placeholder="Nhập mã khuyến mãi (nếu có)"></textarea>
                    </div>

                    <!-- Total -->
                    <div class="total d-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0">Tổng tiền:</p>
                        <p class="total-amount mb-0 fs-4 fw-bold text-success">
                            <?= number_format(array_sum(array_column($order, 'subtotal')), 0, ',', '.') ?>₫
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="cart-actions d-flex justify-content-between align-items-center">
                        <div class="action-buttons">
                            <a href="/ProductController/list" class="btn btn-outline-secondary me-2">Tiếp tục mua hàng</a>
                            <button type="submit" class="btn btn-success" id="checkoutBtn">Thanh toán ngay</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="inner-menu">
                        <ul>
                            <li>
                                <a href="">Home</a>
                            </li>
                            <li>
                                <a href="">About</a>
                            </li>
                            <li>
                                <a href="">Shop</a>
                            </li>
                            <li>
                                <a href="">Contact</a>
                            </li>
                            <li>
                                <a href="">News</a>
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