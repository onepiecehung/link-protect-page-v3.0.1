<?php
/* >_ Developed by Vy Nghia */
require '../login.php';

if(isset($_SESSION['admin'])):
$admin = $_SESSION['admin'];

$ad = new Admin;
$ad->getAdminInfo($admin);
endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Link Protect</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?php echo WEBURL ?>" />
<meta property="og:url" content="<?php echo WEBURL ?>" />
<link href="bootstrap3/css/bootstrap.css?v=1.2" rel="stylesheet" />
<link href="assets/css/gsdk.css?v=1.2" rel="stylesheet" />
<link href="assets/css/styles.css" rel="stylesheet" />
<link href="assets/css/bttn.min.css?v=1.2" rel="stylesheet" />
<link href="css/css.css?v=1.5" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-wysihtml5.css"></link>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
<div class="row">
<!-- NULL -->
</div>

<!-- LOGO HERE -->
<div class="logo">
<!--<img class="repo" src="images/logo.png" />-->
</div>
<?php if(isset($_SESSION['admin'])): ?>
<nav class="navbar navbar-default">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div id="navbar1" class="navbar-collapse collapse">
<ul class="nav navbar-nav">
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="_system/admin?page=/admin/">Thông tin quản trị</a></li>
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="_system/admin?page=/link/">Quản lý liên kết</a></li>
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="_system/admin?page=/protect/">Tạo liên kết</a></li>
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="_system/logout.php">Thoát</a></li>
</ul>
</div>
</div>
</nav>
<?php endif; ?>
</div>
<div class="row">
<div class="col-xs-12" style="text-align: center">
Chào, <a><text id="adminName"><strong><?php echo isset($admins['name']) ? $admins['name'] : 'Bạn chưa đăng nhập'; ?></strong></text></a>
</div>
</div>
<div class="container">
<div class="panel panel-primary">
<div class="panel-heading"><?php
if (isset($_GET['page'])) {
  switch ($_GET['page']) {
	case '/admin/':
      echo 'Thông tin quản trị';
    break;
    case '/link/':
      echo 'Quản lý liên kết';
    break;
    case '/protect/':
      echo 'Khóa liên kết';
    break;
    }
} else {
  echo 'Trang chủ liên kết';
}
?></div>
<div class="panel-body">
<div class="row">
<div class="col-xs-12">
<?php if(empty($_SESSION['admin'])): ?>
<form class="form-horizontal" method="POST">
<div class="form-group">
<label for="link" class="col-sm-2 control-label">Tài khoản</label>
<div class="col-sm-10">
<input type="text" class="form-control" id="username" name="username" placeholder="Tài khoản">
</div>
</div>

<div class="form-group">
<label for="password" class="col-sm-2 control-label">Mật khẩu</label>
<div class="col-sm-10">
<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
</div>
</div>
<div class="col-xs-12" style="text-align: center;">
<button id="login" type="button" class="btn btn-warning btn-fill">Đăng nhập</button>
</div>
</form><br>
<div id="LoginStatus"></div>
<?php
else:
if(empty($_GET['page'])): ?>
<center>Chào mừng bạn đến trang admin, các lựa chọn nằm ở trên!</center><br />
<div class="alert alert-success" style="color:#1abc9c" role="alert">
<font color="black">Mình mong bạn sẽ ủng hộ một chút ít cho tác giả bản web này là <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a>, bạn có thể sử dụng tiền đóng góp để ra 1 ý tưởng về dự án của bạn cho tác giả triển khai.
Đây là hành động <strong>không bắt buộc</strong>, nếu bạn có nhu cầu thì hãy đóng góp để <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a> có thể duy trì các cơ sở vật chất và thử nghiệm các ý tưởng về sau.<br /><br />
<strong>Cảm ơn. Mong sự tích cực từ bạn!</strong></font>
</div>
<?php
endif;
if(isset($_GET['page'])):
switch($_GET['page']):
case '/admin/': ?>
<form class="form-horizontal" method="POST">
<div class="form-group">
<label for="link" class="col-sm-2 control-label">Tên đại diện</label>
<div class="col-sm-10">
<input type="link" class="form-control" id="name" name="name" placeholder="Tên đại diện khi đăng nhập" value="<?php echo $admins['name'] ?>">
</div>
</div>

