<?php
// Tự động load App router và các lớp core
require_once __DIR__ . '/mvc/App.php';
require_once __DIR__ . '/mvc/core/Database.php';

// Khởi chạy App để xử lý URL ?url=Controller/action/param...
$app = new App();
