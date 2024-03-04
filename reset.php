<?php 
session_start();
include "dashboard/inc/config.php";

$get_token = $db->fetch_single_row("tb_reset_pass","token",$_GET['token']);

if ($get_token) {
  if (strtotime(date('Y-m-d H:i:s'))>=$get_token->exp_time) {
    $db->delete('tb_reset_pass','id_user',$get_token->id_user);
     echo '<h1>Link is expired</h1>';
     exit();
  } 

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
    <div class="register-box">
      <div class="register-logo" style="font-size: 30px">
        <a href="#"><b>Reset Password</b></a>
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
        Enter your new password
        </div>
      </div>
     <div id="warning-email" class="callout callout-danger" style="margin-bottom:0;display: none">
        <div id="error-email">
          error
        </div>
      </div>
 
      <div class="register-box-body">
        <p class="login-box-msg">Reset Password</p>
        <form id="forget" action="<?=base_url();?>action_forget.php">
          <div class="form-group has-feedback">
            <input id="password" name="password" type="password" class="form-control" placeholder="New Password" required="">
            <span class="glyphicon glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirm New Password" required="">
            <span class="glyphicon glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <input type="hidden" name="token" value="<?=$get_token->token;?>">
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
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
                 password : {
                    minlength : 3,
                    required:true
                },
                confirm_password : {
                    minlength : 3,
                    required:true,
                    equalTo : "#password"
                }
        
        },
         messages: {
                password: {
                  required:"Enter your new password",
                   minlength:"Use 3 characters or more for your password",
                 },
                 confirm_password: {
                  required:"confirm your password",
                  minlength:"Use 3 characters or more for your password",
                  equalTo:"Those passwords didn't match. Try Again"
                 }
        },
    
    submitHandler: function(form) {
            $("#loadnya").show();
            $(form).ajaxSubmit({
                url : $(this).attr("action"),
                dataType: "json",
                type : "post",
                error: function(data ) { 
                  $("#loadnya").hide();
                  console.log(data); 
                },
                success: function(responseText) {
                  console.log(responseText);
                  $("#loadnya").hide();
                  console.log(responseText);
                      $.each(responseText, function(index) {
                          console.log(responseText[index].status);
                          if(responseText[index].status=="error") {
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
<?php

} else {
   echo '<h1>Link is expired</h1>';
}
?>