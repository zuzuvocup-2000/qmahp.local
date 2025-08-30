<div class="page-wrapper">
	<!-- End Header -->
	<main class="main">
		<div class="page-content">
			<main class="main account">
				<nav class="breadcrumb-nav">
					<div class="container">
						<ul class="breadcrumb">
							<li><a href="/"><i class="d-icon-home"></i></a></li>
							<li>Hồ sơ</li>
						</ul>
					</div>
				</nav>
				<div class="page-content mt-4 mb-10 pb-6">
					<div class="container">
						<h2 class="title title-center mb-10">Tài khoản của tôi</h2>
						<div class="tab tab-vertical gutter-lg">
							<ul class="nav nav-tabs mb-4 col-lg-3 col-md-4" role="tablist">
								<li class="nav-item">
									<a class="active" href="thong-tin-chi-tiet.html">Tổng quan</a>
								</li>
								<li class="nav-item">
									<a class="" href="don-hang-cua-toi.html">Đơn hàng</a>
								</li>
								<li class="nav-item">
									<a class="" href="tai-khoan.html">Thông tin tài khoản</a>
								</li>
								<li class="nav-item">
									<a class=" button-logouts"  href="logout.html">Đăng xuất</a>
								</li>
							</ul>
							<div class="tab-content col-lg-9 col-md-8">
								<div class="tab-pane active" id="dashboard">
									<p class="mb-0">
										Xin chào <span><?php echo $user['fullname'] ?></span> (không phải <span><?php echo $user['fullname'] ?></span>?
										<a class="button-logouts text-primary" href="logout.html">Đăng xuất</a>)
									</p>
									<p class="mb-8">
										Từ trang tổng quan tài khoản, bạn có thể xem các đơn đặt hàng gần đây , quản lý địa chỉ giao hàng và thanh toán
										cũng như chỉnh sửa mật khẩu và chi tiết tài khoản của mình.
									</p>
									<a href="/" class="btn btn-dark btn-rounded">Mua hàng<i class="d-icon-arrow-right"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</main>
</div>