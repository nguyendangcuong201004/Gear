CREATE TABLE products (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,                -- Tên sản phẩm
    code VARCHAR(20),                          -- Mã sản phẩm
    images LONGTEXT,                           -- Ảnh (có thể JSON chuỗi nhiều ảnh)
    price INT,                                 -- Giá bán
    discount INT,                              -- % giảm giá (nếu có)
    description LONGTEXT,                      -- Mô tả chi tiết
    specs LONGTEXT,                            -- Cấu hình / thông số kỹ thuật
    quantity INT,                              -- Số lượng tồn kho
    status VARCHAR(20),                        -- Trạng thái (còn hàng, ngừng KD,...)
    slug VARCHAR(255) NOT NULL,                -- Tên SEO (pc-gaming-x305)
    deleted BOOLEAN DEFAULT FALSE,             -- Xóa mềm
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
);


CREATE TABLE categories (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,               -- Tên danh mục
    image VARCHAR(500),                        -- Ảnh đại diện danh mục
    description LONGTEXT,                      -- Mô tả danh mục
    status VARCHAR(20),                        -- Trạng thái (active/inactive)
    slug VARCHAR(255) NOT NULL,                -- Đường dẫn SEO
    deleted BOOLEAN DEFAULT FALSE,             -- Xóa mềm
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
);



CREATE TABLE products_categories (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);



CREATE TABLE orders (
    id INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL,                -- Mã đơn hàng (vd: ORD12345)
    full_name VARCHAR(50) NOT NULL,           -- Tên người nhận
    phone VARCHAR(10) NOT NULL,               -- SĐT người nhận
    note VARCHAR(500),                        -- Ghi chú đơn hàng
    status VARCHAR(20),                       -- Trạng thái (pending, confirmed,...)
    deleted BOOLEAN DEFAULT FALSE,            -- Xóa mềm
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
);


