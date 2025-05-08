<?php

class ProductController extends Controller{
    private $homeAdminModel;

    public function __construct() {
        $this->homeAdminModel = $this->model("HomeAdminModel");
    }

    public function list (...$filters) {
        $search = null;
        $sortfilter = null;
        $pricefilter = null;
        foreach ($filters as $f) {
            $key = explode('=', $f, 2)[0] ?? '';
            $value = explode('=', $f, 2)[1] ?? '';
            if ($key == 'search'){
                $search = $value;
            }
            if ($key == 'sortfilter'){
                $sortfilter = $value;
            }
            if ($key == 'pricefilter'){
                $pricefilter = $value;
            }
        }
        $model = $this->model("ProductModel");
        $listProducts = $model->getListProducts($search,  $sortfilter, $pricefilter);
        $settings = $this->homeAdminModel->getSiteSettings();
        $this->view("ListProductsView", [
            "listProducts" => $listProducts,
            "settings" => $settings
        ]);
    }

    public function detail ($slug) {
        $h = $this->model("ProductModel");
        $slug = explode('=', $slug, 2)[1] ?? ''; 
        $detailProduct = $h->getDetailProduct($slug);
        $settings = $this->homeAdminModel->getSiteSettings();
        $this->view("ProductView", [
            "detailProduct" => $detailProduct,
            "settings" => $settings
        ]);
    }

    public function addToCart() {
        // 1. Khởi session (nếu chưa)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Lấy dữ liệu POST
        $slug     = $_POST['slug']     ?? null;
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

        if ($slug) {
            // 3. Khởi giỏ hàng nếu chưa có
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            // 4. Cộng dồn hoặc gán mới
            if (isset($_SESSION['cart'][$slug])) {
                $_SESSION['cart'][$slug] += $quantity;
            } else {
                $_SESSION['cart'][$slug]  = $quantity;
            }
        }

        // 5. Chuyển hướng về trang giỏ hàng
        header("Location: /Gear/OrderController/home");
        exit;
    }
}

?>