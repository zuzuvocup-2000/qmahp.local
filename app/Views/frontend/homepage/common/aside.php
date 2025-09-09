<div class="side-content">
    <?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){ ?>
        <div class="related-articles-aside mb40">
            <header class="main-side-header">
                <div class="heading uk-flex uk-flex-middle">
                    <img src="public/news_aside.png" alt="related" class="mr10">
                    Bài viết liên quan
                </div>
            </header>
            <div class="panel-body">
                <?php foreach ($articleRelate as $value) { ?>
                    <div class="related-news-item">
                        <div class="item-pic">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover">
                                <img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>">
                            </a>
                        </div>
                        <div class="product-title mb15">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                <?php echo $value['title'] ?>
                            </a>
                        </div>
                        <div class="date">
                            <?php echo date('d/m/Y', strtotime($value['created_at'])) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>