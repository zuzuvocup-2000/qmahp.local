<?= $this->extend('backend/dashboard/layout/default') ?>

<?= $this->section('title') ?>
    Import từ khóa đa ngữ
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Import từ khóa đa ngữ</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= BASE_URL ?>backend/language/languagekeyword/index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Import Instructions -->
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info-circle"></i> Hướng dẫn import</h5>
                        <p class="mb-0">
                            Import từ khóa đa ngữ từ file JSON hoặc nhập trực tiếp. Định dạng dữ liệu phải tuân theo cấu trúc chuẩn.
                        </p>
                    </div>

                    <!-- Import Methods Tabs -->
                    <ul class="nav nav-tabs" id="importTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="manual-tab" data-toggle="tab" href="#manual" role="tab">
                                <i class="fas fa-keyboard"></i> Nhập thủ công
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="file-tab" data-toggle="tab" href="#file" role="tab">
                                <i class="fas fa-file-upload"></i> Upload file
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="template-tab" data-toggle="tab" href="#template" role="tab">
                                <i class="fas fa-download"></i> Template
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="importTabsContent">
                        <!-- Manual Import Tab -->
                        <div class="tab-pane fade show active" id="manual" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-keyboard"></i> Nhập từ khóa thủ công
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?= BASE_URL ?>backend/language/languagekeyword/import">
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="keywords">Dữ liệu từ khóa (JSON) <span class="text-danger">*</span></label>
                                                    <textarea id="keywords" name="keywords" class="form-control" rows="10" 
                                                              placeholder='Nhập dữ liệu JSON theo định dạng:
{
    "keyword1": {
        "en": "English Text 1",
        "vi": "Văn bản tiếng Việt 1",
        "description": "Mô tả 1",
        "order": 1
    },
    "keyword2": {
        "en": "English Text 2",
        "vi": "Văn bản tiếng Việt 2",
        "description": "Mô tả 2",
        "order": 2
    }
}' required></textarea>
                                                    <small class="form-text text-muted">
                                                        Định dạng JSON với cấu trúc: keyword => {en, vi, description, order}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-upload"></i> Import từ khóa
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-lg ml-2" onclick="validateJSON()">
                                                <i class="fas fa-check"></i> Kiểm tra JSON
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- File Upload Tab -->
                        <div class="tab-pane fade" id="file" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-file-upload"></i> Upload file JSON
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?= BASE_URL ?>backend/language/languagekeyword/import" enctype="multipart/form-data">
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jsonFile">File JSON <span class="text-danger">*</span></label>
                                                    <input type="file" id="jsonFile" name="jsonFile" class="form-control-file" 
                                                           accept=".json" required>
                                                    <small class="form-text text-muted">
                                                        Chọn file JSON có định dạng chuẩn. Kích thước tối đa: 5MB
                                                    </small>
                                                </div>

                                                <div class="form-group">
                                                    <button type="button" class="btn btn-info btn-sm" onclick="previewFile()">
                                                        <i class="fas fa-eye"></i> Xem trước file
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-upload"></i> Upload và Import
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Template Tab -->
                        <div class="tab-pane fade" id="template" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-download"></i> Template và ví dụ
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-file-code"></i> Template JSON:</h6>
                                            <div class="bg-light p-3 rounded">
                                                <pre class="mb-0"><code>{
    "sidebar_sb_article": {
        "en": "Blog",
        "vi": "QL Bài Viết",
        "description": "Sidebar menu item for blog management",
        "order": 1
    },
    "sidebar_sb_user": {
        "en": "User",
        "vi": "QL Thành Viên",
        "description": "Sidebar menu item for user management",
        "order": 2
    }
}</code></pre>
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm mt-2" onclick="downloadTemplate()">
                                                <i class="fas fa-download"></i> Tải template
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-info-circle"></i> Cấu trúc dữ liệu:</h6>
                                            <ul class="list-unstyled">
                                                <li><strong>keyword:</strong> Từ khóa duy nhất</li>
                                                <li><strong>en:</strong> Bản dịch tiếng Anh</li>
                                                <li><strong>vi:</strong> Bản dịch tiếng Việt</li>
                                                <li><strong>description:</strong> Mô tả (tùy chọn)</li>
                                                <li><strong>order:</strong> Thứ tự (tùy chọn)</li>
                                            </ul>
                                            
                                            <h6 class="mt-3"><i class="fas fa-exclamation-triangle"></i> Lưu ý:</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-check text-success"></i> Từ khóa phải là duy nhất</li>
                                                <li><i class="fas fa-check text-success"></i> Bản dịch en và vi là bắt buộc</li>
                                                <li><i class="fas fa-check text-success"></i> Description và order là tùy chọn</li>
                                                <li><i class="fas fa-exclamation-triangle text-warning"></i> File phải có định dạng JSON hợp lệ</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Import History -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-history"></i> Lịch sử import
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center text-muted">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <p>Chức năng lịch sử import sẽ được phát triển trong phiên bản tiếp theo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for import functionality -->
<script>
$(document).ready(function() {
    // Module selection handling for manual import
    $('#module').on('change', function() {
        if ($(this).val() === 'new_module') {
            $('#newModuleGroup').show();
            $('#newModule').prop('required', true);
        } else {
            $('#newModuleGroup').hide();
            $('#newModule').prop('required', false);
        }
    });

    // Module selection handling for file import
    $('#fileModule').on('change', function() {
        if ($(this).val() === 'new_module') {
            $('#fileNewModuleGroup').show();
            $('#fileNewModule').prop('required', true);
        } else {
            $('#fileNewModuleGroup').hide();
            $('#fileNewModule').prop('required', false);
        }
    });

    // Form submission handling
    $('form').on('submit', function(e) {
        const module = $(this).find('select[name*="module"]').val();
        const keywords = $(this).find('textarea[name="keywords"]').val();
        const file = $(this).find('input[type="file"]').val();

        if (!module || module === 'new_module') {
            const newModule = $(this).find('input[name*="newModule"]').val();
            if (!newModule || !newModule.trim()) {
                alert('Vui lòng nhập tên module mới!');
                e.preventDefault();
                return false;
            }
        }

        if (!keywords && !file) {
            alert('Vui lòng nhập dữ liệu từ khóa hoặc chọn file!');
            e.preventDefault();
            return false;
        }

        // If new module, update the module field
        if (module === 'new_module') {
            const newModuleName = $(this).find('input[name*="newModule"]').val().trim();
            $(this).find('select[name*="module"]').append('<option value="' + newModuleName + '" selected>' + newModuleName + '</option>');
            $(this).find('select[name*="module"]').val(newModuleName);
        }
    });
});

