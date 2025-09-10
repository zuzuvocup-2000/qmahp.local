<?php
$menuFooter = get_menu(array('keyword' => 'menu-footer','language' => $language, 'output' => 'array'));
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
    'order_by' => 'tb1.updated_at DESC',
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
                            <img src="<?php echo $general['homepage_logo_ft']; ?>" alt="<?php echo $general['homepage_company']; ?>" class="logo-img">
                        </div>
                        <h3 class="footer-title"><?php echo $keywordList['about-title']; ?></h3>
                        <p class="footer-description">
                            <?php echo $general['homepage_ft']; ?>
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
                        <h3 class="footer-title"><?php echo $keywordList['quick-links-title']; ?></h3>
                        <ul class="footer-links">
                            <?php foreach($menuFooter['data'] as $menu): ?>
                                <li><a href="<?php echo BASE_URL . $menu['canonical'].HTSUFFIX; ?>" class="footer-link"><?php echo $menu['title']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="uk-width-medium-1-4 uk-width-small-1-2">
                    <div class="footer-section">
                        <h3 class="footer-title"><?php echo $keywordList['recent-activities-title']; ?></h3>
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
                                <p class="no-activities"><?php echo $keywordList['recent-activities-no-activities']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="uk-width-medium-1-4 uk-width-small-1-2">
                    <div class="footer-section">
                        <h3 class="footer-title"><?php echo $keywordList['footer-contact-title']; ?></h3>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong><?php echo $keywordList['footer-contact-address']; ?></strong>
                                    <span><?php echo $general['contact_address']; ?></span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong><?php echo $keywordList['footer-contact-phone']; ?></strong>
                                    <span><?php echo $general['contact_phone']; ?></span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong>Hotline</strong>
                                    <span><?php echo $general['contact_hotline']; ?></span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <div class="contact-details">
                                    <strong>Email</strong>
                                    <span><?php echo $general['contact_email']; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Donation Call to Action -->
                        <div class="donation-cta">
                            <h4 class="cta-title"><?php echo $keywordList['donation-title']; ?></h4>
                            <p class="cta-description"><?php echo $keywordList['donation-description']; ?></p>
                            <a href="<?php echo $language == 'vi' ? BASE_URL . 'chung-tay'.HTSUFFIX : BASE_URL . 'en/join-hands'.HTSUFFIX; ?>" class="donate-btn">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <?php echo $keywordList['donation-button']; ?>
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
                    <p><?php echo $general['homepage_copyright']; ?></p>
                </div>
                <div class="footer-links-bottom">
                    <a href="/" class="footer-link-bottom">Điều Khoản</a>
                    <a href="/" class="footer-link-bottom">Chính Sách</a>
                    <a href="/" class="footer-link-bottom">Bảo Mật</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <div class="back-to-top" id="backToTop">
        <i class="fa fa-chevron-up" aria-hidden="true"></i>
    </div>
</footer>

