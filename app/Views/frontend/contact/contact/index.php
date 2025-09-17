<section class="contact-body">
    <!-- Header Section -->
    <div class="contact-header">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-width-large-1-2">
                <!-- Left side - Company info -->
                <div class="contact-info">
                    <p class="welcome-text"><?php echo $keywordList['contact-welcome'] ?></p>
                    <h1 class="company-title"><?php echo $general['homepage_company'] ?></h1>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fa fa-phone"></i>
                            <span>Phone: <?php echo $general['contact_phone'] ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-phone"></i>
                            <span>Hotline: <?php echo $general['contact_hotline'] ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-envelope"></i>
                            <span><?php echo $general['contact_email'] ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-home"></i>
                            <span><?php echo $general['contact_address'] ?></span>
                        </div>
                    </div>
                </div>
                <!-- Right side - Form invitation -->
                <div class="form-invitation">
                    <p><?php echo $keywordList['contact-description'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form Section -->
    <div class="contact-form-section">
        <div class="uk-container uk-container-center">
            <div class="wrap-contact">
                <div class="wrap-form uk-grid uk-grid-large">
                    <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2">
                        <div class="contact-map"><?php echo $general['contact_map'] ?></div> 
                    </div>
                    <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-2">
                        <div class="contact-form-wrapper">
                            <form action="frontend/contact/contact/index" method="post" class="uk-form form form-contact">
                                <div class="form-row">
                                    <input type="text" name="fullname" class="va-fullname-contact-2 uk-width-1-1 input-text" placeholder="<?php echo $keywordList['contact-fullname']; ?>" required>
                                </div>
                                <div class="form-row">
                                    <input type="email" name="email" class="va-email-contact-2 uk-width-1-1 input-text" placeholder="Email *" required>
                                </div>
                                <div class="form-row">
                                    <input type="tel" name="phone" class="va-phone-contact-2 uk-width-1-1 input-text" placeholder="<?php echo $keywordList['contact-phone']; ?>" required>
                                </div>
                                <div class="form-row">
                                    <input type="text" name="subject" class="va-title-contact-2 uk-width-1-1 input-text" placeholder="<?php echo $keywordList['contact-title']; ?>" required>
                                </div>
                                <div class="form-row">
                                    <textarea name="message" class="va-message-contact-2 uk-width-1-1 form-textarea" placeholder="<?php echo $keywordList['contact-content']; ?>" rows="5" required></textarea>
                                </div>
                                <div class="form-row">
                                    <input type="submit" name="create" class="btn-submit submit-form-contact-2" value="<?php echo $keywordList['contact-send']; ?>">
                                </div>
                                <div class="loader" style="display: none;">
                                    <div class="css-spinner clickable"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</section>