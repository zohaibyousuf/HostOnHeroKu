<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e($settings->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap-datepicker.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap-select.min.css') ?>" type="text/css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css') ?>" type="text/css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?php echo asset('css/fontastic.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?php echo asset('css/grasp_mobile_progress_circle-1.0.0.min.css') ?>" type="text/css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') ?>" type="text/css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('css/style.default.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('css/custom.css') ?>" type="text/css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/bootstrap-datepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/popper.js/umd/popper.min.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/grasp_mobile_progress_circle-1.0.0.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery.cookie/jquery.cookie.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('vendor/chart.js/Chart.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/charts-home.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/front.js') ?>"></script>
  </head>
  <body>
    <div class="page login-page">
      <div class="container">
        <div class="form-outer text-center d-flex align-items-center">
          <div class="form-inner">
            <div class="logo text-uppercase"><span><?php echo e($settings->site_title); ?></span></div>
            <form method="POST" action="<?php echo e(route('login')); ?>" id="login-form">
              <?php echo csrf_field(); ?>
              <div class="form-group-material">
                <input id="login-username" type="text" name="username" required class="input-material" value="admin">
                <label for="login-username" class="label-material"><?php echo e(trans('file.UserName')); ?></label>
              </div>
              <div class="form-group-material">
                <input id="login-password" type="password" name="password" required class="input-material" value="admin">
                <label for="login-password" class="label-material"><?php echo e(trans('file.Password')); ?></label>
              </div>
              <button type="submit" class="btn btn-primary"><?php echo e(trans('file.LogIn')); ?></button>
            </form>
            <!-- This should be submit button but I replaced it with <a> for demo purposes-->
            <!-- <button type="submit" class="btn btn-success admin-btn">LogIn as Admin</button>
            <button type="submit" class="btn btn-info staff-btn">LogIn as Staff</button>
            <br><br> -->
            <a href="<?php echo e(route('password.request')); ?>" class="forgot-pass"><?php echo e(trans('file.Forgot Password?')); ?></a>
          </div>
          <div class="copyrights text-center">
            <p><?php echo e(trans('file.Developed By')); ?> <a href="http://lion-coders.com" class="external">LionCoders</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
    $('.admin-btn').on('click', function(){
        $("input[name='username']").focus().val('admin');
        $("input[name='password']").focus().val('admin');
        
        //$("#login-form").submit();
    });

  $('.staff-btn').on('click', function(){
      $("input[name='username']").focus().val('staff');
      $("input[name='password']").focus().val('staff');
      //$("#login-form").submit();
  });
</script>