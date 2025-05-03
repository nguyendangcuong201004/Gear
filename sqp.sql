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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_role VARCHAR(10) DEFAULT 'user'
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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

INSERT INTO orders (id, code, full_name, phone, note, status, deleted, deleted_at, created_at, updated_at) VALUES 
(1, 'ORD00001', 'Nguyễn Văn An', '0912345678', 'Giao hàng trong ngày', 'pending', FALSE, NULL, '2025-04-01 10:00:00', '2025-04-01 10:00:00'),
(2, 'ORD00002', 'Trần Thị Bình', '0987654321', '', 'confirmed', FALSE, NULL, '2025-04-02 14:30:00', '2025-04-02 15:00:00'),
(3, 'ORD00003', 'Lê Minh Châu', '0935123456', 'Gói cẩn thận', 'shipped', FALSE, NULL, '2025-04-03 09:15:00', '2025-04-03 10:00:00'),
(4, 'ORD00004', 'Phạm Quốc Duy', '0909123456', 'Giao vào buổi sáng', 'delivered', FALSE, NULL, '2025-04-04 11:00:00', '2025-04-05 08:00:00'),
(5, 'ORD00005', 'Hoàng Thị E', '0941234567', '', 'cancelled', FALSE, NULL, '2025-04-05 16:00:00', '2025-04-05 16:30:00'),
(6, 'ORD00006', 'Đặng Văn Phúc', '0978123456', 'Giao hàng nhanh', 'pending', FALSE, NULL, '2025-04-06 13:20:00', '2025-04-06 13:20:00'),
(7, 'ORD00007', 'Ngô Thị Giang', '0923456789', '', 'confirmed', FALSE, NULL, '2025-04-07 08:45:00', '2025-04-07 09:00:00'),
(8, 'ORD00008', 'Vũ Minh Hiếu', '0967891234', 'Gọi trước khi giao', 'shipped', FALSE, NULL, '2025-04-08 12:00:00', '2025-04-08 12:30:00'),
(9, 'ORD00009', 'Bùi Thị Kim', '0918765432', '', 'delivered', FALSE, NULL, '2025-04-09 15:00:00', '2025-04-10 09:00:00'),
(10, 'ORD00010', 'Lý Văn Long', '0936789123', 'Giao vào cuối tuần', 'pending', FALSE, NULL, '2025-04-10 17:00:00', '2025-04-10 17:00:00');


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


-- orders_products
INSERT INTO orders_products (order_id, product_id, quantity, price, discount) VALUES 
-- Order 1
(1, 1, 1, 9361678, 5),    -- PC Gaming X305
(1, 4, 2, 11188129, 10),  -- Chuột Logitech G102
-- Order 2
(2, 2, 1, 17389795, 0),   -- Laptop HP G3
-- Order 3
(3, 3, 1, 8348463, 10),   -- Màn Hình LG 24inch
(3, 5, 1, 11389895, 5),   -- Router WiFi TP-Link
(3, 9, 1, 7159294, 10),   -- Bàn phím cơ Razer
-- Order 4
(4, 6, 1, 11893045, 10),  -- PC Gaming AMD
-- Order 5
(5, 7, 1, 18833524, 10),  -- Laptop Asus Zenbook
(5, 8, 1, 12032111, 10),  -- Màn hình Dell 27inch
-- Order 6
(6, 1, 2, 9361678, 5),    -- PC Gaming X305
-- Order 7
(7, 2, 1, 17389795, 0),   -- Laptop HP G3
(7, 4, 1, 11188129, 10),  -- Chuột Logitech G102
-- Order 8
(8, 3, 1, 8348463, 10),   -- Màn Hình LG 24inch
(8, 10, 1, 7780563, 5),   -- Switch 8 cổng
-- Order 9
(9, 6, 1, 11893045, 10),  -- PC Gaming AMD
(9, 9, 1, 7159294, 10),   -- Bàn phím cơ Razer
-- Order 10
(10, 5, 1, 11389895, 5),  -- Router WiFi TP-Link
(10, 8, 1, 12032111, 10); -- Màn hình Dell 27inch

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



INSERT INTO categories (title, image, description, status, slug) VALUES ('Linh Kiện Máy Tính', 'components.jpg', 'CPU, GPU, Ổ cứng, RAM, Mainboard...', 'active', 'linh-kien-may-tinh');

