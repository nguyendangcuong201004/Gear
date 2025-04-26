-- Create questions table
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    tags VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create answers table
CREATE TABLE IF NOT EXISTS answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data for questions (optional)
INSERT INTO questions (user_id, title, content, tags, created_at) VALUES
(1, 'Which gaming laptop is best for under $1000?', 'I am looking for a budget gaming laptop that can run modern games at medium settings. My budget is around $1000. What would you recommend?', 'laptop,gaming,budget', NOW() - INTERVAL 5 DAY),
(2, 'How to optimize SSD performance on Windows 10?', 'I recently upgraded to an SSD but I feel like it\'s not performing as fast as it should. What settings or tweaks should I apply in Windows 10 to get the most out of my SSD?', 'ssd,windows,performance', NOW() - INTERVAL 3 DAY),
(1, 'Best wireless keyboard for programming?', 'I\'m a software developer looking for a comfortable wireless keyboard for long coding sessions. Preferably mechanical with good battery life. Any recommendations?', 'keyboard,wireless,programming', NOW() - INTERVAL 2 DAY),
(3, 'Is liquid cooling worth it for a gaming PC?', 'I\'m building a new gaming PC and wondering if liquid cooling is worth the extra cost over air cooling. I plan to do some overclocking but nothing extreme. What are the pros and cons?', 'cooling,gaming,pc-building', NOW() - INTERVAL 1 DAY);

-- Sample data for answers (optional)
INSERT INTO answers (question_id, user_id, content, created_at) VALUES
(1, 3, 'At that price point, I would recommend the Acer Nitro 5. It has a good balance of CPU and GPU power for the price, and can run most modern games at medium to high settings.', NOW() - INTERVAL 4 DAY),
(1, 2, 'I recently purchased the Lenovo Legion 5 for just under $1000, and it\'s been excellent for gaming. It has a Ryzen 5 CPU and GTX 1650Ti which can handle most games well.', NOW() - INTERVAL 4 DAY),
(2, 1, 'Make sure TRIM is enabled, disable defragmentation for the SSD, and enable AHCI mode in BIOS. Also check that your SSD firmware is up to date.', NOW() - INTERVAL 2 DAY),
(3, 2, 'I\'d recommend the Keychron K2. It\'s wireless, has mechanical switches, good battery life, and works well for programming with a layout that includes arrow keys and function keys.', NOW() - INTERVAL 1 DAY),
(4, 1, 'Liquid cooling is quieter and can provide better cooling for overclocking, but it\'s more expensive and there\'s a small risk of leaks. For moderate overclocking, a good air cooler like the Noctua NH-D15 can be just as effective and more reliable.', NOW() - INTERVAL 12 HOUR); 