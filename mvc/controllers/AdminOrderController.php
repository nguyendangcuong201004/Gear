<?php
class AdminOrderController extends Controller {

    public function list (...$filters) {
        $search = null;
        $page = 1; // Mặc định là trang 1
        
        foreach ($filters as $f) {
            $key = explode('=', $f, 2)[0] ?? '';
            $value = explode('=', $f, 2)[1] ?? '';
            if ($key == 'search'){
                $search = $value;
            }
            if ($key == 'page') {
                $page = (int)$value;
                if ($page < 1) $page = 1; // Đảm bảo trang luôn ≥ 1
            }
        }
        
        $model = $this->model("AdminOrderModel");
        
        // Lấy tổng số đơn hàng để tính số trang
        $totalOrders = $model->countOrders($search);
        $limit = 10; // Số đơn hàng trên mỗi trang
        $totalPages = ceil($totalOrders / $limit);
        
        // Giới hạn page không vượt quá tổng số trang
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }
        
        $listorders = $model->getListOrder($search, $page, $limit);
        
        $this->view("AdminListOrder", [
            "listorders" => $listorders,
            "currentPage" => $page,
            "totalPages" => $totalPages,
            "search" => $search
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