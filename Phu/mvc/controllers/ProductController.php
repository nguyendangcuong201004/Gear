<?php

class ProductController extends Controller{
    public function list () {
        $model = $this->model("ProductModel");
        $listProducts = $model->getListProducts();
        $this->view("ListProductsView", ["listProducts" => $listProducts]);
    }

    public function Show () {
        $h = $this->model("ProductModel");
        $data = $h->getListProduct();
        $this->view("ProductView", ["data" => $data]);
    }
}

?>