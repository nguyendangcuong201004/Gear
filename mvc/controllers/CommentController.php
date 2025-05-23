<?php
// mvc/controllers/CommentController.php
require_once "./mvc/models/CommentModel.php";
require_once "./mvc/models/UserModel.php";
require_once "./mvc/core/Controller.php";

class CommentController extends Controller {
    private $commentModel;
    private $userModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
        $this->userModel = new UserModel();
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_id = $_POST['post_id'];
            $name    = $_POST['name'];
            $comment = $_POST['comment'];

            // Lấy email của người dùng nếu đã đăng nhập
            $email = '';
            if (isset($_COOKIE['user_name'])) {
                $user = $this->userModel->getUserByUsername($_COOKIE['user_name']);
                if ($user && isset($user['email'])) {
                    $email = $user['email'];
                }
            }

            $this->commentModel->addComment($post_id, $name, $comment, $email);
            header("Location: http://localhost/Gear/BlogController/detail/$post_id");
        }
    }
    public function edit($cid = null, $post_id = null) {
        if (!$cid || !$post_id) {
            echo "Thiếu thông tin.";
            return;
        }
    
        $comment = $this->commentModel->getCommentById($cid);
    
        if (!$comment) {
            echo "Không tìm thấy comment.";
            return;
        }
    
        if (isset($_COOKIE['user_name']) && $_COOKIE['user_name'] === $comment['name']) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $updated = $_POST['comment'];
                $this->commentModel->updateComment($cid, $updated);
                header("Location: http://localhost/Gear/BlogController/detail/$post_id");
            } else {
                $this->render("EditCommentView", [
                    "comment" => $comment,
                    "post_id" => $post_id
                ]);
            }
        } else {
            echo "Bạn không có quyền sửa comment này.";
        }
    }
    
    

    public function delete($cid = null, $post_id = null) {
        if (!$cid || !$post_id) {
            echo "Thiếu thông tin.";
            return;
        }
    
        $comment = $this->commentModel->getCommentById($cid);
    
        if (!$comment) {
            echo "Không tìm thấy comment.";
            return;
        }
    
        // Kiểm tra quyền xóa
        if (isset($_COOKIE['user_name']) && $_COOKIE['user_name'] === $comment['name']) {
            $this->commentModel->deleteComment($cid);
        } else {
            echo "Bạn không có quyền xoá comment này.";
            return;
        }
    
        header("Location: http://localhost/Gear/BlogController/detail/$post_id");
    }
    public function render($view, $data = []) {
        require_once "./mvc/views/" . $view . ".php";
    }
}
