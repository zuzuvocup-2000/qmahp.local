<!-- Include CSS file -->
<link rel="stylesheet" href="<?php echo BASE_URL ?>public/frontend/resources/css/article-index.css">

<!-- Hero Section -->
<section class="hero-section" style="background-image: url(<?php echo !empty($detailCatalogue['image']) ? $detailCatalogue['image'] : '/public/frontend/resources/images/hero-bg.jpg' ?>);">
    <div class="hero-overlay"></div>
    <div class="uk-container uk-container-center">
        <div class="hero-content">
            <h1 class="hero-title text-white"><?php echo $object['title'] ?></h1>
            <nav class="breadcrumb">
                <a href="<?php echo BASE_URL ?>" class="breadcrumb-item">
                    <i class="fa fa-home"></i> Trang chủ
                </a>
                <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                    foreach ($breadcrumb as $value) {
                 ?>
                    <span class="breadcrumb-separator">/</span>
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="breadcrumb-item"><?php echo $value['title'] ?></a>
                <?php }} ?>
            </nav>
        </div>
    </div>
</section>
<!-- Main Content -->
<section class="main-content">
    <div class="uk-container uk-container-center">
        <div class="content-wrapper">
            <div class="article-wrap">
                <div class="article-main">
                    <article class="article-detail">
                        <div class="article-header">
                            <h1 class="article-title"><?php echo $object['title'] ?></h1>
                            <div class="article-meta">
                                <span class="article-date">
                                    <i class="fa fa-calendar"></i>
                                    <?php echo date('d/m/Y', strtotime($object['created_at'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="article-description">
                            <?php echo $object['description'] ?>
                        </div>
                        
                        <div class="article-content">
                            <?php echo $object['content'] ?>
                        </div>
                    </article>
                </div>
                <div class="article-relate">
                    <!-- Comment Section -->
                    <div class="comment-section">
                        <h3 class="comment-title">
                            <i class="fa fa-comments"></i>
                            Bình luận
                        </h3>
                                
                        <div class="comment-list">
                            <?php if(isset($commentList) && is_array($commentList) && count($commentList)){ 
                                foreach($commentList as $comment){ 
                            ?>
                            <div class="comment-item" data-comment-id="<?php echo $comment['id']; ?>">
                                <div class="comment-header">
                                    <div class="comment-author">
                                        <strong<?php echo (isset($auth['id']) && $comment['fullname'] == $auth['fullname']) ? ' class="admin"' : ''; ?>><?php echo $comment['fullname'] ?></strong>
                                        <span class="comment-date"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])) ?></span>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <?php echo strip_tags(base64_decode($comment['comment'])) ?>
                                </div>
                                <div class="comment-actions">
                                    <button type="button" class="btn-reply" data-comment-id="<?php echo $comment['id']; ?>">
                                        <i class="fa fa-reply"></i> Trả lời
                                    </button>
                                </div>
                                
                                <!-- Reply form (hidden by default) -->
                                <div class="reply-form-wrapper" id="reply-form-<?php echo $comment['id']; ?>" style="display: none;">
                                    <form class="reply-form" data-parent-id="<?php echo $comment['id']; ?>">
                                        <?php if(isset($auth['id']) && !empty($auth['id'])): ?>
                                            <input type="hidden" class="minh-fullname-reply" value="<?php echo htmlspecialchars($auth['fullname'] ?? ''); ?>">
                                            <input type="hidden" class="minh-email-reply" value="<?php echo htmlspecialchars($auth['email'] ?? ''); ?>">
                                            <input type="hidden" class="minh-phone-reply" value="">
                                        <?php else: ?>
                                            <div class="form-group">
                                                <label>Họ và tên <span class="required">*</span></label>
                                                <input type="text" class="form-control minh-fullname-reply">
                                            </div>
                                            <div class="form-group">
                                                <label>Email <span class="required">*</span></label>
                                                <input type="email" class="form-control minh-email-reply">
                                            </div>
                                            <div class="form-group">
                                                <label>Số điện thoại <span class="required">*</span></label>
                                                <input type="tel" class="form-control minh-phone-reply">
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label>Nội dung trả lời <span class="required">*</span></label>
                                            <textarea class="form-control minh-content-reply" rows="3" placeholder="Nhập nội dung trả lời..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn-submit submit-form-reply">Gửi trả lời</button>
                                            <button type="button" class="btn-cancel-reply">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Display replies for this comment -->
                                <?php if(isset($replyList[$comment['id']]) && is_array($replyList[$comment['id']]) && count($replyList[$comment['id']])): ?>
                                    <div class="replies-list">
                                        <?php foreach($replyList[$comment['id']] as $reply): ?>
                                            <div class="reply-item">
                                                <div class="reply-header">
                                                    <div class="reply-author">
                                                        <strong<?php echo (isset($auth['id']) && $reply['fullname'] == $auth['fullname']) ? ' class="admin"' : ''; ?>><?php echo $reply['fullname'] ?></strong>
                                                        <span class="reply-date"><?php echo date('d/m/Y H:i', strtotime($reply['created_at'])) ?></span>
                                                    </div>
                                                </div>
                                                <div class="reply-content">
                                                    <?php echo strip_tags(base64_decode($reply['comment'])) ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
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
                                <?php if(isset($auth['id']) && !empty($auth['id'])): ?>
                                    <input type="hidden" class="minh-fullname-comment" value="<?php echo htmlspecialchars($auth['fullname'] ?? ''); ?>">
                                    <input type="hidden" class="minh-email-comment" value="<?php echo htmlspecialchars($auth['email'] ?? ''); ?>">
                                    <input type="hidden" class="minh-phone-comment" value="">
                                    
                                    <div class="form-group">
                                        <label>Bình luận với tư cách quản trị viên: <strong><?php echo htmlspecialchars($auth['fullname'] ?? ''); ?></strong></label>
                                    </div>
                                <?php else: ?>
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
                                <?php endif; ?>
                                
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
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="article-sidebar">
                <?php echo view('frontend/homepage/common/aside') ?>
            </div>
        </div>
    </div>
</section>

<script>
var currentUrl = window.location.href;
var urlParts = currentUrl.split('/');
var lastPart = urlParts[urlParts.length - 1];
var url = lastPart.replace('.html', '')
</script>