-- Laptops
INSERT INTO products (name, code, images, price, discount, description, specs, quantity, status, slug, created_at) VALUES
('Laptop Acer Swift 3 SF314 511 55QE', 'SP0011', 'SP0011.jpg', 12990000, 20, 'Acer Swift 3 Evo SF314 511 55QE là laptop mỏng nhẹ với bộ vi xử lý Intel Core i5-1135G7, RAM 16GB LPDDR4X và ổ SSD 512GB PCIe NVMe (nâng cấp lên 1TB). Máy có màn hình 14" Full HD IPS với độ phủ màu sRGB 100%, đồ họa Intel Iris Xe và kết nối Wi-Fi 6. Thiết bị bao gồm cổng Thunderbolt 4, USB-C, nhiều cổng USB-A, HDMI và bảo mật vân tay. Nặng chỉ 1.2kg với màu Bạc Thuần khiết, chạy Windows 11 Home và âm thanh chất lượng cao nhờ công nghệ DTS và Acer PurifiedVoice.', NULL, 10, 'active', 'acer-swift-3', '2025-04-01 10:00:00'),
('Laptop MSI Modern 14 H D13MG 217VN', 'SP0012', 'SP0012.jpg', 17490000, 30, 'Laptop trang bị bộ vi xử lý Intel® Core™ i7-13700H mạnh mẽ, RAM 16GB DDR4 và ổ SSD NVMe PCIe Gen4 1TB nhanh cho đa nhiệm và lưu trữ. Máy có đồ họa Intel® Iris Xe và màn hình 14" FHD+ IPS (1920x1200) tỷ lệ 16:10. Kết nối bao gồm Thunderbolt 4, USB-A 3.2, HDMI 2.1, LAN và Wi-Fi 6E. Các điểm nổi bật khác là bàn phím có đèn nền, webcam HD, Windows 11 Home và thiết kế nhẹ 1.6kg màu đen sang trọng.', NULL, 10, 'active', 'msi-modern-14', '2025-04-02 11:30:00'),
('Laptop gaming MSI Thin 15 B13UC 2044VN', 'SP0013', 'SP0013.jpg', 19490000, 10, 'Laptop trang bị bộ vi xử lý Intel Core i7-13620H (10 nhân, 16 luồng), RAM 16GB DDR4 (nâng cấp lên 64GB) và ổ SSD Gen4 NVMe 512GB nhanh. Được trang bị GPU NVIDIA GeForce RTX 3050 Laptop, lý tưởng cho game và công việc sáng tạo. Màn hình 15.6" FHD IPS-level cung cấp tốc độ làm mới 144Hz cho hình ảnh mượt mà. Bao gồm Wi-Fi 6E, Bluetooth 5.3, nhiều cổng USB, HDMI và bàn phím có đèn nền. Nặng 1.86kg với màu Cosmos Gray, chạy Windows 11 Home và cung cấp hiệu suất ổn định cho cả công việc và giải trí.', NULL, 10, 'active', 'msi-thin-15', '2025-04-03 14:45:00'),
('Laptop gaming Gigabyte G6 KF H3VN853SH', 'SP0014', 'SP0014.jpg', 27490000, 40, 'Laptop hiệu suất cao được trang bị bộ vi xử lý Intel Core i7-13620H với 10 nhân (6P + 4E), cùng RAM 16GB DDR5 (nâng cấp lên 64GB) và ổ SSD PCIe Gen4 512GB, với một khe M.2 bổ sung. Nó có GPU NVIDIA GeForce RTX 4060 Laptop với 8GB GDDR6, lý tưởng cho game và công việc sáng tạo. Màn hình 16" FHD+ IPS-level cung cấp tốc độ làm mới 165Hz mượt mà. Kết nối bao gồm USB-A, USB-C, HDMI, Mini DisplayPort, LAN và đầu đọc thẻ microSD. Nó cũng bao gồm Wi-Fi 6E, Bluetooth 5.2, âm thanh DTS:X Ultra, bàn phím full-size với đèn nền LED 15 màu và chạy Windows 11 Home. Nặng khoảng 2.3kg với màu đen bóng, đây là một máy mạnh mẽ nhưng linh hoạt.', NULL, 10, 'active', 'gigabyte-g6', '2025-04-04 09:15:00'),
('Laptop gaming Gigabyte G5 GD 51VN123SO', 'SP0015', 'SP0015.jpg', 15990000, 0, 'Laptop này được trang bị bộ vi xử lý Intel Core i5-11400H (6 nhân, 12 luồng, lên đến 4.5GHz), RAM 16GB DDR4 (nâng cấp lên 64GB) và ổ SSD PCIe Gen4 512GB, với khe M.2 và 2.5" SATA bổ sung. Nó có đồ họa NVIDIA GeForce RTX 3050 4GB và màn hình 15.6" FHD IPS-level với tốc độ làm mới 144Hz và độ phủ màu 90% sRGB. Thiết bị hỗ trợ nhiều cổng bao gồm USB-A, USB-C, HDMI 2.0, mini DisplayPort và đầu đọc thẻ SD. Nó có bàn phím full-size có đèn nền với đèn LED 15 màu tùy chỉnh, Wi-Fi 6, Bluetooth 5.2, âm thanh Nahimic 3 và chạy Windows 11 Home. Nặng 2.2kg với thiết kế đen bóng, đây là lựa chọn linh hoạt cho game và năng suất.', NULL, 10, 'active', 'gigabyte-g5', '2025-04-05 16:00:00');

