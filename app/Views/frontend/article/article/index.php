<section class="bg-banner-top-new uk-position-relative bg-general" style="background-image: url(<?php echo $detailCatalogue['image'] ?>);">
    <div class="wrap-breadcum">
        <h2 class="heading-2 heading-cat-title">
            <?php echo $detailCatalogue['title'] ?>
        </h2>
        <ul class="uk-breadcrumb">
            <li>
                <a href="#" title=" Trang chủ"><i class="fa fa-home"></i> Trang chủ</a>
            </li>
            <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                foreach ($breadcrumb as $value) {
             ?>
                <li class=""><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
            <?php }} ?>
        </ul>
    </div>
</section>
<section id="body">
    <div id="article-page" class="page-body">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-3-4">
                    <section class="art-detail">
                        <section class="panel-body mb50">
                            <h1 class="main-title"><?php echo $object['title'] ?></h1>
                            <div class="description">
                                <?php echo $object['description'] ?>
                            </div>
                            <article class="article detail-content">
                                <?php echo $object['content'] ?>
                            </article>
                        </section>
                        <?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){ ?>
                            <div class="panel-view-more">
                                <div class="view-more">Xem thêm:</div>
                                <ul class="list-article-relate">
                                    <?php foreach ($articleRelate as $value) { ?>
                                        <li>
                                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <!-- Comment Section -->
                        <div class="comment-section">
                            <h3 class="comment-title">Bình luận</h3>
                            
                            <div class="comment-list">
                                <?php if(isset($commentList) && is_array($commentList) && count($commentList)){ 
                                    foreach($commentList as $comment){ 
                                ?>
                                <div class="comment-item">
                                    <div class="comment-header">
                                        <div class="comment-author">
                                            <strong><?php echo $comment['fullname'] ?></strong>
                                            <span class="comment-date"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])) ?></span>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <?php echo strip_tags(base64_decode($comment['comment'])) ?>
                                    </div>
                                </div>
                                <?php }} else { ?>
                                <div class="comment-item">
                                    <div class="comment-content">
                                        <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            
                            <!-- Comment Pagination -->
                            <?php if(isset($commentPagination) && !empty($commentPagination)){ ?>
                            <div class="comment-pagination">
                                <?php echo $commentPagination ?>
                            </div>
                            <?php } ?>

                            <div class="comment-form-wrapper">
                                <form id="commentForm" class="comment-form">
                                    <div class="form-group">
                                        <label for="commentName">Họ và tên <span class="required">*</span></label>
                                        <input type="text" id="commentName" name="name" class="form-control minh-fullname-comment">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="commentEmail">Email <span class="required">*</span></label>
                                        <input type="email" id="commentEmail" name="email" class="form-control minh-email-comment">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="commentPhone">Số điện thoại <span class="required">*</span></label>
                                        <input type="tel" id="commentPhone" name="phone" class="form-control minh-phone-comment">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="commentContent">Bình luận <span class="required">*</span></label>
                                        <textarea id="commentContent" name="content" class="form-control minh-content-comment" rows="5" placeholder="Nhập bình luận của bạn..."></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="button" name="create" class="btn-submit submit-form-comment">Gửi bình luận</button>
                                    </div>

                                    <div class="loader" style="display: none;">
                                        <div class="css-spinner clickable"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="uk-width-large-1-4">
                    <?php echo view('frontend/homepage/common/aside') ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Comment Section Styles */
.comment-section {
    margin-top: 40px;
    padding: 30px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.comment-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid #007bff;
}

/* Comment Form Styles */
.comment-form-wrapper {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.comment-form .form-group {
    margin-bottom: 20px;
}

.comment-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.comment-form .required {
    color: #dc3545;
}

.comment-form .form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.comment-form .form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.comment-form textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.btn-submit {
    background: #007bff;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background: #0056b3;
}

.btn-submit:disabled {
    background: #6c757d;
    cursor: not-allowed;
}

/* Comment List Styles */
.comment-list {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.comment-item {
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-header {
    margin-bottom: 10px;
}

.comment-author {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.comment-author strong {
    color: #333;
    font-size: 16px;
}

.comment-date {
    color: #6c757d;
    font-size: 14px;
}

.comment-content {
    color: #555;
    line-height: 1.6;
    font-size: 15px;
}

/* Loader Styles */
.loader {
    text-align: center;
    margin-top: 15px;
}

/* Comment Pagination Styles */
.comment-pagination {
    margin: 20px 0;
    text-align: center;
}

.comment-pagination .pagination {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.comment-pagination .pagination li {
    margin: 0 2px;
}

.comment-pagination .pagination li a,
.comment-pagination .pagination li span {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #333;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.comment-pagination .pagination li a:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.comment-pagination .pagination li.active span {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.comment-pagination .pagination li.disabled span {
    color: #6c757d;
    background: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
    .comment-section {
        padding: 20px;
        margin-top: 20px;
    }
    
    .comment-form-wrapper {
        padding: 20px;
    }
    
    .comment-author {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .comment-date {
        margin-top: 5px;
    }
}
</style>

<script>
var currentUrl = window.location.href;
var urlParts = currentUrl.split('/');
var lastPart = urlParts[urlParts.length - 1];
var url = lastPart.replace('.html', '')
</script>
