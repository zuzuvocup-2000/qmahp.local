<?php
    $aboutUs = get_slide(['keyword' => 'about-us', 'language' => $language]);
    $aboutQuy = get_slide(['keyword' => 'about-quy', 'language' => $language]);
    $gallery = get_slide(['keyword' => 'gallery', 'language' => $language]);
    $model = new App\Models\AutoloadModel();
?>
<div id="homepage" class="page-body">
    <?php echo view('frontend/homepage/common/slide'); ?>
    <?php if(isset($aboutUs) && is_array($aboutUs) && count($aboutUs)){ ?>
        <section class="about-us-section">
            <div class="about-us-background" style="background-image: url('<?php echo $aboutUs[0]['image']; ?>');">
                <div class="about-us-overlay"></div>
            </div>
            <div class="uk-container uk-container-center">
                <div class="about-us-content-wrapper">
                    <div class="about-us-header">
                        <h2 class="about-us-title">
                            <?php echo $aboutUs[0]['cat_title']; ?>
                        </h2>
                        <div class="about-us-subtitle">
                            <?php echo $aboutUs[0]['cat_description']; ?>
                        </div>
                        <div class="about-us-divider"></div>
                    </div>
                    <div class="about-us-description">
                        <?php echo $aboutUs[0]['description']; ?>
                        <br>
                        <br>
                        <?php echo $aboutUs[0]['content']; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
    
    <?php if(isset($aboutQuy) && is_array($aboutQuy) && count($aboutQuy)){ ?>
        <section class="about-quy-section">
            <div class="uk-container uk-container-center">
                <div class="about-quy-header">
                    <h2 class="about-quy-title">
                        <?php echo $aboutQuy[0]['cat_title']; ?>
                    </h2>
                </div>
                <div class="about-quy-content">
                    <div class="uk-grid uk-grid-match" data-uk-grid>
                        <?php 
                            for ($i = 0; $i < 3; $i++) {
                                if (isset($aboutQuy[$i]) && is_array($aboutQuy[$i]) && count($aboutQuy[$i]) > 0) {
                                    $item = $aboutQuy[$i];
                                    $tag = explode(' – ', $item['alt']);
                                    if (isset($tag[0]) && trim($tag[0]) === '') {
                                        array_shift($tag);
                                    }
                        ?>
                        <div class="uk-width-1-1 uk-width-medium-1-3">
                            <div class="about-quy-card">
                                <div class="about-quy-card-image">
                                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" />
                                </div>
                                <div class="about-quy-card-content">
                                    <h3 class="about-quy-card-title"><?php echo $item['title']; ?></h3>
                                    <?php if(isset($tag) && is_array($tag) && count($tag) > 0){ ?>
                                    <div class="about-quy-card-values">
                                        <?php foreach($tag as $value){ ?>
                                            <span class="value-item"><?php echo $value; ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                    <div class="about-quy-card-description">
                                        <?php echo $item['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                                }
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php if(isset($album) && is_array($album) && count($album)){ ?>
        <section class="album-section">
            <div class="uk-container uk-container-center">
                <div class="album-header">
                    <h2 class="album-title">
                        <?php echo $album[0]['cat_title']; ?>
                    </h2>
                </div>
            </div>
        </section>
    <?php } ?>
    <?php if(isset($gallery) && is_array($gallery) && count($gallery)){ ?>
    <section class="gallery-wrap">
        <div class="uk-container uk-container-center">
            <div class="gallery-header uk-text-center mb30">
                <h2 class="about-quy-title"><?php echo $gallery[0]['cat_title']; ?></h2>
            </div>
            <div class="gallery-content">
                <div class="grid grid-cols-3 auto-rows-[minmax(0,1fr)] gap-2 xs:gap-4 [grid-auto-flow:dense]">
                    <?php 
                    $pattern = [
                        ['col' =>
                    2, 'row' => 1], ['col' => 1, 'row' => 2], ['col' => 1, 'row' => 1], ['col' => 1, 'row' => 1], ['col' => 1, 'row' => 2], ['col' => 2, 'row' => 1], ['col' => 1, 'row' => 1], ['col' => 1, 'row' => 1], ]; foreach ($gallery as $i
                    => $image) { $layout = $pattern[$i % 8]; $col = (int)$layout['col']; $row = (int)$layout['row']; ?>
                    <div class="col-span-<?php echo $col; ?> row-span-<?php echo $row; ?>">
                        <a class="img-cover block h-full" href="<?php echo base_url($image['image']); ?>" data-lightbox="gallery">
                            <img class="w-full h-full object-cover" src="<?php echo base_url($image['image']); ?>" alt="<?php echo !empty($image['title']) ? $image['title'] : $image['cat_title']; ?>" />
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <?php if(isset($panel['field']) && is_array($panel['field']) && count($panel['field'])){ ?>
    <section class="service-section">
        <div class="uk-container uk-container-center">
            <div class="service-header uk-text-center mb30">
                <h2 class="about-quy-title">
                    <?php echo $panel['field']['title']; ?>
                </h2>
            </div>
            <div class="service-content">
                <?php foreach($panel['field']['data'] as $key => $val){ ?>
                <div class="uk-grid uk-grid-medium <?php echo $key % 2 == 0 ? 'uk-flex-row-reverse' : ''; ?>">
                    <div class="uk-width-small-1-1 uk-width-medium-2-5">
                        <div class="thumb">
                            <a href="" class="img-cover">
                                <img src="<?php echo base_url($val['image']); ?>" alt="<?php echo $val['title']; ?>" />
                            </a>
                        </div>
                    </div>
                    <div class="uk-width-small-1-1 uk-width-medium-3-5">
                        <div class="content">
                            <h3 class="title"><span><?php echo $val['title']; ?></span></h3>
                            <h4 class="sub-title"><span><?php echo base64_decode($val['description']); ?></span></h4>
                            <div class="description">
                                <?php echo base64_decode($val['content']); ?>
                            </div>
                           <ul class="uk-list uk-clearfix">
                            <?php if(isset($val['post']) && is_array($val['post']) && count($val['post'])){ ?>
                            <?php foreach($val['post'] as $keyChild => $valChild){ ?>
                                <li>
                                    <a href="<?php echo base_url($valChild['canonical'].HTSUFFIX); ?>">
                                        <?php echo $valChild['title']; ?>
                                    </a>
                                </li>
                            <?php }} ?>
                           </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>  
</div>
