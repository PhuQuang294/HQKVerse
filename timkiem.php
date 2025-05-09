<?php
if (isset($_POST['search_button'])) {

	$tukhoa = $_POST['search_product'];


	$sql_product = mysqli_query($con, "SELECT * FROM tbl_sanpham WHERE sanpham_name LIKE '%$tukhoa%' ORDER BY sanpham_id DESC");

	$title = $tukhoa;
}
?>
<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Từ khóa tìm kiếm : <?php echo $title ?></h3>
		<!-- //tittle heading -->
		<div class="row">
			<!-- product left -->
			<div class="agileinfo-ads-display col-lg-9">
				<div class="wrapper">
					<!-- first section -->
					<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
						<div class="row">
							<?php
							while ($row_sanpham = mysqli_fetch_array($sql_product)) {
							?>
								<div class="col-md-4 product-men mt-5">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item text-center">
											<img src="images/<?php echo $row_sanpham['sanpham_image'] ?>" alt="">
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="?quanly=chitietsp&id=<?php echo $row_sanpham['sanpham_id'] ?>" class="link-product-add-cart">Xem sản phẩm</a>
												</div>
											</div>
										</div>
										<div class="item-info-product text-center border-top mt-4">
											<h4 class="pt-1">
												<a href="?quanly=chitietsp&id=<?php echo $row_sanpham['sanpham_id'] ?>"><?php echo $row_sanpham['sanpham_name'] ?></a>
											</h4>
											<div class="info-product-price my-2">
												<span class="item_price"><?php echo number_format($row_sanpham['sanpham_giakhuyenmai']) . 'vnđ' ?></span>
												<del><?php echo number_format($row_sanpham['sanpham_gia']) . 'vnđ' ?></del>
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form onsubmit="addToCart(event, this)" method="post">
													<fieldset>
														<input type="hidden" name="tensanpham" value="<?php echo $row_sanpham['sanpham_name'] ?>" />
														<input type="hidden" name="sanpham_id" value="<?php echo $row_sanpham['sanpham_id'] ?>" />
														<input type="hidden" name="giasanpham" value="<?php echo $row_sanpham['sanpham_giakhuyenmai'] ?>" />
														<input type="hidden" name="hinhanh" value="<?php echo $row_sanpham['sanpham_image'] ?>" />
														<input type="hidden" name="soluong" value="1" />
														<input type="submit" value="Thêm giỏ hàng" class="button" />
													</fieldset>
												</form>
											</div>
										</div>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
					<!-- //first section -->
				</div>
			</div>
			<!-- //product left -->
			<!-- product right -->
			<div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
				<div class="side-bar p-sm-4 p-3">
					<div class="search-hotel border-bottom py-2">
						<h3 class="agileits-sear-head mb-3">Brand</h3>
						<form action="#" method="post">
							<input type="search" placeholder="Search Brand..." name="search" required="">
							<input type="submit" value=" ">
						</form>
						<div class="left-side py-2">
							<ul>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span"></span>
								</li>
							</ul>
						</div>
					</div>
					<!-- ram -->
					<div class="left-side border-bottom py-2">
						<h3 class="agileits-sear-head mb-3"></h3>
						<ul>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span"></span>
							</li>
						</ul>
					</div>
					<!-- //ram -->
					<!-- price -->
					<div class="range border-bottom py-2">
						<h3 class="agileits-sear-head mb-3">Price</h3>
						<div class="w3l-range">
							<ul>
								<li>
									<a href="#">Under $1,000</a>
								</li>
								<li class="my-1">
									<a href="#">$1,000 - $5,000</a>
								</li>
								<li>
									<a href="#">$5,000 - $10,000</a>
								</li>
								<li class="my-1">
									<a href="#">$10,000 - $20,000</a>
								</li>
								<li>
									<a href="#">$20,000 $30,000</a>
								</li>
								<li class="mt-1">
									<a href="#">Over $30,000</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- //price -->
					<!-- discounts -->
					<div class="left-side border-bottom py-2">
						<h3 class="agileits-sear-head mb-3">Discount</h3>
						<ul>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">5% or More</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">10% or More</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">20% or More</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">30% or More</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">50% or More</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">60% or More</span>
							</li>
						</ul>
					</div>
					<!-- //discounts -->
					<!-- offers -->
					<div class="left-side border-bottom py-2">
						<h3 class="agileits-sear-head mb-3">Offers</h3>
						<ul>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">Exchange Offer</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">No Cost EMI</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">Special Price</span>
							</li>
						</ul>
					</div>
					<!-- //offers -->
					<!-- delivery -->
					<div class="left-side border-bottom py-2">
						<h3 class="agileits-sear-head mb-3">Cash On Delivery</h3>
						<ul>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">Eligible for Cash On Delivery</span>
							</li>
						</ul>
					</div>
					<!-- //delivery -->
					<!-- arrivals -->
					<div class="left-side border-bottom py-2">
						<h3 class="agileits-sear-head mb-3">New Arrivals</h3>
						<ul>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">Last 30 days</span>
							</li>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">Last 90 days</span>
							</li>
						</ul>
					</div>
					<div class="left-side py-2">
						<h3 class="agileits-sear-head mb-3">Availability</h3>
						<ul>
							<li>
								<input type="checkbox" class="checked">
								<span class="span">Exclude Out of Stock</span>
							</li>
						</ul>
					</div>
					<!-- //arrivals -->
				</div>
				<!-- //product right -->
			</div>
		</div>
	</div>
</div>
<!-- //top products -->
<script>
	function addToCart(event, form) {
		event.preventDefault();
		const formData = new FormData(form);
		formData.append('ajax_add_to_cart', true);

		fetch('include/giohang.php', {
				method: 'POST',
				body: formData
			})
			.then(response => response.text())
			.then(cartCount => {
				updateCartCount(cartCount);
				alert('Sản phẩm đã được thêm vào giỏ hàng!');
			})
			.catch(error => console.error('Error:', error));
	}

	function updateCartCount(count) {
		document.getElementById('cart-count').textContent = count;
	}
</script>