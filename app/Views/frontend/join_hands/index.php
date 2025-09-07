<?php
    $joinHandsBanner = get_slide(['keyword' => 'chung-tay-banner', 'language' => $language]);
?>
<link rel="stylesheet" href="<?= base_url('public/frontend/css/join-hands.css?v=' . time()) ?>">
<!-- Hero Section -->
<section class="chung-tay-hero" style="background-image: url('<?= base_url(isset($joinHandsBanner[0]['image']) ? $joinHandsBanner[0]['image'] : '') ?>');">
    <div class="uk-container uk-container-center">
        <div class="hero-content">
            <h1 class="hero-title"><?= $joinHandsBanner[0]['title'] ?></h1>
            <h2 class="hero-subtitle"><?= $joinHandsBanner[0]['description'] ?></h2>
            <p class="hero-description">"<?= $joinHandsBanner[0]['content'] ?>"</p>
            <div class="hero-actions">
                <a href="#donation-form" class="btn btn-primary btn-lg"><?php echo $keywordList['donate-now'] ?></a>
                <a href="#activities" class="btn btn-outline btn-lg"><?php echo $keywordList['view-activities'] ?></a>
            </div>
        </div>
    </div>
    <div class="hero-overlay"></div>
</section>

<!-- Activities Section -->
<section id="activities" class="activities-section">
    <div class="uk-container uk-container-center">
        <div class="section-header">
            <h2 class="section-title">Hoạt động gần đây</h2>
            <p class="section-description">Những hoạt động thiện nguyện ý nghĩa của chúng tôi</p>
        </div>

        <div class="activities-grid">
            <?php foreach ($activities as $index => $activity): ?>
            <div class="activity-card">
                <div class="activity-image">
                    <img src="<?= base_url($activity['image']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>" loading="lazy">
                    <div class="activity-badge">
                        <span class="date"><?= $activity['date'] ?></span>
                    </div>
                </div>
                <div class="activity-content">
                    <h3 class="activity-title"><?= $activity['title'] ?></h3>
                    <p class="activity-location">
                        <i class="icon-location"></i>
                        <?= $activity['location'] ?>
                    </p>
                    <p class="activity-description"><?= $activity['description'] ?></p>
                    <div class="activity-footer">
                        <span class="activity-amount"><?= $activity['amount'] ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Impact Statistics -->
<section class="impact-section">
    <div class="uk-container uk-container-center">
        <div class="impact-grid">
            <div class="impact-item">
                <div class="impact-number">500+</div>
                <div class="impact-label">Chăn ấm đã trao</div>
            </div>
            <div class="impact-item">
                <div class="impact-number">50+</div>
                <div class="impact-label">Căn nhà đã xây</div>
            </div>
            <div class="impact-item">
                <div class="impact-number">1000+</div>
                <div class="impact-label">Gia đình được hỗ trợ</div>
            </div>
            <div class="impact-item">
                <div class="impact-number">20+</div>
                <div class="impact-label">Tỉnh thành</div>
            </div>
        </div>
    </div>
</section>

<!-- Donation Form Section -->
<section id="donation-form" class="donation-section">
    <div class="uk-container uk-container-center">
        <div class="donation-content">
            <div class="contact-info">
                <h3>Về Quỹ Mái Ấm Hạnh Phúc</h3>
                <div class="info-content">
                    <p>Quỹ Mái Ấm Hạnh Phúc được thành lập với mục tiêu hỗ trợ những hoàn cảnh khó khăn, mang đến mái ấm và hạnh phúc cho những người cần giúp đỡ.</p>
                    
                    <div class="info-highlights">
                        <div class="highlight-item">
                            <i class="icon-heart"></i>
                            <div>
                                <h4>Mục tiêu</h4>
                                <p>Xây dựng mái ấm cho những gia đình có hoàn cảnh khó khăn</p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <i class="icon-handshake"></i>
                            <div>
                                <h4>Cam kết</h4>
                                <p>Minh bạch trong mọi hoạt động và sử dụng đúng mục đích</p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <i class="icon-community"></i>
                            <div>
                                <h4>Tầm nhìn</h4>
                                <p>Lan tỏa yêu thương và tạo nên cộng đồng nhân ái</p>
                            </div>
                        </div>
                    </div>
                </div>
                <h3>Thông tin liên hệ</h3>
                <div class="contact-item">
                    <i class="icon-location"></i>
                    <div>
                        <p><?= $contact_info['address1'] ?></p>
                        <p><?= $contact_info['address2'] ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="icon-phone"></i>
                    <div>
                        <p><?= $contact_info['phone1'] ?></p>
                        <p><?= $contact_info['phone2'] ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="icon-email"></i>
                    <p><?= $contact_info['email'] ?></p>
                </div>
            </div>

            <div class="donation-form-wrapper">
                <form class="donation-form" action="<?= base_url('chung-tay/submit-donation') ?>" method="post">
                    <h3>Gửi thông tin đóng góp</h3>
                    
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="fullname">Họ và tên *</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại *</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Thông tin hoàn cảnh cần hỗ trợ</label>
                        <textarea id="message" name="message" class="form-control" rows="4" placeholder="Mô tả chi tiết về hoàn cảnh cần hỗ trợ..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Gửi thông tin</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="uk-container uk-container-center">
        <div class="cta-content">
            <h2>QUỸ MÁI ẤM HẠNH PHÚC XIN CẢM ƠN</h2>
            <p>NHỮNG TẤM LÒNG CÙNG ĐỒNG HÀNH CÙNG CHÚNG TÔI TRÊN CON ĐƯỜNG ƯỚC MƠ, HÀNH ĐỘNG VÀ KIẾN TẠO SỰ THAY ĐỔI!</p>
            <a href="#donation-form" class="btn btn-primary btn-lg">Chung tay ngay</a>
        </div>
    </div>
</section>

