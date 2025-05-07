<?php
class AdminUserController extends Controller {

    public function list(...$filters) {
        // 1. Lấy từ khóa search và trang nếu có
        $search = null;
        $page = 1; // Mặc định là trang 1
        
        foreach ($filters as $segment) {
            if (strpos($segment, 'search=') === 0) {
                $search = substr($segment, strlen('search='));
            }
            if (strpos($segment, 'page=') === 0) {
                $page = (int)substr($segment, strlen('page='));
                if ($page < 1) $page = 1; // Đảm bảo trang luôn ≥ 1
            }
        }
        
        // 2. Gọi model lấy dữ liệu
        $model = $this->model("AdminUserModel");
        
        // 3. Tính toán phân trang
        $limit = 10; // Số người dùng trên mỗi trang
        $totalUsers = $model->countUsers($search);
        $totalPages = ceil($totalUsers / $limit);
        
        // Đảm bảo trang hiện tại không vượt quá tổng số trang
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }
        
        // 4. Lấy danh sách người dùng cho trang hiện tại
        $resultSet = $model->getAllUsers($search, $page, $limit);

        // 5. Chuyển kết quả thành mảng để truyền view
        $listUsers = [];
        if ($resultSet) {
            while ($row = mysqli_fetch_assoc($resultSet)) {
                $listUsers[] = $row;
            }
        }

        // 6. Render view
        $this->view("AdminListUser", [
            "listUsers" => $listUsers,
            "search" => $search,
            "currentPage" => $page,
            "totalPages" => $totalPages
        ]);
    }

    // form edit
    public function edit($id) {
        $model = $this->model("AdminUserModel");
        $user  = $model->getUserById($id);
        $this->view("AdminEditUser", ["user" => $user]);
    }

    // xử lý lưu sửa
    public function update($id) {
        $data = [
            "username"  => $_POST['username'] ?? '',
            "password"  => $_POST['password'] ?? '',       // nếu bỏ trống sẽ không update pass
            "user_role" => $_POST['user_role'] ?? 'user'
        ];
        $model = $this->model("AdminUserModel");
        $model->updateUser($id, $data);
        header("Location: /Gear/AdminUserController/list");
        exit;
    }

    // soft-delete
    public function delete($id) {
        $model = $this->model("AdminUserModel");
        $model->softDeleteUser($id);
        header("Location: /Gear/AdminUserController/list");
        exit;
    }
}
