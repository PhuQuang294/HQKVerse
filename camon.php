<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn - Thanh toán thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .thank-you-box {
            max-width: 500px;
            margin: 100px auto;
            background: #ffffff;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .thank-you-box h1 {
            color: #28a745;
            font-size: 28px;
            font-weight: bold;
        }

        .thank-you-box p {
            font-size: 18px;
            color: #333;
        }

        .btn-home {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <?php
    //session_start();
    // Include database connection
    if (!isset($con)) {
        include_once('../db/connect.php');
    }

    if (isset($_GET['partnerCode']) && isset($_GET['orderId'])) {
        $partnerCode = $_GET['partnerCode'];
        $orderId = $_GET['orderId']; // Mã đơn hàng của hệ thống
        $amount = $_GET['amount'];
        $orderInfo = $_GET['orderInfo'];
        $transId = $_GET['transId']; // Mã giao dịch MoMo
        $resultCode = $_GET['resultCode']; // Kết quả giao dịch
        $khachhang_id = $_SESSION['khachhang_id'] ?? 0;

        if ($resultCode == 0) {
            // Giao dịch thành công
            $mahang = rand(1000, 9999); // Sinh mã đơn hàng mới

            // Lưu đơn hàng và giao dịch vào CSDL
            $sql_select_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang");
            $mahang = rand(1000, 9999); // Tạo mã đơn hàng ngẫu nhiên


            while ($row = mysqli_fetch_array($sql_select_giohang)) {
                $sanpham_id = $row['sanpham_id'];
                $soluong = $row['soluong']; // Giả sử có cột 'soluong' trong giỏ hàng

                // Lưu vào bảng đơn hàng
                $sql_donhang = mysqli_query($con, "INSERT INTO tbl_donhang(sanpham_id, khachhang_id, soluong, mahang) 
  VALUES ('$sanpham_id', '$khachhang_id', '$soluong', '$mahang')");

                // Lưu vào bảng giao dịch MoMo
                $sql_giaodich = mysqli_query($con, "INSERT INTO tbl_giaodich(sanpham_id, soluong, magiaodich, khachhang_id, trans_id, payment_method) 
        VALUES ('$sanpham_id', '$soluong', '$mahang', '$khachhang_id', '$transId', 'MoMo')");

                // Xóa sản phẩm đã thanh toán khỏi giỏ hàng
                $sql_delete_thanhtoan = mysqli_query($con, "DELETE FROM tbl_giohang");
            }


            // **Xóa $_GET bằng cách redirect về chính trang camon.php nhưng không có tham số**
            header("Location: index.php?quanly=camon");
            exit;
        } else {
            echo "<h2>Lưu đơn hàng thất bại vui lòng kiểm tra lai!</h2>";
        }
    } else {
        //echo "<h2>Không có dữ liệu giao dịch!</h2>";
    }
    ?>

    <div class="thank-you-box">
        <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" width="80" alt="Success">
        <h1>Thanh toán thành công!</h1>
        <p>Cảm ơn bạn đã mua hàng tại <strong>Thời Trang Online</strong>.</p>

        <p>Chúng tôi sẽ xử lý đơn hàng và giao hàng trong thời gian sớm nhất.</p>
        <a href="index.php" class="btn btn-success btn-home">Quay về trang chủ</a>
    </div>

</body>

</html>