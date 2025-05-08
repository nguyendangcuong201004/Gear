<?php
// Sử dụng extract nếu cần, hoặc truy cập trực tiếp qua $data:
$post = $data['post'];
$post_id = $data['post_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Post - <?= htmlspecialchars($post['title']); ?></title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- CKEditor CDN -->
  <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      /* background: url('../../public/images/background_login.webp') no-repeat center center fixed;
      background-size: cover; */
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }
    .admin-container {
      max-width: 800px;
      margin: 80px auto;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      padding: 20px;
    }
    .admin-container h2 {
      color: #4a0072;
      text-align: center;
      margin-bottom: 20px;
    }
    .btn-purple {
      background-color: #4a0072;
      color: #fff;
      border: none;
    }
    .btn-purple:hover {
      background-color: #6a1b9a;
      color: #fff;
    }
  </style>
</head>
<body>
  <div class="admin-container">
    <h2>Edit Post</h2>
    <form action="" method="POST" enctype="multipart/form-data"> 
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" 
               value="<?= htmlspecialchars($post['title']); ?>" required/>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control" id="category" name="category" 
               value="<?= htmlspecialchars($post['category']); ?>" required/>
      </div>
      <div class="form-group">
        <label for="image">Upload Image (Leave blank to keep current image)</label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*"/>
        <small>
          Current image: 
          <img src="../../<?= htmlspecialchars($post['image']); ?>" alt="Current Image" 
               style="max-width: 100px; margin-top: 10px;">
        </small>
      </div>
      <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" id="content" name="content" rows="5"><?= htmlspecialchars($post['content']); ?></textarea>
      </div>
      <button type="submit" class="btn btn-purple">Update Post</button>
      <a href="BlogController/detail/<?= $post_id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
  
  <!-- Khởi tạo CKEditor cho textarea -->
  <script>
    CKEDITOR.replace('content', {
      height: 300,
      width: '100%'
    });
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" 
          integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" 
          integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" 
          crossorigin="anonymous"></script>
</body>
</html>
