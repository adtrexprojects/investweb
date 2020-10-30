<?php
//Verify if user is logged in and act accordingly
session_start(); // start session

//START User Verification
if(isset($_SESSION['logDin_user_email']) ){    
    header('Location: '.$home_dir.'index.php'); // Redirecting To Home Page  
    exit();
}
//END user verification

//??????????????????
$err_msg = "";
if (isset($_GET['err_msg'])) {
    $err_msg = $_GET['err_msg'];
}

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$act_msg = "";
if (isset($_GET['act_msg'])) {
    $act_msg = $_GET['act_msg'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OrangeCard - Authentication | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

 <!-- Favicon and Touch Icons -->
<link rel="apple-touch-icon" sizes="180x180" href="dist/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="dist/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="dist/img/favicon/favicon-16x16.png">
<link rel="manifest" href="dist/img/favicon/site.webmanifest">
    
</head>
<body class="hold-transition login-page" style="background:url(dist/img/idera.jpg) no-repeat center center fixed;
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important;
    margin: 0px;
">
<div class="login-box">
  <div class="login-logo" style="margin-bottom: 5px;">
    <img src="dist/img/logo_dark.png" height="50px" style="margin-bottom: 10px; margin-right: -5px">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">
      <strong>Sign in to Access your Account.</strong><br/>
      <small>You don't have an Account? <a href="../#register" class="text-center">Register</a></small>
    </p>

    <?php 
    if (!empty($err_msg) && ($err_msg == "inputs_error" || $err_msg == "wrong_pass") ) {
    ?>   
        <div class="alert alert-danger fade in" style="text-align: center;" >
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-times-circle fa-fw fa-lg"></i>
            <strong style="border-bottom: 2px solid;"> ACCESS ERROR!</strong><br/> <br/> <strong>Check your login credentials.</strong>
        </div>
    <?php 
    }else if (!empty($err_msg) && ($err_msg == "wrong_ID") ) {
    ?>   
        <div class="alert alert-danger fade in" style="text-align: center;" >
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-times-circle fa-fw fa-lg"></i>
            <strong style="border-bottom: 2px solid;"> ACCESS ERROR!</strong><br/> <br/> <strong>Check your login credentials.</strong>
        </div>
    <?php     
    }else if (!empty($err_msg) && ($err_msg == "not_activated") ) {
    ?>   
        <div class="alert alert-danger fade in" style="text-align: center;" >
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-times-circle fa-fw fa-lg"></i>
            <strong style="border-bottom: 2px solid;"> ACCESS ERROR!</strong><br/> <br/> <strong>Check your login credentials.</strong>
        </div>
    <?php     
    }else if ( $status == "verification" && $act_msg == "success" ) {
    ?>   
        <div class="alert alert-success fade in" style="text-align: center;" >
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-check fa-fw fa-lg"></i>
            <strong style="border-bottom: 2px solid;">Email Verification Successful</strong><br/> <br/> <strong>Check your login credentials. </strong>
        </div>
    <?php 
    } 
    ?> 

    <form action="forms/form_login.php" method="post" name="login_form" id="login_form">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php if(isset($_SESSION["admin_userID"]) && $_SESSION["admin_userID"] != ""){echo $_SESSION["admin_userID"];} ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="#">Forgot Password</a><br/><br/>
    <div style="text-align: center;">
      Back to <a href="../index.php" class="text-center">orangecard.ng</a>
    </div>
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
<?php
  $_SESSION["admin_userID"] ="";
?>


</html>
