<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản lý từ khóa đa ngữ</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index'); ?>">Trang chủ</a>
         </li>
         <li class="active"><strong>Quản lý từ khóa đa ngữ</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý từ khóa đa ngữ</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
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
                                        <option value="1" <?= isset($_GET['publish']) && $_GET['publish'] === '1' ? 'selected' : '' ?>>Đã xuất bản</option>
                                        <option value="0" <?= isset($_GET['publish']) && $_GET['publish'] === '0' ? 'selected' : '' ?>>Chưa xuất bản</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            Tìm kiếm
                                        </button>
                                        <a href="<?php echo base_url('backend/language/languagekeyword/create'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus mr-10"></i> Thêm mới</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="wrap-table">
                        <div class="width-table">
                            <?php if (!empty($keywordList)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="20%">Từ khóa</th>
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
                                                        class="btn btn-sm btn-primary " title="Chỉnh sửa">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="<?= BASE_URL ?>backend/language/languagekeyword/delete/<?= $keyword['id'] ?>" 
                                                        class="btn btn-sm btn-danger" style="margin-left: 5px;" title="Xóa">
                                                            <i class="fa fa-trash"></i>
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