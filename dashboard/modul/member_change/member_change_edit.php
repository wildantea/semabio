<?php
include "../../inc/config.php";
$data_edit = $db->fetch_single_row("tb_data_member","id_user",$_POST['id_data']);
$data_user = $db->fetch_single_row("sys_users","id",$_POST['id_data']);
?>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="edit_member_change" method="post" class="form-horizontal" action="<?=base_admin();?>modul/member_change/member_change_action.php?act=up">
<input type="hidden" name="id_user" value="<?=$data_user->id;?>">
              <div class="form-group">
                <label for="Full Name" class="control-label col-lg-2">Full Name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="full_name" value="<?=$data_user->full_name;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
            <div class="form-group">
                <label for="Gender" class="control-label col-lg-2">Gender </label>
                <div class="col-lg-10">
                    <select id="sex" name="sex" data-placeholder="Pilih Gender..." class="form-control chzn-select" tabindex="2" >
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
                <label for="City" class="control-label col-lg-2">City <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="city" value="<?=$data_edit->city;?>" class="form-control" required>
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
                <label for="Telephone/Mobile" class="control-label col-lg-2">Telephone/Mobile <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="phone" value="<?=$data_edit->phone;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-2">Email</label>
                        <div class="col-lg-10">
                          <input type="text" id="email" name="email" value="<?=$data_user->email;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Affiliation" class="control-label col-lg-2">Affiliation <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="affiliation" value="<?=$data_edit->affiliation;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
      <div class="form-group">
                        <label for="nama_foto" class="control-label col-lg-2">Foto</label>
                        <div class="col-lg-10">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px;">
                             <img src="../../upload/back_profil_foto/<?=$data_user->foto_user?>">
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
              
              <input type="hidden" name="id" value="<?=$data_edit->id;?>">

              <div class="form-group">
                <div class="col-lg-12">
                  <div class="modal-footer"> 
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang["cancel_button"];?></button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                  </div>
                </div>
              </div><!-- /.form-group -->

            </form>

<script type="text/javascript">
    
    $(document).ready(function() {
    
    
    
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
        
    
    $("#edit_member_change").validate({
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
            
        
        
          city: {
          required: true,
          //minlength: 2
          },
        
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
        
        },
         messages: {
            
        
        
          city: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
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
                            $('#modal_member_change').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                 location.reload();
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
