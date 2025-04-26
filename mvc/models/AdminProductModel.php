<?php

class AdminProductModel extends Database {
    public function getAllProducts($search = null) {
        $sql = "SELECT * FROM products";
        $conds = ["deleted = 0"];

        if ($search) {
            $conds[] = "slug LIKE '%{$search}%'";
        }

        if (count($conds)) {
            $sql .= " WHERE " . implode(" AND ", $conds);
        }
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    public function getProductById($id) {
        $id_safe = intval($id);
        $res = mysqli_query($this->con, "SELECT * FROM products WHERE id=$id_safe LIMIT 1");
        return mysqli_fetch_assoc($res);
    }

    public function insertProduct($data) {
        $name = mysqli_real_escape_string($this->con, $data['name']);
        $slug = mysqli_real_escape_string($this->con, $data['slug']);
        $code = mysqli_real_escape_string($this->con, $data['code']);
        $price = intval($data['price']);
        $discount = intval($data['discount']);
        $qty = intval($data['quantity']);
        $desc = mysqli_real_escape_string($this->con, $data['description']);
        $status = mysqli_real_escape_string($this->con, $data['status']);
        $img = mysqli_real_escape_string($this->con, $data['images']);
        $sql = "INSERT INTO products (name, code, slug, price, discount, quantity, description, status, images, created_at) " .
               "VALUES ('$name', '$code', '$slug',$price,$discount,$qty,'$desc','$status','$img',NOW())";
        mysqli_query($this->con, $sql) or die(mysqli_error($this->con));
    }

    public function updateProduct($id, $data) {
        $id_safe   = intval($id);
        $name      = mysqli_real_escape_string($this->con, $data['name']);
        $slug      = mysqli_real_escape_string($this->con, $data['slug']);
        $code      = mysqli_real_escape_string($this->con, $data['code']);
        $price     = intval($data['price']);
        $discount  = intval($data['discount']);
        $qty       = intval($data['quantity']);
        $desc      = mysqli_real_escape_string($this->con, $data['description']);
        $status    = mysqli_real_escape_string($this->con, $data['status']);
        $img       = mysqli_real_escape_string($this->con, $data['images']);
    
        $sql = "UPDATE products SET
                  name='$name',
                  code='$code',
                  slug='$slug',
                  price=$price,
                  discount=$discount,
                  quantity=$qty,
                  description='$desc',
                  status='$status',
                  images='$img',
                  updated_at=NOW()
                WHERE id=$id_safe";
        mysqli_query($this->con, $sql) or die(mysqli_error($this->con));
    }

    public function deleteProduct($id) {
        $id_safe = intval($id);
        $sql = "UPDATE products
                SET deleted = 1,
                    deleted_at = NOW()
                WHERE id = $id_safe";
        mysqli_query($this->con, $sql)
            or die("Delete failed: " . mysqli_error($this->con));
    }

    /**
     * Kiểm tra xem đã tồn tại code hoặc slug chưa.
     * @param string $code
     * @param string $slug
     * @param int|null $excludeId  Nếu đang edit thì truyền vào ID để bỏ qua chính record đó
     * @return bool  true nếu đã có trùng
     */
    public function existsCodeOrSlug(string $code, string $slug, int $excludeId = null): bool {
        $codeSafe = mysqli_real_escape_string($this->con, $code);
        $slugSafe = mysqli_real_escape_string($this->con, $slug);
        $sql = "SELECT COUNT(*) AS cnt 
                FROM products 
                WHERE deleted = 0 
                AND (code = '$codeSafe' OR slug = '$slugSafe')";
        if ($excludeId) {
            $sql .= " AND id <> " . intval($excludeId);
        }
        $res = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_assoc($res);
        return (int)$row['cnt'] > 0;
    }
}