-- Desktop PCs
INSERT INTO products (name, code, images, price, discount, description, specs, quantity, status, slug, created_at) VALUES
('PC GVN Intel i9-14900K/ VGA RTX 4060 Ti', 'SP0016', 'SP0016.jpg', 52990000, 30, 'PC tùy biến cao cấp này có bộ vi xử lý Intel Core i9-14900K (24 nhân, 32 luồng, lên đến 6.0GHz) kết hợp với bo mạch chủ ASUS TUF GAMING Z790-PLUS WIFI DDR5. Bao gồm RAM Corsair Vengeance RGB DDR5 32GB (5600MHz) và card đồ họa MSI GeForce RTX 4060 Ti VENTUS 3X 8GB OC cho hiệu suất mạnh mẽ trong game và sáng tạo nội dung. Lưu trữ bao gồm SSD WD Black SN770 500GB NVMe Gen4, với tùy chọn nâng cấp HDD. Hệ thống được cấp nguồn bởi nguồn Cooler Master MWE GOLD 850W V2 (80 Plus Gold, Full Modular, ATX 3.1). Nó được đặt trong vỏ Corsair 6500X TG Mid-Tower Black và làm mát bằng tản nhiệt nước Corsair iCUE LINK TITAN 360 RX RGB, hỗ trợ bởi gói ba quạt Corsair iCUE LINK QX120 RGB với hub. Một thiết lập cao cấp, sẵn sàng cho tương lai với hiệu suất mạnh mẽ và thẩm mỹ RGB ấn tượng.', NULL, 10, 'active', 'pc-i9-rtx4060ti', '2025-04-06 10:00:00'),
('PC GVN Intel i7-14700F/ VGA RTX 3060', 'SP0017', 'SP0017.jpg', 31890000, 34, 'PC mạnh mẽ này được trang bị bộ vi xử lý Intel Core i7-14700F (20 nhân, 28 luồng, lên đến 5.4GHz) trên bo mạch chủ ASUS TUF GAMING Z790-PLUS WIFI DDR5. Nó có RAM Kingston Fury Beast RGB DDR5 16GB (5600MHz) và card đồ họa MSI GeForce RTX 3060 Ventus 2X OC 12GB cho game và đa nhiệm mượt mà. Về lưu trữ, nó bao gồm SSD WD Black SN770 500GB NVMe PCIe Gen4, với tùy chọn nâng cấp HDD. Hệ thống được cấp nguồn bởi nguồn Corsair CX750 80 Plus Bronze 750W và đặt trong vỏ Deepcool CH560 DIGITAL Black 4F bóng bẩy. Làm mát được xử lý bởi tản nhiệt nước Cooler Master MASTERLIQUID ML240 ILLUSION AIO, đảm bảo hiệu suất ổn định ngay cả khi tải nặng.', NULL, 10, 'active', 'pc-i7-rtx3060', '2025-04-07 11:00:00'),
('PC GVN Homework R5 5600G', 'SP0018', 'SP0018.jpg', 7790000, 25, 'GVN Homework R5 là một PC đáng tin cậy và giá cả phải chăng được cung cấp năng lượng bởi bộ vi xử lý AMD Ryzen 5 5600GT (6 nhân, 12 luồng, lên đến 4.6GHz), kết hợp với bo mạch chủ ASUS PRIME B450M-A II. Nó đi kèm với RAM G.Skill Ripjaws V DDR4 8GB (3600MHz) và SSD PNY CS900 250GB SATA3 cho lưu trữ cơ bản. Hệ thống sử dụng nguồn Jetek J400 và được đặt trong vỏ Jetek X919. Tùy chọn GPU và HDD có thể tùy chỉnh dựa trên nhu cầu của người dùng, làm cho nó trở thành lựa chọn linh hoạt và có thể nâng cấp cho sử dụng tại nhà hoặc văn phòng.', NULL, 10, 'active', 'pc-r5-5600g', '2025-04-08 12:00:00'),
('PC GVN AMD R7-7700X/ RTX 4060', 'SP0019', 'SP0019.jpg', 30990000, 19, 'GVN AMD R7-7700X / RTX 4060 là một PC mạnh mẽ tầm trung đến cao cấp, được xây dựng với bộ vi xử lý AMD Ryzen 7 7700X (8 nhân, 16 luồng, lên đến 5.4GHz) trên bo mạch chủ ASUS TUF GAMING B650M-E WIFI với hỗ trợ DDR5. Nó bao gồm RAM Corsair Vengeance RGB DDR5 32GB (5600MHz) và card đồ họa GIGABYTE GeForce RTX 4060 WINDFORCE OC 8GB cho hiệu suất game và sáng tạo xuất sắc. Lưu trữ được xử lý bởi SSD WD Black SN770 500GB NVMe Gen4, với tùy chọn nâng cấp HDD. Hệ thống được cấp nguồn bởi Cooler Master MWE 750W Bronze V3 và đặt trong vỏ Cooler Master CD600 Black bóng bẩy. Làm mát được đảm bảo bởi tản nhiệt nước Cooler Master MASTERLIQUID ML240 ILLUSION và bộ ba quạt Xigmatek STARLINK ARGB cho luồng không khí và phong cách.', NULL, 10, 'active', 'pc-r7-rtx4060', '2025-04-09 13:00:00'),
('PC GVN AMD R9-9950X/ VGA RTX 4090', 'SP0020', 'SP0020.jpg', 138000000, 52, 'PC hiệu suất cao cấp có bộ vi xử lý AMD Ryzen 9 9950X (16 nhân, 32 luồng, lên đến 5.7GHz) kết hợp với bo mạch chủ ASUS ROG STRIX X870E-E GAMING WIFI, hỗ trợ RAM TeamGroup T-Force XTreem ARGB DDR5 48GB siêu nhanh (8000MHz). Nó được cung cấp năng lượng bởi ASUS TUF Gaming GeForce RTX 4090 24GB OC Edition, cung cấp đồ họa hàng đầu cho game 4K, render 3D và công việc AI. Lưu trữ bao gồm SSD Samsung 990 PRO 2TB NVMe Gen4, với tùy chọn nâng cấp HDD. Hệ thống được đặt trong vỏ ASUS ROG Hyperion GR701 tuyệt đẹp, làm mát bởi tản nhiệt nước ASUS ROG Ryujin III 360 ARGB Extreme. Nguồn ASUS ROG Thor Platinum 1200W đảm bảo cung cấp điện đáng tin cậy và hiệu quả. Đây là một thiết lập đầy đủ, mạnh mẽ được xây dựng cho những người đam mê và chuyên gia đòi hỏi tuyệt đối tốt nhất.', NULL, 10, 'active', 'pc-r9-rtx4090', '2025-04-10 14:00:00');

