<?php
    $model = new App\Models\AutoloadModel();
    $articleByCatalogue = $model->_get_where([
        'select'   => 'tb1.id, tb2.title, tb1.image, tb2.canonical, tb2.description, tb1.created_at', // <-- thêm tb1.id
        'where'    => [
            'tb1.deleted_at' => 0,
            'tb1.publish'    => 1,
            'tb1.level'      => 2,
            'tb1.parentid'   => $detailCatalogue['parentid'],
        ],
        'table'    => 'article_catalogue as tb1',
        'join'     => [
            [
                'article_translate as tb2',
                'tb2.module = "article_catalogue" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'',
                'inner'
            ]
        ],
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.created_at desc'
    ], true);
    
    if (!empty($articleByCatalogue) && is_array($articleByCatalogue)) {
        foreach ($articleByCatalogue as $key => $val) {
            $catId = (int) $val['id'];
    
            $articleByCatalogue[$key]['post'] = $model->_get_where([
                'select' => 'tb1.id, tb2.title, tb1.image, tb2.canonical, tb1.created_at',
                'table'  => 'article as tb1',
                'join'   => [
                    [
                        'article_translate as tb2',
                        'tb2.objectid = tb1.id AND tb2.module = "article" AND tb2.language = \''.$language.'\'',
                        'inner'
                    ],
                ],
                'where'  => [
                    'tb1.publish'     => 1,
                    'tb1.deleted_at'  => 0,
                    'tb1.catalogueid' => $catId,
                ],
                'order_by' => 'tb1.created_at DESC',
                'limit' => '5',
            ], true);
        }
    }

    $articleListByYear = [];

    $news = $model->_get_where([
        'select' => 'tb1.id, tb2.title, tb1.image, tb2.canonical, tb1.created_at',
        'table'  => 'article as tb1',
        'join'   => [
            [
                'article_translate as tb2',
                'tb2.objectid = tb1.id AND tb2.module = "article" AND tb2.language = \''.$language.'\'',
                'inner'
            ],
        ],
        'where'  => [
            'tb1.publish'     => 1,
            'tb1.deleted_at'  => 0,
        ],
        'order_by' => 'tb1.created_at DESC',
    ], true);

    if (!empty($news) && is_array($news)) {
        foreach ($news as $new) {
            $year = date('Y', strtotime($new['created_at']));
    
            if (!isset($articleListByYear[$year])) {
                $articleListByYear[$year] = [];
            }
    
            $articleListByYear[$year][] = $new;
        }
    
        ksort($articleListByYear);
    }
?>
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
                    <?php if(isset($articleByCatalogue) && is_array($articleByCatalogue) && count($articleByCatalogue)){ 
                        foreach($articleByCatalogue as $key => $val){ 
                    ?>
                    <div class="category-item">
                        <div class="uk-flex uk-flex-space-between">
                            <a href="<?php echo $val['canonical'].HTSUFFIX ?>" class="category-link">
                                <?php echo $val['title'] ?>
                                <div class="category-date"><?php echo date('d/m/y', strtotime($val['created_at'])) ?></div>
                            </a>
                            <?php if(isset($val['post']) && is_array($val['post']) && count($val['post'])){ ?>
                            <div class="btn-more" data-toggle="submenu-<?php echo $key ?>">
                                <i class="fa fa-chevron-down"></i>
                            </div>
                            <?php } ?>
                        </div>
                        <?php if(isset($val['post']) && is_array($val['post']) && count($val['post'])){ ?>
                        <ul class="uk-list uk-clearfix mt10 submenu" id="submenu-<?php echo $key ?>" style="display: none;">
                            <?php foreach($val['post'] as $keyPost => $valPost){  ?>
                            <li class="uk-flex uk-flex-space-between">
                                <a href="<?php echo $valPost['canonical'].HTSUFFIX ?>"><?php echo $valPost['title'] ?></a>
                                <div class="category-date"><?php echo date('d/m/y', strtotime($valPost['created_at'])) ?></div>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                    <?php }} ?>
                </div>
                <div class="categories-title">Tin tức theo năm</div>
                <div class="categories-list">
                    <!-- Year Categories -->
                    <?php if(isset($articleListByYear) && is_array($articleListByYear) && count($articleListByYear)){ 
                        $firstYear = true;
                        foreach($articleListByYear as $year => $articles){ 
                    ?>
                    <div class="category-item">
                        <div class="uk-flex uk-flex-space-between">
                            <a href="#" class="category-link">
                                <?php echo $year ?>
                                <div class="category-date"><?php echo count($articles) ?> bài viết</div>
                            </a>
                            <div class="btn-more" data-toggle="year-<?php echo $year ?>">
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>
                        <ul class="uk-list uk-clearfix mt10 submenu" id="year-<?php echo $year ?>" style="display: none;">
                            <?php foreach($articles as $article){  ?>
                            <li class="uk-flex uk-flex-space-between">
                                <a href="<?php echo $article['canonical'].HTSUFFIX ?>"><?php echo $article['title'] ?></a>
                                <div class="category-date"><?php echo date('d/m/y', strtotime($article['created_at'])) ?></div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php 
                        $firstYear = false;
                        } 
                    } else { 
                    ?>
                    <div class="category-item">
                        <div class="uk-flex uk-flex-space-between">
                            <span class="category-link">Chưa có bài viết</span>
                        </div>
                    </div>
                    <?php } ?>
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

<style>
.submenu {
    overflow: hidden;
}

.btn-more {
    cursor: pointer;
}

.fa-chevron-down {
    transition: transform 0.3s ease-in-out;
}

.fa-chevron-down.rotate{
    transform: rotate(-180deg);
}
</style>

<script>
$(document).ready(function() {
    // Handle toggle for both categories and years
    $('.btn-more').on('click', function(e) {
        e.preventDefault();
        
        var $caret = $(this).find('.fa-chevron-down');
        var $dropdown = $(this).closest('.category-item').find('.submenu');
        
        // Toggle caret rotation
        $caret.toggleClass('rotate');
        
        // Toggle submenu with smooth animation
        $dropdown.slideToggle(300);
    });
});
</script>