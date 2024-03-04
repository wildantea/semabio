<?php
include "../../inc/config.php";
?>
 <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
      <form id="input_data_rekening" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/data_rekening/data_rekening_action.php?act=in">
                      
              <div class="form-group">
                <label for="Nama Bank" class="control-label col-lg-2">Nama Bank <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="nama_bank" placeholder="Nama Bank" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Atas Nama" class="control-label col-lg-2">Atas Nama <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="nama_pemilik" placeholder="Atas Nama" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="No Rekening" class="control-label col-lg-2">No Rekening <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="no_rekening" placeholder="No Rekening" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Cabang" class="control-label col-lg-2">Cabang <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="cabang" placeholder="Cabang" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
                      

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
    
     
    
    
    $("#input_data_rekening").validate({
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
            
          nama_bank: {
          required: true,
          //minlength: 2
          },
        
          nama_pemilik: {
          required: true,
          //minlength: 2
          },
        
          no_rekening: {
          required: true,
          //minlength: 2
          },
        
          cabang: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          nama_bank: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          nama_pemilik: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          no_rekening: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          cabang: {
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
                            $('#modal_data_rekening').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top").fadeIn(1000);
                            $(".notif_top").fadeOut(1000, function() {
                                dtb_data_rekening.draw();
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