CREATE TABLE orders_products (
    id INT NOT NULL AUTO_INCREMENT,
    order_id INT NOT NULL,                     -- Mã đơn hàng
    product_id INT NOT NULL,                   -- Mã sản phẩm
    quantity INT NOT NULL,                     -- Số lượng mua
    price INT NOT NULL,                        -- Giá tại thời điểm mua
    discount INT,                              -- Giảm giá (nếu có)
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    address VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    user_role VARCHAR(10) DEFAULT 'user'
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    author VARCHAR(20) default 'Admin'
);
CREATE TABLE `comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `comment` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- categories
INSERT INTO categories (title, image, description, status, slug) VALUES ('PC Gaming', 'pc-gaming.jpg', 'Máy tính chơi game hiệu năng cao', 'active', 'pc-gaming');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Laptop Văn Phòng', 'laptop-vanphong.jpg', 'Laptop mỏng nhẹ cho công việc', 'active', 'laptop-van-phong');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Màn Hình', 'man-hinh.jpg', 'Màn hình Full HD, 2K, 4K', 'active', 'man-hinh');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Phụ Kiện', 'phu-kien.jpg', 'Chuột, bàn phím, tai nghe...', 'active', 'phu-kien');
INSERT INTO categories (title, image, description, status, slug) VALUES ('Thiết Bị Mạng', 'network.jpg', 'Router, Switch, WiFi Mesh', 'active', 'thiet-bi-mang');

-- products
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('PC Gaming X305', 'SP0001', 'pc-gaming-x305.jpg', 9361678, 5, 'Sản phẩm PC Gaming X305 phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 47, 'active', 'pc-gaming-x305');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Laptop HP G3', 'SP0002', 'laptop-hp-g3.jpg', 17389795, 0, 'Sản phẩm Laptop HP G3 phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 36, 'active', 'laptop-hp-g3');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Màn Hình LG 24inch', 'SP0003', 'màn-hình-lg-24inch.jpg', 8348463, 10, 'Sản phẩm Màn Hình LG 24inch phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 62, 'active', 'màn-hình-lg-24inch');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Chuột Logitech G102', 'SP0004', 'chuột-logitech-g102.jpg', 11188129, 10, 'Sản phẩm Chuột Logitech G102 phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 66, 'active', 'chuột-logitech-g102');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Router WiFi TP-Link', 'SP0005', 'router-wifi-tp-link.jpg', 11389895, 5, 'Sản phẩm Router WiFi TP-Link phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 75, 'active', 'router-wifi-tp-link');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('PC Gaming AMD', 'SP0006', 'pc-gaming-amd.jpg', 11893045, 10, 'Sản phẩm PC Gaming AMD phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 17, 'active', 'pc-gaming-amd');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Laptop Asus Zenbook', 'SP0007', 'laptop-asus-zenbook.jpg', 18833524, 10, 'Sản phẩm Laptop Asus Zenbook phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 38, 'active', 'laptop-asus-zenbook');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Màn hình Dell 27inch', 'SP0008', 'màn-hình-dell-27inch.jpg', 12032111, 10, 'Sản phẩm Màn hình Dell 27inch phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 99, 'active', 'màn-hình-dell-27inch');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Bàn phím cơ Razer', 'SP0009', 'bàn-phím-cơ-razer.jpg', 7159294, 10, 'Sản phẩm Bàn phím cơ Razer phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 35, 'active', 'bàn-phím-cơ-razer');
INSERT INTO products (name, code, images, price, discount, description, quantity, status, slug) VALUES ('Switch 8 cổng', 'SP0010', 'switch-8-cổng.jpg', 7780563, 5, 'Sản phẩm Switch 8 cổng phù hợp với nhu cầu sử dụng cá nhân hoặc doanh nghiệp.', 20, 'active', 'switch-8-cổng');


INSERT INTO products_categories (product_id, category_id) VALUES (1, 1);
INSERT INTO products_categories (product_id, category_id) VALUES (2, 2);
INSERT INTO products_categories (product_id, category_id) VALUES (3, 3);
INSERT INTO products_categories (product_id, category_id) VALUES (4, 4);
INSERT INTO products_categories (product_id, category_id) VALUES (5, 5);
INSERT INTO products_categories (product_id, category_id) VALUES (6, 1);
INSERT INTO products_categories (product_id, category_id) VALUES (7, 2);
INSERT INTO products_categories (product_id, category_id) VALUES (8, 3);
INSERT INTO products_categories (product_id, category_id) VALUES (9, 4);
INSERT INTO products_categories (product_id, category_id) VALUES (10, 5);



-- 1. Bảng questions
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,                        -- Người hỏi là user đã đăng ký
    title VARCHAR(255) NOT NULL,                 -- Tiêu đề câu hỏi
    content TEXT NOT NULL,                       -- Nội dung câu hỏi
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 2. Bảng answers
CREATE TABLE answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,                    -- Câu hỏi tương ứng
    user_id INT NOT NULL,                        -- Người trả lời là user đã đăng ký
    content TEXT NOT NULL,                       -- Nội dung câu trả lời
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 3. Bảng tags (danh sách tag duy nhất)
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL             -- Tên tag (VD: 'laptop', 'valorant')
);

-- 4. Bảng question_tags (gắn nhiều tag cho câu hỏi)
CREATE TABLE question_tags (
    question_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (question_id, tag_id),
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);



INSERT INTO tags (name) VALUES
    ('laptop'),
    ('chuot-gaming'),
    ('ban-phim-co'),
    ('tai-nghe'),
    ('man-hinh'),
    ('pc-build'),
    ('gear'),
    ('gaming-chair'),
    ('webcam'),
    ('microphone'),

    ('cau-hinh'),
    ('tu-van-mua'),
    ('loi-phan-cung'),
    ('loi-phan-mem'),
    ('choi-game'),
    ('fps'),
    ('stream'),
    ('driver'),
    ('hieu-nang'),
    ('update'),

    ('rgb'),
    ('wireless'),
    ('bluetooth'),
    ('hot-swappable'),
    ('cooling'),
    ('low-latency'),
    ('macro');

-- Bảng page_sections: Lưu thông tin về các phần trên trang
CREATE TABLE IF NOT EXISTS page_sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Bảng page_content: Lưu nội dung đơn lẻ (không lặp lại)
CREATE TABLE IF NOT EXISTS page_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,
    `key` VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    content_type ENUM('text', 'image') NOT NULL DEFAULT 'text',
    FOREIGN KEY (section_id) REFERENCES page_sections(id) ON DELETE CASCADE,
    UNIQUE (section_id, `key`)
);

-- Bảng product_categories: Lưu danh sách sản phẩm trong Our Product Categories
CREATE TABLE IF NOT EXISTS product_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (section_id) REFERENCES page_sections(id) ON DELETE CASCADE
);

-- Bảng stats: Lưu dữ liệu cho Stats Section
CREATE TABLE IF NOT EXISTS stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,
    number INT NOT NULL,
    label VARCHAR(100) NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (section_id) REFERENCES page_sections(id) ON DELETE CASCADE
);

-- Bảng journey_items: Lưu các mốc thời gian trong Our Journey
CREATE TABLE IF NOT EXISTS journey_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,
    year INT NOT NULL,
    description TEXT NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (section_id) REFERENCES page_sections(id) ON DELETE CASCADE
);

-- Bảng team_members: Lưu thông tin thành viên trong Our Team
CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    info TEXT NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (section_id) REFERENCES page_sections(id) ON DELETE CASCADE
);

-- Thêm dữ liệu vào các bảng
-- Thêm các phần vào page_sections
INSERT INTO page_sections (name, description) VALUES
('our_story', 'Câu chuyện của chúng tôi'),
('mission_values', 'Sứ mệnh & Giá trị'),
('product_categories', 'Our Product Categories'),
('stats', 'Stats Section'),
('journey', 'Our Journey'),
('team', 'Our Team');

-- Lấy ID của các phần để sử dụng
SET @our_story_id = (SELECT id FROM page_sections WHERE name = 'our_story');
SET @mission_values_id = (SELECT id FROM page_sections WHERE name = 'mission_values');
SET @product_categories_id = (SELECT id FROM page_sections WHERE name = 'product_categories');
SET @stats_id = (SELECT id FROM page_sections WHERE name = 'stats');
SET @journey_id = (SELECT id FROM page_sections WHERE name = 'journey');
SET @team_id = (SELECT id FROM page_sections WHERE name = 'team');

-- Thêm nội dung cho Câu chuyện của chúng tôi
INSERT INTO page_content (section_id, `key`, content, content_type) VALUES
(@our_story_id, 'paragraph_1', 'GearBK được thành lập vào năm 2025 với sứ mệnh đơn giản: cung cấp cho những người đam mê công nghệ các linh kiện và phụ kiện máy tính chất lượng cao với giá cả cạnh tranh. Bắt đầu từ một cửa hàng trực tuyến nhỏ, GearBK đã phát triển thành một thương hiệu đáng tin cậy trên thị trường công nghệ Việt Nam.', 'text'),
(@our_story_id, 'paragraph_2', 'Đội ngũ của chúng tôi bao gồm những người yêu công nghệ nhiệt thành, tận tụy mang đến những sản phẩm mới nhất và tuyệt vời nhất cho khách hàng. Chúng tôi tin vào sức mạnh của công nghệ trong việc thay đổi cuộc sống và doanh nghiệp, và chúng tôi cam kết trở thành một phần của sự thay đổi đó.', 'text'),
(@our_story_id, 'banner_image', '/ltw/public/images/Banner.jpg', 'image');

-- Thêm nội dung cho Sứ mệnh & Giá trị
INSERT INTO page_content (section_id, `key`, content, content_type) VALUES
(@mission_values_id, 'quality_title', 'Chất lượng là ưu tiên hàng đầu', 'text'),
(@mission_values_id, 'quality_item_1', 'Kiểm định chất lượng nghiêm ngặt cho từng sản phẩm', 'text'),
(@mission_values_id, 'quality_item_2', 'Tuân thủ tiêu chuẩn quốc tế và chứng nhận an toàn', 'text'),
(@mission_values_id, 'quality_item_3', 'Bảo hành 12 tháng và hỗ trợ kỹ thuật tận tâm', 'text'),
(@mission_values_id, 'satisfaction_title', 'Sự hài lòng của khách hàng', 'text'),
(@mission_values_id, 'satisfaction_item_1', 'Hỗ trợ tư vấn 24/7 qua nhiều kênh', 'text'),
(@mission_values_id, 'satisfaction_item_2', 'Chính sách đổi trả linh hoạt trong 30 ngày', 'text'),
(@mission_values_id, 'satisfaction_item_3', 'Khảo sát & cải tiến dựa trên phản hồi khách hàng', 'text'),
(@mission_values_id, 'innovation_title', 'Đổi mới sáng tạo', 'text'),
(@mission_values_id, 'innovation_item_1', 'Nghiên cứu & phát triển sản phẩm mới liên tục', 'text'),
(@mission_values_id, 'innovation_item_2', 'Hợp tác cùng startup công nghệ hàng đầu', 'text'),
(@mission_values_id, 'innovation_item_3', 'Cập nhật xu hướng công nghệ mới nhất', 'text');

-- Thêm dữ liệu cho Our Product Categories
INSERT INTO product_categories (section_id, image_url, title, description, display_order) VALUES
(@product_categories_id, '/ltw/public/images/RTX.jpg', 'Graphics Cards', 'Latest NVIDIA and AMD GPU options', 1),
(@product_categories_id, '/ltw/public/images/RAM.jpg', 'Memory', 'High-performance RAM for gaming and productivity', 2),
(@product_categories_id, '/ltw/public/images/SSD.jpg', 'Storage', 'Fast SSDs and reliable HDDs', 3),
(@product_categories_id, '/ltw/public/images/AMD.jpg', 'Processors', 'Intel and AMD CPUs for every need', 4),
(@product_categories_id, '/ltw/public/images/demo-product.webp', 'Peripherals', 'Keyboards, mice, and other accessories', 5);

-- Thêm dữ liệu cho Stats Section
INSERT INTO stats (section_id, number, label, display_order) VALUES
(@stats_id, 5000, 'Khách hàng hài lòng', 1),
(@stats_id, 1200, 'Sản phẩm', 2),
(@stats_id, 8, 'Năm kinh nghiệm', 3),
(@stats_id, 15, 'Giải thưởng', 4);

-- Thêm dữ liệu cho Our Journey
INSERT INTO journey_items (section_id, year, description, display_order) VALUES
(@journey_id, 2021, 'GearBK was founded as a small online store selling computer parts to local enthusiasts.', 1),
(@journey_id, 2022, 'Opened our first physical store in Ho Chi Minh City, expanding our reach to local customers.', 2),
(@journey_id, 2023, 'Became an official partner with major brands like ASUS, MSI, and NVIDIA, offering premium products.', 3),
(@journey_id, 2024, 'Expanded our operations nationwide with three new stores and an enhanced online platform.', 4),
(@journey_id, 2025, 'Launched our custom PC building service and expanded into gaming peripherals and accessories.', 5);

-- Thêm dữ liệu cho Our Team
INSERT INTO team_members (section_id, image_url, name, role, info, display_order) VALUES
(@team_id, 'https://randomuser.me/api/portraits/men/32.jpg', 'Vo Nguyen Duc Phat', 'Founder & CEO', '10+ years in tech, passionate about innovation.', 1),
(@team_id, 'https://randomuser.me/api/portraits/women/44.jpg', 'Nguyen Trung Phu', 'Marketing Director', 'Expert in digital marketing, drives brand growth.', 2),
(@team_id, 'https://randomuser.me/api/portraits/men/22.jpg', 'Nguyen Dang Cuong', 'Technical Director', 'Leads tech innovation with 8+ years of experience.', 3),
(@team_id, 'https://randomuser.me/api/portraits/men/22.jpg', 'Hồ Tấn Phát', 'Technical Director', 'Focuses on user-centric product development.', 4);