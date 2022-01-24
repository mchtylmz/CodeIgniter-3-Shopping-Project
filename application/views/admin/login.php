<?php  ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo html_escape($title); ?> - <?php echo html_escape($this->general_settings->application_name); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>"/>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/_all-skins.min.css">

    <!-- Custom css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/custom.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style media="screen">
      .bg-image {
        background-image: url('<?=base_url()?>assets/img/fashion-bg.jpg');
        background-position: top;
        background-repeat: no-repeat;
        background-size: auto;
      }
    </style>
</head>

<body class="hold-transition login-page bg-image">
<div class="login-box">
    <div class="login-logo">
        <a href="<?php echo admin_url(); ?>login"
          style="
          padding: 3px 9px;
          text-shadow: 0 0 20px black, 0 0 20px black;
          color: white;
          background-color: rgba(0,0,0,0.2);
          "><b><?php echo html_escape($this->general_settings->application_name); ?></b>&nbsp;<?php echo trans("panel"); ?></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <h4 class="login-box-msg"><?php echo trans("login"); ?></h4>

        <!-- include message block -->
        <?php $this->load->view('admin/includes/_messages'); ?>

        <!-- form start -->
        <?php if ($recaptcha_status) {
            echo form_open('common_controller/admin_login_post', ['id' => 'form_validate', 'class' => 'validate_terms',
                'onsubmit' => "var serializedData = $(this).serializeArray();var recaptcha = ''; $.each(serializedData, function (i, field) { if (field.name == 'g-recaptcha-response') {recaptcha = field.value;}});if (recaptcha.length < 5) { $('.g-recaptcha>div').addClass('is-invalid');return false;} else { $('.g-recaptcha>div').removeClass('is-invalid');}"]);
        } else {
            echo form_open('common_controller/admin_login_post');
        } ?>

        <div class="form-group has-feedback">
            <label class="form-control-label">Email Adresi</label>
            <input type="email" name="email" class="form-control form-input"
                   placeholder="<?php echo trans("email"); ?>" autocomplete="off"
                   value="<?php echo old('email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <label class="form-control-label">Şifre</label>
            <input type="password" name="password" class="form-control form-input"
                   placeholder="<?php echo trans("password"); ?>" autocomplete="off"
                   <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
            <span class=" glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <label class="form-control-label">Giriş Kodu</label>
            <input type="text" name="code" minlength="4" class="form-control form-input"
                   placeholder="XXXX.." autocomplete="off" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
        </div>

        <?php if ($recaptcha_status): ?>
            <div class="recaptcha-cnt">
                <?php generate_recaptcha(); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-8 col-xs-12">
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    <?php echo trans("login"); ?>
                </button>
            </div>
            <!-- /.col -->
        </div>

        <?php echo form_close(); ?><!-- form end -->
    </div>

</div>
</body>
</html>
