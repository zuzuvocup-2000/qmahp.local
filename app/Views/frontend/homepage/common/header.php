<?php
$model = new App\Models\AutoloadModel();
$currentDay = date('Y-m-d H:i:s');
$currentDayStart = $currentDay . ' 00:00:00';
$currentDayEnd = $currentDay . ' 23:59:59';

$languageList = $model->_get_where([
	'select' => 'title, image',
	'table' => 'language',
	'where' => [
		'deleted_at' => 0
	],
], true);

?>
<div class="wrap-header-pc">
	<div class="uk-container uk-container-center pt10 pb10">
		<div class="uk-flex uk-flex-right">
			<div class="language-list uk-flex uk-flex-middle">
				<a href="<?php echo BASE_URL ?>"   class="uk-flex uk-flex-middle">
					<img src="/upload/image/language/vn.png" alt="Vietnamese">
					<span>VN</span>
				</a>
				<a href="<?php echo BASE_URL_LANG ?>"   class="uk-flex uk-flex-middle">
					<img src="/upload/image/language/anh.png" alt="English">
					<span>EN</span>
				</a>
			</div>
		</div>
	</div>
	<header class="pc-header uk-visible-large" data-uk-sticky>
		<div class="hd-menu-search top-search bg-theme" style="display: none;">
			<div class="uk-container uk-container-center">
				<form action="" method="get" class="uk-form form">
					<div class="uk-flex uk-flex-middle">
						<button type="submit" name="" value="" class="btn-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
						<div class="form-row">
							<input type="text" name="keyword" class="uk-width-1-1 input-text" placeholder="Type & hit enter..." />
						</div>
						<a class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
				</form>
			</div>
		</div>
		<section class="upper">
			<div class="uk-container uk-container-2 uk-container-center">
				<div class="uk-flex uk-flex-middle uk-flex-space-between">
					<?php echo logo(); ?>
					<div class="uk-flex uk-flex-middle">
						<?php echo view('frontend/homepage/common/navigation') ?>
						 <div class="hd-btn">
							 <a href="chung-tay" title="" class=""><?php echo $keywordList['hd_chung_tay']; ?></a>
						 </div>
						 <div class="hd-menu-search ml20">
							<a class="open-search icon no-hover" title="Tìm kiếm"><i class="fa fa-search" aria-hidden="true"></i></a>
							<div class="dropdown-search">
								<form action="" method="get" class="uk-form form">
									<input type="text" name="keyword" class="uk-width-1-1 input-text" placeholder="Nhập nội dung tìm kiếm?" />
									<button type="submit" name="" value="" class="btn-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> <!-- .upper -->
	</header>
</div>
<header class="mobile-header uk-hidden-large" data-uk-sticky>
	<div class="hd-menu-search top-search bg-theme" style="display: none;">
		<div class="uk-container uk-container-center">
			<form action="" method="get" class="uk-form form">
				<div class="uk-flex uk-flex-middle">
					<button type="submit" name="" value="" class="btn-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
					<div class="form-row">
						<input type="text" name="keyword" class="uk-width-1-1 input-text" placeholder="Type & hit enter..." />
					</div>
					<a class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></a>
				</div>
			</form>
		</div>
	</div>
	<section class="upper">
		<div class="uk-flex uk-flex-middle uk-flex-space-between">
			<div class="logo"><a href="" title="Logo"><img src="<?php echo $general['homepage_logo']; ?>" alt="Logo" /></a></div>
			<div class="mb_toolbox uk-flex uk-flex-middle">
				
				<div class="hd-btn chungtay-btn">
					<a href="chung-tay" title="" class="m0 uk-text-center" style="padding: 9px 5px;font-size: 16px;">Chung tay</a>
				</div>
				<div class="hd-menu-search">
					<a class="open-search icon no-hover" title="Tìm kiếm"><i class="fa fa-search" aria-hidden="true"></i></a>
				</div>
				<?php echo view('frontend/homepage/common/offcanvas') ?>
			</div>
		</div>
	</section><!-- .upper -->
</header><!-- .mobile-header -->







