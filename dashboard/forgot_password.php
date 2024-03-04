<!DOCTYPE html>
<html>
(中略)
  <body class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="../../lib/adminlte/index2.html"><b>Admin</b>LTE</a>
      </div>
 
      <div id="warning" class="callout callout-danger">
        <h4>Warning!</h4>
        <div id="warning_message">
          This is a message.
          This is a message.
          This is a message.
        </div>
      </div>
 
      <div class="register-box-body">
        <p class="login-box-msg">Reset Password</p>
        <form>
          <div class="form-group has-feedback">
            <input id="password" type="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="password_confirmation" type="password" class="form-control" placeholder="Retype password">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button id="register" type="button" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        </form>
 
        <a href="login.html" class="text-center">I already have a membership</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
 
    <!-- jQuery 2.1.4 -->
    <script src="../../lib/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../lib/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../../lib/adminlte/plugins/iCheck/icheck.min.js"></script>
    <!-- common -->
    <script src="../../assets/javascript/config.js"></script>
    <script>
      // reset passoword function.
      function reset_password(token){
        var input = {
          user: {
            password: $("#password").val(),
            password_confirmation: $("#password_confirmation").val()
          }
        };
 
        $.ajax({
          url: requestUrl('api/v1/password_resets/' + token + '.json'),
          type: 'PUT',
          data: input,
          dataType: 'json',
          complete: function(XMLHttpRequest, textStatus, errorThrown) {
            switch (XMLHttpRequest.status){
              case 200:
                sessionStorage.info = 'Reset password success. Please login.';
                document.location.href = "login.html";
                break;
              case 404:
                $("#warning").toggle();
                $("#warning_message").text('Request is not found.');
                break;
              case 406:
                $("#warning").toggle();
                $("#warning_message").text('Reset password failed. Please check your passwords.');
              default:
                console.log("error");
                break;
            }
          }
        });
      }
 
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
 
        $("#warning").css("display", "none");
 
        // register.
        $("#register").click(function(){
          var parameters = location.href.split("?");
          var token = parameters[1].split("=")[1];
 
          // token check, reset password.
          $.ajax({
            url: requestUrl('api/v1/password_resets/' + token + '/edit.json'),
            type: 'GET',
            dataType: 'json',
            complete: function(XMLHttpRequest, textStatus, errorThrown) {
              switch (XMLHttpRequest.status){
                case 200:
                  reset_password(token);
                  break;
                case 404:
                  $("#warning").toggle();
                  $("#warning_message").text('Request is not found.');
                  break;
                default:
                  console.log("error");
                  break;
              }
            }
          });
 
        });
      });
    </script>
  </body>
</html>