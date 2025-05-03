<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Liên Hệ</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.10/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar-link {
            color: #ced4da;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #495057;
            color: #fff;
        }
        .stats-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 24px;
            color: #fff;
        }
        .stats-icon.blue {
            background-color: #435ebe;
        }
        .stats-icon.red {
            background-color: #dc3545;
        }
        .stats-icon.green {
            background-color: #198754;
        }
        .stats-icon.purple {
            background-color: #6f42c1;
        }
        .table-primary {
            background-color: #cfe2ff !important;
        }
        .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }
        #modal-message {
            max-height: 300px;
            overflow-y: auto;
        }
        .filter-card {
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }
        .filter-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .filter-card.active {
            border-color: #435ebe;
            background-color: #f8f9ff;
        }
        
        /* Responsive styles */
        @media (max-width: 767.98px) {
            .stats-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
            .filter-card .card-body {
                padding: 0.75rem;
            }
            .filter-card .h5 {
                font-size: 1rem;
            }
            .card-header {
                padding: 0.75rem;
            }
            .table {
                font-size: 0.875rem;
            }
            .modal-dialog {
                margin: 0.5rem;
            }
        }
        
        /* Custom DataTable responsive styles */
        .dtr-details {
            width: 100%;
        }
        .dtr-title {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">          
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Quản Lý Liên Hệ</h1>
                </div>
                
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-6 col-xl-3 col-md-6 mb-4">
                        <div class="card border-0 shadow h-100 py-2 filter-card" data-filter="all" style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="stats-icon blue me-3">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small">Tổng Số</div>
                                        <div class="h5 mb-0 font-weight-bold"><?php echo count($data['contacts']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3 col-md-6 mb-4">
                        <div class="card border-0 shadow h-100 py-2 filter-card" data-filter="unread" style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="stats-icon red me-3">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small">Chưa Đọc</div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            <?php 
                                            $unreadCount = 0;
                                            foreach ($data['contacts'] as $contact) {
                                                if ($contact['status'] === 'unread') {
                                                    $unreadCount++;
                                                }
                                            }
                                            echo $unreadCount;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3 col-md-6 mb-4">
                        <div class="card border-0 shadow h-100 py-2 filter-card" data-filter="read" style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="stats-icon green me-3">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small">Đã Đọc</div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            <?php 
                                            $readCount = 0;
                                            foreach ($data['contacts'] as $contact) {
                                                if ($contact['status'] === 'read') {
                                                    $readCount++;
                                                }
                                            }
                                            echo $readCount;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3 col-md-6 mb-4">
                        <div class="card border-0 shadow h-100 py-2 filter-card" data-filter="replied" style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="stats-icon purple me-3">
                                            <i class="fas fa-reply"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small">Đã Phản Hồi</div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            <?php 
                                            $repliedCount = 0;
                                            foreach ($data['contacts'] as $contact) {
                                                if ($contact['status'] === 'replied') {
                                                    $repliedCount++;
                                                }
                                            }
                                            echo $repliedCount;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact List Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">Danh Sách Liên Hệ</h6>
                        <div id="filter-status" class="text-muted small mt-2 mt-md-0">Hiển thị tất cả liên hệ</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="contactTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ Tên</th>
                                        <th>Email</th>
                                        <th>Tiêu Đề</th>
                                        <th>Ngày Tạo</th>
                                        <th>Trạng Thái</th>
                                        <th class="no-sort">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['contacts'] as $contact): ?>
                                    <tr class="<?php echo $contact['status'] === 'unread' ? 'table-primary' : ''; ?>" data-id="<?php echo $contact['id']; ?>" style="cursor: pointer;">
                                        <td><?php echo $contact['id']; ?></td>
                                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['subject'] ?? '(Không có tiêu đề)'); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($contact['created_at'])); ?></td>
                                        <td>
                                            <?php if ($contact['status'] === 'unread'): ?>
                                                <span class="badge bg-danger">Chưa đọc</span>
                                            <?php elseif ($contact['status'] === 'read'): ?>
                                                <span class="badge bg-success">Đã đọc</span>
                                            <?php elseif ($contact['status'] === 'replied'): ?>
                                                <span class="badge bg-primary">Đã phản hồi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td onclick="event.stopPropagation();">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton<?php echo $contact['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="d-none d-md-inline">Thao tác</span>
                                                    <span class="d-inline d-md-none"><i class="fas fa-cog"></i></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?php echo $contact['id']; ?>">
                                                    <li><a class="dropdown-item" href="#" onclick="viewContact(<?php echo $contact['id']; ?>)">
                                                        <i class="fas fa-eye"></i> Xem chi tiết
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="changeStatus(<?php echo $contact['id']; ?>, 'read')">
                                                        <i class="fas fa-check-double"></i> Đánh dấu đã đọc
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="changeStatus(<?php echo $contact['id']; ?>, 'unread')">
                                                        <i class="fas fa-envelope"></i> Đánh dấu chưa đọc
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="changeStatus(<?php echo $contact['id']; ?>, 'replied')">
                                                        <i class="fas fa-reply"></i> Đánh dấu đã phản hồi
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteContact(<?php echo $contact['id']; ?>)">
                                                        <i class="fas fa-trash-alt"></i> Xóa
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
    <!-- Contact Details Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Chi Tiết Liên Hệ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                        <!-- Content will be loaded dynamically -->
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Đang tải dữ liệu...</p>
                        </div>
                    </div>
                    
                    <!-- Reply form (hidden by default) -->
                    <div id="replyForm" class="mt-4" style="display: none;">
                        <h6 class="border-top pt-3">Phản hồi</h6>
                        <div class="mb-3">
                            <textarea id="replyMessage" class="form-control" rows="5" placeholder="Nhập nội dung phản hồi..."></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="sendReplyBtn">
                                <i class="fas fa-paper-plane me-1"></i> Gửi phản hồi
                            </button>
                        </div>
                    </div>
                    
                    <!-- Previous reply section (if exists) -->
                    <div id="previousReply" class="mt-4" style="display: none;">
                        <h6 class="border-top pt-3">Phản hồi đã gửi</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="small text-muted mb-1">Gửi lúc <span id="replyTimestamp"></span></p>
                            <div id="replyContent" style="white-space: pre-wrap;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-wrap gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success" id="markAsReadBtn">
                        <i class="fas fa-check-double me-1 d-none d-sm-inline"></i>Đã đọc
                    </button>
                    <button type="button" class="btn btn-primary" id="toggleReplyBtn">
                        <i class="fas fa-reply me-1 d-none d-sm-inline"></i>Phản hồi
                    </button>
                    <button type="button" class="btn btn-primary" id="markAsRepliedBtn">
                        <i class="fas fa-paper-plane me-1 d-none d-sm-inline"></i>Đánh dấu phản hồi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.10/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.10/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Initialize DataTable
        let contactTable;
        let activeFilter = 'all';
        
        $(document).ready(function() {
            contactTable = $('#contactTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: [1, 5, 6] }, // Name, Status, Actions are high priority
                    { responsivePriority: 2, targets: [2, 4] },    // Email and Date are medium priority
                    { responsivePriority: 3, targets: [0, 3] },    // ID and Subject are low priority
                    { targets: 'no-sort', orderable: false }       // Disable sorting on action column
                ],
                language: {
                    search: "Tìm kiếm:",
                    lengthMenu: "Hiển thị _MENU_ mục",
                    info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    infoEmpty: "Hiển thị 0 đến 0 của 0 mục",
                    infoFiltered: "(lọc từ _MAX_ mục)",
                    paginate: {
                        first: "Đầu",
                        last: "Cuối",
                        next: "Sau",
                        previous: "Trước"
                    },
                    emptyTable: "Không có dữ liệu",
                    zeroRecords: "Không tìm thấy kết quả nào phù hợp"
                },
                drawCallback: function() {
                    // Make rows clickable after redraw
                    $('#contactTable tbody tr').off('click').on('click', function() {
                        const id = $(this).data('id');
                        viewContact(id);
                    });
                }
            });
            
            // Make rows clickable
            $('#contactTable tbody tr').off('click').on('click', function() {
                const id = $(this).data('id');
                viewContact(id);
            });
            
            // Set initial active filter
            $('.filter-card[data-filter="all"]').addClass('active');
            
            // Add click event for filter cards
            $('.filter-card').click(function() {
                const filter = $(this).data('filter');
                
                // Don't do anything if the same filter is clicked again
                if (activeFilter === filter) return;
                
                activeFilter = filter;
                
                // Reset all cards to default state
                $('.filter-card').removeClass('active');
                $(this).addClass('active');
                
                // Apply filter to DataTable
                if (filter === 'all') {
                    contactTable.column(5).search('').draw();
                    $('#filter-status').html('Hiển thị tất cả liên hệ');
                } else {
                    // Get the exact text to filter by
                    let filterText = '';
                    let statusText = '';
                    
                    if (filter === 'unread') {
                        filterText = 'Chưa đọc';
                        statusText = 'Hiển thị liên hệ <span class="badge bg-danger">Chưa đọc</span>';
                    } else if (filter === 'read') {
                        filterText = 'Đã đọc';
                        statusText = 'Hiển thị liên hệ <span class="badge bg-success">Đã đọc</span>';
                    } else if (filter === 'replied') {
                        filterText = 'Đã phản hồi';
                        statusText = 'Hiển thị liên hệ <span class="badge bg-primary">Đã phản hồi</span>';
                    }
                    
                    contactTable.column(5).search(filterText).draw();
                    $('#filter-status').html(statusText);
                }
                
                // Add animation effect for table refresh
                $('#contactTable').fadeOut(100).fadeIn(300);
            });

            // Handle window resize to ensure DataTable works well on all devices
            let resizeTimer;
            $(window).resize(function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Adjust DataTable to fit new screen size
                    contactTable.columns.adjust().responsive.recalc();
                }, 250);
            });
        });
        
        // Format date helper
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        // View contact details
        function viewContact(id) {
            // Show modal with loading spinner
            const modal = new bootstrap.Modal(document.getElementById('contactModal'));
            modal.show();
            
            // Reset modal content to show loading spinner
            document.getElementById('modalContent').innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Đang tải dữ liệu...</p>
                </div>
            `;
            
            // Hide action buttons and forms until data is loaded
            document.getElementById('markAsReadBtn').style.display = 'none';
            document.getElementById('markAsRepliedBtn').style.display = 'none';
            document.getElementById('toggleReplyBtn').style.display = 'none';
            document.getElementById('replyForm').style.display = 'none';
            document.getElementById('previousReply').style.display = 'none';
            
            // Fetch contact details
            const url = '/Gear/ContactAdminController/viewContactDetails/' + id;
            
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const contact = data.data;
                        
                        // Update modal content
                        let statusBadge = '';
                        if (contact.status === 'unread') {
                            statusBadge = '<span class="badge bg-danger">Chưa đọc</span>';
                        } else if (contact.status === 'read') {
                            statusBadge = '<span class="badge bg-success">Đã đọc</span>';
                        } else if (contact.status === 'replied') {
                            statusBadge = '<span class="badge bg-primary">Đã phản hồi</span>';
                        }
                        
                        document.getElementById('modalContent').innerHTML = `
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p><strong>Họ tên:</strong> ${contact.name}</p>
                                    <p><strong>Email:</strong> ${contact.email}</p>
                                    <p><strong>Điện thoại:</strong> ${contact.phone || 'Không có'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Ngày gửi:</strong> ${formatDate(contact.created_at)}</p>
                                    <p><strong>Trạng thái:</strong> ${statusBadge}</p>
                                    <p><strong>Đăng ký nhận tin:</strong> ${contact.newsletter == 1 ? 'Có' : 'Không'}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Tiêu đề</h6>
                                    <p>${contact.subject || '(Không có tiêu đề)'}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Nội dung tin nhắn</h6>
                                    <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">${contact.message}</div>
                                </div>
                            </div>
                        `;
                        
                        // Store contact ID for reply functionality
                        document.getElementById('sendReplyBtn').setAttribute('data-id', contact.id);
                        
                        // Set up button visibility and actions based on status
                        if (contact.status === 'unread') {
                            document.getElementById('markAsReadBtn').style.display = 'block';
                            document.getElementById('markAsRepliedBtn').style.display = 'block';
                            document.getElementById('toggleReplyBtn').style.display = 'block';
                        } else if (contact.status === 'read') {
                            document.getElementById('markAsReadBtn').style.display = 'none';
                            document.getElementById('markAsRepliedBtn').style.display = 'block';
                            document.getElementById('toggleReplyBtn').style.display = 'block';
                        } else if (contact.status === 'replied') {
                            document.getElementById('markAsReadBtn').style.display = 'none';
                            document.getElementById('markAsRepliedBtn').style.display = 'none';
                            document.getElementById('toggleReplyBtn').style.display = 'none';
                            
                            // Show previous reply if exists
                            if (contact.admin_reply) {
                                document.getElementById('previousReply').style.display = 'block';
                                document.getElementById('replyContent').textContent = contact.admin_reply;
                                if (contact.replied_at) {
                                    document.getElementById('replyTimestamp').textContent = formatDate(contact.replied_at);
                                }
                            }
                        }
                        
                        // Set up button actions
                        document.getElementById('markAsReadBtn').onclick = function() {
                            changeStatus(contact.id, 'read');
                        };
                        
                        document.getElementById('markAsRepliedBtn').onclick = function() {
                            changeStatus(contact.id, 'replied');
                        };
                        
                        document.getElementById('toggleReplyBtn').onclick = function() {
                            const replyForm = document.getElementById('replyForm');
                            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
                        };
                        
                        document.getElementById('sendReplyBtn').onclick = function() {
                            sendReply(contact.id);
                        };
                    } else {
                        document.getElementById('modalContent').innerHTML = `
                            <div class="alert alert-danger" role="alert">
                                ${data.message || 'Không thể tải dữ liệu liên hệ.'}
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modalContent').innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            Đã xảy ra lỗi khi tải dữ liệu liên hệ. Vui lòng thử lại sau.
                        </div>
                    `;
                });
        }
        
        // Send reply to contact
        function sendReply(contactId) {
            const replyMessage = document.getElementById('replyMessage').value.trim();
            
            if (!replyMessage) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Vui lòng nhập nội dung phản hồi',
                    icon: 'error'
                });
                return;
            }
            
            const formData = new FormData();
            formData.append('contact_id', contactId);
            formData.append('reply_message', replyMessage);
            
            // Show loading indicator on button
            const sendReplyBtn = document.getElementById('sendReplyBtn');
            const originalBtnText = sendReplyBtn.innerHTML;
            sendReplyBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang gửi...';
            sendReplyBtn.disabled = true;
            
            fetch('/Gear/ContactAdminController/replyToContact', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Reset button state
                sendReplyBtn.innerHTML = originalBtnText;
                sendReplyBtn.disabled = false;
                
                if (data.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: data.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                        if (modal) {
                            modal.hide();
                        }
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: data.message || 'Không thể gửi phản hồi.',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset button state
                sendReplyBtn.innerHTML = originalBtnText;
                sendReplyBtn.disabled = false;
                
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Đã xảy ra lỗi khi gửi phản hồi.',
                    icon: 'error'
                });
            });
        }
        
        // Change contact status
        function changeStatus(id, status) {
            const formData = new FormData();
            formData.append('contact_id', id);
            formData.append('status', status);
            
            fetch('/Gear/ContactAdminController/changeContactStatus', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Đã xảy ra lỗi khi cập nhật trạng thái'
                });
            });
        }
        
        // Delete contact
        function deleteContact(id) {
            Swal.fire({
                title: 'Xác nhận xóa',
                text: 'Bạn có chắc chắn muốn xóa liên hệ này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('contact_id', id);
                    
                    fetch('/Gear/ContactAdminController/deleteContact', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã xảy ra lỗi khi xóa liên hệ'
                        });
                    });
                }
            });
        }
    </script>
</body>

</html>