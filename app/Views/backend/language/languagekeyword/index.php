<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Quản lý từ khóa đa ngữ</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm mới
                            </a>
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/import" class="btn btn-success">
                                <i class="fas fa-upload"></i> Import
                            </a>
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/export" class="btn btn-info">
                                <i class="fas fa-download"></i> Export
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="card-body">
                    <form method="GET" action="<?= BASE_URL ?>backend/language/languagekeyword/index">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Từ khóa tìm kiếm:</label>
                                    <input type="text" name="keyword" class="form-control" 
                                           value="<?= $currentKeyword ?? '' ?>" 
                                           placeholder="Nhập từ khóa...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trạng thái:</label>
                                    <select name="publish" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="1" <?= (isset($_GET['publish']) && $_GET['publish'] === '1') ? 'selected' : '' ?>>Đã xuất bản</option>
                                        <option value="0" <?= (isset($_GET['publish']) && $_GET['publish'] === '0') ? 'selected' : '' ?>>Chưa xuất bản</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Tìm kiếm
                                        </button>
                                        <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" class="btn btn-secondary">
                                            <i class="fas fa-refresh"></i> Làm mới
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Keywords List -->
                <div class="card-body">
                    <?php if (!empty($keywordList)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Từ khóa</th>
                                        <th width="15%">Module</th>
                                        <th width="20%">Bản dịch tiếng Anh</th>
                                        <th width="20%">Bản dịch tiếng Việt</th>
                                        <th width="5%">Thứ tự</th>
                                        <th width="5%">Trạng thái</th>
                                        <th width="10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($keywordList as $keyword): ?>
                                        <tr>
                                            <td><?= $keyword['id'] ?></td>
                                            <td>
                                                <strong><?= $keyword['keyword'] ?></strong>
                                                <?php if (!empty($keyword['description'])): ?>
                                                    <br><small class="text-muted"><?= $keyword['description'] ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?= ucfirst($keyword['module']) ?></span>
                                            </td>
                                            <td>
                                                <div class="text-truncate" title="<?= $keyword['en_translation'] ?>">
                                                    <?= $keyword['en_translation'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate" title="<?= $keyword['vi_translation'] ?>">
                                                    <?= $keyword['vi_translation'] ?>
                                                </div>
                                            </td>
                                            <td class="text-center"><?= $keyword['order'] ?></td>
                                            <td class="text-center">
                                                <?php if ($keyword['publish'] == 1): ?>
                                                    <span class="badge badge-success">Đã xuất bản</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Chưa xuất bản</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL ?>backend/language/languagekeyword/update/<?= $keyword['id'] ?>" 
                                                       class="btn btn-sm btn-primary" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>backend/language/languagekeyword/delete/<?= $keyword['id'] ?>" 
                                                       class="btn btn-sm btn-danger" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if (!empty($pagination)): ?>
                            <div class="d-flex justify-content-center mt-3">
                                <?= $pagination ?>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có dữ liệu</h5>
                            <p class="text-muted">Chưa có từ khóa nào được tạo. Hãy tạo từ khóa đầu tiên!</p>
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm từ khóa đầu tiên
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AJAX Search Script -->
<script>
$(document).ready(function() {
    // Auto search on input change
    let searchTimer;
    $('input[name="keyword"]').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            $('form').submit();
        }, 500);
    });

    // Auto submit on module change
    $('select[name="module"]').on('change', function() {
        $('form').submit();
    });

    // Auto submit on publish change
    $('select[name="publish"]').on('change', function() {
        $('form').submit();
    });
});
</script>