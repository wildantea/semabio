<?php
include "../../inc/config.php";
$data_edit = $db->fetch_single_row("tb_data_payment_proof","id",$_POST['id_data']);
?>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="edit_payment_confirmation" method="post" class="form-horizontal" action="<?=base_admin();?>modul/payment_confirmation/payment_confirmation_action.php?act=up">
                            
              <div class="form-group">
                <label for="Account Holder" class="control-label col-lg-2">Account Holder <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="nama_pengirim" value="<?=$data_edit->nama_pengirim;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Bank" class="control-label col-lg-2">Bank <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="asal_bank" value="<?=$data_edit->asal_bank;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="no_rekening_pengirim" class="control-label col-lg-2">no_rekening_pengirim </label>
                <div class="col-lg-10">
                  <input type="text" name="no_rekening_pengirim" value="<?=$data_edit->no_rekening_pengirim;?>" class="form-control" >
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Payment proof" class="control-label col-lg-2">Payment proof <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="file_proof" value="<?=$data_edit->file_proof;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Payment proof" class="control-label col-lg-2">Payment proof <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="file_proof" value="<?=$data_edit->file_proof;?>" class="form-control" required>
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
    
    
    
    
    $("#edit_payment_confirmation").validate({
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
            
          nama_pengirim: {
          required: true,
          //minlength: 2
          },
        
          asal_bank: {
          required: true,
          //minlength: 2
          },
        
          file_proof: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          nama_pengirim: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          asal_bank: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          file_proof: {
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
                            $('#modal_payment_confirmation').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                 dtb_payment_confirmation.draw();
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
