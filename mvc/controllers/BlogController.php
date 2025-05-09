<?php
require_once "./mvc/models/BlogModel.php";
require_once "./mvc/core/Controller.php"; // dòng này nếu chưa có


class BlogController extends Controller {
    
    public function list(...$params) {
        $search = $params[0] ?? ''; // lấy từ khóa nếu có
        $search = str_replace('-', ' ', $search); // convert 'hello-world' -> 'hello world'
    
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 6;
        $start = ($page - 1) * $limit;
    
        $blogModel = $this->model("BlogModel");
    
        if (!empty($search)) {
            $stmt = $blogModel->searchPosts($search, $start, $limit);
            $total = $blogModel->countSearchPosts($search);
        } else {
            $stmt = $blogModel->getBlogPosts($page, $limit);
            $total = $blogModel->countTotalPosts();
        }
    
        $total_pages = ceil($total / $limit);
    
        $this->render("BlogViews", [
            "posts" => $stmt,
            "page" => $page,
            "total_pages" => $total_pages,
            "search" => $search // gán lại cho View nếu cần hiển thị
        ]);
    }
    public function search($keyword = '') {
        $keyword = str_replace('-', ' ', $keyword); // hello-world → hello world
        $page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit   = 6;
        $start   = ($page - 1) * $limit;
    
        $blogModel = $this->model("BlogModel");
    
        $stmt  = $blogModel->searchPosts($keyword, $start, $limit);
        $total = $blogModel->countSearchPosts($keyword);
    
        $total_pages = ceil($total / $limit);
    
        $this->render("BlogViews", [
            "posts" => $stmt,
            "page" => $page,
            "total_pages" => $total_pages,
            "search" => $keyword
        ]);
    }
    
    
    
    public function create() {
        // Nếu là submit form (method POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title    = $_POST['title'];
            $category = $_POST['category'];
            $content  = $_POST['content'];
            $image    = "";

            // Xử lý upload ảnh nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

                $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
if (!in_array($_FILES['image']['type'], $allowed_types)) {
    die("File không đúng định dạng ảnh!");
}

                $target_dir = "public/uploads/";  // Thư mục lưu ảnh
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image_name  = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image_name;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $target_file;
                }
            }

            // Khởi tạo model và gọi phương thức thêm bài viết mới
            $blogModel = new BlogModel();
            if ($blogModel->createPost($title, $category, $image, $content)) {
                echo "<script>alert('Post created successfully!'); window.location='/Gear/BlogController/list';</script>";
            } else {
                echo "Error creating post!";
            }
        } else {
            // Nếu là GET, hiển thị form tạo bài viết mới
            $this->render("CreateBlog");
        }
    }

    // Phương thức render view
    public function detail(...$params) {
        // Lấy ID bài viết từ các tham số truyền vào
        $post_id = isset($params[0]) ? (int)$params[0] : 0;
        if ($post_id <= 0) {
            echo "<h1>Post not found!</h1>";
            var_dump($params);
            exit;
        }
        
        // Khởi tạo model
        $blogModel = new BlogModel();
        
        // Xử lý thao tác xóa bài viết nếu có tham số GET action=delete
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            if ($blogModel->deletePostById($post_id)) {
                header("Location: /Gear/BlogController/list"); // hoặc route phù hợp
                exit;
            } else {
                echo "Error deleting post!";
            }
        }
        
        // Xử lý gửi bình luận nếu có dữ liệu POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['email'], $_POST['comment'])) {
            $name    = $_POST['name'];
            $email   = $_POST['email'];
            $comment = $_POST['comment'];
            if ($blogModel->createComment($post_id, $name, $email, $comment)) {
                header("Location: /Gear/BlogController/detail/" . $post_id);
                exit;
            } else {
                echo "Error adding comment!";
            }
        }
        
        // Lấy dữ liệu bài viết
        $post = $blogModel->getPostById($post_id);
        if (!$post) {
            echo "<h1>Post not found!</h1>";
            exit;
        }
        
        // Lấy danh sách bình luận
        $comments = $blogModel->getComments($post_id);
        
        // Đóng gói dữ liệu gửi sang view
        $data = [
            "post"     => $post,
            "comments" => $comments,
            "post_id"  => $post_id
        ];
        
        $this->render("BlogDetailView", $data);
    }
    
    
    // Phương thức render view dùng chung cho Controller
    public function render($view, $data = []) {
        require_once "./mvc/views/$view.php";
    }
    public function edit(...$params) {
        // Lấy ID bài viết từ URL: nếu dùng định tuyến friendly URL (BlogController/edit/4)
        if (!empty($params)) {
            $post_id = (int)$params[0];
        } elseif (isset($_GET['id'])) {
            $post_id = (int)$_GET['id'];
        } else {
            echo "<h1>Post not found!</h1>";
            exit;
        }
    
        // Khởi tạo model
        $blogModel = new BlogModel();
        
        // Lấy bài viết cần chỉnh sửa
        $post = $blogModel->getPostById($post_id);
        if (!$post) {
            echo "<h1>Post not found!</h1>";
            exit;
        }
        
        // Xử lý form submit (cập nhật bài viết)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form (nên sử dụng prepared statements trong model để an toàn)
            $title    = $blogModel->con->real_escape_string($_POST['title']);
            $category = $blogModel->con->real_escape_string($_POST['category']);
            $content  = $blogModel->con->real_escape_string($_POST['content']);
            $image    = $post['image']; // Dùng ảnh hiện tại nếu không thay đổi
    
            // Xử lý upload ảnh nếu có file mới được chọn
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Nếu bạn để uploads trong public, điều chỉnh đường dẫn cho phù hợp
                $target_dir = "public/uploads/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image_name  = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $image_name;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $target_file; // Cập nhật đường dẫn ảnh mới
                }
            }
            
            // Gọi model để update bài viết
            if ($blogModel->updatePost($post_id, $title, $category, $content, $image)) {
                // Chuyển hướng về trang chi tiết bài viết
                header("Location: /Gear/BlogController/detail/" . $post_id);
                exit;
            } else {
                echo "Error updating post!";
            }
        }
        
        // Nếu không POST, render view edit kèm dữ liệu bài viết hiện tại
        $data = [
            "post"    => $post,
            "post_id" => $post_id
        ];
        $this->render("EditBlogView", $data);
    }
    
}
?>
