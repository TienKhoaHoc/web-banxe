<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Thế giới xe máy</title>
    <link rel="shortcut icon" href="img/icon.ico" />

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">

    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <!-- Jquery -->
    <script src="lib/Jquery/Jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- Our files -->
    <link rel="stylesheet" href="css/admin/style.css">
    <link rel="stylesheet" href="css/admin/progress.css">

    <script src="data/products.js"></script>
    <!-- <script src="js/classes.js"></script> -->
    <script src="js/dungchung.js"></script>
    <script src="js/admin.js"></script>
</head>

<body>
    <header>
        <h2>MotorBikeHub - Admin</h2>
    </header>

    <!-- Menu -->
    <aside class="sidebar">
        <ul class="nav">
            <li class="nav-title">MENU</li>
            <!-- <li class="nav-item"><a class="nav-link active"><i class="fa fa-home"></i> Home</a></li> -->
            <li class="nav-item" onclick="refreshTableSanPham()"><a class="nav-link"><i class="fa fa-th-large"></i> Sản Phẩm</a></li>
            <!-- <li class="nav-item" onclick="refreshTableHang()"><a class="nav-link"><i class="fa fa-motorcycle"></i> Hảng</a></li> -->
            <li class="nav-item" onclick="refreshTableDonHang()"><a class="nav-link"><i class="fa fa-file-text-o"></i> Đơn Hàng</a></li>
            <li class="nav-item" onclick="refreshTableKhachHang()"><a class="nav-link"><i class="fa fa-address-book-o"></i> Khách Hàng</a></li>
            <li class="nav-item"><a class="nav-link"><i class="fa fa-bar-chart-o"></i> Thống Kê</a></li>
            <hr>
            <li class="nav-item">
                <a class="nav-link" id="btnDangXuat">
                    <i class="fa fa-arrow-left"></i>
                    Đăng xuất
                </a>
            </li>
        </ul>
    </aside>

    <!-- Khung hiển thị chính -->
    <div class="main">
        <div class="home">

        </div>

        <!-- Sản Phẩm -->
        <div class="sanpham">
            <table class="table-header">
                <tr>
                    <!-- Theo độ rộng của table content -->
                    <th title="Sắp xếp" style="width: 5%" onclick="sortProductsTable('stt')">Stt <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortProductsTable('masp')">Mã <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 40%" onclick="sortProductsTable('ten')">Tên <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 15%" onclick="sortProductsTable('gia')">Giá <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortProductsTable('khuyenmai')">Khuyến mãi <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortProductsTable('gia')">Trạng thái <i class="fa fa-sort"></i></th>
                    <th style="width: 10%">Hành động</th>
                </tr>
            </table>

            <div class="table-content">
            </div>

            <!--<div class="table-content">
            <?php
                require_once('BackEnd/ConnectionDB/DB_classes.php');

                $sp = new SanPhamBUS();
                $i = 1;
                echo "<table class='table-outline hideImg'>";
                foreach ($sp->select_all() as $rowname => $row) {
                    echo "<tr>
                        <td style'width: 5%'>" . $i++ . "</td>
                        <td style='width: 10%'>" . $row['MaSP'] . "</td>
                        <td style='width: 40%'>
                            <a title='Xem chi tiết' target='_blank' href='chitietsanpham.php?" . $row['TenSP'] . "'>" . $row['TenSP'] . "</a>
                            <img src='" . $row['HinhAnh'] . "'></img>
                        </td>
                        <td style='width: 15%'>" . $row['DonGia'] . "</td>
                        <td style='width: 15%'>" . $row['MaKM'] . "</td>
                        <td style='width: 15%'>
                            <div class='tooltip'>
                                <i class='fa fa-wrench' onclick='addKhungSuaSanPham('" . $row['MaSP'] . "')'></i>
                                <span class='tooltiptext'>Sửa</span>
                            </div>
                            <div class='tooltip'>
                                <i class='fa fa-trash' onclick='xoaSanPham('" . $row['MaSP'] . "', '" . $row['TenSP'] . "')'></i>
                                <span class='tooltiptext'>Xóa</span>
                            </div>
                        </td>
                    </tr>";
                }
                echo "</table>";
            ?>
            </div>-->

            <div class="table-footer">
                <select name="kieuTimSanPham">
                    <option value="ma">Tìm theo mã</option>
                    <option value="ten">Tìm theo tên</option>
                </select>
                <input type="text" placeholder="Tìm kiếm..." onkeyup="timKiemSanPham(this)">
                <button onclick="document.getElementById('khungThemSanPham').style.transform = 'scale(1)'; autoMaSanPham()">
                    <i class="fa fa-plus-square"></i>
                    Thêm sản phẩm
                </button>
                <button onclick="refreshTableSanPham()">
                    <i class="fa fa-refresh"></i>
                    Làm mới
                </button>

            </div>

            <div id="khungThemSanPham" class="overlay">
                <span class="close" onclick="this.parentElement.style.transform = 'scale(0)';">&times;</span>
                <form method="post" action="" enctype="multipart/form-data" onsubmit="return themSanPham();">
                    <table class="overlayTable table-outline table-content table-header">
                        <tr>
                            <th colspan="2">Thêm Sản Phẩm</th>
                        </tr>
                        <tr>
                            <td>Mã sản phẩm:</td>
                            <td><input readonly type="text" id="maspThem" name="maspThem"></td>
                        </tr>
                        <tr>
                            <td>Tên sản phẩm:</td>
                            <td><input type="text"></td>
                        </tr>
                        <t>
                            <td>Hãng:</td>
                            <td>
                                <select name="chonCompany" onchange="autoMaSanPham(this.value)">
                                    <script>
                                        ajaxLoaiSanPham();
                                    </script>
                                </select>
                            </td>
                        </t r>
                            <?php
                                $tenfilemoi = ""; // Đặt giá trị mặc định

                                // Xử lý tải ảnh lên
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    // Rest of your code...

                                    if (
                                        ($_FILES["hinhanh"]["type"] == "image/jpeg" || $_FILES["hinhanh"]["type"] == "image/png" || $_FILES["hinhanh"]["type"] == "image/jpg")
                                        && ($_FILES["hinhanh"]["size"] < 5000000)
                                    ) {
                                        // Kiểm tra thư mục tồn tại
                                        if (!is_dir("img/products/")) {
                                            mkdir("img/products/", 0755, true);
                                        }

                                        $masp = $_POST['maspThem'];
                                        $tenfilemoi = "img/products/" . $masp . "." . pathinfo($_FILES["hinhanh"]["name"], PATHINFO_EXTENSION);

                                        if (file_exists($tenfilemoi)) {
                                            echo "Error: File đã tồn tại.";
                                        } else {
                                            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $tenfilemoi);
                                            echo "Success: Ảnh đã được tải lên thành công.";
                                        }
                                    } else {
                                        echo "Error: Kiểu file không hợp lệ hoặc kích thước lớn hơn 5MB.";
                                    }
                                }
                            ?>
                        <tr>
                            <td>Hình:</td>
                            <td>
                                <img class="hinhDaiDien" id="anhDaiDienSanPhamThem" src="">
                                <input type="file" name="hinhanh" onchange="capNhatAnhSanPham(this.files, 'anhDaiDienSanPhamThem', '<?php echo $tenfilemoi; ?>')">
                                <input style="display: none;" type="text" id="hinhanh" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>Giá tiền:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Số lượng:</td>
                            <td><input type="text" value="0"></td>
                        </tr>
                        <tr>
                            <td>Số sao:</td>
                            <td><input disabled="disabled" value="0" type="text"></td>
                        </tr>
                        <tr>
                            <td>Đánh giá:</td>
                            <td><input disabled="disabled" value="0" type="text"></td>
                        </tr>
                        <tr>
                            <td>Khuyến mãi:</td>
                            <td>
                                <select name="chonKhuyenMai" onchange="showGTKM()">
                                    <script type="text/javascript">
                                        ajaxKhuyenMai();
                                    </script>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Giá trị khuyến mãi:</td>
                            <td><input id="giatrikm" type="text"></td>
                        </tr>
                        <tr>
                            <th colspan="2">Thông số kĩ thuật</th>
                        </tr>
                        <tr>
                            <td>Dung Tích Bình Xăng:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Khối Lượng:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Phuộc Trước:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Phuộc Sau:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Dài x Rộng x Cao:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Dung Tích Nhớt Máy:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Mức Tiêu Thụ Nhiên Liệu:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Moment Cực Đại:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Dung Tích Xy-lanh:</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="table-footer"> <button name="submit">THÊM</button> </td>
                        </tr>
                    </table>
                </form>
                <div style="display: none;" id="hinhanh"></div>
            </div>
            <div id="khungSuaSanPham" class="overlay"></div>
        </div> <!-- // sanpham -->



        <!-- <div class="hang">
            <table class="table-header">
                <tr>
                    <th>Stt</th>
                    <th>Mã Hảng</th>
                    <th>Tên Hảng</th>
                    <th>Hình Ảnh</th>
                    <th>Mô tả</th>
                    <th>Hàng Động</th>
                </tr>
            </table>

            <div class="table-content">
            </div>

            <div class="table-footer">
                <button >
                        <i class="fa fa-plus-square"></i>
                        Thêm sản phẩm
                </button>
            </div>
            
        </div> -->

        <!-- Đơn Hàng -->
        <div class="donhang">
            <table class="table-header">
                <tr>
                    <!-- Theo độ rộng của table content -->
                    <th title="Sắp xếp" style="width: 5%" onclick="sortDonHangTable('stt')">Stt <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 13%" onclick="sortDonHangTable('madon')">Mã đơn <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 7%" onclick="sortDonHangTable('khach')">Khách <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 20%" onclick="sortDonHangTable('sanpham')">Sản phẩm <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 15%" onclick="sortDonHangTable('tongtien')">Tổng tiền <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" style="width: 10%" onclick="sortDonHangTable('ngaygio')">Ngày giờ <i class="fa fa-sort"></i></th>
                    <th style="width: 10%">Hành động</th>
                </tr>
            </table>

            <div class="table-content">
            </div>

            <div class="table-footer">
                <div class="timTheoNgay">
                    Từ ngày: <input type="date" id="fromDate">
                    Đến ngày: <input type="date" id="toDate">

                    <button onclick="locDonHangTheoKhoangNgay()"><i class="fa fa-search"></i> Tìm</button>
                </div>

                <select name="kieuTimDonHang">
                    <option value="ma">Tìm theo mã đơn</option>
                    <option value="khachhang">Tìm theo tên khách hàng</option>
                    <option value="trangThai">Tìm theo trạng thái</option>
                </select>
                <input type="text" placeholder="Tìm kiếm..." onkeyup="timKiemDonHang(this)">
            </div>

        </div> <!-- // don hang -->


        <!-- Khách hàng -->
        <div class="khachhang">
            <table class="table-header">
                <tr>
                    <!-- Theo độ rộng của table content -->
                    <th title="Sắp xếp"  onclick="sortKhachHangTable('stt')">Stt <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp"  onclick="sortKhachHangTable('hoten')">Họ tên <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp"  onclick="sortKhachHangTable('email')">Email <i class="fa fa-sort"></i></th>
                    <th title="Sắp xếp" onclick="sortKhachHangTable('taikhoan')">Tài khoản <i class="fa fa-sort"></i></th>
                
                    <th style="width: 10%">Hành động</th>
                </tr>
            </table>

            <div class="table-content">
            </div>

            <div class="table-footer">
                <select name="kieuTimKhachHang">
                    <option value="ten">Tìm theo họ tên</option>
                    <option value="email">Tìm theo email</option>
                    <option value="taikhoan">Tìm theo tài khoản</option>
                </select>
                <input type="text" placeholder="Tìm kiếm..." onkeyup="timKiemNguoiDung(this)">
                <!-- <button onclick="openThemNguoiDung()"><i class="fa fa-plus-square"></i> Thêm người dùng</button> -->
            </div>
        </div> <!-- // khach hang -->

        <!-- Thống kê -->
        <div class="thongke">
            <div class="canvasContainer">
                <canvas id="myChart1"></canvas>
            </div>

            <div class="canvasContainer">
                <canvas id="myChart2"></canvas>
            </div>

            <div class="canvasContainer">
                <canvas id="myChart3"></canvas>
            </div>

            <div class="canvasContainer">
                <canvas id="myChart4"></canvas>
            </div>

        </div>
    </div> <!-- // main -->


    <footer>
        
    </footer>
</body>

</html>