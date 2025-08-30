<?= $this->extend('backend/dashboard/layout/default') ?>

<?= $this->section('title') ?>
    Xóa từ khóa đa ngữ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Xóa từ khóa đa ngữ</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Cảnh báo!</h5>
                        Bạn đang thực hiện xóa từ khóa đa ngữ. Hành động này không thể hoàn tác.
                    </div>

                    <!-- Keyword Information -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Thông tin từ khóa
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%"><strong>ID:</strong></td>
                                            <td><?= $language_keyword['id'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Từ khóa:</strong></td>
                                            <td><code><?= $language_keyword['keyword'] ?></code></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Module:</strong></td>
                                            <td><span class="badge badge-info"><?= ucfirst($language_keyword['module']) ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Thứ tự:</strong></td>
                                            <td><?= $language_keyword['order'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Trạng thái:</strong></td>
                                            <td>
                                                <?php if ($language_keyword['publish'] == 1): ?>
                                                    <span class="badge badge-success">Đã xuất bản</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Chưa xuất bản</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%"><strong>Tiếng Anh:</strong></td>
                                            <td><?= $language_keyword['en_translation'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tiếng Việt:</strong></td>
                                            <td><?= $language_keyword['vi_translation'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mô tả:</strong></td>
                                            <td>
                                                <?php if (!empty($language_keyword['description'])): ?>
                                                    <?= $language_keyword['description'] ?>
                                                <?php else: ?>
                                                    <em class="text-muted">Không có mô tả</em>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ngày tạo:</strong></td>
                                            <td><?= $language_keyword['created_at'] ?? 'N/A' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Người tạo:</strong></td>
                                            <td>ID: <?= $language_keyword['userid_created'] ?? 'N/A' ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Impact Analysis -->
                    <div class="card mt-3">
                        <div class="card-header bg-danger text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-exclamation-triangle"></i> Phân tích tác động
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-globe"></i> Tác động đến giao diện:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success"></i> Các trang sử dụng từ khóa này sẽ hiển thị text gốc</li>
                                        <li><i class="fas fa-check text-success"></i> Không ảnh hưởng đến chức năng của hệ thống</li>
                                        <li><i class="fas fa-exclamation-triangle text-warning"></i> Có thể làm mất tính đa ngữ của giao diện</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-database"></i> Tác động đến dữ liệu:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success"></i> Dữ liệu được xóa mềm (soft delete)</li>
                                        <li><i class="fas fa-check text-success"></i> Có thể khôi phục từ database nếu cần</li>
                                        <li><i class="fas fa-info text-info"></i> Không ảnh hưởng đến các bản ghi khác</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Form -->
                    <div class="card mt-3">
                        <div class="card-header bg-danger text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-trash"></i> Xác nhận xóa
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= BASE_URL ?>backend/language/languagekeyword/delete/<?= $language_keyword['id'] ?>">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="confirmDelete" required>
                                        <label class="custom-control-label" for="confirmDelete">
                                            <strong>Tôi xác nhận rằng tôi muốn xóa từ khóa này và hiểu rõ hậu quả của hành động này.</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="deleteReason">Lý do xóa (tùy chọn):</label>
                                    <textarea id="deleteReason" name="deleteReason" class="form-control" rows="3" 
                                              placeholder="Nhập lý do xóa từ khóa này..."></textarea>
                                </div>

                                <input type="hidden" name="delete" value="1">
                                <input type="hidden" name="id" value="<?= $language_keyword['id'] ?>">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger btn-lg" id="deleteBtn" disabled>
                                        <i class="fas fa-trash"></i> Xóa từ khóa
                                    </button>
                                    <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" class="btn btn-secondary btn-lg ml-2">
                                        <i class="fas fa-times"></i> Hủy bỏ
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Alternative Actions -->
                    <div class="card mt-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-lightbulb"></i> Hành động thay thế
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <a href="<?= BASE_URL ?>backend/language/languagekeyword/update/<?= $language_keyword['id'] ?>" 
                                       class="btn btn-primary btn-block">
                                        <i class="fas fa-edit"></i><br>
                                        Chỉnh sửa
                                    </a>
                                    <small class="text-muted">Thay đổi nội dung thay vì xóa</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn btn-warning btn-block" onclick="togglePublish()">
                                        <i class="fas fa-eye-slash"></i><br>
                                        Ẩn từ khóa
                                    </button>
                                    <small class="text-muted">Chuyển về trạng thái chưa xuất bản</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" 
                                       class="btn btn-secondary btn-block">
                                        <i class="fas fa-list"></i><br>
                                        Danh sách
                                    </a>
                                    <small class="text-muted">Quay lại danh sách từ khóa</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for delete confirmation -->
<script>
$(document).ready(function() {
    // Enable/disable delete button based on checkbox
    $('#confirmDelete').on('change', function() {
        $('#deleteBtn').prop('disabled', !this.checked);
    });

    // Form submission confirmation
    $('form').on('submit', function(e) {
        if (!$('#confirmDelete').is(':checked')) {
            alert('Vui lòng xác nhận rằng bạn muốn xóa từ khóa này!');
            e.preventDefault();
            return false;
        }

        return confirm('Bạn có chắc chắn muốn xóa từ khóa này? Hành động này không thể hoàn tác!');
    });
});

// Toggle publish status
function togglePublish() {
    if (confirm('Bạn có muốn chuyển từ khóa này về trạng thái chưa xuất bản thay vì xóa?')) {
        // Redirect to update page with publish=0
        window.location.href = '<?= BASE_URL ?>backend/language/languagekeyword/update/<?= $language_keyword['id'] ?>';
    }
}
</script>
<?= $this->endSection() ?>
