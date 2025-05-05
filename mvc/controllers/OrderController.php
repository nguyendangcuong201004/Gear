<?php

class OrderController extends Controller
{
    // alias list → home
    public function list()
    {
        return $this->home();
    }

    public function home()
    {
        // Gọi model
        $model = $this->model("OrderModel");
        // Lấy mảng item
        $order = $model->getDashboard();
        // Render view, truyền mảng vào key 'order'
        // print_r($order);
        $this->view("CartView", ["order" => $order]);
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Lấy dữ liệu gửi lên
        $slug = $_POST['slug']     ?? '';
        $qty  = max(1, intval($_POST['quantity'] ?? 1));

        if ($slug) {
            // Khởi cart nếu cần
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            // Cập nhật session
            $_SESSION['cart'][$slug] = $qty;
        }
        // Quay lại trang cart để refresh view
        header('Location: /OrderController/home');
        exit;
    }

    public function remove()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $slug = $_POST['slug'] ?? '';
        unset($_SESSION['cart'][$slug]);
        header('Location: /OrderController/home');
        exit;
    }

    public function checkout() {
        // 1. Khởi session nếu chưa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Lấy dữ liệu từ POST
        $fullName = trim($_POST['full_name'] ?? '');
        $phone    = trim($_POST['phone']     ?? '');
        $note     = trim($_POST['note']      ?? '');
        $cart     = $_SESSION['cart'] ?? [];

        // 3. Nếu cart trống hoặc thiếu thông tin bắt buộc
        if (empty($cart) || $fullName === '' || $phone === '') {
            // Bạn có thể redirect về giỏ hàng kèm thông báo lỗi
            header("Location: /Gear/OrderController/home");
            exit;
        }

        // 4. Gọi model để tạo order và lấy ID mới
        $model    = $this->model("OrderModel");
        $orderId  = $model->createOrder($fullName, $phone, $note, $cart);

        // 5. Xóa session cart
        unset($_SESSION['cart']);

        // 6. Chuyển sang trang cảm ơn, truyền mã đơn
        header('Location: /Gear/OrderController/thanks/order_id=' . $orderId);
        exit;
    }

    // Trang cảm ơn
    public function thanks(...$filters) {
        $orderId = null;
        foreach ($filters as $f) {
            $key = explode('=', $f, 2)[0] ?? '';
            $value = explode('=', $f, 2)[1] ?? '';
            if ($key == 'order_id'){
                $orderId = $value;
            }
        }
        $model = $this->model("OrderModel");
        $order = $model->getOrder($orderId);
        $this->view("ThanksView", ["order" => $order]);
    }
}
