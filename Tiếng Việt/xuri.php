<?php
/* >_ Developed by Vy Nghia */
error_reporting(0);
require_once 'login.php';

if(isset($accessToken)){
	$sHash = $_GET['x'];
	
	$link = new Protect;
	$link->fetchHash($sHash);
	$link->setCreatorID($URL['FBID']);
	$link->getUserInfo($accessToken);
	
	if(isset($URL['Password'])){
		if($URL['Password'] !== ""){
			$PasswordLocked = true;
			if(isset($_POST['password'])){
				if($_POST['password'] == $URL['Password']){
					unset($PasswordLocked);
				}
			} else {
				$Password = null;
			}
		}
	}
	
	$link->Check(PAGEID, $accessToken, $URL['Hash'], $URL['PostID'], $URL['tags_require'], $userID);
		
	if($FoundPost == true && $PostID == 0){
		mysql_query("UPDATE `link` SET `PostID` = '$FoundPostID' WHERE `Hash` = '$sHash'");
	}
} else {
	$_SESSION['back'] = $_SERVER['REQUEST_URI'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Link Protect</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?php echo WEBURL ?>" />
<meta name="description" content="Ẩn link chống ninja, bảo vệ link share trên group, fanpage facebook, tăng tương tác cho bài viết">
<meta property="og:title" content="Link Protect" />
<meta property="og:image" content="logo.png" />
<meta property="og:site_name" content="Link Protect" />
<meta property="og:description" content="Ẩn link chống ninja, bảo vệ link share trên group, fanpage facebook, tăng tương tác cho bài viết" />
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
<?php if(isset($accessToken)): ?>
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
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="/">Trang chủ</a></li>
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="logout.php">Thoát</a></li>
</ul>
</div>
</div>
</nav>
<?php endif; ?>
</div>
<div class="row">
<div class="col-xs-12" style="text-align: center">
Chào, <a href="https://facebook.com/" target="_blanks"><strong><?php echo isset($userName) ? $userName : 'Bạn chưa đăng nhập'; ?></strong></a>
</div>
</div>
<div class="container">
<?php if(isset($accessToken)): ?>
<div class="row">
<div class="col-sm-3">
<div class="panel panel-primary">
<div class="panel-heading"><i class="fa fa-user-circle"></i> Người chia sẻ</div>
<ul class="list-group">
<a href="https://www.facebook.com/<?php echo $CreatorID ?>" target="_blanks"><li class="list-group-item" style="text-align: center;"><img src="https://graph.facebook.com/<?php echo $CreatorID ?>/picture?type=large&redirect=true&width=80&height=80" alt="<?php echo $CreatorID ?>" class="img-circle">
<div style="font-weight: bold;"><?php echo $CreatorName ?></div></li></a>
<li class="list-group-item" style="font-weight: bold; color: green">Bị báo cáo:</li>
<li class="list-group-item" style="color: gray"><i class="fa fa-bug"></i>Link Virus: 0 / 0 bài</li>
<li class="list-group-item" style="color: red"><i class="fa fa-minus-circle"></i>Spam: 0 / 0 bài</li>
</ul>
</div>
</div>
<div class="col-sm-9">
<div class="panel panel-primary">
<div class="panel-heading"><i class="fa fa-info-circle"></i> Thông tin chung</div>
<div class="panel-body">
<div class="row">
<div class="panel panel-default" style="margin-left: 10px; margin-right: 10px;">
<div class="panel-body" style="word-wrap: break-word">
<center><strong>Link bài viết gốc:</strong><br />
<a style="color: black; font-size: 17px;" <?php echo ($FoundPostURL !== null) ? 'href="'.$FoundPostURL.'"' : null;?> target="_blank" ><?php echo ($FoundPostURL !== null) ? $FoundPostURL : 'Link khóa này chưa được cập nhật link bài viết trong Group';?></a></center>
</div>
</div>
<div class="col-xs-12">
<strong>Kiểm tra điều kiện mở khóa:</strong><br />
<?php if($URL['tags_require'] == 1): ?>
<label class="checkbox ct-blue" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo (max($tagsCount, 0) == 0) ? 'checked' : 'unchecked'; ?>><?php echo (max($tagsCount, 0) == 0) ? 'Bạn đã hoàn thành gắn thẻ 3 người bạn' : 'Vui lòng gắn thẻ 3 người bạn vào liên kết bài viết trên (có thể cộng dồn)'; ?></label>
<?php else: ?>
<label class="checkbox ct-blue" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo (isset($FoundPost)) ? 'checked' : null; ?>><?php echo (isset($FoundPost)) ? 'Đã xác nhận #hashtag của liên kết này' : 'Liên kết này chưa được gắn #hashtag'; ?></label>
<?php endif; ?>
<label class="checkbox ct-red" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo ($Liked == true) ? 'checked' : null; ?>><?php echo ($Liked == true) ? 'Bạn đã thích bài viết của liên kết này' : 'Bạn chưa thích bài viết của liên kết này'; ?></label>
<label class="checkbox ct-orange" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo (empty($PasswordLocked)) ? 'checked' : null; ?>><?php echo (empty($PasswordLocked)) ? 'Khóa mật khẩu - OK!' : 'Liên kết này có mật khẩu, hãy điền mật khẩu để mở khóa'; ?></label>
<?php if(isset($PasswordLocked)): ?>
<form action="" method="POST">
<div class="input-group">
<input type="text" name="password" class="form-control" placeholder="Vui lòng nhập mật khẩu">
<span class="input-group-btn">
<button class="btn btn-info btn-fill" type="submit"><i class="fa fa-unlock"></i> Mở khóa</button>
</span>
</div>
</form>
<?php endif; ?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php else: ?>
<div class="row">
<div class="panel panel-primary">
<div class="panel-heading">Khóa nội dung</div>
<div class="panel-body">
<div class="col-xs-12" style="text-align: center">
<div id="status">Để tiếp tục sử dụng bạn vui lòng nhấn vào nút "<strong>kết nối</strong>".<br /><img src="assets/img/down.gif" /></div>
<center><a href="<?php echo $loginUrl ?>"><button id="btn-ketnoi" class="btn btn-primary btn-fill">Kết nối</button></a>
<br />
<br />
(Lưu ý: Nếu là lần đầu tiên sử dụng Ứng dụng sẽ yêu cầu quyền lấy thông tin cá nhận <strong>Công khai</strong> của bạn. Ứng dụng chỉ lấy những thông tin mà bạn công khai như <strong>Tên</strong> và <strong>ID</strong> để xác nhận. Ngoài ra <strong>không lấy bất cứ quyền nào</strong>, không lưu cookie hay token).</center>
</div>
</div>
</div>
</div>
<?php endif; ?>
<!-- Ads
<div class="panel panel-default">
<div class="panel-body">
<iframe data-aa='533838' src='//ad.a-ads.com/533838?size=990x90' scrolling='no' style='width:990px; height:90px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
<div id="qc" style="font-weight: bold; font-size: 17px;text-align: center;"></div>
</div>
</div> -->
<?php if(isset($FoundPost) && isset($Liked) && empty($PasswordLocked) && max($tagsCount, 0) == 0): ?>
<div class="panel panel-primary">
<div class="panel-heading"><i class="fa fa-unlock"></i> Nội dung ẩn</div>
<div class="panel-body">
<div class="row">
<div class="col-xs-12">
<div class="panel panel-default">
<div class="panel-body" style="word-wrap: break-word">
<center><a style="color: black; font-size: 17px;" href="<?php echo $URL['Url'] ?>"><?php echo $URL['Url'] ?></a></center>
</div>
</div>
<br>
<br>
<span style="color: green; font-weight: bold;">Thông tin link:</span><br>
<span style="color: red; font-weight: bold;">- <i class="fa fa-bug"></i> Báo cáo Virus: </span>0 lần<br>
<span style="color: gray; font-weight: bold;">- <i class="fa fa-minus-circle"></i> Báo cáo Spam: </span>0 lần
</div>
</div>
</div>
</div>
<?php endif; ?>
<footer class="footer" style="font-size:12px;">
<p style="font-size:13px;">&copy; <?php echo date('Y'); ?> Vy Nghia</p>
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
<script>
    	var spush;
    	var clipboard = new Clipboard('.btn');
    	clipboard.on('success', function(e) {
        	call(e.trigger,'Đã copy!');
	    });

	    clipboard.on('error', function(e) {
	        call(e.trigger,'Lỗi rùi!');
	    });
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});

		}, 100);
		$('.btn-tooltip').tooltip();
		$( "#btn-submit" ).on( "click", function() {
			  check_dup();
		});
		$('.textarea').wysihtml5();
		$( "#type1, #type2" ).change(function () {
			  if ($("#type2").is(":checked"))
			  {
			  		$("#box_content").show("slow");
			  		$("#box_url").hide("slow");
			  		//$("#type_url").val('');

			  }
			  if ($("#type1").is(":checked"))
			  {
			  		$("#box_url").show("slow");
			  		$("#box_content").hide("slow");
			  		//$("#type_content").val('');
			  }
		});

		$( "#btn-push" ).on( "click", function() {
			var frm = $(document.formpush);
			var data = frm.serializeArray();

			$.ajax({
	            method      : 'POST',
				cache		: false,
	            url 		: 'ajax/pre_push.php',
		    	data		: data,
	            beforeSend: function () {
             		$("#loading").show()
        		},
		        success: function (repo) {
					$('#ketqua').html(repo);
					$("#loading").hide()
				}
		    });
		});



		function push()
		{
			var spush = setInterval(function(){ send_push(spush) }, 2000);
			$("div#ketqua div#div-btn-push").html('');
		}

		function send_push(spush)
		{
			$.ajax({
	            method      : 'GET',
	            cache       : false,
	            dataType    : "json",
	            url         : 'ajax/send_push.php',
	            beforeSend: function () {
             		$("#loading").show()
        		},
		        success: function (repo) {

					if(repo.status != "done")
	            	{
	            		$("div#ketqua div#push_status").html(repo.msg);
	            	}
	            	else
	            	{
	            		$("div#ketqua div#push_status").html('Hoàn thành!');
						$("#loading").hide()
						clearInterval(spush);
	            	}
				}

	             });
		}


		function call(elem, text)
		{
			elem.innerHTML = text;
		}
	    function submit()
		{
			var frm = $(document.formsubmit);
			var data = frm.serializeArray();

			$.ajax({
	            method        : 'POST',
				cache		: false,
	            url 		: 'ajax/encode.php',
		    	data		: data,
	            beforeSend: function () {
             		$("#loading").show()
        		},
		        success: function (repo) {
					$('#ketqua').html(repo);
					$("#loading").hide()
				}
		    });

		}


		function check_dup()
		{
			var frm = $(document.formsubmit);
			var data = frm.serializeArray();
			$.ajax({
	            method        : 'POST',
				cache		: false,
	            url 		: 'ajax/dup.php',
	            dataType	:"json",
	            data		: data,
	            beforeSend: function () {
             		$("#loading").show()
        		},
		        success: function (repo) {
					$("#loading").hide()
					if(repo.status == 0)
					{
						submit();
					}
					else
					{
						$("#ketqua").html(repo.html);
					}
				}
		    });

		}
		function danhgia(hash)
		{
			$.ajax({
	            method        : 'GET',
	            cache       : false,
	            dataType    : "json",
	            url         : 'ajax/action.php?hash='+ hash,
	            beforeSend: function () {
             		$("#loading").show()
        		},
		        success: function (repo) {
					$("#loading").hide()
					if(repo.error == 0)
	            	{
	            		$('#danhgia').modal('hide')
	            		$("#msgdanhgia_ok").html(repo.msg);
	            	}
	            	else
	            	{
	            		$("#msgdanhgia").html(repo.msg);
	            	}
				}

	             });
		}

		function add(hash)
		{
			$.ajax({
	            method        : 'GET',
	            cache       : false,
	            dataType    : "json",
	            url         : 'ajax/action.php?hash='+ hash,
	            beforeSend: function () {
             		$("#loading").show()
        		},
		        success: function (repo) {
					$("#loading").hide()
					if(repo.error == 0)
	            	{
	            		$("#msgdanhgia_ok").html(repo.msg);
	            	}
	            	else
	            	{
	            		$("#msgdanhgia_ok").html(repo.msg);
	            	}
				}

	             });
		}
		function remove(hash)
		{
			var xacnhan = confirm("Bạn có muốn xóa link này không?\n* Lưu ý: Thao tác không thể phục hồi");
			if (xacnhan == true) {
			    $.ajax({
	            method      : 'GET',
	            cache       : false,
	            dataType    : "json",
	            url         : 'ajax/action.php?hash='+ hash,
	            beforeSend: function () {
             		$("#loading").show()
        		},
		        success: function (repo) {
					$("#loading").hide()
					if(repo.error == 0)
	            	{
	            		alert(repo.msg);
	            		location.reload();
	            	}
	            	else
	            	{
	            		alert(repo.msg);
	            	}
				}

	             });
			}
			else
			{
				alert("Không xóa thì bấm vào đây làm gì vậy....! kekekek (^.^!)");
			}

		}


		    </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71090934-5', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
