<?php 
session_start();
include "dashboard/inc/config.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
   
   <!-- special jquery jQuery 2.1.3 -->
    <script src="<?=base_admin();?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!--form asset -->
    <!-- Bootstrap 3.3.2 -->
    <link href="<?=base_admin();?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
   <!-- Theme style -->
    <link href="<?=base_admin();?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
     <!--switch button -->
       <link href="<?=base_admin();?>assets/plugins/chosen/chosen.min.css" rel="stylesheet" type="text/css" />
 <!--image preview -->
  <link href="<?=base_admin();?>assets/plugins/holder/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?=base_admin();?>assets/plugins/select2/select2.min.css">

  <body class="hold-transition register-page">
    <div class="register-box hold-transition register-page">
      <div class="register-logo" style="font-size: 30px">
        <a href="#"><b>Forgot your password?</b></a>
      </div>
       <div class="register-box-body notif-success" style="padding-left: 0;padding-right: 0;display: none" >
       <div id="warning-success" class="callout callout-success">
        <div id="warning_message">
        </div>
      </div>
    </div>
    
      <div class="forget-content">
      <div id="warning" class="callout callout-info" style="margin-bottom:0">
        <div id="warning_message">
         Enter your email address to reset your password. You may need to check your spam folder 
        </div>
      </div>
     <div id="warning-email" class="callout callout-danger" style="margin-bottom:0;display: none">
        <div id="error-email">
          error
        </div>
      </div>
 
      <div class="register-box-body">
        <p class="login-box-msg">Reset Password</p>
        <form id="forget" action="<?=base_url();?>forget.php">
          <div class="form-group has-feedback">
            <input id="email" name="email" type="text" class="form-control" placeholder="Email" required="">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat submit-button">Send <img src="ajax-loader.gif" class="loader-button" style="display: none;"></button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.form-box -->
    </div>
    </div><!-- /.register-box -->
    <script src="<?=base_admin();?>assets/login/js/jqueryform.js"></script>
  <script src="<?=base_admin();?>assets/login/js/validate.js"></script>
 <script type="text/javascript">
   $(document).ready(function(){

   $("#forget").validate({
        errorClass: "help-block",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").removeClass(
                "has-success").addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").removeClass(
                "has-error").addClass("has-success");
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("select2")) {
                 element.parent().append(error);
            } else if (element.attr("accept") == "image/*") {
                element.parent().parent().parent().append(error);
            }
            else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            }
            else if (element.hasClass("file-upload-data")) {
               element.parent().parent().parent().append(error);
            }
            else if (element.attr("type") == "checkbox") {
                element.parent().parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        rules: {
            
                 email : {
                    required:true,
                    email : true,
                },
        
        },
         messages: {
                 email: {
                  required:"Enter your email",
                 }
        },
    
    submitHandler: function(form) {
             $('.submit-button').attr('disabled', 'disabled');
             $('.loader-button').show();
            $(form).ajaxSubmit({
                url : $(this).attr("action"),
                dataType: "json",
                type : "post",
                error: function(data ) { 
                  console.log(data); 
                  $('.submit-button').attr('disabled', false);
                  $('.loader-button').hide();
                  $("#error-email").text(data['responseText']);
                   $("#warning-email").focus()
                   $("#warning-email").fadeIn();
                },
                success: function(responseText) {
                      $.each(responseText, function(index) {
                          console.log(responseText[index].status);
                          if(responseText[index].status=="error") {
                            $('.submit-button').attr('disabled', false);
                            $('.loader-button').hide();
                             $("#error-email").html(responseText[index].error_message);
                             $("#warning-email").focus()
                             $("#warning-email").fadeIn();
                          } else if(responseText[index].status=="good") {
                            $(".forget-content").html('');
                            $("#warning_message").html(responseText[index].success);
                            $(".notif-success").show();
                            console.log(responseText);
                          }
                    });
                }

            });
        }
    });

  });
 </script>
  </body>
</html>