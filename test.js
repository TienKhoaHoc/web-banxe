// ========================== Sản Phẩm ========================
// Vẽ bảng danh sách sản phẩm
function addTableProducts(list_products) {
    var tc = document.getElementsByClassName('sanpham')[0].getElementsByClassName('table-content')[0];
    var s = `<table class="table-outline hideImg">`;

    for (var i = 0; i < list_products.length; i++) {
        var p = list_products[i];
        s += `<tr>
            <td style="width: 5%">` + (i + 1) + `</td>
            <td style="width: 10%">` + p.MaSP + `</td>
            <td style="width: 40%">
                <a title="Xem chi tiết" target="_blank" href="chitietsanpham.php?` + p.TenSP.split(' ').join('-') + `">` + p.TenSP + `</a>
                <img src="` + p.HinhAnh + `"></img>
            </td>
            <td style="width: 15%">` + parseInt(p.DonGia).toLocaleString() + `</td>
            <td style="width: 10%">` + /*promoToStringValue(*/ (p.KM.TenKM) /*)*/ + `</td>
            <td style="width: 10%">` + (p.TrangThai==1?"Hiện":"Ẩn") + `</td>
            <td style="width: 10%">
                <div class="tooltip">
                    <i class="fa fa-wrench" onclick="addKhungSuaSanPham('` + p.MaSP + `')"></i>
                    <span class="tooltiptext">Sửa</span>
                </div>
                <div class="tooltip">
                    <i class="fa fa-trash" onclick="xoaSanPham('` + p.TrangThai + `', '` + p.MaSP + `', '` + p.TenSP + `')"></i>
                    <span class="tooltiptext">Xóa</span>
                </div>
            </td>
        </tr>`;
    }

    s += `</table>`;

    tc.innerHTML = s;
}

// Tìm kiếm
function timKiemSanPham(inp) {
    var kieuTim = document.getElementsByName('kieuTimSanPham')[0].value;
    var text = inp.value;

    // Lọc
    var vitriKieuTim = {
        'ma': 1,
        'ten': 2
    }; // mảng lưu vị trí cột

    var listTr_table = document.getElementsByClassName('sanpham')[0].getElementsByClassName('table-content')[0].getElementsByTagName('tr');
    for (var tr of listTr_table) {
        var td = tr.getElementsByTagName('td')[vitriKieuTim[kieuTim]].innerHTML.toLowerCase();

        if (td.indexOf(text.toLowerCase()) < 0) {
            tr.style.display = 'none';
        } else {
            tr.style.display = '';
        }
    }
}

// Thêm
function layThongTinSanPhamTuTable(id) {
    var khung = document.getElementById(id);
    var tr = khung.getElementsByTagName('tr');

    var masp = tr[1].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var name = tr[2].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var company = tr[3].getElementsByTagName('td')[1].getElementsByTagName('select')[0].value;
    var img =  document.getElementById("hinhanh").value;
    var price = tr[5].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var amount = tr[6].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var star = tr[7].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var rateCount = tr[8].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var promoName = tr[9].getElementsByTagName('td')[1].getElementsByTagName('select')[0].value;
    var promoValue = tr[10].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;

    var screen = tr[12].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var os = tr[13].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var camara = tr[14].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var camaraFront = tr[15].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var cpu = tr[16].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var ram = tr[17].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var rom = tr[18].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var microUSB = tr[19].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;
    var battery = tr[20].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value;

    return {
        "name": name,
        "img": img,
        "price": price,
        "company": company,
        "amount": amount,
        "star": star,
        "rateCount": rateCount,
        "promo": {
            "name": promoName,
            "value": promoValue
        },
        "detail": {
            "screen": screen,
            "os": os,
            "camara": camara,
            "camaraFront": camaraFront,
            "cpu": cpu,
            "ram": ram,
            "rom": rom,
            "microUSB": microUSB,
            "battery": battery
        },
        "masp": masp,
        "TrangThai": 1
    };
}

