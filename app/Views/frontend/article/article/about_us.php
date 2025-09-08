<!-- Banner Section -->
<section class="bg-banner-top-new uk-position-relative bg-general" style="background-image: url('<?php echo $detailCatalogue['image'] ?>');">
    <div class="wrap-breadcum">
        <h2 class="heading-2 heading-cat-title text_white">
            <?php echo $detailCatalogue['title'] ?>
        </h2>
        <ul class="uk-breadcrumb">
            <li>
                <a href="<?php echo $language === 'vi' ? BASE_URL : BASE_URL_LANG ?>" title="<?php echo $language === 'vi' ? 'Trang chủ' : 'Home' ?>"><i class="fa fa-home"></i> <?php echo $language === 'vi' ? 'Trang chủ' : 'Home' ?></a>
            </li>
            <li><span><?php echo $detailCatalogue['title'] ?></span></li>
        </ul>
    </div>
</section>

<!-- Main Content Section -->
<section class="pt50 pb50">
    <div id="about-page" class="page-body">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <!-- Sidebar Navigation -->
                <div class="uk-width-large-1-4">
                    <div class="about-sidebar">
                        <div class="sidebar-panel">
                            <div class="panel-body">
                                <?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){ ?>
                                <ul class="about-nav uk-list">
                                    <?php foreach ($articleRelate as $key => $value) { ?>
                                        <li class="about-nav-item <?php echo $value['id'] == $object['id'] ? 'active' : '' ?>" data-section="<?php echo $value['id'] ?>">
                                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="about-nav-link">
                                                <?php echo $value['title'] ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="uk-width-large-3-4">
                    <div class="about-content">
                        <!-- Vision Section -->
                        <section id="vision" class="about-section active">
                            <div class="section-header">
                                <h2 class="section-title"><?php echo $object['title'] ?></h2>
                                <div class="section-divider"></div>
                            </div>
                            <div class="section-content">
                                <div class="content-wrapper">
                                    <div class="vision-text">
                                        <?php echo $object['description'] ?>
                                        <?php echo $object['content'] ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