<div class="form-group">
<label for="link" class="col-sm-2 control-label">Tài khoản</label>
<div class="col-sm-10">
<input type="link" class="form-control" id="user" name="user" placeholder="Tài khoản đăng nhập" value="<?php echo $admins['username'] ?>">
</div>
</div>

<div class="form-group">
<label for="password" class="col-sm-2 control-label">Mật khẩu</label>
<div class="col-sm-10">
<input type="password" class="form-control" id="pass" name="pass" placeholder="Mật khẩu đăng nhập" value="<?php echo $admins['password'] ?>">
</div>
</div>
<div class="col-xs-12" style="text-align: center;">
<button id="updateAdmin" type="button" class="btn btn-warning btn-fill">Cập nhật</button>
</div>
<br /><br />
<div id="ketqua"></div>
</form>
<?php break;
case '/link/':
?>
<table class="table table-bordered" id="adminTB">
    <thead>
      <tr>
        <th>URL</th>
        <th>Short URL</th>
        <th>Post ID</th>
        <th><center>Xóa</center></th>
      </tr>
    </thead>
    <tbody id="linkTBresult">
<?php
$LinkTB = mysql_query("SELECT * FROM `link`");
if($LinkTB === false){
    throw new Exception(mysql_error($con));
}
while($link = mysql_fetch_array($LinkTB)): ?>
      <tr id="link-<?php echo $link['id'] ?>">
        <td><?php echo $link['Url'] ?></td>
        <td><?php echo $link['SUrl']?></td>
        <td><?php echo $link['PostID']?></td>
        <td align="center"><a id="delete" data-id="<?php echo $link['id']?>" style="cursor: pointer"><i class="fa fa-trash"></i></a></td>
      </tr>
<?php endwhile; ?>
    </tbody>
  </table>
<?php break; ?>
<?php
/* Genarator Link Protect */
case '/protect/':
if(isset($_SESSION['facebook_access_token'])): ?>
<form class="form-horizontal" id="formsubmit" name="formsubmit" method="POST">
<div class="form-group">
<label for="link" class="col-sm-2 control-label">Link khóa</label>
<div class="col-sm-10">
<input type="link" class="form-control" id="link" name="link" placeholder="Link cần giấu">
</div>
</div>

