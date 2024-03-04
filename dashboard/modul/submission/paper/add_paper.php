<?php
session_start();
include "../../../inc/config.php";
$id_user = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
$id_user = $id_user->id_user;
?>
 <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>

      <form id="input_input_setara" method="post" action="<?=base_admin();?>modul/submission/paper/chat_action.php?act=paper_in">
              <div class="form-group">
                <label for="Presenter" class="control-label">Description<span style="color:#FF0000">*</span></label>
                  <input type="text" name="message" placeholder="Description" class="form-control" required>
              </div><!-- /.form-group -->

              <input type="hidden" name="id_abstract" value="<?=$_POST['id_abstract'];?>">
              <input type="hidden" name="id_user" value="<?=$id_user;?>">

              <div class="form-group">
                        <label for="city" class="control-label">Full Paper</label>
              <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="file_name"  class="file-upload-data" required="">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                      </div><!-- /.form-group -->

              <div class="form-group">
                <button type="submit" class="btn btn-primary save-data"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
              </div><!-- /.form-group -->
 
      </form>
<script type="text/javascript">
    
    $(document).ready(function() {

      //trigger validation onchange
      $('select').on('change', function() {
          $(this).valid();
      });

      //chosen select
      $(".chzn-select").chosen();
      $(".chzn-select-deselect").chosen({
          allow_single_deselect: true
      });
        
      //hidden validate because we use chosen select
      $.validator.setDefaults({ ignore: [] });
    
    $("#input_input_setara").validate({
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
        
    submitHandler: function(form) {
            $(".loader-paper-add").show();
            $(".save-data").attr("disabled", "disabled");
            $(form).ajaxSubmit({
                url : $(this).attr("action"),
                dataType: "json",
                type : "post",
                error: function(data ) { 
                  $(".save-data").attr("disabled", false);
                  $("#loadnya").hide();
                  console.log(data); 
                  $(".isi_warning").html(data.responseText);
                  $(".error_data").focus()
                  $(".error_data").fadeIn();
                },
                success: function(responseText) {
                  $(".loader-paper-add").hide();
                  console.log(responseText);
                      $.each(responseText, function(index) {
                          console.log(responseText[index].status);
                          if (responseText[index].status=="die") {
                            $("#informasi").modal("show");
                          } else if(responseText[index].status=="error") {
                            $(".save-data").attr("disabled", false);
                             $(".isi_warning").text(responseText[index].error_message);
                             $(".error_data").focus()
                             $(".error_data").fadeIn();
                          } else if(responseText[index].status=="good") {
                            $(".save-data").attr("disabled", "disabled");
                            $(".error_data").hide();
                            $(".notif_top").fadeIn(500);
                            $(".notif_top").fadeOut(500, function() {
                                   dtb_paper.ajax.reload();
                                $('#add-paper').find('.fa').toggleClass('fa-minus fa-plus');
                                $("#input_paper_form").html('');
                                $("#input_paper_form").slideUp();
                            });
                          }
                    });
                }

            });
        }
    });
});

</script>
