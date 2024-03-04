<?php
session_start();
include "../../../inc/config.php";
$data_edit = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_data']);
?>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="edit_abstract" method="post" class="form-horizontal" action="<?=base_admin();?>modul/submission/submission_admin/change_status.php?act=up_reviewer">
<?php
$get_reviewer = $db->query("select * from tb_data_reviewer where id_abstract=? order by urutan asc",array('id_abstract' => $data_edit->id));
if ($get_reviewer->rowCount()>0) {
  $i=1;
  foreach ($get_reviewer as $review) {
    ?>
          <div class="form-group row-clone">
              <label for="Tanggal Lahir" class="control-label col-lg-2">Reviewer <?=$i;?><span style="color:#FF0000">*</span></label>
              <div class="col-lg-7">
              <select name="id_user[]" id="id_user<?=$i;?>" class="form-control chzn-select rev" tabindex="2" required="">
              <option value=""></option>
  <?php

$reviewer = $db->query("select * from sys_users where group_level='reviewer'");
                     foreach ($reviewer as $rev) {

                        if ($review->id_reviewer==$rev->id) {
                          echo "<option value='$rev->id' selected>$rev->full_name</option>";
                        } else {
                       echo "<option value='$rev->id'>$rev->full_name</option>";
                          }
                     } ?>
              </select>
              </div>
             <div class="col-lg-3" style="font-weight:bold;padding-left: 0;padding-right: 0;">
               <span class="btn btn-success add_clone" data-toggle="tooltip" data-title="Tambah Reviewer Lain"><i class="fa fa-plus"></i></span>
               <span class="btn btn-danger remove_clone" data-toggle="tooltip" data-title="Hapus Reviewer"><i class="fa fa-trash"></i></span>
               <?php
               $array_login = array('root','administrator');
                if (in_array($_SESSION['group_level'],$array_login)) {
                  $login_as = '<a href="'.base_admin().'inc/login_as.php?id='.$review->id_reviewer.'&adm_id=1" class="btn btn-success btn-sm" data-toggle="tooltip" title="" data-original-title="Login As Reviewer"><i class="fa fa-user"></i></a>';
                  echo $login_as;
                }
                ?>
             </div>
          </div><!-- /.form-group -->
    <?php
     $i++;
  }
 
} else {
  ?>
          <div class="form-group row-clone">
              <label for="Tanggal Lahir" class="control-label col-lg-2">Reviewer <span style="color:#FF0000">*</span></label>
              <div class="col-lg-8">
              <select name="id_user[]" id="id_user<?=$i;?>" class="form-control chzn-select rev" tabindex="2" required="">
              <option value=""></option>
  <?php

$reviewer = $db->query("select * from sys_users where group_level='reviewer'");
                     foreach ($reviewer as $rev) {

                        if ($review->id_reviewer==$rev->id) {
                          echo "<option value='$rev->id' selected>$rev->full_name</option>";
                        } else {
                       echo "<option value='$rev->id'>$rev->full_name</option>";
                          }
                     } ?>
              </select>
              </div>
             <div class="col-lg-2" style="font-weight:bold;padding-left: 0;padding-right: 0;">
               <span class="btn btn-success add_clone" data-toggle="tooltip" data-title="Tambah Reviewer Lain"><i class="fa fa-plus"></i></span>
               <span class="btn btn-danger remove_clone" data-toggle="tooltip" data-title="Hapus Reviewer"><i class="fa fa-trash"></i></span>

             </div>
          </div><!-- /.form-group -->
  <?php
}
?>


<input type="hidden" name="id_abstract" value="<?=$data_edit->id;?>">

              <div class="form-group">
                <div class="col-lg-12">
                  <div class="modal-footer"> 
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang["cancel_button"];?></button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                  </div>
                </div>
              </div><!-- /.form-group -->

            </form>

<script type="text/javascript">
    

    $(document).ready(function() {

var user_id = 0;
$("#edit_abstract").on('click','.add_clone',function(event) {
  //$(".row-clone:last").clone().insertAfter(".row-clone:last");
  $(".chzn-select").chosen('destroy');

  var cloned = $(this).parent().parent().clone().insertAfter( $(this).parent().parent());

  user_id++;

  cloned.find('.rev').attr('id','id_user'+user_id);

  $(".chzn-select").chosen();
   // $(this).parent().parent().clone().appendTo('.clone-embed');
   // cloned.find('.var_name').val('');
   // cloned.find('.rev').html('');
   console.log(user_id);
    cloned.find('.rev').val("");
    cloned.find('.rev').trigger("chosen:updated");
});
$("#edit_abstract").on('click','.remove_clone',function(event) {
    var jml_element = $('.row-clone').length;
    if (jml_element>1) {
      $(this).parent().parent().remove();
    }
});

        //trigger validation onchange
      $('select').on('change', function() {
          $(this).valid();
      });
      //hidden validate because we use chosen select
      $.validator.setDefaults({ ignore: [] });
      //chosen select
      $(".chzn-select").chosen();
      $(".chzn-select-deselect").chosen({
          allow_single_deselect: true
      });
          
    $("#edit_abstract").validate({
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
        rules : {
          "id_user[]" : {
            required : true
          }
        },
        messages: {

          "id_user[]": {
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
                            $('#modal_status_change').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                 dtb_abstract.draw(false);
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
