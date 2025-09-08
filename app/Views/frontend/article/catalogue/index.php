<!-- Hero Section -->
<section class="hero-section" style="background-image: url(<?php echo !empty($detailCatalogue['image']) ? $detailCatalogue['image'] : '/public/frontend/resources/images/hero-bg.jpg' ?>);">
    <div class="hero-overlay"></div>
    <div class="uk-container uk-container-center">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo $detailCatalogue['title'] ?></h1>
            <p class="hero-subtitle"><?php echo strip_tags(base64_decode($detailCatalogue['description'])) ?></p>
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
            <!-- Left Column - Categories -->
            <div class="categories-sidebar">
                <div class="categories-title">Danh mục</div>
                <div class="categories-list">
                    <!-- Main Categories -->
                    <?php if(isset($child) && is_array($child) && count($child)){ 
                        foreach($child as $cat){ 
                    ?>
                    <div class="category-item">
                        <a href="<?php echo $cat['canonical'].HTSUFFIX ?>" class="category-link">
                            <i class="fa fa-chevron-down"></i>
                            <?php echo $cat['title'] ?>
                        </a>
                        <div class="category-date"><?php echo date('d/m/y', strtotime($cat['created_at'])) ?></div>
                    </div>
                    <?php }} ?>
                    
                    <!-- Year Categories -->
                    <div class="year-categories">
                        <div class="year-item">
                            <a href="#" class="year-link">
                                <i class="fa fa-chevron-down"></i>
                                2021
                            </a>
                        </div>
                        <div class="year-item">
                            <a href="#" class="year-link">
                                <i class="fa fa-chevron-right"></i>
                                2023
                            </a>
                        </div>
                        <div class="year-item">
                            <a href="#" class="year-link">
                                <i class="fa fa-chevron-right"></i>
                                2024
                            </a>
                        </div>
                        <div class="year-item">
                            <a href="#" class="year-link">
                                <i class="fa fa-chevron-right"></i>
                                2025
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Articles -->
            <div class="articles-main">
                <div class="articles-list">
                    <?php if(isset($articleList) && is_array($articleList) && count($articleList)){
                        foreach ($articleList as $value) {
                    ?>
                    <article class="article-item">
                        <div class="article-image">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                <img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" />
                            </a>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                    <?php echo $value['title'] ?>
                                </a>
                            </h3>
                            <div class="article-description">
                                <?php echo strip_tags(base64_decode($value['description'])) ?>
                            </div>
                            <div class="article-date">
                                <?php echo date('d/m/y', strtotime($value['created_at'])) ?>
                            </div>
                        </div>
                    </article>
                    <?php }} else { ?>
                    <div class="no-articles">
                        <div class="no-articles-icon">
                            <i class="fa fa-newspaper-o"></i>
                        </div>
                        <h3>Chưa có bài viết nào</h3>
                        <p>Hiện tại chưa có bài viết nào trong danh mục này.</p>
                    </div>
                    <?php } ?>
                </div>

                <!-- Pagination -->
                <?php if(isset($pagination) && !empty($pagination)){ ?>
                <div class="pagination-wrapper">
                    <?php echo $pagination ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>