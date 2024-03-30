<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dangnhap.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
            
        function kiemTraDangNhap(){
            a=document.getElementById("username").value;
            b=document.getElementById("password").value;
            if(a == "")
                {
                    alert("Tài khoản không được để trống!Vui lòng nhập tài khoản.");
                    form.username.focus();
                    return false;
                }
            if(b == "")
                {
                    alert("Mật khẩu không được để trống!Vui lòng nhập mật khẩu.");
                    form.password.focus();
                    return false;
                }
            $.ajax({
                url:"php/xulidangnhapadmin.php",
                type:"post",
                data: {
                    data_username:a,
                    data_password:b
                },
                //async:true,
                success:function(kq){
                    if(kq.indexOf("yes")!= -1) 
                        {
                            alert("Đăng nhập thành công");
                            window.location="admin.php";
                        }
                    else {
                        alert("Vui lòng kiểm tra lại");
                        document.getElementById("username").value="";
                        document.getElementById("password").value="";
                        form.username.focus();
                    }
                    // }
                }

            });
        }
    </script>
</head>

<body>
  <div class="login-box">
    <h2>Login</h2>
    <form>
      <div class="user-box">
        <input name="username" type="text" id="username" required="">
        <label>Username</label>
      </div>
      <div class="user-box">
        <input name="password" type="password" id="password" required="">
        <label>Password</label>
      </div>
      <a href="javascript:void(0);" onclick="kiemTraDangNhap()">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Sign In
      </a>
      <div id="hienthiketqua"></div>
    </form>
  </div>
</body>