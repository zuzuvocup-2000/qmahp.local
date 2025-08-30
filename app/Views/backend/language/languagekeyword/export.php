<?= $this->extend('backend/dashboard/layout/default') ?>

<?= $this->section('title') ?>
    Export từ khóa đa ngữ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Export từ khóa đa ngữ</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Export Instructions -->
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info-circle"></i> Hướng dẫn export</h5>
                        <p class="mb-0">
                            Export từ khóa đa ngữ theo module và ngôn ngữ cụ thể. Dữ liệu sẽ được xuất ra định dạng JSON để dễ dàng import lại hoặc sử dụng cho mục đích khác.
                        </p>
                    </div>

                    <!-- Export Form -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-download"></i> Cài đặt export
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="<?= BASE_URL ?>backend/language/languagekeyword/export">
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="language">Ngôn ngữ <span class="text-danger">*</span></label>
                                            <select id="language" name="language" class="form-control" required>
                                                <option value="en">Tiếng Anh</option>
                                                <option value="vi">Tiếng Việt</option>
                                                <option value="both">Cả hai ngôn ngữ</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Chọn ngôn ngữ để export
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="format">Định dạng file</label>
                                            <select id="format" name="format" class="form-control">
                                                <option value="json">JSON (Mặc định)</option>
                                                <option value="csv">CSV</option>
                                                <option value="txt">Text</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="includeMetadata">Bao gồm metadata</label>
                                            <select id="includeMetadata" name="includeMetadata" class="form-control">
                                                <option value="0">Không</option>
                                                <option value="1">Có (ID, ngày tạo, người tạo...)</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Thêm thông tin bổ sung vào file export
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-download"></i> Export từ khóa
                                    </button>
                                    <button type="button" class="btn btn-info btn-lg ml-2" onclick="previewExport()">
                                        <i class="fas fa-eye"></i> Xem trước
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Export Options -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-cogs"></i> Tùy chọn export nâng cao
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-filter"></i> Lọc dữ liệu:</h6>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="onlyPublished" checked>
                                            <label class="custom-control-label" for="onlyPublished">
                                                Chỉ export từ khóa đã xuất bản
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="includeDescription">
                                            <label class="custom-control-input" for="includeDescription">
                                                Bao gồm mô tả
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="includeOrder">
                                            <label class="custom-control-input" for="includeOrder">
                                                Bao gồm thứ tự
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-sort"></i> Sắp xếp:</h6>
                                    <div class="form-group">
                                        <label for="sortBy">Sắp xếp theo:</label>
                                        <select id="sortBy" class="form-control">
                                            <option value="order">Thứ tự</option>
                                            <option value="keyword">Từ khóa</option>
                                            <option value="created_at">Ngày tạo</option>
                                            <option value="updated_at">Ngày cập nhật</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="sortDirection">Hướng sắp xếp:</label>
                                        <select id="sortDirection" class="form-control">
                                            <option value="ASC">Tăng dần</option>
                                            <option value="DESC">Giảm dần</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Export History -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-history"></i> Lịch sử export
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center text-muted">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <p>Chức năng lịch sử export sẽ được phát triển trong phiên bản tiếp theo.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Export Examples -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-lightbulb"></i> Ví dụ export
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-file-code"></i> Export tiếng Anh:</h6>
                                    <div class="bg-light p-3 rounded">
                                        <pre class="mb-0"><code>{
    "sidebar_sb_article": "Blog",
    "sidebar_sb_user": "User",
    "nav_nav_logout": "Logout"
}</code></pre>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-file-code"></i> Export tiếng Việt:</h6>
                                    <div class="bg-light p-3 rounded">
                                        <pre class="mb-0"><code>{
    "sidebar_sb_article": "QL Bài Viết",
    "sidebar_sb_user": "QL Thành Viên",
    "nav_nav_logout": "Đăng xuất"
}</code></pre>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6><i class="fas fa-file-code"></i> Export cả hai ngôn ngữ:</h6>
                                    <div class="bg-light p-3 rounded">
                                        <pre class="mb-0"><code>{
    "sidebar_sb_article": {
        "en": "Blog",
        "vi": "QL Bài Viết"
    },
    "sidebar_sb_user": {
        "en": "User",
        "vi": "QL Thành Viên"
    }
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Export Buttons -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-bolt"></i> Export nhanh
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn btn-success btn-block" onclick="quickExport('cms', 'en')">
                                        <i class="fas fa-download"></i><br>
                                        CMS - Tiếng Anh
                                    </button>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn btn-info btn-block" onclick="quickExport('cms', 'vi')">
                                        <i class="fas fa-download"></i><br>
                                        CMS - Tiếng Việt
                                    </button>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn btn-warning btn-block" onclick="quickExport('cms', 'both')">
                                        <i class="fas fa-download"></i><br>
                                        CMS - Cả hai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for export functionality -->
<script>
$(document).ready(function() {
    // Language selection handling
    $('#language').on('change', function() {
        const language = $(this).val();
        if (language === 'both') {
            $('#includeMetadata').val('1').prop('disabled', true);
        } else {
            $('#includeMetadata').prop('disabled', false);
        }
    });

    // Format selection handling
    $('#format').on('change', function() {
        const format = $(this).val();
        if (format === 'csv') {
            $('#includeMetadata').val('0').prop('disabled', true);
        } else {
            $('#includeMetadata').prop('disabled', false);
        }
    });
});

// Preview export data
function previewExport() {
    const module = $('#module').val();
    const language = $('#language').val();
    
    if (!module) {
        alert('Vui lòng chọn module trước!');
        $('#module').focus();
        return;
    }

    // Show loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tải...';
    btn.disabled = true;

    // Make AJAX request to preview
    $.get('<?= BASE_URL ?>backend/language/languagekeyword/ajaxSearch', {
        keyword: '',
        module: module,
        limit: 10
    })
    .done(function(response) {
        if (response.success && response.data.length > 0) {
            let preview = `Xem trước export cho module "${module}":\n\n`;
            
            response.data.forEach((item, index) => {
                preview += `${index + 1}. ${item.keyword}\n`;
                if (language === 'en' || language === 'both') {
                    preview += `   EN: ${item.en_translation}\n`;
                }
                if (language === 'vi' || language === 'both') {
                    preview += `   VI: ${item.vi_translation}\n`;
                }
                preview += '\n';
            });

            if (response.data.length >= 10) {
                preview += `... và còn ${response.data.length - 10} từ khóa khác`;
            }

            alert(preview);
        } else {
            alert('Không có dữ liệu để export cho module này!');
        }
    })
    .fail(function() {
        alert('Có lỗi xảy ra khi tải dữ liệu!');
    })
    .always(function() {
        // Restore button
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

// Quick export function
function quickExport(module, language) {
    if (confirm(`Bạn có muốn export từ khóa của module "${module}" với ngôn ngữ "${language}"?`)) {
        // Set form values and submit
        $('#module').val(module);
        $('#language').val(language);
        $('form').submit();
    }
}

// Download sample data
function downloadSample(module, language) {
    const sampleData = {
        'cms': {
            'en': {
                'sidebar_sb_article': 'Blog',
                'sidebar_sb_user': 'User',
                'nav_nav_logout': 'Logout'
            },
            'vi': {
                'sidebar_sb_article': 'QL Bài Viết',
                'sidebar_sb_user': 'QL Thành Viên',
                'nav_nav_logout': 'Đăng xuất'
            }
        }
    };

    if (sampleData[module] && sampleData[module][language]) {
        const dataStr = JSON.stringify(sampleData[module][language], null, 2);
        const dataBlob = new Blob([dataStr], {type: 'application/json'});
        
        const link = document.createElement('a');
        link.href = URL.createObjectURL(dataBlob);
        link.download = `${module}_${language}_sample.json`;
        link.click();
    } else {
        alert('Không có dữ liệu mẫu cho module và ngôn ngữ này!');
    }
}
</script>
<?= $this->endSection() ?>
