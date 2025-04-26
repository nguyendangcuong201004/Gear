<?php
class AdminProductController extends Controller {

    public function list (...$filters) {
        $search = null;
        foreach ($filters as $f) {
            $key = explode('=', $f, 2)[0] ?? '';
            $value = explode('=', $f, 2)[1] ?? '';
            if ($key == 'search'){
                $search = $value;
            }
        }
        $model = $this->model("AdminProductModel");
        $listProducts = $model->getAllProducts($search);
        $this->view("AdminListProduct", ["listProducts" => $listProducts]);
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
            'images'      => $_POST['images'] ?? '',
            'price'       => intval($_POST['price'] ?? 0),
            'discount'    => intval($_POST['discount'] ?? 0),
            'description' => $_POST['description'] ?? '',
            'quantity'    => intval($_POST['quantity'] ?? 0),
            'status'      => $_POST['status'] ?? 'inactive',
        ];
        // Sinh slug từ name
        $slug = strtolower(trim(preg_replace('/\\s+/', '-', $data['name'])));
        $data['slug'] = $slug;
    
        $model = $this->model('AdminProductModel');
        // Kiểm tra trùng
        if ($model->existsCodeOrSlug($data['code'], $slug)) {
            $error = 'Mã sản phẩm đã tồn tại!';
            return $this->view('CreateProduct', [
                'product' => $data,
                'error'   => $error
            ]);
        }
    
        $model->insertProduct($data);
        header('Location: /AdminProductController/list');
        exit;
    }
    
    
    public function update($id) {
        $data = [
            'name'        => $_POST['name']        ?? '',
            'code'        => $_POST['code']        ?? '',
            'images'      => $_POST['images']      ?? '',
            'price'       => intval($_POST['price'] ?? 0),
            'discount'    => intval($_POST['discount'] ?? 0),
            'description' => $_POST['description'] ?? '',
            'specs'       => $_POST['specs']       ?? '',
            'quantity'    => intval($_POST['quantity'] ?? 0),
            'status'      => $_POST['status']      ?? 'inactive',
            'slug'        => $_POST['slug']        ?? '',
        ];
        $model = $this->model("AdminProductModel");
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
        // 2) Cập nhật
        $model->updateProduct($id, $data);
        header("Location: /AdminProductController/edit/$id");
        exit;
    }
    

    public function delete($id) {
        // 1. Lấy model
        $model = $this->model("AdminProductModel");
        // 2. Gọi hàm xóa mềm (set deleted = 1)
        $model->deleteProduct($id);
        // 3. Redirect về danh sách
        header("Location: /AdminProductController/list");
        exit;
    }
 
}