-- Peripherals
INSERT INTO products (name, code, images, price, discount, description, specs, quantity, status, slug, created_at) VALUES
('Chuột không dây SteelSeries Aerox 3 Wireless Snow Edition', 'SP0021', 'SP0021.jpg', 2490000, 21, 'Nhẹ — hoặc siêu mỏng — là xu hướng thiết kế mới cho chuột máy tính, và SteelSeries đã áp dụng nó trong dòng Aerox 3 không dây của họ. Hãy cùng nhìn kỹ hơn vào SteelSeries Aerox 3 Wireless Snow Edition, phiên bản màu trắng tinh khiết và bóng bẩy của chiếc chuột nhẹ hiện đại này.', NULL, 10, 'active', 'chuot-aerox-3', '2025-04-11 10:00:00'),
('Chuột Razer Basilisk V3 35K', 'SP0022', 'SP0022.jpg', 2190000, 12, 'Bước vào trò chơi và thể hiện kỹ năng của bạn với sự tùy chỉnh và độ chính xác vô song của Razer Basilisk V3 35K — chuột RGB có dây tiên tiến nhất của chúng tôi. Với cảm biến thế hệ mới và bánh cuộn được thiết kế để tùy chỉnh sâu hơn, bạn sẽ có tất cả các công cụ cần thiết để thiết lập màn chơi hoàn hảo mọi lúc.', NULL, 10, 'active', 'chuot-razer-basilisk', '2025-04-12 11:00:00'),
('Bàn phím cơ E-Dra EK375v2 Beta Linear Switch', 'SP0023', 'SP0023.jpg', 550000, 32, 'E-Dra EK375v2 Beta Linear Switch là bàn phím cơ 82 phím nhỏ gọn được thiết kế cho hiệu suất và phong cách. Với cấu trúc Gasket-mounted với đệm silicone trong vỏ để cải thiện âm thanh và cảm giác, nó được trang bị E-DRA Custom Linear Switches cho các lần nhấn phím mượt mà, yên tĩnh. Bàn phím sử dụng giao diện USB Type-C và bao gồm keycap PBT Doubleshot, đèn LED Rainbow và hỗ trợ anti-ghosting đầy đủ. Với vỏ màu đen và keycap xanh-đen, nó hoàn toàn tương thích với Windows OS và được bảo hành 24 tháng.', NULL, 10, 'active', 'ban-phim-edra-beta', '2025-04-13 12:00:00'),
('Bàn phím AKKO MOD007B-HE PC Santorini Sakura Pink Magnetic Switch', 'SP0024', 'SP0024.jpg', 2390000, 0, 'AKKO MOD007B-HE PC Santorini Sakura Pink là sản phẩm mới nhất trong dòng MOD007B phổ biến của AKKO, nổi tiếng với bố cục 75% nhỏ gọn, hiệu suất ổn định và khả năng tùy chỉnh cao. Phiên bản này có các switch từ tính tốc độ cao cho thời gian phản hồi siêu nhanh và độ bền ngoại hạng. Với thiết kế lấy cảm hứng từ Santorini màu hồng và chủ đề hoa anh đào, bàn phím này không chỉ mang lại hiệu suất game hàng đầu mà còn tạo ra một tuyên bố thị giác táo bạo — hoàn hảo cho các game thủ đánh giá cao cả chức năng và phong cách.', NULL, 10, 'active', 'ban-phim-akko-santorini', '2025-04-14 13:00:00'),
('Bàn phím cơ có dây AULA F2058 (Đen, Switch Đỏ)', 'SP0025', 'SP0025.jpg', 690000, 54, 'AULA F2058 là bàn phím cơ có dây full-size 104 phím được xây dựng cho hiệu suất mượt mà và đáp ứng. Với các switch Red tuyến tính bền bỉ được đánh giá cho 60 triệu lần nhấn phím, nó mang lại trải nghiệm gõ yên tĩnh, thỏa mãn. Bàn phím có đèn nền LED Rainbow 7 màu với hiệu ứng ánh sáng động đồng bộ với âm thanh. Được thiết kế với keycap ABS, cáp USB 2.0 1.2m và trọng lượng 700g, nó vừa chắc chắn vừa thực tế. Tương thích với Windows và Mac, nó cũng bao gồm kê tay, dụng cụ tháo keycap và hướng dẫn sử dụng. Hoàn hảo cho cả thiết lập làm việc và chơi game.', NULL, 10, 'active', 'ban-phim-aula-f2058', '2025-04-15 14:00:00');

