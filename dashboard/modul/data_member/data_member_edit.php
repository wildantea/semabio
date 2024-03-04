<!-- Content Header (Page header) -->
              <section class="content-header">
                  <h1>Data Member</h1>
                    <ol class="breadcrumb">
                        <li>
                        <a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a>
                        </li>
                        <li>
                        <a href="<?=base_index();?>data-member">Data Member</a>
                        </li>
                        <li class="active"><?php echo $lang["edit"];?> Data Member</li>
                    </ol>
              </section>

              <!-- Main content -->
              <section class="content">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="box box-solid box-primary">
                          <div class="box-header">
                              <h3 class="box-title"><?php echo $lang["edit"];?> Data Member</h3>
                              <div class="box-tools pull-right">
                                  <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-pencil"></i></button>
                              </div>
                          </div>
                      <div class="box-body">
                       <div class="alert alert-danger error_data" style="display:none">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="isi_warning"></span>
                      </div>
                          <form id="edit_data_member" method="post" class="form-horizontal" action="<?=base_admin();?>modul/data_member/data_member_action.php?act=up">

 <div class="form-group">
                <label for="Full Name" class="control-label col-lg-2">Full Name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="full_name" value="<?=$data_user->full_name;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Username" class="control-label col-lg-2">Username <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="username" value="<?=$data_user->username;?>" class="form-control" readonly>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Email" class="control-label col-lg-2">Email <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text"  data-rule-email="true" name="email" value="<?=$data_user->email;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                        <label for="Photo" class="control-label col-lg-2">Photo <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                             <img src="<?=base_url();?>upload/back_profil_foto/<?=$data_user->foto_user?>" class="myImage">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="foto_user" accept="image/*">
                              </span>
                              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.form-group -->


                            <div class="form-group">
                        <label for="Country" class="control-label col-lg-2">Country <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <select  id="country_id" name="country_id" data-placeholder="Pilih Country..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("tb_ref_country") as $isi) {

                  if ($data_edit->country_id==$isi->id) {
                    echo "<option value='$isi->id' selected>$isi->country_name</option>";
                  } else {
                  echo "<option value='$isi->id'>$isi->country_name</option>";
                    }
               } ?>
              </select>
          </div>
                      </div><!-- /.form-group -->

              <div class="form-group">
                <label for="Phone" class="control-label col-lg-2">Phone <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="phone" value="<?=$data_edit->phone;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Affiliation" class="control-label col-lg-2">Affiliation <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="affiliation" value="<?=$data_edit->affiliation;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="City" class="control-label col-lg-2">City <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="city" value="<?=$data_edit->city;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
            <div class="form-group">
                <label for="Gender" class="control-label col-lg-2">Gender <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                    <select id="sex" name="sex" data-placeholder="Pilih Gender..." class="form-control chzn-select" tabindex="2" required>
                      <option value=""></option>
                     <?php
                     $option = array(
'Male' => 'Male',

'Female' => 'Female',
);
                     foreach ($option as $isi => $val) {

                        if ($data_edit->sex==$isi) {
                          echo "<option value='$data_edit->sex' selected>$val</option>";
                        } else {
                       echo "<option value='$isi'>$val</option>";
                          }
                     } ?>
                    </select>
                  </div>
            </div><!-- /.form-group -->
            
<div class="form-group">
                        <label for="Group user" class="control-label col-lg-2">Group user <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <select  id="group_level" name="group_level" data-placeholder="Pilih Group user..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
              <?php foreach ($db->fetch_all("sys_group_users where level in('presenter','participant')") as $isi) {

                  if ($data_user->group_level==$isi->level) {
                    echo "<option value='$isi->level' selected>$isi->level_name</option>";
                  } else {
                  echo "<option value='$isi->level'>$isi->level_name</option>";
                    }
               } ?>
              </select>
          </div>
                      </div><!-- /.form-group -->
            <div class="form-group">
                <label for="Active" class="control-label col-lg-2">Active </label>
                <div class="col-lg-10">
                <?php if ($data_user->aktif=="Y") {
                ?>
                  <input name="aktif" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="aktif" data-on-text="Yes" data-off-text="No" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->
            
                            <input type="hidden" name="id" value="<?=$data_user->id;?>">
                            <div class="form-group">
                                <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                                <div class="col-lg-10">
                                <a href="<?=base_index();?>data-member" class="btn btn-default "><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                                </div>
                            </div><!-- /.form-group -->
                          </form>
                      </div>
                  </div>
              </div>
              </section><!-- /.content -->

<script type="text/javascript">
    $(document).ready(function() {
    
      $.each($(".make-switch"), function () {
            $(this).bootstrapSwitch({
            onText: $(this).data("onText"),
            offText: $(this).data("offText"),
            onColor: $(this).data("onColor"),
            offColor: $(this).data("offColor"),
            size: $(this).data("size"),
            labelText: $(this).data("labelText")
            });
          });
        
    
      //trigger validation onchange
      $('select').on('change', function() {
          $(this).valid();
      });
      //hidden validate because we use chosen select
      $.validator.setDefaults({ ignore: ":hidden:not(select)" });
      //chosen select
      $(".chzn-select").chosen();
      $(".chzn-select-deselect").chosen({
          allow_single_deselect: true
      });
        
    
    $("#edit_data_member").validate({
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
            if (element.hasClass("chzn-select")) {
                var id = element.attr("id");
                error.insertAfter("#" + id + "_chosen");
            } else if (element.attr("accept") == "image/*") {
                element.parent().parent().parent().append(error);
            } else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            } else if (element.hasClass("file-upload-data")) {
               element.parent().parent().parent().append(error);
            } else if (element.attr("type") == "checkbox") {
                element.parent().parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        rules: {
            
          country_id: {
          required: true,
          //minlength: 2
          },
        
          phone: {
          required: true,
          //minlength: 2
          },
        
          affiliation: {
          required: true,
          //minlength: 2
          },
        
          city: {
          required: true,
          //minlength: 2
          },
        
          sex: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          country_id: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          phone: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          affiliation: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          city: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          sex: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
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
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                    window.history.back();
                            });
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
