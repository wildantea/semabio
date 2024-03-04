<?php 
session_start();
/*header("location:./");
exit();*/
include "dashboard/inc/config.php";
$setting_conference = $db->fetch_single_row("tb_ref_setting_conference","is_aktif","Y");


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Pendaftaran <?=$setting_conference->conference_name;?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
     <link rel="shortcut icon" type="image/png" href="<?=base_admin();?>assets/user.png">

   <!-- special jquery jQuery 2.1.3 -->
    <script src="<?=base_admin();?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!--form asset -->
    <!-- Bootstrap 3.3.2 -->
    <link href="<?=base_admin();?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
   <!-- Theme style -->
  
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
     <!--switch button -->
       <link href="<?=base_admin();?>assets/plugins/chosen/chosen.min.css" rel="stylesheet" type="text/css" />
 <!--image preview -->
  <link href="<?=base_admin();?>assets/plugins/holder/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?=base_admin();?>assets/plugins/select2/select2.min.css">
  <link href="<?=base_admin();?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
@media (min-width: 768px) {
  .content {
    margin-left:20%;
  }
}
body {
  background: url("<?=base_admin();?>assets/oriental.png");
}
</style>
    </head>
  <body>
   <div class="fakeloader"></div>
   <div id="loadnya" style="display:none">
    <img src="<?=base_admin();?>assets/dist/img/loadnya.gif" class="ajax-loader"/>
</div>

