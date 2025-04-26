<?php
class AboutController extends Controller {
    public function index() {
        // Simply render the About Us view
        $this->view("AboutView");
    }
    
    public function list() {
        // Redirect to index method
        $this->index();
    }
}
?> 