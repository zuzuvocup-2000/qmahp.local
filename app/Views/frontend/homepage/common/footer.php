<?php
$model = new App\Models\AutoloadModel();



// Get recent activities
$recentActivities = $model->_get_where([
    'select' => 'tb2.title, tb2.canonical, tb1.image, tb1.created_at',
    'table' => 'article as tb1',
    'join' => [
        ['article_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "article" AND tb2.language = \''.$language.'\' ', 'inner']
    ],  
    'where' => [
        'tb1.deleted_at' => 0,
        'tb1.publish' => 1,
    ],
    'order_by' => 'tb1.created_at DESC',
    'limit' => 3
], true);

?>

<footer class="charity-footer">
    <!-- Main Footer Content -->
    <div class="footer-main">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-match" data-uk-grid-margin>
                <!-- Organization Info -->
                <div class="uk-width-medium-1-4 uk-width-small-1-2">
                    <div class="footer-section">
                        <div class="footer-logo">
                            <img src="<?php echo $general['homepage_logo']; ?>" alt="Charity Organization Logo" class="logo-img">
                        </div>
                        <h3 class="footer-title">Về Tổ Chức</h3>
                        <p class="footer-description">
                            Chúng tôi cam kết mang đến những giá trị tích cực cho cộng đồng thông qua các hoạt động thiện nguyện, 
                            hỗ trợ những người có hoàn cảnh khó khăn và xây dựng một xã hội tốt đẹp hơn.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link facebook" title="Facebook">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="social-link twitter" title="Twitter">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="social-link instagram" title="Instagram">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="social-link youtube" title="YouTube">
                                <i class="fa fa-youtube" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="uk-width-medium-1-4 uk-width-small-1-2">
                    <div class="footer-section">
                        <h3 class="footer-title">Liên Kết Nhanh</h3>
                        <ul class="footer-links">
                            <li><a href="<?php echo BASE_URL; ?>" class="footer-link">Trang Chủ</a></li>
                            <li><a href="<?php echo BASE_URL; ?>gioi-thieu" class="footer-link">Giới Thiệu</a></li>
                            <li><a href="<?php echo BASE_URL; ?>hoat-dong" class="footer-link">Hoạt Động</a></li>
                            <li><a href="<?php echo BASE_URL; ?>du-an" class="footer-link">Dự Án</a></li>
                            <li><a href="<?php echo BASE_URL; ?>tin-tuc" class="footer-link">Tin Tức</a></li>
                            <li><a href="<?php echo BASE_URL; ?>chung-tay" class="footer-link">Chung Tay</a></li>
                            <li><a href="<?php echo BASE_URL; ?>lien-he" class="footer-link">Liên Hệ</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="uk-width-medium-1-4 uk-width-small-1-2">
                    <div class="footer-section">
                        <h3 class="footer-title">Hoạt Động Gần Đây</h3>
                        <div class="recent-activities">
                            <?php if(isset($recentActivities) && is_array($recentActivities)): ?>
                                <?php foreach($recentActivities as $activity): ?>
                                    <div class="activity-item">
                                        <div class="activity-image">
                                            <img src="<?php echo $activity['image']; ?>" alt="<?php echo $activity['title']; ?>">
                                        </div>
                                        <div class="activity-content">
                                            <h4 class="activity-title">
                                                <a href="<?php echo BASE_URL . $activity['canonical'].HTSUFFIX; ?>" class="activity-link">
                                                    <?php echo $activity['title']; ?>
                                                </a>
                                            </h4>
                                            <span class="activity-date">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo date('d/m/Y', strtotime($activity['created_at'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="no-activities">Chưa có hoạt động nào</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="uk-width-medium-1-4 uk-width-small-1-2">
                    <div class="footer-section">
                        <h3 class="footer-title">Thông Tin Liên Hệ</h3>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong>Địa chỉ:</strong>
                                    <span>123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong>Điện thoại:</strong>
                                    <span>+84 123 456 789</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong>Email:</strong>
                                    <span>info@charity.org.vn</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong>Giờ làm việc:</strong>
                                    <span>Thứ 2 - Thứ 6: 8:00 - 17:00</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Donation Call to Action -->
                        <div class="donation-cta">
                            <h4 class="cta-title">Chung Tay Vì Cộng Đồng</h4>
                            <p class="cta-description">Mỗi đóng góp của bạn đều có ý nghĩa</p>
                            <a href="<?php echo BASE_URL; ?>chung-tay" class="donate-btn">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                Quyên Góp Ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> Tổ Chức Thiện Nguyện. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="footer-links-bottom">
                    <a href="<?php echo BASE_URL; ?>dieu-khoan" class="footer-link-bottom">Điều Khoản</a>
                    <a href="<?php echo BASE_URL; ?>chinh-sach" class="footer-link-bottom">Chính Sách</a>
                    <a href="<?php echo BASE_URL; ?>bao-mat" class="footer-link-bottom">Bảo Mật</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <div class="back-to-top" id="backToTop">
        <i class="fa fa-chevron-up" aria-hidden="true"></i>
    </div>
</footer>

