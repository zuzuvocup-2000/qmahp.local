<?= $this->extend('backend/dashboard/layout/default') ?>

<?= $this->section('title') ?>
    Thêm từ khóa đa ngữ mới
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Thêm từ khóa đa ngữ mới</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (isset($validate)): ?>
                        <div class="alert alert-danger">
                            <h5><i class="icon fas fa-ban"></i> Lỗi validation!</h5>
                            <?= $validate ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>backend/language/languagekeyword/create">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keyword">Từ khóa <span class="text-danger">*</span></label>
                                    <input type="text" id="keyword" name="keyword" class="form-control" 
                                           value="<?= old('keyword') ?>" 
                                           placeholder="Ví dụ: sidebar_sb_article" required>
                                    <small class="form-text text-muted">
                                        Từ khóa duy nhất để định danh. Sử dụng format: module_section_key
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="module">Module <span class="text-danger">*</span></label>
                                    <select id="module" name="module" class="form-control" required>
                                        <option value="">Chọn module</option>
                                        <?php foreach ($availableModules as $module): ?>
                                            <option value="<?= $module ?>" <?= (old('module') === $module) ? 'selected' : '' ?>>
                                                <?= ucfirst($module) ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <option value="new_module">+ Thêm module mới</option>
                                    </select>
                                </div>

                                <div class="form-group" id="newModuleGroup" style="display: none;">
                                    <label for="newModule">Tên module mới</label>
                                    <input type="text" id="newModule" name="newModule" class="form-control" 
                                           placeholder="Nhập tên module mới">
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" 
                                              placeholder="Mô tả hoặc ngữ cảnh sử dụng của từ khóa"><?= old('description') ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="order">Thứ tự</label>
                                    <input type="number" id="order" name="order" class="form-control" 
                                           value="<?= old('order') ?: '0' ?>" min="0">
                                    <small class="form-text text-muted">
                                        Số càng nhỏ thì hiển thị càng trước
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="publish">Trạng thái</label>
                                    <select id="publish" name="publish" class="form-control">
                                        <option value="1" <?= (old('publish') === '1' || old('publish') === '') ? 'selected' : '' ?>>Đã xuất bản</option>
                                        <option value="0" <?= (old('publish') === '0') ? 'selected' : '' ?>>Chưa xuất bản</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="en_translation">Bản dịch tiếng Anh <span class="text-danger">*</span></label>
                                    <textarea id="en_translation" name="en_translation" class="form-control" rows="4" 
                                              placeholder="Nhập bản dịch tiếng Anh" required><?= old('en_translation') ?></textarea>
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            <span id="enCharCount">0</span>/500 ký tự
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vi_translation">Bản dịch tiếng Việt <span class="text-danger">*</span></label>
                                    <textarea id="vi_translation" name="vi_translation" class="form-control" rows="4" 
                                              placeholder="Nhập bản dịch tiếng Việt" required><?= old('vi_translation') ?></textarea>
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            <span id="viCharCount">0</span>/500 ký tự
                                        </small>
                                    </div>
                                </div>

                                <!-- Preview Section -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-eye"></i> Xem trước
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="font-weight-bold">Tiếng Anh:</label>
                                                <div id="enPreview" class="border p-2 bg-light rounded">
                                                    <em class="text-muted">Chưa có nội dung</em>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="font-weight-bold">Tiếng Việt:</label>
                                                <div id="viPreview" class="border p-2 bg-light rounded">
                                                    <em class="text-muted">Chưa có nội dung</em>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i> Lưu từ khóa
                                    </button>
                                    <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" class="btn btn-secondary btn-lg ml-2">
                                        <i class="fas fa-times"></i> Hủy bỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for form functionality -->
<script>
$(document).ready(function() {
    // Module selection handling
    $('#module').on('change', function() {
        if ($(this).val() === 'new_module') {
            $('#newModuleGroup').show();
            $('#newModule').prop('required', true);
        } else {
            $('#newModuleGroup').hide();
            $('#newModule').prop('required', false);
        }
    });

    // Character count for translations
    $('#en_translation').on('input', function() {
        const count = $(this).val().length;
        $('#enCharCount').text(count);
        updatePreview('en', $(this).val());
    });

    $('#vi_translation').on('input', function() {
        const count = $(this).val().length;
        $('#viCharCount').text(count);
        updatePreview('vi', $(this).val());
    });

    // Update preview
    function updatePreview(lang, text) {
        const previewId = lang + 'Preview';
        if (text.trim()) {
            $('#' + previewId).html(text);
        } else {
            $('#' + previewId).html('<em class="text-muted">Chưa có nội dung</em>');
        }
    }

    // Form validation
    $('form').on('submit', function(e) {
        const keyword = $('#keyword').val().trim();
        const module = $('#module').val();
        const enTranslation = $('#en_translation').val().trim();
        const viTranslation = $('#vi_translation').val().trim();

        if (!keyword) {
            alert('Vui lòng nhập từ khóa!');
            $('#keyword').focus();
            e.preventDefault();
            return false;
        }

        if (!module || module === 'new_module') {
            if (module === 'new_module' && !$('#newModule').val().trim()) {
                alert('Vui lòng nhập tên module mới!');
                $('#newModule').focus();
                e.preventDefault();
                return false;
            }
        }

        if (!enTranslation) {
            alert('Vui lòng nhập bản dịch tiếng Anh!');
            $('#en_translation').focus();
            e.preventDefault();
            return false;
        }

        if (!viTranslation) {
            alert('Vui lòng nhập bản dịch tiếng Việt!');
            $('#vi_translation').focus();
            e.preventDefault();
            return false;
        }

        // If new module, update the module field
        if (module === 'new_module') {
            const newModuleName = $('#newModule').val().trim();
            $('#module').append('<option value="' + newModuleName + '" selected>' + newModuleName + '</option>');
            $('#module').val(newModuleName);
        }
    });

    // Initialize character counts
    $('#en_translation').trigger('input');
    $('#vi_translation').trigger('input');
});
</script>
<?= $this->endSection() ?>
