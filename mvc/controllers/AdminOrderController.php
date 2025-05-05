<?php
class AdminOrderController extends Controller {

    public function list (...$filters) {
        $search = null;
        foreach ($filters as $f) {
            $key = explode('=', $f, 2)[0] ?? '';
            $value = explode('=', $f, 2)[1] ?? '';
            if ($key == 'search'){
                $search = $value;
            }
        }
        $model      = $this->model("AdminOrderModel");
        $listorders = $model->getListOrder($search);
        $this->view("AdminListOrder", [
            "listorders" => $listorders
        ]);
    }

    public function detail($id) {
        // 1) Load model
        $model = $this->model("AdminOrderModel");
    
        // 2) Lấy thông tin chung của đơn hàng
        $order = $model->getOrderById($id);
    
        // 3) Lấy danh sách sản phẩm trong đơn
        $items = $model->getOrderProducts($id);
    
        // 4) Render view chi tiết
        $this->view("AdminDetailOrder", [
            "order" => $order,
            "items" => $items
        ]);
    }

    public function delete($id) {
        // 1) Khởi session hay middleware kiểm auth nếu cần
        // 2) Gọi model để soft-delete
        $model = $this->model("AdminOrderModel");
        $model->softDeleteOrder($id);

        // 3) Quay về danh sách
        header("Location: /Gear/AdminOrderController/list");
        exit;
    }
    

    public function updateStatus($id) {
        // Lấy status mới từ POST
        $newStatus = $_POST['status'] ?? null;
        if ($newStatus) {
            // Gọi model để cập nhật
            $model = $this->model("AdminOrderModel");
            $model->updateStatus($id, $newStatus);
        }
        // Quay về trang danh sách (hoặc detail tuỳ bạn)
        header("Location: /Gear/AdminOrderController/list");
        exit;
    }
 
}