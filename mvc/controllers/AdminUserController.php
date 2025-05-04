<?php
class AdminUserController extends Controller {

    public function list(...$filters) {
        // 1. Lấy từ khóa search nếu có
        $search = null;
        foreach ($filters as $segment) {
            if (strpos($segment, 'search=') === 0) {
                $search = substr($segment, strlen('search='));
                break;
            }
        }

        // 2. Gọi model lấy dữ liệu
        $model      = $this->model("AdminUserModel");
        $resultSet  = $model->getAllUsers($search);

        // 3. Chuyển kết quả thành mảng để truyền view
        $listUsers = [];
        if ($resultSet) {
            while ($row = mysqli_fetch_assoc($resultSet)) {
                $listUsers[] = $row;
            }
        }

        // 4. Render view
        $this->view("AdminListUser", [
            "listUsers" => $listUsers,
            "search"    => $search
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
        header("Location: /AdminUserController/list");
        exit;
    }

    // soft-delete
    public function delete($id) {
        $model = $this->model("AdminUserModel");
        $model->softDeleteUser($id);
        header("Location: /AdminUserController/list");
        exit;
    }
}