<div class="form-group">
<label for="password" class="col-sm-2 control-label">Khóa mật khẩu</label>
<div class="col-sm-10">
<input type="password" class="form-control" id="pass" name="pass" placeholder="Password mở link">
<br />Để trống nếu không đặt
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" style="padding-top: 0px;">Yêu cầu tags</label>
<div class="col-sm-10">
<label class="checkbox ct-blue" for="tags" style="padding-top: 0px;">
<input type="checkbox" id="tags" data-toggle="checkbox" value="1"> Phải tag 3 bạn bè vào mới được mở khóa</label></div>
</div>
<div class="col-xs-12" style="text-align: center;">
<button id="lock-link" type="button" class="btn btn-warning btn-fill">Tạo Link</button>
</div>
<div id="ketqua"></div>
</form>
<?php else: ?>
<div id="status"><center>Để tiếp tục sử dụng bạn vui lòng nhấn vào nút "<strong>kết nối</strong>".</center><br /></div>
<center><a href="<?php echo $loginUrl ?>"><button id="btn-ketnoi" class="btn btn-primary btn-fill">Kết nối</button></a>
<?php
$_SESSION['back'] = 'admin?page=/protect/';
endif;
break;
endswitch;
endif; endif; ?>
</div>
</div>
</div>
</div>
<footer class="footer" style="font-size:12px;">
<p style="font-size:13px;">&copy; 2017 Vy Nghia</p>
</footer>
<div id="loading">
<img src="assets/img/load2.gif" /><br />
<strong>Loading...</strong>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
<script src="assets/js/gsdk-checkbox.js"></script>
<script src="assets/js/gsdk-radio.js"></script>
<script src="assets/js/gsdk-bootstrapswitch.js"></script>
<script src="assets/js/get-shit-done.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script src="assets/js/wysihtml5-0.3.0.js"></script>
<script src="assets/js/bootstrap-wysihtml5.js?v=1507225806"></script>
<script src="assets/js/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.min.js"></script>
<script>
  var clipboard = new Clipboard('#copyLink');
		$( "#login" ).on( "click", function() {
			 Login();
		});


		function Login()
		{
			var user = $('#username').val()
			var pass = $('#password').val()
			if(!user || !pass){
				$('#LoginStatus').html('<div class="alert alert-warning"><strong>Lỗi đăng nhập!</strong> Vui lòng nhập đủ thông và thử lại!</div>')
			} else {
			$.ajax({
			method: 'POST',
			url: '_system/data/admin_login.php',
			data: { user: user, pass: pass},
			beforeSend: function () {
				$("#loading").show()
			},
			success: function (data) {
					$("#loading").hide()
					if(data == 1){
						$('#LoginStatus').html('<div class="alert alert-success"><strong>Đăng nhập thành công!</strong> Đang thực thi đăng nhập ....</div>')
						location.reload();
					} else if(data == 2){
						$('#LoginStatus').html('<div class="alert alert-danger"><strong>Lỗi đăng nhập!</strong> Tài khoản không tồn tại, vui lòng thử lại!</div>')
					} else {
						$('#LoginStatus').html('<div class="alert alert-danger"><strong>Lỗi đăng nhập!</strong> Có lẽ bạn đã nhập sai mật khẩu, vui lòng thử lại!</div>')
					}
				}
			});
			}

		}

	<?php if(isset($_SESSION['admin'])): ?>
	$(function(){
		$('#updateAdmin').on('click',function(){
			var name = $('#name').val()
			var user = $('#user').val()
			var pass = $('#pass').val()
			$.ajax({
			method: 'POST',
			url: '_system/data/admin_update.php',
			data: { name: name, user: user, pass: pass},
			beforeSend: function () {
				$("#loading").show()
			},
			success: function (data) {
					$("#adminName").html("<strong>" + name + "</strong>")
					$("#loading").hide()
					swal(
					'Đã thay đổi!',
					'Thông tin quản trị viên đã được thay đổi!',
					'success'
				  )
				  console.log(data);
				}
			});
		});
	});
	
	
	//Create Link
	$(function(){
		$('#lock-link').on('click',function(){
			var link = $('#link').val()
			var pass = $('#pass').val()
			var tags = $('input[type="checkbox"]:checked').val()
			$.ajax({
			method: 'POST',
			url: '_system/data/admin_link.php?action=create',
			data: { link: link, pass: pass, tags: tags },
			beforeSend: function () {
				$("#loading").show()
			},
			success: function (data) {
					$("#loading").hide()
					$("#ketqua").html(data);
				}
			});
		});
	});

  //Delete user
  $(function(){
		$('#linkTBresult').on('click', '#delete' ,function(event){
			let $this = $(this);
			let id = $this.data('id');
			swal({
			  title: 'Bạn chắc chắn điều này?',
			  text: "Có thật bạn muốn xóa liên kết này? Điều này khi hoàn thành sẽ không thể hoàn tác!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Vâng, xóa nó!',
			  cancelButtonText: 'Hủy'
			}).then(function () {
				$.ajax({
				method: 'POST',
				url: '_system/data/admin_link.php?action=delete',
				data: { id: id },
				beforeSend: function () {
					$("#loading").show()
				},
				success: function (data) {
						swal(
							'Đã xóa!',
							' Liên kết này đã được xóa!',
							'success'
						  )
						$("#loading").hide()
						$('#link-' + id).remove()
					}
				});
			})
		});
  });
	<?php endif; ?>
</script>
</body>
</html>
