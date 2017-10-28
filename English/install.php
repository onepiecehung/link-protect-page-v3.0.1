<?php
/* Developed by Vy Nghia */
session_start();
require '_system/config.php';
if(isset($_POST['web']) && isset($_POST['page']) && isset($_POST['dbhost']) && isset($_POST['dbuser']) && isset($_POST['dbpass']) && isset($_POST['dbname'])){
  echo 'ok';
      
  $ConfigFile = fopen("_system/config.php", "w") or die("Cannot create this file!");
  $ConfigContent = '<?php
/* >_ Developed by Vy Nghia */
require \'class/ProtectClass.php\';

//default config
define(\'PAGEID\', \''.$_POST['page'].'\');
define(\'WEBURL\', \''.$_POST['web'].'\');

$db = new Database;
$db->dbhost(\''.$_POST['dbhost'].'\');
$db->dbuser(\''.$_POST['dbuser'].'\');
$db->dbpass(\''.$_POST['dbpass'].'\');
$db->dbname(\''.$_POST['dbname'].'\');

$db->connect();

//Facebook App
$FacebookAppID = \''.$_POST['FBAID'].'\';
$FacebookAppSecret = \''.$_POST['FBASecret'].'\';

//Google Api
$GoogleApiKey = \''.$_POST['GGKey'].'\';';
  fwrite($ConfigFile, $ConfigContent);
  fclose($ConfigFile);
  exit;
}

if(isset($_POST['password'])){
  $Password = 'Please not anti-gay'; //option password
  if($_POST['password'] == $Password){
    echo (01);
    $_SESSION['install'] = true;
    exit;
  } else {
    echo (02);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Link Protect</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
</div><div class="container">
<div class="row">
</div>
<div class="panel panel-primary">
<div class="panel-heading">Configuration</div>
<div class="panel-body">
<div class="row">
  <?php if(isset($_SESSION['install'])): ?>
  <?php if(mysql_error()): ?>
    <div class="alert alert-danger"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cannot connect!</strong> Unable to connect to your MySQL ....</div>
  <?php else: ?>
    <div class="alert alert-success"><strong><i class="fa fa-check" aria-hidden="true"></i> Connacted!</strong> Connected to your MySQL ....</div>
  <?php endif; ?>
  <form class="form-horizontal" method="POST">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="2"><center>The conditions about PHP </center></th>
      </tr>
      <tr>
        <th>Conditon</th>
        <th width="180px">Version</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Minimum requirements</td>
        <td>5.x.x</td>
      </tr>
      <tr>
        <td>Standard requirements</td>
        <td>5.6.x</td>
      </tr>
      <tr>
        <td>PHP version on your server</td>
        <td><?php echo phpversion() ?> (<a href="php/version" target="_blank">View details</a>)</td>
      </tr>
    </tbody>
  </table>
  <h3>Format targ</h3>
  <div class="form-group">
  <label for="title" class="col-sm-2 control-label">Website</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="web" name="web" placeholder="http://domain.com" value="<?php echo WEBURL ?>">
  <small>*GDomain names that include http: // at the end of the domain may not have / (VD: http://domain.com, http://domain.com/) </small>
  </div>
  </div>

  <div class="form-group">
  <label for="title" class="col-sm-2 control-label">Page ID</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="page" name="page" placeholder="http://domain.com" value="<?php echo PAGEID ?>">
  <small>*Only supports Page ID / Fanpage on Facebook</small>
  </div>
  </div>

  <h3>Databse (MySQL)</h3>
  <div class="form-group">
  <label for="title" class="col-sm-2 control-label">DB Host</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="dbhost" name="dbhost" placeholder="Default localhost" value="<?php $db->dbinfo('dbhost') ?>">
  </div>
  </div>

  <div class="form-group">
  <label for="description" class="col-sm-2 control-label">DB Username</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="dbuser" name="dbuser" placeholder="MySQL server username" value="<?php $db->dbinfo('dbuser') ?>">
  </div>
  </div>

  <div class="form-group">
  <label for="description" class="col-sm-2 control-label">DB Password</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="dbpass" name="dbpass" placeholder="MySQL server password" value="<?php $db->dbinfo('dbpass') ?>">
  </div>
  </div>

  <div class="form-group">
  <label for="description" class="col-sm-2 control-label">DB Name</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="dbname" name="dbname" placeholder="MySQL server databse name" value="<?php $db->dbinfo('dbname') ?>">
  </div>
  </div>

  <h3>Interactive Data Api</h3>
  <div class="form-group">
  <label for="description" class="col-sm-2 control-label">Google Api Key</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="GGKey" name="GGkey" placeholder="Google Short URL Api Key" value="<?php echo $GoogleApiKey ?>">
  </div>
  </div>

  <div class="form-group">
  <label for="description" class="col-sm-2 control-label">Facebook App ID</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="FBAID" name="FBAID" placeholder="Facebook App ID" value="<?php echo $FacebookAppID ?>">
  </div>
  </div>

  <div class="form-group">
  <label for="description" class="col-sm-2 control-label">Facebook App Secret</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="FBASecret" name="FBASecret" placeholder="Facebook App Secret" value="<?php echo $FacebookAppSecret ?>">
  </div>
  </div>
  <div class="col-xs-12" style="text-align: center;">
  <button id="install" type="button" class="btn btn-warning btn-fill">Cập nhật cấu hình</button>
  </div>
  </form>
<?php else: ?>
  <form class="form-horizontal" method="POST">
  <div class="form-group">
  <label for="description" class="col-sm-2 control-label">Password access</label>
  <div class="col-sm-10">
  <input type="password" class="form-control" id="PasswordAccess" name="PasswordAccess" placeholder="Password access this file" value="">
  </div>
  </div>
  <div class="col-xs-12" style="text-align: center;">
  <button id="login" type="button" class="btn btn-warning btn-fill">Access</button>
  </div>
  </form>
  <div id="loginStatus"></div>
<?php endif ?>
</div>
</div>
</div>
<footer class="footer" style="font-size:12px;">
<p style="font-size:13px;">&copy; <?php echo date('Y') ?> Vy Nghia</p>
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
<script src="assets/js/bootstrap-wysihtml5.js?v=1508435276"></script>
<script src="assets/js/clipboard.min.js"></script>
<script>
<?php if(isset($_SESSION['install'])): ?>
$( "#install" ).on( "click", function() {
  var web = $('#web').val()
  var page = $('#page').val()
  var GGKey = $('#GGKey').val()
  var FBAID = $('#FBAID').val()
  var FBASecret = $('#FBASecret').val()
  var dbhost = $('#dbhost').val()
  var dbuser = $('#dbuser').val()
  var dbpass = $('#dbpass').val()
  var dbname = $('#dbname').val()
  $.ajax({
  method: 'POST',
  url: 'install.php',
  data: { web: web, page: page, GGKey: GGKey, FBAID: FBAID, FBASecret: FBASecret, dbhost: dbhost, dbuser: dbuser, dbpass: dbpass, dbname: dbname },
  beforeSend: function () {
    $("#loading").show()
  },
  success: function (data) {
      $("#loading").hide()
      if(data == 'ok'){
        location.reload();
      }
    }
  });
});
<?php else: ?>
$("#PasswordAccess").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#login").click();
    }
});
$( "#login" ).on( "click", function() {
  var password = $('#PasswordAccess').val()
  if(!password){
    $('#loginStatus').html('<br /><div class="alert alert-warning"><strong>Note!</strong> Please do not leave the password blank!</div>')
  } else {
    $.ajax({
    method: 'POST',
    url: 'install.php',
    data: { password: password },
    beforeSend: function () {
      $("#loading").show()
    },
    success: function (data) {
        $("#loading").hide()
        if(data == 01){
          $('#loginStatus').html('<br /><div class="alert alert-success"><strong>Logged in successfully!</strong> Is performing a login ....</div>')
          location.reload();
        } else {
          $('#loginStatus').html('<br /><div class="alert alert-danger"><strong>Login failed!</strong> You may have entered the wrong password, please try again!</div>')
        }
      }
    });
  }
});
<?php endif; ?>
</script>
</body>
</html>