// Validate JSON format
function validateJSON() {
    const jsonText = $('#keywords').val().trim();
    if (!jsonText) {
        alert('Vui lòng nhập dữ liệu JSON để kiểm tra!');
        return;
    }

    try {
        const parsed = JSON.parse(jsonText);
        let validCount = 0;
        let invalidCount = 0;

        for (const [keyword, data] of Object.entries(parsed)) {
            if (data.en && data.vi) {
                validCount++;
            } else {
                invalidCount++;
            }
        }

        alert(`Kiểm tra hoàn tất!\n\nTừ khóa hợp lệ: ${validCount}\nTừ khóa không hợp lệ: ${invalidCount}\n\nTổng: ${Object.keys(parsed).length} từ khóa`);
    } catch (e) {
        alert('JSON không hợp lệ!\n\nLỗi: ' + e.message);
    }
}

// Preview uploaded file
function previewFile() {
    const fileInput = document.getElementById('jsonFile');
    const file = fileInput.files[0];
    
    if (!file) {
        alert('Vui lòng chọn file trước!');
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        alert('File quá lớn! Kích thước tối đa là 5MB.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            const content = e.target.result;
            const parsed = JSON.parse(content);
            
            let preview = 'Nội dung file:\n\n';
            let count = 0;
            
            for (const [keyword, data] of Object.entries(parsed)) {
                if (count < 5) { // Show first 5 items
                    preview += `${keyword}:\n`;
                    preview += `  EN: ${data.en || 'N/A'}\n`;
                    preview += `  VI: ${data.vi || 'N/A'}\n`;
                    preview += `  Desc: ${data.description || 'N/A'}\n`;
                    preview += `  Order: ${data.order || 'N/A'}\n\n`;
                }
                count++;
            }
            
            if (count > 5) {
                preview += `... và ${count - 5} từ khóa khác`;
            }
            
            alert(preview);
        } catch (e) {
            alert('File không phải định dạng JSON hợp lệ!\n\nLỗi: ' + e.message);
        }
    };
    
    reader.readAsText(file);
}

// Download template
function downloadTemplate() {
    const template = {
        "sidebar_sb_article": {
            "en": "Blog",
            "vi": "QL Bài Viết",
            "description": "Sidebar menu item for blog management",
            "order": 1
        },
        "sidebar_sb_user": {
            "en": "User",
            "vi": "QL Thành Viên",
            "description": "Sidebar menu item for user management",
            "order": 2
        },
        "nav_nav_logout": {
            "en": "Logout",
            "vi": "Đăng xuất",
            "description": "Navigation logout button text",
            "order": 3
        }
    };

    const dataStr = JSON.stringify(template, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    
    const link = document.createElement('a');
    link.href = URL.createObjectURL(dataBlob);
    link.download = 'language_keywords_template.json';
    link.click();
}
</script>
<?= $this->endSection() ?>
