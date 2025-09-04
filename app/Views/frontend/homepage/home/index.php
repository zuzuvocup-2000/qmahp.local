<?php
    $aboutUs = get_slide(['keyword' => 'about-us', 'language' => $language]);
    $aboutQuy = get_slide(['keyword' => 'about-quy', 'language' => $language]);
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
    
</div>