-- Components
INSERT INTO products (name, code, images, price, discount, description, specs, quantity, status, slug, created_at) VALUES
('Bo mạch chủ GIGABYTE X870E AORUS PRO ICE (DDR5)', 'SP0026', 'SP0026.jpg', 12290000, 23, 'Được thiết kế cho người đam mê và người dùng năng suất cao, GIGABYTE X870E AORUS PRO ICE là bo mạch chủ AM5 cao cấp có hỗ trợ tiên tiến cho bộ vi xử lý AMD Ryzen™ 9000, 8000 và 7000 Series. Với hỗ trợ bộ nhớ DDR5 siêu nhanh lên đến 8200MT/s (OC), USB4 tích hợp, PCIe 5.0 và Wi-Fi 7, bo mạch này mang lại hiệu suất sẵn sàng cho tương lai trong thiết kế màu trắng ICE thanh lịch.', NULL, 10, 'active', 'bo-mach-chu-x870e', '2025-04-16 10:00:00'),
('Bộ xử lý AMD Ryzen 5 8400F (Tray)', 'SP0027', 'SP0027.jpg', 4290000, 12, 'AMD Ryzen™ 5 8400F là bộ vi xử lý máy tính để bàn 6 nhân, 12 luồng được xây dựng trên quy trình TSMC FinFET 4nm tiên tiến, cung cấp hiệu suất nổi bật cho game, năng suất và điện toán chính thống. Tương thích với nền tảng AM5 và bộ nhớ DDR5, nó mang lại tốc độ nhanh, hỗ trợ PCIe® 4.0 và TDP hiệu quả 65W—tất cả không có đồ họa tích hợp, hoàn hảo cho hệ thống sử dụng GPU chuyên dụng.', NULL, 10, 'active', 'amd-ryzen-5-8400f', '2025-04-17 11:00:00'),
('Card đồ họa GIGABYTE AORUS GeForce RTX 4080 SUPER XTREME ICE 16G', 'SP0028', 'SP0028.jpg', 49990000, 31, 'GIGABYTE AORUS GeForce RTX 4080 SUPER XTREME ICE 16G là card đồ họa hiệu suất cao được thiết kế cho những người đam mê và game thủ chuyên nghiệp. Với nhân được ép xung từ nhà máy, thẩm mỹ tuyệt đẹp và làm mát mạnh mẽ, card này được xây dựng để thống trị ở độ phân giải 4K và hơn thế nữa.', NULL, 10, 'active', 'rtx-4080-super-16g', '2025-04-18 12:00:00'),
('RAM PNY XLR8 1x8GB 3200MHz DDR4 LONGDIMM (MD8GD4320016XR)', 'SP0029', 'SP0029.jpg', 650000, 54, 'PNY XLR8 Gaming DDR4 8GB 3200MHz được xây dựng cho game thủ, người dùng năng suất cao và những người đam mê hiệu suất muốn tăng tốc độ và phản hồi của PC để bàn. Được thiết kế với các thành phần chất lượng cao và được kiểm tra khả năng tương thích trên nhiều bo mạch chủ, module RAM này mang lại hiệu suất ổn định và hiệu quả.', NULL, 10, 'active', 'ram-pny-8gb-3200', '2025-04-19 13:00:00'),
('Ổ SSD SSTC Megamouth 256GB', 'SP0030', 'SP0030.jpg', 590000, 37, 'Ổ SSD SSTC Megamouth 256GB là một nâng cấp lưu trữ tuyệt vời cho máy tính để bàn và laptop, cung cấp thời gian khởi động nhanh hơn, truyền tệp nhanh hơn và cải thiện tổng thể độ phản hồi của hệ thống. Được xây dựng với hệ số 2.5-inch và giao diện SATA III 6Gb/s, đây là giải pháp cắm và chạy lý tưởng cho nhu cầu điện toán hàng ngày.', NULL, 10, 'active', 'ssd-sstc-256gb', '2025-04-20 14:00:00');

-- Components
INSERT INTO products (name, code, images, price, discount, description, specs, quantity, status, slug, created_at) VALUES
('Tai nghe Gaming Không dây HP HyperX Cloud JET Đen', 'SP0031', 'SP0031.jpg', 1990000, 0, 'Tai nghe HP HyperX Cloud JET Đen là một tai nghe gaming không dây phổ biến, được thiết kế để mang đến âm thanh sống động, chất lượng xây dựng bền bỉ và kết nối đáng tin cậy. Cho dù bạn đang chơi game, nghe nhạc hoặc giao tiếp với đồng đội, tai nghe này đảm bảo trải nghiệm âm thanh cao cấp với công nghệ tiên tiến và vật liệu chất lượng cao.', NULL, 10, 'active', 'tai-nghe-hp-hyperx', '2025-04-21 10:00:00'),
('Tai nghe Over-Ear Không dây EDIFIER W800BT Pro với Chống ồn chủ động', 'SP0032', 'SP0032.jpg', 1190000, 0, 'EDIFIER W800BT Pro là tai nghe over-ear không dây cao cấp được thiết kế để mang đến âm thanh sống động, khả năng khử tiếng ồn thông minh và sự thoải mái cả ngày. Được trang bị công nghệ tiên tiến, tai nghe này lý tưởng cho những người yêu âm nhạc, người thường xuyên di chuyển và các chuyên gia.', NULL, 10, 'active', 'tai-nghe-edifier-w800bt', '2025-04-22 11:00:00'),
('Tai nghe In-Ear Gaming ASUS ROG CETRA II CORE với Jack 3.5mm', 'SP0033', 'SP0033.jpg', 890000, 0, 'Trải nghiệm âm thanh sống động và sự thoải mái vượt trội với ASUS ROG CETRA II CORE – tai nghe gaming in-ear cao cấp được thiết kế cho game thủ đa nền tảng. Với driver 9.4mm tinh chỉnh chính xác, jack cắm 3.5mm đa năng, và thiết kế nhẹ, công thái học, nó hoàn hảo cho các phiên chơi game dài dù bạn đang sử dụng PC, console hay di động.', NULL, 10, 'active', 'tai-nghe-asus-rog-cetra-ii', '2025-04-23 12:00:00'),
('Tai nghe True Wireless ASUS ROG CETRA với Chống ồn chủ động & Hộp sạc không dây', 'SP0034', 'SP0034.jpg', 1750000, 0, 'Nâng cao trải nghiệm chơi game di động của bạn với tai nghe ASUS ROG CETRA TRUE Wireless — được thiết kế cho game thủ nghiêm túc đòi hỏi tự do không dây, âm thanh sống động và kiểm soát tiếng ồn tiên tiến. Với khả năng khử tiếng ồn chủ động (ANC), chống nước IPX4 và thời lượng pin lên đến 27 giờ, những tai nghe in-ear này mang lại hiệu suất và tiện lợi trong thiết kế mỏng nhẹ.', NULL, 10, 'active', 'tai-nghe-asus-rog-cetra-true', '2025-04-24 13:00:00'),
('Tai nghe Gaming RGB Không dây Logitech G733 LIGHTSPEED – Đen', 'SP0035', 'SP0035.jpg', 2250000, 0, 'Logitech G733 là tai nghe gaming over-ear không dây cao cấp kết hợp hiệu suất âm thanh tiên tiến với thiết kế thời trang và thoải mái. Với công nghệ không dây LIGHTSPEED, mic có thể tháo rời và đèn RGB tùy chỉnh, tai nghe này được thiết kế cho game thủ nghiêm túc đánh giá cao cả chức năng và phong cách.', NULL, 10, 'active', 'tai-nghe-logitech-g733', '2025-04-25 14:00:00');

