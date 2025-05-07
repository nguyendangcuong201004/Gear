<?php

class AdminUserModel extends Database {
    public function getAllUsers($search = null, $page = 1, $limit = 10) {
        // Tính offset dựa vào trang hiện tại
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT * FROM users WHERE deleted = 0";
        if ($search) {
            $s = mysqli_real_escape_string($this->con, $search);
            $sql .= " AND username LIKE '%{$s}%'";
        }
        
        // Thêm LIMIT và OFFSET cho phân trang
        $sql .= " ORDER BY id DESC LIMIT {$offset}, {$limit}";
        
        return mysqli_query($this->con, $sql);
    }
    
    /**
     * Đếm tổng số người dùng để phân trang
     */
    public function countUsers($search = null) {
        $sql = "SELECT COUNT(*) as total FROM users WHERE deleted = 0";
        if ($search) {
            $s = mysqli_real_escape_string($this->con, $search);
            $sql .= " AND username LIKE '%{$s}%'";
        }
        
        $result = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_assoc($result);
        return (int)$row['total'];
    }

    public function getUserById(int $id) {
        $id  = intval($id);
        $res = mysqli_query($this->con,
            "SELECT * FROM users WHERE id = {$id} AND deleted = 0"
        );
        return mysqli_fetch_assoc($res) ?: null;
    }


    public function updateUser($id, $data) {
        $id = intval($id);
        $set = [];

        if (isset($data['username'])) {
            $u = mysqli_real_escape_string($this->con, $data['username']);
            $set[] = "username = '{$u}'";
        }
        if (!empty($data['password'])) {
            $p = password_hash($data['password'], PASSWORD_DEFAULT);
            $set[] = "password = '{$p}'";
        }
        if (isset($data['user_role'])) {
            $r = mysqli_real_escape_string($this->con, $data['user_role']);
            $set[] = "user_role = '{$r}'";
        }

        $set[] = "updated_at = '" . date("Y-m-d H:i:s") . "'";

        $sql = "UPDATE users
                SET " . implode(", ", $set) . "
                WHERE id = {$id}
                  AND deleted = 0
        ";

        return mysqli_query($this->con, $sql);

    }

    public function softDeleteUser($id) {
        $id = intval($id);
        $now = date("Y-m-d H:i:s");
        $sql = "
          UPDATE users
          SET deleted = 1,
              deleted_at = '{$now}',
              updated_at = '{$now}'
          WHERE id = {$id}
        ";
        return mysqli_query($this->con, $sql);
    }
}
