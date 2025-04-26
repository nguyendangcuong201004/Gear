<?php

class OrderModel extends Database {
    /**
     * Trả về mảng các item trong giỏ (session)
     * mỗi phần tử chứa: slug, name, images, price (sau giảm), quantity, subtotal
     */
    public function getDashboard() {
        // 1) Khởi session nếu chưa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2) Lấy giỏ hàng từ session
        $cart = $_SESSION['cart'] ?? [];
        $items = [];

        // 3) Với mỗi slug trong cart, truy vấn chi tiết
        foreach ($cart as $slug => $qty) {
            // Sanitize
            $slug_safe = mysqli_real_escape_string($this->con, $slug);

            // Lấy bản ghi product
            $res = mysqli_query(
                $this->con,
                "SELECT * FROM products WHERE slug = '{$slug_safe}' LIMIT 1"
            );
            $prod = mysqli_fetch_assoc($res);
            if (! $prod) continue;

            // Tính giá sau giảm và subtotal
            $price    = (int)($prod['price'] * (100 - $prod['discount']) / 100);
            $subtotal = $price * $qty;

            // Gom vào mảng
            $items[] = [
                'slug'     => $prod['slug'],
                'name'     => $prod['name'],
                'images'   => $prod['images'],
                'price'    => $price,
                'quantity' => $qty,
                'subtotal' => $subtotal
            ];
        }

        return $items;
    }

    public function createOrder($fullName, $phone, $note, $cart) {
        // 1) Sinh code: ORD + 5 chữ số
        $res = mysqli_query($this->con, "SELECT MAX(id) AS maxid FROM orders");
        $row = mysqli_fetch_assoc($res);
        $next = (int)$row['maxid'] + 1;
        $code = 'ORD' . str_pad($next, 5, '0', STR_PAD_LEFT);

        // 2) Escape dữ liệu
        $fn = mysqli_real_escape_string($this->con, $fullName);
        $ph = mysqli_real_escape_string($this->con, $phone);
        $nt = mysqli_real_escape_string($this->con, $note);
        $now = date("Y-m-d H:i:s");

        // 3) Insert vào orders
        $sql = "
            INSERT INTO orders
              (code, full_name, phone, note, status, created_at, updated_at)
            VALUES
              ('$code', '$fn', '$ph', '$nt', 'pending', '$now', '$now')
        ";
        mysqli_query($this->con, $sql)
            or die("Order insert failed: " . mysqli_error($this->con));
        $orderId = mysqli_insert_id($this->con);

        // 4) Insert từng mục trong cart
        foreach ($cart as $slug => $qty) {
            // Lấy product_id, price, discount
            $s = mysqli_real_escape_string($this->con, $slug);
            $r = mysqli_query($this->con,
                "SELECT id, price, discount 
                 FROM products 
                 WHERE slug = '$s' 
                 LIMIT 1"
            );
            if ($p = mysqli_fetch_assoc($r)) {
                $pid      = (int)$p['id'];
                $price    = (int)$p['price'];
                $discount = (int)$p['discount'];

                $q = intval($qty);
                $sql2 = "
                    INSERT INTO orders_products
                      (order_id, product_id, quantity, price, discount)
                    VALUES
                      ($orderId, $pid, $q, $price, $discount)
                ";
                mysqli_query($this->con, $sql2)
                    or die("OrderItems insert failed: " . mysqli_error($this->con));
            }
        }

        return $orderId;
    }

    /**
     * Lấy code từ order_id, để hiển thị trên ThanksView
     */
    public function getOrderCodeById($orderId) {
        $id = intval($orderId);
        $r = mysqli_query($this->con,
            "SELECT code FROM orders WHERE id = $id"
        );
        $row = mysqli_fetch_assoc($r);
        return $row['code'] ?? '';
    }

    /**
     * Lấy chi tiết đơn hàng và các sản phẩm
     */
    public function getOrder($orderId) {
        $id = intval($orderId);
        $r  = mysqli_query(
            $this->con,
            "SELECT * FROM orders WHERE id = $id LIMIT 1"
        );
        $order = mysqli_fetch_assoc($r);
        if (!$order) return null;

        $ri = mysqli_query(
            $this->con,
            "SELECT op.quantity, op.price, op.discount, p.name, p.images " .
            "FROM orders_products op " .
            "JOIN products p ON op.product_id = p.id " .
            "WHERE op.order_id = $id"
        );
        $items = [];
        while ($row = mysqli_fetch_assoc($ri)) {
            $items[] = $row;
        }
        $order['items'] = $items;

        return $order;
    }
}