-- Màn hình
INSERT INTO products (name, code, images, price, discount, description, specs, quantity, status, slug, created_at) VALUES
('Màn hình Gaming ASUS ROG Swift PG27UCDM 27" 4K UHD QD-OLED – 240Hz, 0.03ms', 'SP0036', 'SP0036.jpg', 34990000, 0, 'ASUS ROG Swift PG27UCDM là màn hình gaming QD-OLED 4K UHD 27 inch tiên tiến, mang đến hình ảnh tuyệt đẹp và hiệu suất cực nhanh cho trải nghiệm chơi game cạnh tranh và sống động. Với tốc độ làm mới 240Hz, thời gian phản hồi 0.03ms và tương thích với NVIDIA G-SYNC, nó được thiết kế cho gameplay mượt mà và phản ứng nhanh.', NULL, 10, 'active', 'man-hinh-asus-rog-swift', '2025-04-26 10:00:00'),
('Màn hình Cong LG 34WR55QK-B 34" UltraWide QHD – 100Hz, USB-C', 'SP0037', 'SP0037.jpg', 10990000, 0, 'LG 34WR55QK-B là màn hình cong UltraWide 34 inch được thiết kế cho công việc và giải trí sống động. Với độ phân giải QHD tỷ lệ 21:9, tốc độ làm mới 100Hz và kết nối USB-C, nó mang đến sự kết hợp hoàn hảo giữa hiệu suất, đa năng và thiết kế thanh lịch.', NULL, 10, 'active', 'man-hinh-lg-ultrawide', '2025-04-27 11:00:00'),
('Màn hình Samsung LS27F320GAEXXV 27" IPS FHD – Tần số quét 120Hz', 'SP0038', 'SP0038.jpg', 2990000, 0, 'Samsung LS27F320GAEXXV là màn hình IPS Full HD 27 inch được xây dựng cho hiệu suất mượt mà và góc nhìn rộng. Dù là để làm việc, giải trí hay chơi game thông thường, màn hình này mang lại chất lượng đáng tin cậy với thiết kế tối giản.', NULL, 10, 'active', 'man-hinh-samsung-fhd', '2025-04-28 12:00:00'),        
('Màn hình Gaming GIGABYTE G25F2 25" IPS – Tần số quét 200Hz', 'SP0039', 'SP0039.jpg', 3290000, 0, 'Được xây dựng cho game thủ cạnh tranh, GIGABYTE G25F2 mang lại hình ảnh cực kỳ mượt mà và độ chính xác màu sắc sống động với tốc độ làm mới 200Hz và tấm nền IPS sắc nét. Hoàn hảo cho trò chơi nhịp độ nhanh và giải trí sống động.', NULL, 10, 'active', 'man-hinh-gigabyte-gaming', '2025-04-29 13:00:00'),
('Màn hình Gaming MSI MPG 322URX QD-OLED 32" – 4K 240Hz, Quantum Dot OLED', 'SP0040', 'SP0040.jpg', 31490000, 0, 'Được thiết kế cho game thủ ưu tú, MSI MPG 322URX trang bị công nghệ tấm nền QD-OLED tiên tiến cho độ rực rỡ màu sắc vô song và hiệu suất siêu nhanh. Với độ phân giải 4K, tốc độ làm mới 240Hz và thời gian phản hồi 0.03ms, màn hình này đảm bảo mỗi khung hình đều sắc nét và vô cùng sống động.', NULL, 10, 'active', 'man-hinh-msi-qd-oled', '2025-04-30 14:00:00');

