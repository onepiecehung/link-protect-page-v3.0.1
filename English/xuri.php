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
<meta name="description" content="Hide anti-ninja link, protect link share on group, facebook fanpage, increase interactivity for posts">
<meta property="og:title" content="Link Protect" />
<meta property="og:image" content="logo.png" />
<meta property="og:site_name" content="Link Protect" />
<meta property="og:description" content="Hide anti-ninja link, protect link share on group, facebook fanpage, increase interactivity for posts" />
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
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="/">Home</a></li>
<li class="btn btn-primary btn-round bttn-unite bttn-lg bttn-primary"><a href="logout.php">Logout</a></li>
</ul>
</div>
</div>
</nav>
<?php endif; ?>
</div>
<div class="row">
<div class="col-xs-12" style="text-align: center">
Hi, <a href="https://facebook.com/" target="_blanks"><strong><?php echo isset($userName) ? $userName : 'You are not logged in'; ?></strong></a>
</div>
</div>
<div class="container">
<?php if(isset($accessToken)): ?>
<div class="row">
<div class="col-sm-3">
<div class="panel panel-primary">
<div class="panel-heading"><i class="fa fa-user-circle"></i> Sharer</div>
<ul class="list-group">
<a href="https://www.facebook.com/<?php echo $CreatorID ?>" target="_blanks"><li class="list-group-item" style="text-align: center;"><img src="https://graph.facebook.com/<?php echo $CreatorID ?>/picture?type=large&redirect=true&width=80&height=80" alt="<?php echo $CreatorID ?>" class="img-circle">
<div style="font-weight: bold;"><?php echo $CreatorName ?></div></li></a>
<li class="list-group-item" style="font-weight: bold; color: green">Report:</li>
<li class="list-group-item" style="color: gray"><i class="fa fa-bug"></i>Link Virus: 0 / 0 bài</li>
<li class="list-group-item" style="color: red"><i class="fa fa-minus-circle"></i>Spam: 0 / 0 bài</li>
</ul>
</div>
</div>
<div class="col-sm-9">
<div class="panel panel-primary">
<div class="panel-heading"><i class="fa fa-info-circle"></i> General Information</div>
<div class="panel-body">
<div class="row">
<div class="panel panel-default" style="margin-left: 10px; margin-right: 10px;">
<div class="panel-body" style="word-wrap: break-word">
<center><strong>Link bài viết gốc:</strong><br />
<a style="color: black; font-size: 17px;" <?php echo ($FoundPostURL !== null) ? 'href="'.$FoundPostURL.'"' : null;?> target="_blank" ><?php echo ($FoundPostURL !== null) ? $FoundPostURL : 'This link link has not been updated the article link in the page';?></a></center>
</div>
</div>
<div class="col-xs-12">
<strong>Kiểm tra điều kiện mở khóa:</strong><br />
<?php if($URL['tags_require'] == 1): ?>
<label class="checkbox ct-blue" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo (max($tagsCount, 0) == 0) ? 'checked' : 'unchecked'; ?>><?php echo (max($tagsCount, 0) == 0) ? 'You\'ve finished tagging 3 friends' : 'Please tag your 3 friends on the above post (can be accumulated)'; ?></label>
<?php else: ?>
<label class="checkbox ct-blue" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo (isset($FoundPost)) ? 'checked' : null; ?>><?php echo (isset($FoundPost)) ? 'Confirmed #hashtag for this link' : 'This link is not attached to #hashtag'; ?></label>
<?php endif; ?>
<label class="checkbox ct-red" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo ($Liked == true) ? 'checked' : null; ?>><?php echo ($Liked == true) ? 'You liked the post of this link' : 'You do not like the post of this link'; ?></label>
<label class="checkbox ct-orange" for="checkbox1"><input type="checkbox" value="" data-toggle="checkbox" <?php echo (empty($PasswordLocked)) ? 'checked' : null; ?>><?php echo (empty($PasswordLocked)) ? 'Password Locked - OK!' : 'This link has a password, please enter the password of this link to unlock it'; ?></label>
<?php if(isset($PasswordLocked)): ?>
<form action="" method="POST">
<div class="input-group">
<input type="text" name="password" class="form-control" placeholder="Vui lòng nhập mật khẩu">
<span class="input-group-btn">
<button class="btn btn-info btn-fill" type="submit"><i class="fa fa-unlock"></i> Unlock</button>
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
<div class="panel-heading">Lock content</div>
<div class="panel-body">
<div class="col-xs-12" style="text-align: center">
<div id="status">To continue using, please click the button "<strong>Login</strong>".<br /><img src="assets/img/down.gif" /></div>
<center><a href="<?php echo $loginUrl ?>"><button id="btn-ketnoi" class="btn btn-primary btn-fill">Login</button></a>
<br />
<br />
(Note: If this is your first time using the Application, you will be asked to submit your Public Information. Besides, We do not exploit any of your rights).</center>
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
<div class="panel-heading"><i class="fa fa-unlock"></i> Hidden content</div>
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
<span style="color: green; font-weight: bold;">Link Information:</span><br>
<span style="color: red; font-weight: bold;">- <i class="fa fa-bug"></i> Report Virus: </span>0 (times)<br>
<span style="color: gray; font-weight: bold;">- <i class="fa fa-minus-circle"></i> Report Spam: </span>0 (times)
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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71090934-5', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
