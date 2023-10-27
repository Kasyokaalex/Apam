<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <title>User login - Shoman</title>

    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>/public/css/bootstrap.min.css?v=<?=time() ?>" rel="stylesheet"></link>
    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>/public/css/bootstrap-reboot.css" rel="stylesheet"></link>
    
    <link href="<?=base_url() ?>/public/css/toastr.min.css" rel="stylesheet"></link>
    

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/fonts/flaticons/uicons-solid-rounded.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/css/style.css" />
    <style>form{max-width: 350px;}</style>

</head>

<body style="background-color: #fff;">
    <div class="row">
        <div class="col d-flex justify-content-center align-items-center">
        
            <?php if ($page == 'forgot_password') { ?>
                <form id="forgot_password_form" method="post" action="<?=base_url('account/sendForgotPasswordEmail') ?>">
                    <h3 class="form-signin-heading text-danger" style="font-size: 1.7em">Password Reset</h3>
                    <p style="margin-bottom: 25px; font-size: 14.5px" class="text-muted">Enter the your account email. We will send you a reset link that will expire in 15 minutes. Click it to reset your password</p>
                    <div id="message"></div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address </label>
                        <input type="text" class="form-control" size="20" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="d-flex align-content-stretch" style="margin-top:1em;">
                        <button class="btn btn-danger btn-save" type="submit" id="forgot-password-btn">Send the link</button>
                        <span class="p-2">OR</span>
                        <a class="btn btn-outline-success" href="<?= base_url() . '/login' ?>">Login instead?</a>
                    </div>
                </form>

            <?php } else if ($page == 'reset_password') { ?>

                <form id="change_password_form" method="post" action="<?=base_url() ?>/account/changePassword">

                    <h3 class="form-signin-heading text-danger" style="font-size: 1.7em">Change Password</h3>
                    <p style="margin-bottom: 25px; font-size: 14.5px" class="text-muted">Enter your new password and confirm it to proceed. Incase your reset link is expired, please <a href="<?=base_url() ?>/login/index/forgot_password">Request Another</a> link</p>
                    <input type="hidden" name="token" value="<?=$token ?>" />
                    <div class="form-group">
                        <label for="password" class="form-label">New Password </label>
                        <input class="form-control" id="password" type="password" name="password" placeholder="Enter your new Password" required>
                    </div>
                    <div class="form-group">
                        <label for="conf_password" class="form-label">Confirm Password </label>
                        <input class="form-control" id="confirm_password" type="password" name="confirm_password" placeholder="Confirm your password" required>
                    </div>
                    <div class="d-flex" style="margin-bottom: 20px;">
                        <button class="btn btn-block btn-danger col" style="margin-top:1em;" type="submit" name="submit" id="reset-password-btn">Update Password</button>
                    </div>
                </form>

            <?php } else { ?> <!-- Login Page -->


                <?= form_open(base_url() . '/login/authenticate', array('class' => 'form-signin','id' => 'login_form')) ?>

                    <h3 class="form-signin-heading" style="color: #800080; font-size: 1.7em">Log In</h3>

                    <p style="margin-bottom: 25px; font-size: 14.5px" class="text-muted">Hola! Welcome back. Kindly login to your account to manage your business.</p>

                    <div class="form-group">
                        <label for="username" class="form-label">Username </label>
                        <input class="form-control" size="20" type="text" name="username" id="username" placeholder="Enter your username" autocomplete="nop" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" size="20" id="password" placeholder="Enter your password" autocomplete="nop" required>
                    </div>

                    <div class="text-right" style="margin-bottom: 20px;">
                        <a href="<?= base_url() . '/login/sendForgotPasswordEmail' ?>">Forgot Password?</a>
                    </div>

                    <div class="d-grid col-12">
                        <button class="btn btn-success btn-block btn-save" id="loginButton" type="submit">LOG IN</button>
                    </div>

                <?=form_close(); ?>
            <?php } ?>
        </div>

        <div class="col" style="height: 100vh; margin: 0px;z-index: -1000;background: url('<?= base_url() ?>/public/imgs/bg1.jpg') no-repeat; background-size: cover; background-position: center;">
        </div>

    </div>

    <div height="40px">
        <div class="text-center text-muted" style="padding-right: 5em; font-size: 12.5px;">&copy; Shoman 2018 - <?= date("Y") ?> &middot; Powered by <a style="color: #800080" href="https://www.vintextechnologies.com">Vintex Technologies</a></div>
    </div>
