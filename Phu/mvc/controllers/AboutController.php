<?php
class AboutController extends Controller {
    public function index() {
        // Kiểm tra người dùng dựa trên cookie thay vì session
        if (isset($_COOKIE['user_name']) && $_COOKIE['user_name'] === 'admin') {
            // If admin, render the admin view
            $this->view("AboutViewAdmin");
        } else {
            // If not admin, render the regular view
            $this->view("AboutView");
        }
    }
    
    public function list() {
        // Redirect to index method
        $this->index();
    }
}