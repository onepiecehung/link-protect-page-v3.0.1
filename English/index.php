<?php
/* >_ Developed by Vy Nghia */
error_reporting(0);
require_once 'login.php';
if(mysql_error()){
  die('Unable to connect to SQL Server, please re-configure it');
}
if(isset($accessToken)){
	function userID($Token){
		global $userID;
		$ProfileApi = 'https://graph.facebook.com/me?access_token='.$Token;
		$user = json_decode(file_get_contents($ProfileApi, true));
		$userID = $user->id;
	}
} else {
	$userID = 0;
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
Hi, <a href="https://facebook.com/<?php echo $userID ?>" target="_blanks"><strong><?php echo isset($profile['name']) ? $profile['name'] : 'You are not logged in'; ?></strong></a>
</div>
</div>
<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Lock content</div>
<div class="panel-body">
<div class="row">

<div class="col-xs-12" style="text-align: center">
<?php if(empty($accessToken)): ?>
<div id="status">To continue using, please click the button "<strong>Login</strong>".<br /><img src="assets/img/down.gif" /></div>
<center><a href="<?php echo $loginUrl ?>"><button id="btn-ketnoi" class="btn btn-primary btn-fill">Login</button></a>
<br />
<br />
(Note: If this is your first time using the Application, you will be asked to submit your Public Information. Besides, We do not exploit any of your rights).</center>
<?php else: ?>
<div id="status">Look above and click on the one you need</div>
<?php endif; ?>
</div>
</div>
</div>
</div>
<!-- Ads
<div class="panel panel-default">
<div class="panel-body">
<iframe data-aa='533838' src='//ad.a-ads.com/533838?size=990x90' scrolling='no' style='width:990px; height:90px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
<div id="qc" style="font-weight: bold; font-size: 17px;text-align: center;"></div>
</div>
</div> -->
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
