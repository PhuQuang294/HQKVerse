<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// Ensure database connection is included
if (!isset($con)) {
	include_once('../db/connect.php');
}

if (isset($_POST['themgiohang'])) {
	$tensanpham = $_POST['tensanpham'];
	$sanpham_id = $_POST['sanpham_id'];
	$hinhanh = $_POST['hinhanh'];
	$gia = $_POST['giasanpham'];
	$soluong = $_POST['soluong'];
	$sql_select_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
	$count = mysqli_num_rows($sql_select_giohang);
	if ($count > 0) {
		$row_sanpham = mysqli_fetch_array($sql_select_giohang);
		$soluong = $row_sanpham['soluong'] + 1;
		$sql_giohang = "UPDATE tbl_giohang SET soluong='$soluong' WHERE sanpham_id='$sanpham_id'";
	} else {
		$sql_giohang = "INSERT INTO tbl_giohang (tensanpham, sanpham_id, giasanpham, hinhanh, soluong) 
                    VALUES ('" . mysqli_real_escape_string($con, $tensanpham) . "', 
                            '" . mysqli_real_escape_string($con, $sanpham_id) . "', 
                            '" . mysqli_real_escape_string($con, $gia) . "', 
                            '" . mysqli_real_escape_string($con, $hinhanh) . "', 
                            '" . mysqli_real_escape_string($con, $soluong) . "')";
	}
	$insert_row = mysqli_query($con, $sql_giohang);
	// if($insert_row==0){
	//  header('Location:index.php?quanly=chitietsp&id='.$sanpham_id);    
	// }

} elseif (isset($_POST['capnhatsoluong'])) {

	if (isset($_POST['product_id']) && is_array($_POST['product_id'])) {
		for ($i = 0; $i < count($_POST['product_id']); $i++) {
			$sanpham_id = $_POST['product_id'][$i];
			$soluong = $_POST['soluong'][$i];
			if ($soluong <= 0) {
				$sql_delete = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
			} else {
				$sql_update = mysqli_query($con, "UPDATE tbl_giohang SET soluong='$soluong' WHERE sanpham_id='$sanpham_id'");
			}
		}
	}
} elseif (isset($_GET['xoa'])) {
	$id = $_GET['xoa'];
	$sql_delete = mysqli_query($con, "DELETE FROM tbl_giohang WHERE giohang_id='$id'");
} elseif (isset($_GET['dangxuat'])) {
	$id = $_GET['dangxuat'];
	if ($id == 1) {
		unset($_SESSION['dangnhap_home']);
	}
} elseif (isset($_POST['thanhtoan'])) {
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$note = $_POST['note'];
	$address = $_POST['address'];
	$giaohang = $_POST['giaohang'];

	$sql_khachhang = mysqli_query($con, "INSERT INTO tbl_khachhang(name,phone,email,address,note,giaohang,password) values ('$name','$phone','$email','$address','$note','$giaohang','$password')");
	if ($sql_khachhang) {
		$sql_select_khachhang = mysqli_query($con, "SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
		$mahang = rand(0, 9999);
		$row_khachhang = mysqli_fetch_array($sql_select_khachhang);
		$khachhang_id = $row_khachhang['khachhang_id'];
		$_SESSION['dangnhap_home'] = $row_khachhang['name'];
		$_SESSION['khachhang_id'] = $khachhang_id;
		for ($i = 0; $i < count($_POST['thanhtoan_product_id']); $i++) {
			$sanpham_id = $_POST['thanhtoan_product_id'][$i];
			$soluong = $_POST['thanhtoan_soluong'][$i];
			$sql_donhang = mysqli_query($con, "INSERT INTO tbl_donhang(sanpham_id,khachhang_id,soluong,mahang) values ('$sanpham_id','$khachhang_id','$soluong','$mahang')");
			$sql_giaodich = mysqli_query($con, "INSERT INTO tbl_giaodich(sanpham_id,soluong,magiaodich,khachhang_id) values ('$sanpham_id','$soluong','$mahang','$khachhang_id')");
			$sql_delete_thanhtoan = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
		}
	}
} elseif (isset($_POST['thanhtoandangnhap'])) {

	$khachhang_id = $_SESSION['khachhang_id'];
	$mahang = rand(0, 9999);
	for ($i = 0; $i < count($_POST['thanhtoan_product_id']); $i++) {
		$sanpham_id = $_POST['thanhtoan_product_id'][$i];
		$soluong = $_POST['thanhtoan_soluong'][$i];
		$sql_donhang = mysqli_query($con, "INSERT INTO tbl_donhang(sanpham_id,khachhang_id,soluong,mahang) values ('$sanpham_id','$khachhang_id','$soluong','$mahang')");
		$sql_giaodich = mysqli_query($con, "INSERT INTO tbl_giaodich(sanpham_id,soluong,magiaodich,khachhang_id,payment_method) values ('$sanpham_id','$soluong','$mahang','$khachhang_id','COD')");
		$sql_delete_thanhtoan = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
	}
	header("Location: index.php?quanly=camon");
	exit;
}

if (isset($_POST['ajax_add_to_cart'])) {
	$tensanpham = $_POST['tensanpham'];
	$sanpham_id = $_POST['sanpham_id'];
	$hinhanh = $_POST['hinhanh'];
	$gia = $_POST['giasanpham'];
	$soluong = $_POST['soluong'];

	$sql_select_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
	$count = mysqli_num_rows($sql_select_giohang);
	if ($count > 0) {
		$row_sanpham = mysqli_fetch_array($sql_select_giohang);
		$soluong = $row_sanpham['soluong'] + $soluong; // Increment by the submitted quantity
		$sql_giohang = "UPDATE tbl_giohang SET soluong='$soluong' WHERE sanpham_id='$sanpham_id'";
	} else {
		$sql_giohang = "INSERT INTO tbl_giohang (tensanpham, sanpham_id, giasanpham, hinhanh, soluong) 
                        VALUES ('" . mysqli_real_escape_string($con, $tensanpham) . "', 
                                '" . mysqli_real_escape_string($con, $sanpham_id) . "', 
                                '" . mysqli_real_escape_string($con, $gia) . "', 
                                '" . mysqli_real_escape_string($con, $hinhanh) . "', 
                                '" . mysqli_real_escape_string($con, $soluong) . "')";
	}
	mysqli_query($con, $sql_giohang);

	// Return updated cart count
	$sql_cart_count = mysqli_query($con, "SELECT SUM(soluong) AS total_items FROM tbl_giohang");
	$row_cart_count = mysqli_fetch_array($sql_cart_count);
	$total_items = $row_cart_count['total_items'] ? $row_cart_count['total_items'] : 0;

	echo $total_items; // Return only the total count
	exit;
}
?>

<!-- checkout page -->
<div class="privacy py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			Giỏ hàng của bạn
		</h3>
		<?php
		if (isset($_SESSION['dangnhap_home'])) {
			echo '<p style="color:#000;">Xin chào bạn: ' . $_SESSION['dangnhap_home'] . '<a href="index.php?quanly=giohang&dangxuat=1">Đăng xuất</a></p>';
		} else {
			echo '';
		}
		?>

		<!-- //tittle heading -->
		<div class="checkout-right">
			<?php
			$sql_lay_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");

			?>

			<div class="table-responsive">
				<form action="" method="POST">

					<table class="timetable_sub">
						<thead>
							<tr>
								<th>Thứ tự</th>
								<th>Sản phẩm</th>
								<th>Số lượng</th>
								<th>Tên sản phẩm</th>

								<th>Giá</th>
								<th>Giá tổng</th>
								<th>Quản lý</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$total = 0;
							$total_items = 0;
							while ($row_fetch_giohang = mysqli_fetch_array($sql_lay_giohang)) {
								$price = floatval($row_fetch_giohang['giasanpham']); // Ensure numeric value
								$subtotal = $row_fetch_giohang['soluong'] * $price;
								$total += $subtotal;
								$total_items += $row_fetch_giohang['soluong']; // Count total items
								$i++;
							?>
								<tr class="rem1">
									<td class="invert"><?php echo $i ?></td>
									<td class="invert-image">
										<a href="single.html">
											<img src="images/<?php echo $row_fetch_giohang['hinhanh'] ?>" alt=" " height="120" class="img-responsive">
										</a>
									</td>
									<td class="invert">
										<input type="hidden" name="product_id[]" value="<?php echo $row_fetch_giohang['sanpham_id'] ?>">
										<input type="number" min="1" name="soluong[]" value="<?php echo $row_fetch_giohang['soluong'] ?>">


									</td>
									<td class="invert"><?php echo $row_fetch_giohang['tensanpham'] ?></td>
									<td class="invert"><?php echo number_format($price) . ' vnđ'; ?></td>
									<td class="invert"><?php echo number_format($subtotal) . ' vnđ'; ?></td>
									<td class="invert">
										<a href="?quanly=giohang&xoa=<?php echo $row_fetch_giohang['giohang_id'] ?>">Xóa</a>
									</td>
								</tr>
							<?php
							}
							?>
							<tr>
								<td colspan="7">Tổng tiền : <?php echo number_format($total) . ' vnđ'; ?></td>

							</tr>
							<tr>
								<td colspan="7"><input type="submit" class="btn btn-success" value="Cập nhật giỏ hàng" name="capnhatsoluong">
									<?php
									$sql_giohang_select = mysqli_query($con, "SELECT * FROM tbl_giohang");
									$count_giohang_select = mysqli_num_rows($sql_giohang_select);

									if (isset($_SESSION['dangnhap_home']) && $count_giohang_select > 0) {
										while ($row_1 = mysqli_fetch_array($sql_giohang_select)) {
									?>

											<input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_1['sanpham_id'] ?>">
											<input type="hidden" name="thanhtoan_soluong[]" value="<?php echo $row_1['soluong'] ?>">
										<?php
										}
										?>
										<input type="submit" class="btn btn-primary" value="Thanh toán giỏ hàng" name="thanhtoandangnhap">
				</form>

				<form method="POST" action="include/thanhtoanmomo.php" class="mt-2">

					<input type="hidden" name="tongtien" value="<?php echo $total; ?>">

					<input type="submit" class="btn btn-danger" value="Thanh toán Momo" name="payUrl">
				</form>


			<?php
									}
			?>

			</td>

			</tr>
			</tbody>
			</table>

			</div>
		</div>

		<?php
		if (!isset($_SESSION['dangnhap_home'])) {
		?>
			<div class="checkout-left">
				<div class="address_form_agile mt-sm-5 mt-4">
					<!-- <h4 class="mb-sm-4 mb-3">Thêm địa chỉ giao hàng</h4> -->
					<!-- <form action="" method="post" class="creditly-card-form agileinfo_form">
						<div class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
								<div class="first-row">
									<div class="controls form-group">
										<input class="billing-address-name form-control" type="text" name="name" placeholder="Điền tên" required="">
									</div>
									<div class="w3_agileits_card_number_grids">
										<div class="w3_agileits_card_number_grid_left form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Số phone" name="phone" required="">
											</div>
										</div>
										<div class="w3_agileits_card_number_grid_right form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Địa chỉ" name="address" required="">
											</div>
										</div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Email" name="email" required="">
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Password" name="password" required="">
									</div>
									<div class="controls form-group">
										<textarea style="resize: none;" class="form-control" placeholder="Ghi chú" name="note" required=""></textarea>
									</div>
									<div class="controls form-group">
										<select class="option-w3ls" name="giaohang">
											<option>Chọn hình thức giao hàng</option>
											<option value="1">COD</option>
											<option value="0">Thanh toán MOMO</option>


										</select>
									</div>
								</div>
								<?php
								$sql_lay_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");
								while ($row_thanhtoan = mysqli_fetch_array($sql_lay_giohang)) {
								?>
									<input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_thanhtoan['sanpham_id'] ?>">
									<input type="hidden" name="thanhtoan_soluong[]" value="<?php echo $row_thanhtoan['soluong'] ?>">
								<?php
								}
								?>
								<input type="submit" name="thanhtoan" class="btn btn-success" style="width: 20%" value="Thanh toán">

							</div>
						</div>
					</form> -->
					<a href="#" data-toggle="modal" data-target="#dangnhap" class="text-dark btn btn-warning">
						<i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập để tiến hành thanh toán</a>
				</div>
			</div>

		<?php
		}
		?>
	</div>
</div>
<!-- //checkout page -->