function themSanPham() {
    var newSp = layThongTinSanPhamTuTable('khungThemSanPham');

    // Kiểm tra tên sản phẩm
    var pattCheckTenSP = /([a-z A-Z0-9&():.'_-]{2,})$/;
    if (!pattCheckTenSP.test(newSp.name)) {
        alert("Tên sản phẩm không hợp lệ");
        return false;
    }

    // Kiểm tra giá tiền
    var pattCheckGia = /^([0-9]){1,}(000)$/;
    if (!pattCheckGia.test(newSp.price)) {
        alert("Đơn giá sản phẩm không hợp lệ");
        return false;
    }

    // Kiểm tra số lượng
    var pattCheckSL = /[0-9]{1,}$/;
    if (!pattCheckSL.test(newSp.amount)) {
        alert("Số lượng sản phẩm không hợp lệ");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "php/xulysanpham.php",
        dataType: "json",
        data: {
            request: "add",
            dataAdd: newSp
        },
        success: function (data, status, xhr) {
            Swal.fire({
                type: 'success',
                title: 'Thêm thành công'
            });
            resetForm();
            document.getElementById('khungThemSanPham').style.transform = 'scale(0)';
            refreshTableSanPham();
        },
        error: function (xhr, status, error) {
            Swal.fire({
                type: "error",
                title: "Lỗi",
                text: "Có lỗi khi thêm sản phẩm. Vui lòng thử lại."
            });
        }
    });

    // Hiển thị thông báo thành công (bạn có thể di chuyển nó vào success callback của AJAX)
    alert('Thêm sản phẩm "' + newSp.name + '" thành công.');
    refreshTableSanPham();
}

function resetForm() {
    var khung = document.getElementById('khungThemSanPham');
    var tr = khung.getElementsByTagName('tr');

    tr[2].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value = "";
    tr[4].getElementsByTagName('td')[1].getElementsByTagName('img')[0].src = "";
    tr[5].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value = "";
    tr[6].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value = "0";

    tr[12].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[13].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[14].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[15].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[16].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[17].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[18].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[19].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
    tr[20].getElementsByTagName('td')[1].getElementsByTagName('input')[0].value ="";
}

function autoMaSanPham(company) {
    // hàm tự tạo mã cho sản phẩm mới
    var autoMaSP = list_products[list_products.length-1].MaSP;
    document.getElementById('maspThem').value = parseInt(autoMaSP)+1;
}

// Xóa
function xoaSanPham(trangthai, masp, tensp) {
    if (trangthai == 1)
    {
        // alert ("Sản phẩm còn đang bán");
        Swal.fire({
            type: 'warning',
            title: 'Bạn có muốn ẨN ' + tensp + ' không!',
            showCancelButton: true
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    type: "POST",
                    url: "php/xulysanpham.php",
                    dataType: "json",
                    // timeout: 1500, // sau 1.5 giây mà không phản hồi thì dừng => hiện lỗi
                    data: {
                        request: "hide",
                        id: masp,
                        trangthai: 0
                    },
                    success: function(data, status, xhr) {
                        Swal.fire({
                            type: 'success',
                            title: 'Ẩn thành công'
                        })
                        refreshTableSanPham();
                    },
                    error: function(e) {
                        Swal.fire({
                            type: "error",
                            title: "Lỗi xóa",
                            html: e.responseText
                        });
                    }
                });
            }
        })
    }
    else
    {
        if (window.confirm('Bạn có chắc muốn xóa ' + tensp)) {
            // Xóa
            $.ajax({
                type: "POST",
                url: "php/xulysanpham.php",
                dataType: "json",
                // timeout: 1500, // sau 1.5 giây mà không phản hồi thì dừng => hiện lỗi
                data: {
                    request: "delete",
                    maspdelete: masp
                },
                success: function(data, status, xhr) {
                    
                },
                error: function() {
                    Swal.fire({
                        type: "error",
                        title: "Lỗi xóa"
                    });
                }
            });

            // Vẽ lại table 
            refreshTableSanPham();
        }
    }
}