</body>
<!-- <div id="toast-container" class="toast-top-right" aria-live="polite" role="alert"><div class="toast toast-info" style="display: block;"><div class="toast-message">Incorrect Credentials! Try Again</div></div></div> -->
</html>

<script src="<?= base_url(); ?>/public/js/jquery-3.7.0.min.js"></script>
<script src="<?= base_url(); ?>/public/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url(); ?>/public/js/jquery.form.min.js"></script>
<script src="<?=base_url(); ?>/public/js/jquery.validate.min.js"></script>

<script src="<?=base_url(); ?>/public/js/toastr.min.js"></script>


<!-- ALERT MESSAGE HERE -->

<?php if (!empty($error)) { ?>

    <script>
        $('.alert').show();
        setTimeout(function() {
            $('.alert').hide()
        }, 10000);
    </script>

    <div class="alert alert-danger alert-dismissible" role="alert" style="position: fixed;min-width: 300px;top: 30px; right: 50px;">
    
        <div><?= $error; ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>

<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {

        // if Activation is a Success
        <?php if ($_GET['verified'] ?? '' == 'true') { ?>

            set_feedback('success', 'Account Activated Successfully! Please Login');
        <?php } ?>

        $("#login_form input:first").focus();
        <?php if ($noActivation ?? '' == 'true') { ?>

            alertify.confirm("Account Activation", "<span style='font-size:40px;position:absolute;top:68px;' class='fi fi-sr-info text-danger'></span> <div style='margin-left:55px;'>Your account needs to be activated, check your email for activation link</div>",


                function() {

                    window.location.reload();

                }).set('labels', {
                ok: 'Send me the Link Again',
                cancel: 'Am on it'
            });;

        <?php } ?>
        
        
        var forgot_password_settings = {
            submitHandler: function(form) {
                
                $(form).find(".btn-save").html('Sending Email...');
                $(form).find(".btn-save").prop('disabled', true);

                $(form).ajaxSubmit({
                    success: function(response) {

                        if (response.success) {
                            toastr.success(response.message, '', { timeOut: 0, extendedTimeOut: 0, positionClass: 'toast-top-right' });
                        } else {
                            toastr.error(response.message, '', { timeOut: 0, extendedTimeOut: 0, positionClass: 'toast-top-right' });
                        }
                        $(form).find(".btn-save").html('RESEND LINK');
                        $(form).find(".btn-save").prop('disabled', false);
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                email: {
                    required: true,
                    email: true
                }
            }
        };

        $('#forgot_password_form').validate(forgot_password_settings);
        
        var settings = {
            submitHandler: function(form) {
                
                $(form).find(".btn-save").html('Loading...');

                $(form).ajaxSubmit({
                    success: function(response) {

                        if (response.success) {
                            toastr.success(response.message, '', {positionClass: 'toast-top-right' });
                            window.location.href = "<?= base_url('/home'); ?>";
                        } else {
                            toastr.error(response.message, '', { timeOut: 0, extendedTimeOut: 0, positionClass: 'toast-top-right' });
                        }
                        $(form).find(".btn-save").html('LOG IN');
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                username: "required",
                password: "required",

            }
        };

        $('#login_form').validate(settings);
        
        
        
        var changePasswordSettings = {
            
            submitHandler: function(form) {
                                
                $(form).find(".btn-save").html('Changing...');

                $(form).ajaxSubmit({
                    success: function(response) {

                        if (response.success) {
                            toastr.success(response.message, '', {timeOut: 0, extendedTimeOut: 0, positionClass: 'toast-top-right' });
                            window.location.href = "<?= base_url('/home'); ?>";
                        } else {
                            toastr.error(response.message, '', { positionClass: 'toast-top-right' });
                        }
                        $(form).find(".btn-save").html('UPDATE PASSWORD');
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    equalTo: "#password"
                }
            },
            messages: {
                confirm_password: {
                    equalTo: "Passwords do not match!"
                }
            }
        };

        $('#change_password_form').validate(changePasswordSettings);
    });

</script>