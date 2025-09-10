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
 <?php if(isset($panel['join-hand']) && is_array($panel['join-hand']) && count($panel['join-hand'])){ ?>
    <section id="activities" class="activities-section">
        <div class="uk-container uk-container-center">
            <div class="section-header">
                <h2 class="section-title"><?= $panel['join-hand']['title'] ?></h2>
                <p class="section-description"><?= $panel['join-hand']['description'] ?></p>
            </div>

            <div class="activities-grid">
                <?php foreach ($panel['join-hand']['data'] as $index => $activity): ?>
                <div class="activity-card">
                    <div class="activity-image">
                        <img src="<?= base_url($activity['image']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>" loading="lazy">
                        <div class="activity-badge">
                            <span class="date"><?= date('d/m/Y', strtotime($activity['created_at'])) ?></span>
                        </div>
                    </div>
                    <div class="activity-content">
                        <h3 class="activity-title"><?= $activity['title'] ?></h3>
                        <p class="activity-description">
                            <?= mb_strimwidth(strip_tags(base64_decode($activity['description'])), 0, 512, '...') ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php } ?>

<!-- Impact Statistics -->
<section class="impact-section">
    <div class="uk-container uk-container-center">
        <div class="impact-grid">
            <div class="impact-item">
                <div class="impact-number"><?= $general['banner_number_gift'] ?></div>
                <div class="impact-label"><?= $general['banner_label_gift'] ?></div>
            </div>
            <div class="impact-item">
                <div class="impact-number"><?= $general['banner_number_house'] ?></div>
                <div class="impact-label"><?= $general['banner_label_house'] ?></div>
            </div>
            <div class="impact-item">
                <div class="impact-number"><?= $general['banner_number_family'] ?></div>
                <div class="impact-label"><?= $general['banner_label_family'] ?></div>
            </div>
            <div class="impact-item">
                <div class="impact-number"><?= $general['banner_number_province'] ?></div>
                <div class="impact-label"><?= $general['banner_label_province'] ?></div>
            </div>
        </div>
    </div>
</section>

<!-- Donation Form Section -->
<section id="donation-form" class="donation-section">
    <div class="uk-container uk-container-center">
        <div class="donation-content">
            <div class="contact-info">
                <h3><?php echo $keywordList['about-happy'] ?></h3>
                <div class="info-content">
                    <p><?php echo $keywordList['about-description'] ?></p>
                    
                    <div class="info-highlights">
                        <div class="highlight-item">
                            <i class="icon-heart"></i>
                            <div>
                                <h4><?php echo $keywordList['about-goal'] ?></h4>
                                <p><?php echo $keywordList['about-goal-description'] ?></p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <i class="icon-handshake"></i>
                            <div>
                                <h4><?php echo $keywordList['about-commit'] ?></h4>
                                <p><?php echo $keywordList['about-commit-description'] ?></p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <i class="icon-community"></i>
                            <div>
                                <h4><?php echo $keywordList['about-vision'] ?></h4>
                                <p><?php echo $keywordList['about-vision-description'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <h3><?php echo $keywordList['contact-info'] ?></h3>
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
                <form class="donation-form" action="<?= base_url('chung-tay/submit-donation'.HTSUFFIX) ?>" method="post">
                    <h3><?php echo $keywordList['send-info'] ?></h3>
                    
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <?php 
                                $errors = session()->getFlashdata('errors');
                                if(is_array($errors)){
                                    foreach($errors as $error){
                                        echo $error;
                                    }
                                }else{
                                    echo $errors;
                                }
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $formData = session()->getFlashdata('form_data');
                    $fullname = $formData['fullname'] ?? '';
                    $email = $formData['email'] ?? '';
                    $phone = $formData['phone'] ?? '';
                    $message = $formData['message'] ?? '';
                    ?>

                    <div class="form-group">
                        <label for="fullname"><?php echo $keywordList['fullname'] ?> *</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" value="<?= htmlspecialchars($fullname) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone"><?php echo $keywordList['phone'] ?> *</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="message"><?php echo $keywordList['message'] ?></label>
                        <textarea id="message" name="message" class="form-control" rows="4" placeholder="<?php echo $keywordList['message-description'] ?>"><?= htmlspecialchars($message) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block"><?php echo $keywordList['send-info-btn'] ?></button>
                </form>
            </div>
        </div>

        <script>
        // Auto scroll to form when there are errors
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('errors') || session()->getFlashdata('success')): ?>
                // Scroll to form when there are validation errors
                const formElement = document.querySelector('.donation-form');
                if (formElement) {
                    // Add error highlight class
                    formElement.classList.add('error-highlight');
                    
                    // Scroll to form with smooth animation
                    formElement.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    
                    // Focus on first input field
                    const firstInput = formElement.querySelector('input[required]');
                    if (firstInput) {
                        setTimeout(function() {
                            firstInput.focus();
                        }, 500);
                    }
                    
                    // Remove highlight after 5 seconds
                    setTimeout(function() {
                        formElement.classList.remove('error-highlight');
                    }, 5000);
                }
            <?php endif; ?>
        });
        </script>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="uk-container uk-container-center">
        <div class="cta-content">
            <h2><?php echo $keywordList['thank-you'] ?></h2>
            <p><?php echo $keywordList['thank-you-description'] ?></p>
            <a href="#donation-form" class="btn btn-primary btn-lg"><?php echo $keywordList['join-hands-btn'] ?></a>
        </div>
    </div>
</section>

