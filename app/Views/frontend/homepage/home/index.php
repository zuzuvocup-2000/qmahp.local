<?php
    $model = new App\Models\AutoloadModel();
?>
<div id="homepage" class="page-body">
    <?php echo  view('frontend/homepage/common/slide'); ?>
    <?php if(isset($listProduct) && is_array($listProduct)  && count($listProduct)){ ?>
        <section class="ht2109_panel" id="menu">
            <div class="uk-container uk-container-center">
                <div class="panel-head uk-text-center">
                    <h2 class="heading-1 mb15"><span><?php echo $panel['layout-2']['title'] ?></span></h2>
                    <div class="subtitle"><?php echo $panel['layout-2']['description'] ?></div>
                </div>
                <div class="panel-body">
                    <section class="mobile-hp-topprd hp-panel">
                        <div class="uk-container uk-container-center">
                            <?php /*
                            <header class="panel-head">
                                <div class="uk-overflow-container">
                                    <ul class="uk-list uk-clearfix uk-flex uk-flex-middle nav-tabs" data-uk-switcher="{connect:'#hp-prd-1',animation: 'uk-animation-fade, uk-animation-slide-left', swiping: true }">
                                    <?php foreach ($valCat['post'] as $keyChild => $valChild) {?>
                                        <li aria-expanded="true" class="<?php echo ($keyChild == 0)? 'uk-active':'' ?>"><a href="#menu" title="<?php echo $valChild['title'] ?>"><?php echo $valChild['title'] ?></a></li>
                                    <?php } ?>
                                   </ul>
                               </div>
                            </header>
                            */ ?>
                            <section class="panel-body">
                            <ul id="hp-prd-1" class="uk-switcher">
                                <?php foreach ($listProduct as $keyChild => $valChild) {?>
                                <li>
                                    <?php if(isset($valChild['post']) && is_array($valChild['post'])  && count($valChild['post'])){ ?>
                                    <ul class="uk-list uk-clearfix list-art">
                                        <?php foreach ($valChild['post'] as $keyPost => $valPost) {?>
                                        <?php        
                                            $title = $valPost['title'];
                                            // $href = rewrite_url($valPost['canonical'], true, false);
                                            $image = $valPost['image'];
                                            // $description = $valPost['description'];
                                            $description = cutnchar(strip_tags(base64_decode($valPost['description'])), 150);

                                            $price = $valPost['price'];
                                        ?>
                                        <li>
                                           <article class="uk-clearfix article-1">
                                                <div class="thumb"><a href="#popup_image" data-uk-modal class="image img-cover dt_popup_image"
                                                    data-caption="<?php echo $valPost['description'] ?>"
                                                    data-url="<?php echo $valPost['landing_link'] ?>"
                                                    ><img src="<?php echo $image ?>" alt="<?php echo $title ?>"></a></div>
                                                <div class="info">
                                                    <h3 class="title">
                                                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                            <a href="#" title="<?php echo $title ?>" class="line-2"><?php echo $title ?></a>
                                                            <div class="price"><?php echo CURRENCY.$price ?></div>
                                                        </div>
                                                    </h3>
                                                    <div class="description line-3"></div>
                                                </div>
                                            </article>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                    <div class="panel-foot">
                                        <div class="image img-cover">
                                            <img src="<?php echo $valChild['image'] ?>" alt="">
                                        </div>
                                        <?php if (isset($valChild['landing_link']) && !empty($valChild['landing_link'])): ?>
                                            <div class="uk-flex uk-flex-center">
                                                <a target="_blank" href="<?php echo $valChild['landing_link'] ?>" class="dt_btn_viewmore">Viewmore</a>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                            </section>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    <?php } ?>
</div>