<?php
if ($setting_conference) {
?>
<!--notif here -->
<div class="notif_top" style="display:none">
  <div class="alert alert-success" style="margin-left:0">
  <button class="close" data-dismiss="alert">×</button>
  <center><strong>Berhasil Registrasi</strong></center>
</div>
</div>
            
              
                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-9"> 
        <div class="box box-success box-solid" style="display: none">
                                 <div class="box-header">
                                    <h3 class="box-title">Pendaftaran berhasil</h3>

                                </div>

                  <div class="box-body" style="text-align: center">
                    <img src="<?=base_admin();?>assets/success.png">
                    <h4 class="content-success">
                    </h4>
                  </div>
        </div>
        <div class="box box-solid box-primary box-reg">
                                 <div class="box-header">
                                    <h3 class="box-title">Pendaftar <?=$setting_conference->conference_name;?></h3>

                                </div>

                  <div class="box-body">
 <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
<form id="reg" method="post" class="form-horizontal" action="reg.php">
                      <div class="form-group">
                        <label for="First Name" class="control-label col-lg-3">Nama Lengkap <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="text" id="full_name" name="full_name" placeholder="Nama Lengkap" class="form-control" required data-msg-required="Silakan isi nama Lengkap anda">
                        </div>
                      </div><!-- /.form-group -->

                      <div class="form-group">
                        <label for="First Name" class="control-label col-lg-3">Gelar Depan</label>
                        <div class="col-lg-2">
                          <input type="text" id="gelar_depan" name="gelar_depan" placeholder="Dr." class="form-control">
                          <div class="text-helper">Silakan isi jika ada</div>
                        </div>
                         <label for="First Name" class="control-label col-lg-2">Gelar Belakang</label>
                          <div class="col-lg-2">
                         <input type="text" id="gelar_belakang" name="gelar_belakang" placeholder="M.Si" class="form-control">
                       </div>
                      </div><!-- /.form-group -->

                      <div class="form-group">
                        <label for="First Name" class="control-label col-lg-3">Jenis Kelamin <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <select class="form-control" id="sex" name="sex">
                            <option value="Male">Laki - Laki</option>
                            <option value="Female">Perempuan</option>
                          </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-3">Jenis Partisipasi <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
<select class="form-control chzn-select" name="is_presenter" id="is_presenter">
  <option value="">Pilih Jenis Partisipasi</option>
  <?php 
  foreach ($db->fetch_all("jenis_partisipasi") as $isi) {
    echo "<option value='$isi->id'>$isi->jenis_partisipasi</option>";  
  } 
  ?>
        </select>
        <span  class="help-block" style="margin-bottom:0">Pemakalah: Bisa Kirim abstract, paper. <br>
        Non-Pemakalah: Tidak bisa Kirim abstract, paper.<br><span>
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Last Name" class="control-label col-lg-3">Kategori Peserta <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                        
                        <select class="form-control select2" name="kategori_daftar" required="" id="kategori_daftar" placeholder="Pilih Kategori Peserta" data-msg-required="Wajib diisi">
                          </select>
                        </div>
                      </div><!-- /.form-group -->
                      <div id="isi_syarat"></div>
<div class="form-group institution">
                        <label for="Last Name" class="control-label col-lg-3">Asal Institusi <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="text" id="affiliation" name="affiliation" placeholder="Institution" class="form-control" required="" data-msg-required="Wajib diisi"> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Email" class="control-label col-lg-3">Alamat Lengkap <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="text" id="city" name="city" value="Bandung" class="form-control" required data-msg-required="Wajib diisi"> 
                        </div>
                      </div><!-- /.form-group -->
                      <input type="hidden" name="country_id" value="104">

<div class="form-group">
                        <label for="Email" class="control-label col-lg-3">Nomor Handphone/Wa <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="text" id="phone" name="phone" placeholder="Nomor Handphone/Wa" class="form-control" required data-msg-required="Wajib diisi"> 
                        </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Email" class="control-label col-lg-3">Email <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="email" id="email" data-rule-email="true" name="email" placeholder="Email" class="form-control" required data-msg-required="Wajib diisi"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Last Name" class="control-label col-lg-3">Username <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="text" id="username" name="username" placeholder="Username" class="form-control" required data-msg-required="Wajib diisi"> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Password Baru" class="control-label col-lg-3">Password <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="password" id="password" name="password" class="form-control" data-msg-required="Wajib diisi"> 
                        </div>
                      </div><!-- /.form-group -->
                       <div class="form-group">
                        <label for="Password Baru" class="control-label col-lg-3">Konfirmasi Ulang Password <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-7">
                          <input type="password" id="password_confirm" name="password_confirm" class="form-control" data-msg-required="Wajib diisi"> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-3">&nbsp;</label>
                        <div class="col-lg-9">
                          <input type="submit" class="btn btn-primary" value="Register">
                        </div>
                      </div><!-- /.form-group -->
                      <div class="border-top card-body text-center">Sudah punya akun ? <a href="<?=base_admin();?>login.php">Log In</a></div>
                    </form>       
                  </div>

                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
 <!--form asset -->
 <!-- jQuery 2.1.3 -->
   <script src="<?=base_admin();?>assets/login/js/jqueryform.js"></script>
  <script src="<?=base_admin();?>assets/login/js/validate.js"></script>
    
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=base_admin();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="<?=base_admin();?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?=base_admin();?>assets/plugins/holder/holder.js" type="text/javascript"></script>
<script src="<?=base_admin();?>assets/plugins/holder/jasny-bootstrap.min.js" type="text/javascript"></script>
         <!-- add new calendar event modal -->
 <script>
$(document).ready(function(){
  
    $(".select2").select2();
 $(".select2").on("select2:close", function (e) {  
        $(this).valid(); 
    });

  $("#is_presenter").change(function(){
                  $.ajax({
            type : "post",
            url : "<?=base_url();?>get_kat.php",
            data : {par:this.value},
            success : function(data) {
              $("#isi_syarat").html('');
                $("#kategori_daftar").html(data);
                $("#kategori_daftar").select2();
            }
        });

            });


  $("#kategori_daftar").change(function(){
                  $.ajax({
            type : "post",
            url : "<?=base_url();?>get_syarat.php",
            data : {par:this.value},
            success : function(data) {
                $("#isi_syarat").html(data);
            }
        });

            });
/*
$("#from").change(function(){
  if (this.value=='N') {
    $("#institution").val("");
    $("#institution").attr("placeholder", "Type your Institution");
  } else {
    $("#institution").attr("placeholder", "Type your Institution");
    $("#institution").val("<?=$db->fetch_single_row("tb_ref_setting_conference","id",1)->host_conference_name;?>");
  }
});*/
            });
$(document).ready(function(){

   $("#reg").validate({
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
                password_confirm : {
                    minlength : 3,
                    required:true,
                    equalTo : "#password"
                }
        
        },
         messages: {
            
                 password: {
                  required:"Enter password",
                  minlength:"Use 3 characters or more for your password",
                 },
                 password_confirm: {
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
                          if (responseText[index].status=="die") {
                            $("#informasi").modal("show");
                          } else if(responseText[index].status=="error") {
                             $(".isi_warning").text(responseText[index].error_message);
                             $(".error_data").focus()
                             $(".error_data").fadeIn();
                          } else if(responseText[index].status=="good") {
                            $(".box-reg").remove();
                            $(".content-success").html(responseText[index].email_status);
                            $(".box-success").fadeIn();
                            console.log(responseText);
                          } else {
                             console.log(responseText);
                             $(".isi_warning").text(responseText[index].error_message);
                             $(".error_data").focus()
                             $(".error_data").fadeIn();
                          }
                    });
                }

            });
        }
    });

  });
        </script>
        <?php
      } else {
?>
<div class="notif_top">
  <div class="alert alert-warning" style="margin-left:0">
  <button class="close" data-dismiss="alert">×</button>
  <center><strong>Saat ini belum ada seminar yang dibuka</strong></center>
</div>
</div>
<?php
      }
      ?>
  </body>
</html>
