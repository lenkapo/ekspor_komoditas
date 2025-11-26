<!-- Product Alus Solution Licenced PHP Script -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?php echo base_url('assets/temaalus/image/mini.png'); ?>" type="image/gif" sizes="20x20">
  <title>Login | Alus Base</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
  <!-- Icon Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/temaalus/img/favicon.png">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/plugins/iCheck/square/blue.css">
  <!-- toasty notif -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/temaalus/dist/css/toasty.css" >

  <!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">
  .cover{
    background: rgba(147,206,222,1);
    background-size: cover;
  }
  </style>
</head>

<body class="hold-transition login-page cover">
<div class="login-box">
  <div class="login-logo">
    <a href="" style='color:#fff;'><b>ALUS BASE</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="<?php echo base_url('admin/Login/login'); ?>" method="post" id="form">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="identity">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
     <!-- <div class="g-recaptcha" data-theme="light" data-sitekey="6LdVbg8UAAAAALev4WfQ3is84fRty4XVJg6VWnOb" style="transform:scale(1.06);transform-origin:0;-webkit-transform:scale(1.06);transform:scale(1.06);-webkit-transform-origin:0 0;transform-origin:0 0;"></div>
        
      </div> -->
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox">
            <label>
            	<a href="<?php echo base_url('forgot_password/');?>"> Forgot Password ?</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="button" class="btn btn-primary btn-block btn-flat" id="submitform">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/jquery.cookie.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/temaalus/bootstrap/js/bootstrap.min.js"></script>
<!-- maul login -->
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/m_login.js"></script>
<!-- Toasty Notif -->
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/toasty.js"></script>
</body>
</html>
