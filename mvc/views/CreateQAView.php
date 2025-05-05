<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask a Question - GearBK Q&A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Gear/public/css/blog.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Gear/public/css/createQA.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-inner-content">
                        <div class="header-logo">
                            <img src="../public/images/LogoGearBK.webp" alt="">
                            <span>GearBK</span>
                        </div>
                        <div class="header-menu">
                            <ul>
                                <li><a href="/Gear">HOME</a></li>
                                <li><a href="/Gear/AboutController/index">ABOUT</a></li>
                                <li><a href="/Gear/shop">SHOP</a></li>
                                <li><a href="/Gear/contact">CONTACT</a></li>
                                <li><a href="/Gear/BlogController/list">BLOG</a></li>
                                <li><a href="/Gear/QAController/list" class="active">Q&A</a></li>
                                <?php if (isset($_COOKIE['user_name'])): ?>
                                    <li><a href="../AuthController/logout">ĐĂNG XUẤT</a></li>
                                <?php else: ?>
                                    <li><a href="../AuthController/login">ĐĂNG NHẬP</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="header-shop"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="header-user"><i class="fa-solid fa-user"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="create-qa-container">
        <h1 class="create-qa-title animate__animated animate__fadeIn">Ask a Question</h1>
        
        <?php if (isset($error)): ?>
            <div class="qa-error qa-error-shake animate__animated animate__headShake">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <div class="create-qa-card animate__animated animate__fadeIn animate__delay-1s">
            <h2 class="qa-form-title">What would you like to ask?</h2>
            
            <form action="/Gear/QAController/create" method="post">
                <div class="qa-form-group animate-fade-in-up delay-1">
                    <label for="title" class="qa-form-label">Title</label>
                    <input type="text" name="title" id="title" class="qa-form-input" placeholder="Be specific and imagine you're asking a question to another person" required>
                </div>
                
                <div class="qa-form-group animate-fade-in-up delay-2">
                    <label for="content" class="qa-form-label">Question Details</label>
                    <textarea name="content" id="content" class="qa-form-textarea" placeholder="Include all the information someone would need to answer your question"></textarea>
                    <input type="hidden" id="content-hidden" name="content">
                </div>
                
                <div class="qa-form-group animate-fade-in-up delay-3">
                    <label for="tags" class="qa-form-label">Tags</label>
                    <div class="qa-tags-container">
                        <!-- Ô nhập liệu tag -->
                        <div class="qa-tags-input-container">
                            <button type="button" id="show-tags-btn" class="show-tags-btn">
                                <i class="fas fa-tags"></i> Show tags <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        
                        <!-- Vùng hiển thị tags đã chọn -->
                        <div id="selected-tags" class="selected-tags-container"></div>
                        
                        <!-- Vùng hiển thị thông báo lỗi -->
                        <div class="tags-limit-message">
                            <i class="fas fa-exclamation-circle"></i> Maximum 5 tags allowed
                        </div>
                        
                        <!-- Danh sách tags có sẵn (mặc định ẩn) -->
                        <div id="tags-dropdown" class="tags-dropdown" style="display: none;">
                            <?php
                            // Lưu tất cả tags vào JavaScript để xử lý tìm kiếm
                            echo '<script>const allTags = [';
                            $tagsArray = [];
                            if (isset($data['tags']) && $data['tags']->num_rows > 0) {
                                $data['tags']->data_seek(0);
                                while ($tag = $data['tags']->fetch_assoc()) {
                                    $tagsArray[] = "{id: " . $tag['id'] . ", name: '" . htmlspecialchars($tag['name']) . "'}";
                                }
                                echo implode(',', $tagsArray);
                            }
                            echo '];</script>';
                            
                            if (isset($data['tags']) && $data['tags']->num_rows > 0) {
                                echo '<div class="tags-list" id="tags-list">';
                                $data['tags']->data_seek(0);
                                while ($tag = $data['tags']->fetch_assoc()) {
                                    echo '<div class="tag-item" data-id="' . $tag['id'] . '" data-name="' . htmlspecialchars($tag['name']) . '">';
                                    echo htmlspecialchars($tag['name']);
                                    echo '</div>';
                                }
                                echo '</div>';
                            } else {
                                echo '<div class="no-tags">No tags available. Type to create your own.</div>';
                            }
                            ?>
                        </div>
                        
                        <!-- Hidden inputs để lưu các tags đã chọn -->
                        <div id="tags-hidden-inputs"></div>
                    </div>
                </div>
                
                <div class="qa-form-btn-group animate-fade-in-up delay-4">
                    <a href="/Gear/QAController/list" class="qa-back-btn">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="qa-submit-btn">
                        <i class="fas fa-paper-plane"></i> Post Your Question
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Floating Tips Box -->
        <div class="qa-floating-tips" id="floating-tips">
            <div class="qa-close-tips" id="close-tips">
                <i class="fas fa-times"></i>
            </div>
            <div class="qa-tips-title">
                <i class="fas fa-lightbulb"></i> Tips for a great question
            </div>
            <div class="qa-tips-content">
                <ul class="qa-tips-list">
                    <li>Summarize your problem in a one-line title</li>
                    <li>Describe what you've tried and what you expected to happen</li>
                    <li>Add details like error messages, product models, etc.</li>
                    <li>Use clear, concise language and proper formatting</li>
                    <li>Add relevant tags to help others find your question</li>
                </ul>
            </div>
        </div>
        
        <p class="text-center text-white mt-4">Copyright © <?= date('Y'); ?> GearBK</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Summernote rich text editor
            $('#content').summernote({
                placeholder: 'Include all the information someone would need to answer your question',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            
            // Form submission handling to capture Summernote content
            $('form').on('submit', function() {
                // Get the content from Summernote before submitting
                const content = $('#content').summernote('code');
                // Update the hidden field with the HTML content
                $('#content-hidden').val(content);
            });

            // Focus effect for form inputs
            const formInputs = document.querySelectorAll('.qa-form-input, .qa-tags-input');
            
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.01)';
                });
                
                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
            
            // Show floating tips after a slight delay
            setTimeout(() => {
                document.getElementById('floating-tips').classList.add('active');
            }, 1000);
            
            // Close tips box
            document.getElementById('close-tips').addEventListener('click', function() {
                document.getElementById('floating-tips').classList.remove('active');
            });
            
            // Xử lý hiển thị và lựa chọn tags
            const tagSearch = document.getElementById('tag-search');
            const showTagsBtn = document.getElementById('show-tags-btn');
            const tagsDropdown = document.getElementById('tags-dropdown');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const tagsHiddenInputs = document.getElementById('tags-hidden-inputs');
            const tagsList = document.getElementById('tags-list');
            const tagsLimitMessage = document.querySelector('.tags-limit-message');
            
            let selectedTags = [];
            
            // Hiển thị/ẩn dropdown tags
            showTagsBtn.addEventListener('click', function() {
                if (tagsDropdown.style.display === 'none') {
                    tagsDropdown.style.display = 'block';
                    this.querySelector('.fa-chevron-down').classList.replace('fa-chevron-down', 'fa-chevron-up');
                } else {
                    tagsDropdown.style.display = 'none';
                    this.querySelector('.fa-chevron-up').classList.replace('fa-chevron-up', 'fa-chevron-down');
                }
            });
            
            // Chọn tag khi click vào tag trong dropdown
            if (tagsList) {
                tagsList.addEventListener('click', function(e) {
                    const tagItem = e.target.closest('.tag-item');
                    if (tagItem) {
                        const tagId = tagItem.getAttribute('data-id');
                        const tagName = tagItem.getAttribute('data-name');
                        
                        toggleTag(tagId, tagName);
                    }
                });
            }
            
            // Thêm tag khi nhấn Enter trong ô tìm kiếm
            tagSearch.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    
                    const newTagName = this.value.trim();
                    if (newTagName) {
                        // Kiểm tra xem tag này đã tồn tại trong danh sách chưa
                        const existingTag = allTags.find(tag => tag.name.toLowerCase() === newTagName.toLowerCase());
                        
                        if (existingTag) {
                            toggleTag(existingTag.id, existingTag.name);
                        } else {
                            // Nếu là tag mới
                            toggleTag('new', newTagName);
                        }
                        
                        this.value = '';
                    }
                }
            });
            
            // Hàm toggle chọn/bỏ chọn tag
            function toggleTag(tagId, tagName) {
                // Kiểm tra xem tag đã được chọn chưa
                const existingIndex = selectedTags.findIndex(tag => tag.name.toLowerCase() === tagName.toLowerCase());
                
                if (existingIndex > -1) {
                    // Nếu đã chọn thì bỏ chọn
                    removeTag(existingIndex);
                } else {
                    // Nếu chưa chọn và chưa đạt tối đa 5 tags thì thêm vào
                    if (selectedTags.length < 5) {
                        selectedTags.push({ id: tagId, name: tagName });
                        renderSelectedTags();
                        
                        // Highlight tag trong dropdown nếu có
                        const tagItem = document.querySelector(`.tag-item[data-name="${tagName}"]`);
                        if (tagItem) {
                            tagItem.classList.add('selected');
                        }
                    } else {
                        showTagLimitError();
                    }
                }
            }
            
            // Hiển thị các tags đã chọn
            function renderSelectedTags() {
                selectedTagsContainer.innerHTML = '';
                tagsHiddenInputs.innerHTML = '';
                
                selectedTags.forEach((tag, index) => {
                    // Tạo thẻ hiển thị
                    const tagElement = document.createElement('div');
                    tagElement.className = 'selected-tag';
                    tagElement.innerHTML = `
                        ${tag.name}
                        <span class="remove-tag" data-index="${index}">×</span>
                    `;
                    selectedTagsContainer.appendChild(tagElement);
                    
                    // Tạo input ẩn để submit
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'tags[]';
                    hiddenInput.value = tag.name;
                    tagsHiddenInputs.appendChild(hiddenInput);
                });
                
                // Thêm sự kiện xóa tag
                const removeButtons = document.querySelectorAll('.remove-tag');
                removeButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        removeTag(index);
                    });
                });
            }
            
            // Xóa tag đã chọn
            function removeTag(index) {
                const removedTag = selectedTags[index];
                selectedTags.splice(index, 1);
                renderSelectedTags();
                
                // Bỏ highlight tag trong dropdown
                const tagItem = document.querySelector(`.tag-item[data-name="${removedTag.name}"]`);
                if (tagItem) {
                    tagItem.classList.remove('selected');
                }
            }
            
            // Hiển thị thông báo lỗi khi chọn quá 5 tags
            function showTagLimitError() {
                tagsLimitMessage.classList.add('show');
                setTimeout(() => {
                    tagsLimitMessage.classList.remove('show');
                }, 3000);
            }
            
            // Xử lý khi click ra ngoài dropdown thì ẩn dropdown
            document.addEventListener('click', function(e) {
                if (!tagsDropdown.contains(e.target) && !showTagsBtn.contains(e.target) && !tagSearch.contains(e.target)) {
                    tagsDropdown.style.display = 'none';
                    if (showTagsBtn.querySelector('.fa-chevron-up')) {
                        showTagsBtn.querySelector('.fa-chevron-up').classList.replace('fa-chevron-up', 'fa-chevron-down');
                    }
                }
            });
            
            // Title validation for minimum length
            const titleInput = document.getElementById('title');
            titleInput.addEventListener('blur', function() {
                if (this.value.length < 10) {
                    this.style.borderColor = '#e74c3c';
                    if (!document.querySelector('.title-error')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'qa-tags-help title-error';
                        errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> Title should be at least 10 characters';
                        errorMsg.style.color = '#e74c3c';
                        this.parentNode.appendChild(errorMsg);
                    }
                } else {
                    this.style.borderColor = '#ddd';
                    const errorMsg = document.querySelector('.title-error');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
            
            // Content validation for minimum length
            const contentInput = document.getElementById('content');
            contentInput.addEventListener('blur', function() {
                if (this.value.length < 30) {
                    this.style.borderColor = '#e74c3c';
                    if (!document.querySelector('.content-error')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'qa-tags-help content-error';
                        errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> Please provide more details (at least 30 characters)';
                        errorMsg.style.color = '#e74c3c';
                        this.parentNode.appendChild(errorMsg);
                    }
                } else {
                    this.style.borderColor = '#ddd';
                    const errorMsg = document.querySelector('.content-error');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
            
            // Add animation to the form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                // Basic client-side validation
                let isValid = true;
                
                if (titleInput.value.length < 10) {
                    titleInput.style.borderColor = '#e74c3c';
                    isValid = false;
                }
                
                if (contentInput.value.length < 30) {
                    contentInput.style.borderColor = '#e74c3c';
                    isValid = false;
                }
                
                // Kiểm tra số lượng tag khi submit
                const checkedTags = document.querySelectorAll('input[name="tags[]"]:checked');
                if (checkedTags.length > 5) {
                    if (tagsLimitMessage) {
                        tagsLimitMessage.classList.add('show');
                    }
                    isValid = false;
                }
                
                // Kiểm tra cũng với trường hợp nhập thủ công
                if (tagsInput) {
                    const tags = tagsInput.value.split(',').filter(tag => tag.trim() !== '');
                    if (tags.length > 5) {
                        tagsInput.style.borderColor = '#e74c3c';
                        isValid = false;
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    // Shake the form to indicate error
                    document.querySelector('.create-qa-card').classList.add('qa-error-shake');
                    setTimeout(() => {
                        document.querySelector('.create-qa-card').classList.remove('qa-error-shake');
                    }, 500);
                    return;
                }
                
                // Add submit animation
                document.querySelector('.qa-submit-btn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            });
        });
    </script>
</body>
</html> 