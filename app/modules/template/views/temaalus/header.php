<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php echo $this->alus_auth->description_application(); ?>">
  <meta name="keywords" content="<?php echo $this->alus_auth->keyword_application(); ?>">
  <meta name="author" content="<?php echo $this->alus_auth->author_application(); ?>">

  <link rel="icon" href="<?php echo base_url('assets/logo/mini.png'); ?>" type="image/gif" sizes="20x20">
  <title><?php echo $title; ?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/dist/fontawesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/dist/ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/dist/css/skins/_all-skins.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/temaalus/dist/css/toasty.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/temaalus/dist/css/bootstrap-datetimepicker.min.css'); ?>">
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/temaalus/dist/js/jquery.cookie.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>assets/temaalus/bootstrap/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/temaalus/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <!-- Toasty Notif -->
  <script src="<?php echo base_url(); ?>assets/temaalus/dist/js/toasty.js"></script>


  <!-- <script type="text/javascript">
    $(document).ready(function() {
    $('.navbar a.dropdown-toggle').on('click', function(e) {
        var $el = $(this);
        var $parent = $(this).offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if(!$parent.parent().hasClass('nav')) {
            $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
        }

        $('.nav li.open').not($(this).parents("li")).removeClass("open");

        return false;
    });
});

  </script> -->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition sidebar-mini <?php echo $this->config->item('skin_page'); ?>">
  <div class="wrapper">

    <header class="main-header">
      <a href="<?php echo base_url('dashboard'); ?>" class="logo">
        <span class="logo-mini">
          <!-- <img src="<?php echo base_url('assets/logo/mini.png'); ?>" height="50%" width="50%"> -->
        </span>
        <span class="logo-lg">
          <!-- <img src="<?php echo base_url('assets/logo/mini.png'); ?>" height="18%" width="18%"> -->
          <!-- <b>ALUS</b> BASE -->
        </span>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-bell"></i>
                <span class="label label-danger">0</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header"><i class="fa fa-bullhorn"></i> Anda memiliki 0 notifikasi baru</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                  </ul>
                </li>
                <li class="footer"><a href="#" onclick="read_all_notif()">Mark all as read</a></li>

              </ul>
            </li>
            <!-- END NOTIF -->
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <?php if (file_exists(base_url('assets/avatar') . "/" . $this->session->userdata('avatar'))) { ?>
                  <img src="<?php echo base_url('assets/avatar') . "/" . $this->session->userdata('avatar'); ?>" class="user-image" alt="Avatar">
                <?php } else { ?>
                  <img src="<?php echo base_url('assets/avatar'); ?>/avatar_default.png" class="user-image" alt="Avatar">
                <?php } ?>
                <span class="hidden-xs"><?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <?php if (file_exists(base_url('assets/avatar') . "/" . $this->session->userdata('avatar'))) { ?>
                    <img src="<?php echo base_url('assets/avatar') . "/" . $this->session->userdata('avatar'); ?>" class="img-circle" alt="Avatar">
                  <?php } else { ?>
                    <img src="<?php echo base_url('assets/avatar'); ?>/avatar_default.png" class="img-circle" alt="Avatar">
                  <?php } ?>
                  <p>
                    <?php echo $this->session->userdata('job'); ?>
                    <small><?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?></small>
                  </p>
                </li>
                <!-- Menu Body -->

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo base_url('user_profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo base_url(); ?>admin/login/logout" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
        <!-- /.container-fluid -->
      </nav>
    </header>

    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <?php if (file_exists(base_url('assets/avatar') . "/" . $this->session->userdata('avatar'))) { ?>
              <img src="<?php echo base_url('assets/avatar') . "/" . $this->session->userdata('avatar'); ?>" class="img-circle" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo base_url('assets/avatar'); ?>/avatar_default.png" class="img-circle" alt="User Image">
            <?php } ?>
          </div>
          <div class="pull-left info">
            <p><?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <?php echo $this->Alus_hmvc->get_menu(); ?>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <script>
      var csrf_nm = '<?php echo $this->config->item("csrf_token_name"); ?>';
      var csrf_ck = '<?php echo $this->config->item("csrf_cookie_name"); ?>';
      $.ajaxSetup({
        beforeSend: function(xhr, settings) {
          switch (settings.type) {
            case "POST":
              settings.data += "&" + csrf_nm + "=" + get_newer();
              break;
          }
        }
      });

      function get_newer() {
        return $.cookie(csrf_ck);
      }

      function popup(ms = null, timess = null) {
        if (timess == null) {
          timess = 3000;
        }
        if (ms == null) {
          $().toasty({
            message: "Berhasil",
            autoHide: timess
          });
        } else {
          $().toasty({
            message: ms,
            autoHide: timess
          });
        }
      }

      function read_flag(id_ptn) {
        $.ajax({
          url: '<?php echo base_url(); ?>dashboard/read_flag_notif/' + id_ptn,
          type: 'get',
          success: function(data) {
            return true;
          }
        });
      }

      function read_all_notif() {
        $.ajax({
          url: '<?php echo base_url(); ?>dashboard/read_all_notif/',
          type: 'get',
          success: function(data) {
            location.reload();
          }
        });
      }
    </script>