-- Thiết Bị Mạng
INSERT INTO products (name, code, images, price, discount, description, specs, quantity, status, slug, created_at) VALUES
('Bộ phát Wifi ASUS RT-AC59U V2 Trắng (Gaming Di động)', 'SP0041', 'SP0041.jpg', 890000, 0, 'Router WiFi băng tần kép AC1500 với MU-MIMO, AiMesh cho hệ thống wifi mở rộng, tính năng Kiểm soát của cha mẹ để truyền phát video 4K mượt mà từ Youtube và Netflix.', NULL, 10, 'active', 'wifi-asus-rt-ac59u', '2025-05-01 10:00:00'),
('Bộ phát Wifi Mesh TP-Link AC1200 Deco E4 (2 Thiết bị)', 'SP0042', 'SP0042.jpg', 1399000, 0, 'Deco E4 là cách đơn giản nhất để đảm bảo tín hiệu Wi-Fi mạnh ở mọi góc trong nhà của bạn lên tới hơn 260 mét vuông. Các kết nối Wi-Fi và đường truyền Ethernet tùy chọn hoạt động cùng nhau để liên kết các thiết bị Deco, cung cấp tốc độ mạng nhanh hơn và vùng phủ sóng thực sự liền mạch. Muốn mở rộng vùng phủ sóng? Đơn giản chỉ cần thêm một Deco khác.', NULL, 10, 'active', 'wifi-mesh-tp-link', '2025-05-02 11:00:00'),
('Cáp mạng ORICO 5 mét CAT6 (dây dẹp)', 'SP0043', 'SP0043.jpg', 70000, 0, 'Cáp Orico là sản phẩm tương thích cho việc kết nối mạng đến mọi nhà phổ biến nhất. Mức giá của loại cáp này khá rẻ mà chất lượng vẫn rất tốt. CAT6 là loại dây được sản xuất trên dây truyền công nghệ tiên tiến giúp đạt tốc độ lên tới 1000 Mbs/s đường truyền kết nối tuyệt vời với 8 lõi đồng chất là ưu điểm của CAT6 so với CAT5 hay các dòng cat thấp hơn. Dây cáp được thiết kế cực kì mỏng nhẹ nhưng rất chắc chắn. Trên dây dẫn có in các thông tin cần thiết cho khách hàng sử dụng.', NULL, 10, 'active', 'cap-mang-orico', '2025-05-03 12:00:00'),      
('USB Wifi Asus AC53 Nano', 'SP0044', 'SP0044.jpg', 350000, 0, 'Với nhu cầu sử dụng wifi hiện tại, để tăng cường khả năng bắt sóng wifi cũng như đảm bảo kết nối xuyên suốt không gián đoạn. Bạn có thể sử dụng USB thu sóng wifi này. Dễ dàng cài đặt và sử dụng một cách đơn giản, tương thích nhiều hệ điều hành là một điểm cộng của sản phẩm.', NULL, 10, 'active', 'usb-wifi-asus', '2025-05-04 13:00:00'),
('USB Thu Sóng TP-Link TX20U Plus', 'SP0045', 'SP0045.jpg', 899000, 0, 'TP-Link TX20U Plus thiết bị thu sóng Wifi được tích hợp nhiều cải tiến mạnh mẽ mang đến tốc độ Wifi siêu nhanh, hỗ trợ băng tần kép được chuyển đổi linh hoạt cùng độ phủ sóng mạnh mẽ nâng cao trải nghiệm khi chơi game và cải thiện hiệu suất làm việc thêm phần hiệu quả.', NULL, 10, 'active', 'usb-thu-song-tp-link', '2025-05-05 14:00:00');     

INSERT INTO products_categories (product_id, category_id) VALUES
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2);

INSERT INTO products_categories (product_id, category_id) VALUES
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1);

INSERT INTO products_categories (product_id, category_id) VALUES
(21, 4),
(22, 4),
(23, 4),
(24, 4),
(25, 4);

INSERT INTO products_categories (product_id, category_id) VALUES
(26, 6),
(27, 6),
(28, 6),
(29, 6),
(30, 6);

INSERT INTO products_categories (product_id, category_id) VALUES
(31, 4),
(32, 4),
(33, 4),
(34, 4),
(35, 4);

INSERT INTO products_categories (product_id, category_id) VALUES
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3);

INSERT INTO products_categories (product_id, category_id) VALUES
(41, 5),
(42, 5),
(43, 5),
(44, 5),
(45, 5);

-- Create the site_settings table
CREATE TABLE site_settings (
    id INT NOT NULL AUTO_INCREMENT,
    setting_key VARCHAR(100) NOT NULL,
    setting_value MEDIUMTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY unique_setting_key (setting_key)
);

