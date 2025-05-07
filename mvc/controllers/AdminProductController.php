<?php
class AdminProductController extends Controller {

    public function list (...$filters) {
        $search = null;
        $page = 1; // Trang mặc định
        
        foreach ($filters as $f) {
            $key = explode('=', $f, 2)[0] ?? '';
            $value = explode('=', $f, 2)[1] ?? '';
            if ($key == 'search'){
                $search = $value;
            }
            if ($key == 'page'){
                $page = (int)$value > 0 ? (int)$value : 1;
            }
        }
        
        $limit = 10; // Số sản phẩm mỗi trang
        $model = $this->model("AdminProductModel");
        
        // Lấy tổng số sản phẩm và tính số trang
        $totalProducts = $model->countProducts($search);
        $totalPages = ceil($totalProducts / $limit);
        
        // Đảm bảo trang hiện tại không vượt quá tổng số trang
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }
        
        // Lấy danh sách sản phẩm cho trang hiện tại
        $listProducts = $model->getAllProducts($search, $page, $limit);
        
        $this->view("AdminListProduct", [
            "listProducts" => $listProducts,
            "currentPage" => $page,
            "totalPages" => $totalPages,
            "search" => $search
        ]);
    }

    public function edit ($id) {
        $model = $this->model("AdminProductModel");
        $product = $model->getProductById($id);
        $this->view("updateProduct", ["product" => $product]);
    }

    public function create() {
        $this->view("CreateProduct");
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $data = [
            'name'        => $_POST['name'] ?? '',
            'code'        => $_POST['code'] ?? '',
            'price'       => intval($_POST['price'] ?? 0),
            'discount'    => intval($_POST['discount'] ?? 0),
            'description' => $_POST['description'] ?? '',
            'quantity'    => intval($_POST['quantity'] ?? 0),
            'status'      => $_POST['status'] ?? 'inactive',
            'images'      => '', // Sẽ được cập nhật khi xử lý file
        ];
        
        // Xử lý upload file
        $model = $this->model('AdminProductModel');
        
        // Kiểm tra nếu có file upload
        $errorMessage = '';
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $fileName = $model->uploadImage($_FILES['product_image']);
            if ($fileName) {
                $data['images'] = $fileName;
            } else {
                $errorMessage = 'Lỗi upload ảnh: File không hợp lệ hoặc quá lớn (tối đa 5MB)';
            }
        } else {
            // Không có file, sử dụng ảnh mặc định hoặc báo lỗi
            $data['images'] = 'default-product.jpg';
        }
        
        // Nếu có lỗi upload, hiển thị thông báo
        if ($errorMessage) {
            return $this->view('CreateProduct', [
                'product' => $data,
                'error'   => $errorMessage
            ]);
        }
        
        // Sinh slug từ name
        $slug = strtolower(trim(preg_replace('/\\s+/', '-', $data['name'])));
        $data['slug'] = $slug;
    
        // Kiểm tra trùng
        if ($model->existsCodeOrSlug($data['code'], $slug)) {
            $error = 'Mã sản phẩm đã tồn tại!';
            return $this->view('CreateProduct', [
                'product' => $data,
                'error'   => $error
            ]);
        }
    
        $model->insertProduct($data);
        header('Location: /Gear/AdminProductController/list');
        exit;
    }
    
    
    public function update($id) {
        $data = [
            'name'        => $_POST['name']        ?? '',
            'code'        => $_POST['code']        ?? '',
            'price'       => intval($_POST['price'] ?? 0),
            'discount'    => intval($_POST['discount'] ?? 0),
            'description' => $_POST['description'] ?? '',
            'specs'       => $_POST['specs']       ?? '',
            'quantity'    => intval($_POST['quantity'] ?? 0),
            'status'      => $_POST['status']      ?? 'inactive',
            'slug'        => $_POST['slug']        ?? '',
        ];

        $model = $this->model("AdminProductModel");
        
        // Xử lý upload file
        $errorMessage = '';
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $fileName = $model->uploadImage($_FILES['product_image']);
            if ($fileName) {
                $data['images'] = $fileName;
            } else {
                $errorMessage = 'Lỗi upload ảnh: File không hợp lệ hoặc quá lớn (tối đa 5MB)';
            }
        }
        
        // Nếu có lỗi upload, hiển thị thông báo
        if ($errorMessage) {
            $product = array_merge($data, ['id' => $id]);
            return $this->view("updateProduct", [
                'product' => $product,
                'error'   => $errorMessage
            ]);
        }
        
        // 1) Check trùng (bỏ qua chính ID đang edit)
        if ($model->existsCodeOrSlug($data['code'], $data['slug'], $id)) {
            $error   = "Mã sản phẩm đã tồn tại!";
            $product = array_merge($data, ['id' => $id]);
            $this->view("updateProduct", [
                'product' => $product,
                'error'   => $error
            ]);
            return;
        }
        
        // Lấy thông tin sản phẩm hiện tại để giữ lại ảnh cũ nếu không upload ảnh mới
        if (!isset($data['images'])) {
            $currentProduct = $model->getProductById($id);
            $data['images'] = $currentProduct['images'];
        }
        
        // 2) Cập nhật
        $model->updateProduct($id, $data);
        header("Location: /Gear/AdminProductController/edit/$id");
        exit;
    }
    

    public function delete($id) {
        // 1. Lấy model
        $model = $this->model("AdminProductModel");
        // 2. Gọi hàm xóa mềm (set deleted = 1)
        $model->deleteProduct($id);
        // 3. Redirect về danh sách
        header("Location: /Gear/AdminProductController/list");
        exit;
    }
 
}