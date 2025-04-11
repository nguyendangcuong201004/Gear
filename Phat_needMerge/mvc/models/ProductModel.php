<?php

class ProductModel extends Database{
    public function getListProducts() {
        $qr = "SELECT * FROM products";
        return mysqli_query($this->con, $qr);
    }

    public function getDetailProduct(){
        return "Data";
    }
}

?>