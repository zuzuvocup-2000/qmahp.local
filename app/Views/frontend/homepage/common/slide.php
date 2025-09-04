<?php $slide = get_slide(['keyword' => 'main-slide' , 'language' => $language ]); ?>
<?php if(isset($slide) && is_array($slide) && count($slide)){ ?>
<section class="main-slide">
    <div class="uk-slidenav-position slide-show" data-uk-slideshow="{autoplay: true, autoplayInterval: 7500, animation: 'swipe'}">
        <ul class="uk-slideshow">
            <?php foreach($slide as $key => $val) {
                $title = $val['title'];
                $href = $val['canonical'].HTSUFFIX;
                $image = $val['image'];
                $description = cutnchar(strip_tags($val['description']), 250);
            ?>
				<li>
					<div class="slide-content">
						<div class="image img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></div>
                        <div class="overlay-slide uk-position-relative">
                            <div class="uk-width-large-3-5 uk-container-center uk-position-relative" style="width: 100%; height: 100%;">	
                                <div class="slide_title">
                                    <h1 class="heading-1 target animated"><?php echo $title ?></h1>
                                    <p class="description target animated"><?php echo $description ?></p>
                                </div>
                            </div>
                        </div>
					</div>
                </li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php } ?>

<script>
	$(document).ready(function() {
		var target = $('.target');
		var target_title = $('.uk-slideshow .overlay-slide .heading-1');
		var target_description = $('.uk-slideshow .overlay-slide .description');
		var animate_1 = 'slideInDown';
		var animate_2 = 'slideInLeft';

		// Initialize first slide
		setTimeout(function() {
			target.removeClass('hide');
			target_title.addClass(animate_1);
			target_description.addClass(animate_2);
		}, 100);

		UIkit.on('beforeshow.uk.slideshow', function(){
			target.addClass('hide');
			target_title.removeClass(animate_1);
			target_description.removeClass(animate_2);
		});

		UIkit.on('show.uk.slideshow', function(){
			setTimeout(function() {
				target.removeClass('hide');
				target_title.addClass(animate_1);
				target_description.addClass(animate_2);
			}, 300);
		});
	});
</script>