-- Insert default settings
INSERT INTO site_settings (setting_key, setting_value) VALUES 
('company_name', 'GearBK'),
('logo', '603a3c244e75fea7_1746261481.webp'),
('phone', '0123456789'),
('email', 'contact@gearbk.com'),
('address', '268 Lý Thường Kiệt, Phường 14, Quận 10, Thành phố Hồ Chí Minh'),
('about_text', 'GearBK là cửa hàng chuyên cung cấp các thiết bị công nghệ, máy tính, linh kiện và phụ kiện gaming chính hãng với chất lượng hàng đầu.'),
('about_title', 'Về Chúng Tôi'),
('about_content', '<p>GearBK tự hào là nhà cung cấp thiết bị công nghệ gaming hàng đầu tại Việt Nam. Với đội ngũ nhân viên chuyên nghiệp và am hiểu sâu sắc về công nghệ, chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng nhất với dịch vụ tận tâm.</p><p>Chúng tôi không chỉ là nơi bán hàng, mà còn là đối tác tin cậy đồng hành cùng bạn trong hành trình khám phá thế giới công nghệ.</p>'),
('about_image', '20016ff4fbd3412a_1746261370.webp'),
('about_history_title', 'Lịch Sử Hình Thành'),
('about_history_content', '<p>GearBK được thành lập vào năm 2015 bởi một nhóm những người đam mê công nghệ và game thủ chuyên nghiệp. Chúng tôi bắt đầu từ một cửa hàng nhỏ tại Quận 10, Thành phố Hồ Chí Minh.</p><p>Qua nhiều năm phát triển, GearBK đã mở rộng thành chuỗi cửa hàng phủ khắp các thành phố lớn trên cả nước, trở thành thương hiệu uy tín trong lĩnh vực phân phối thiết bị gaming và công nghệ.</p><p>Năm 2020, GearBK trở thành đối tác chiến lược của nhiều thương hiệu công nghệ hàng đầu thế giới như ASUS, MSI, Razer...</p>'),
('about_mission_title', 'Sứ Mệnh Của Chúng Tôi'),
('about_mission_content', '<p>Sứ mệnh của GearBK là mang đến cho khách hàng trải nghiệm gaming tuyệt vời nhất với những sản phẩm công nghệ chất lượng cao và dịch vụ chuyên nghiệp.</p><p>Chúng tôi cam kết:</p><ul><li>Cung cấp sản phẩm chính hãng, chất lượng cao</li><li>Tư vấn chuyên nghiệp, tận tâm</li><li>Dịch vụ hậu mãi chu đáo</li><li>Giá cả cạnh tranh, minh bạch</li></ul>'),
('about_vision_title', 'Tầm Nhìn'),
('about_vision_content', '<p>GearBK hướng đến việc trở thành nhà phân phối thiết bị gaming và công nghệ hàng đầu Việt Nam, mang đến giải pháp công nghệ tối ưu cho mọi nhu cầu của khách hàng.</p><p>Chúng tôi không ngừng đổi mới, cập nhật xu hướng công nghệ mới nhất để đáp ứng nhu cầu ngày càng cao của khách hàng trong kỷ nguyên số.</p>'),
('about_values_title', 'Giá Trị Cốt Lõi'),
('about_values_content', '<p>Tại GearBK, chúng tôi cam kết mang đến những giá trị cốt lõi sau:</p><ul><li>Chất lượng sản phẩm luôn đặt lên hàng đầu</li><li>Dịch vụ khách hàng tận tâm</li><li>Giá cả cạnh tranh, minh bạch</li><li>Bảo hành chuyên nghiệp</li><li>Liên tục cập nhật sản phẩm mới nhất</li></ul>'),
('about_achievements_title', 'Thành Tựu & Giải Thưởng'),
('about_achievements_content', '<p>GearBK tự hào là đơn vị tiên phong trong lĩnh vực cung cấp thiết bị gaming tại Việt Nam với những thành tựu:</p><ul><li>Top 10 Nhà bán lẻ thiết bị Gaming uy tín nhất 2023</li><li>Đối tác chính thức của các thương hiệu lớn: ASUS, MSI, Razer, Logitech...</li><li>Hệ thống cửa hàng phủ sóng toàn quốc</li><li>Nhà tài trợ cho nhiều giải đấu Esports lớn tại Việt Nam</li></ul>'),
('thank_you_title', 'Cảm Ơn Quý Khách'),
('thank_you_text', 'GearBK luôn nỗ lực không ngừng để mang đến cho quý khách những sản phẩm chất lượng với dịch vụ tận tâm.'),
('hours_weekday', '8:00 - 21:00'),
('hours_saturday', '9:00 - 21:00'),
('hours_sunday', '10:00 - 20:00'),
('facebook_url', 'https://facebook.com/gearbk'),
('twitter_url', 'https://twitter.com/gearbk'),
('instagram_url', 'https://instagram.com/gearbk'),
('youtube_url', 'https://youtube.com/gearbk'),
('tiktok_url', 'https://tiktok.com/@gearbk'),
('map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4946681015187!2d106.65718631539816!3d10.772020062162692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1650701542804!5m2!1svi!2s');

-- Create carousel_slides table
CREATE TABLE carousel_slides (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    button_text VARCHAR(50),
    button_link VARCHAR(255),
    image_url VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0,
    deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Insert default carousel slides
INSERT INTO carousel_slides (title, description, button_text, button_link, image_url, display_order) VALUES 
('Thiết Bị Gaming Cao Cấp', 'Trải nghiệm hiệu suất vượt trội với thiết bị gaming hàng đầu thị trường', 'Mua Ngay', '#featured-products', 'd90f441209670271_1746261088.jpg', 1),
('Laptop Gaming Chính Hãng', 'Chiến game mượt mà mọi lúc mọi nơi với laptop gaming đỉnh cao', 'Mua Ngay', '#featured-products', '473c992e8bbd7e0d_1746258606.jpg', 2),
('Phụ Kiện Gaming Chất Lượng', 'Nâng cấp trải nghiệm với phụ kiện gaming chất lượng, bền bỉ', 'Mua Ngay', '#featured-products', 'f33c887d1d0c06ba_1746258590.jpg', 3); 