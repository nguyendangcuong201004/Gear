<?php

class ProductModel extends Database{
    public function getListProducts($search = null,  $sortfilter = null, $pricefilter = null) {
        $sql = "SELECT * FROM products";
        $conds = ["deleted = 0"];

        if ($search) {
            $conds[] = "slug LIKE '%{$search}%'";
        }
        if ($pricefilter && $pricefilter !== '1') {
            switch ($pricefilter) {
                case '2':
                    $conds[] = "price < 500000";
                    break;
                case '3':
                    $conds[] = "price BETWEEN 500000 AND 5000000";
                    break;
                case '4':
                    $conds[] = "price BETWEEN 5000000 AND 15000000";
                    break;
                case '5':
                    $conds[] = "price BETWEEN 15000000 AND 30000000";
                    break;
                case '6':
                    $conds[] = "price > 30000000";
                    break;
            }
        }
        if (count($conds)) {
            $sql .= " WHERE " . implode(" AND ", $conds);
        }
        if ($sortfilter) {
            switch ($sortfilter) {
                case 'price-asc':
                    $sql .= " ORDER BY price ASC";
                    break;
                case 'price-desc':
                    $sql .= " ORDER BY price DESC";
                    break;
                case 'az':
                    $sql .= " ORDER BY name ASC";
                    break;
                case 'za':
                    $sql .= " ORDER BY name DESC";
                    break;
                default:
                    $sql .= " ORDER BY id DESC";
            }
        }
        // echo $sql;
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function getDetailProduct($slug){
        $slug_safe = mysqli_real_escape_string($this->con, $slug);
        $sql    = "SELECT * FROM products WHERE slug = '{$slug_safe}'";
        $result = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_assoc($result); 
        return $row;
    }

    public function getSearchProducts($search) {
        $qr = "SELECT * FROM products WHERE slug LIKE '%{$search}%'";
        return mysqli_query($this->con, $qr);
    }
}

?>