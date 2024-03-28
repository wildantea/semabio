<?php
session_start();
include "../../inc/config.php";
//get payment last
$last_payment = $db->fetch_single_row("tb_ref_setting_conference","is_aktif",'Y');
if (date('Y-m-d H:i:s')>$last_payment->last_payment) {
  echo "Upload Bukti Pembayaran sudah ditutup";
  exit();
}
$data_edit = $db->fetch_custom_single("select title_abstract, tb_data_payment.* from tb_data_payment left join tb_data_abstract
on tb_data_payment.id_abstract=tb_data_abstract.id
where tb_data_payment.id=?",array('id' => $_POST['id_data']));
?>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="edit_payment_proof" method="post" class="form-horizontal" action="<?=base_admin();?>modul/payment_proofs/payment_proofs_action.php?act=in">
<input type="hidden" name="id_payment" value="<?=$data_edit->id;?>">
              <div class="form-group">
                <label for="Invoice Number" class="control-label col-lg-2">Inv</label>
                <div class="col-lg-2">
                  <input type="text" name="inv_number" value="#<?=$data_edit->inv_number;?>" class="form-control" readonly>
                </div>
                <div class="col-lg-4">
                  <div class="input-group">
                <span class="input-group-addon">Rp. </span>
                <input type="text" class="form-control" value="<?=number_format($data_edit->jumlah,0,",",".");?>" readonly>
                <input type="hidden" name="jumlah" value="<?=$data_edit->jumlah;?>">
              </div>
                </div>
              </div><!-- /.form-group -->
<?php
if ($_SESSION['group_level']=='presenter') {
  ?>
              <div class="form-group">
                <label for="Total" class="control-label col-lg-2">Paper</label>
                <div class="col-lg-10">
                  <input type="text" name="title" value="<?=$data_edit->title_abstract;?>" class="form-control" readonly>
                </div>
              </div><!-- /.form-group -->
  <?php
}
?>

              
              <div class="form-group">
                <label for="Bank Account" class="control-label col-lg-2">Bank Account <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="asal_bank" class="form-control" placeholder="BCA/BRI/BNI" required>
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                <label for="Account bank name" class="control-label col-lg-2">Account Holder<span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="nama_pengirim" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
          <div class="form-group">
              <label for="Account number" class="control-label col-lg-2">Account No</label>
              <div class="col-lg-10">
                <input type="text" data-rule-number="true" name="no_rekening_pengirim" class="form-control" required>
              </div>
          </div><!-- /.form-group -->
          <div class="form-group">
              <label for="transfer date" class="control-label col-lg-2">Transfer Date <span style="color:#FF0000">*</span></label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker">
                    <input type="text" autocomplete="off" class="form-control tgl_picker_input" name="date_payment" required autocomplete="off"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
               <!-- in case you need two column <div class="col-lg-1" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">S/d</div> -->
          </div><!-- /.form-group -->

              <div class="form-group">
                        <label for="Payment proof" class="control-label col-lg-2">Payment proof <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="file_proof" accept="image/*" class="file-upload-data">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          <span>Pilih Gambar/Photo Bukti Bayar</span>
                          </div>
                        </div>

                      </div><!-- /.form-group -->

              <input type="hidden" name="id" value="<?=$data_edit->id;?>">

              <div class="form-group">
                <div class="col-lg-12">
                  <div class="modal-footer"> 
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang["cancel_button"];?></button>
                  <button type="submit" class="btn btn-primary save-data"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                  </div>
                </div>
              </div><!-- /.form-group -->

            </form>

<script type="text/javascript">
    
    $(document).ready(function() {
    
         $(".tgl_picker").datepicker({ 
        format: "yyyy-mm-dd",
        autoclose: true, 
        todayHighlight: true
        }).on("change",function(){
          $(":input",this).valid();
        });
       
    
    
    $("#edit_payment_proof").validate({
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
            
          jumlah: {
          required: true,
          //minlength: 2
          },
        
          nama_pengirim: {
          required: true,
          //minlength: 2
          },
        
          no_rekening_pengirim: {
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
            
          jumlah: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          nama_pengirim: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          no_rekening_pengirim: {
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
            $(".save-data").attr("disabled", "disabled");
            $(form).ajaxSubmit({
                url : $(this).attr("action"),
                dataType: "json",
                type : "post",
                error: function(data ) { 
                  $("#loadnya").hide();
                  console.log(data); 
                  $(".save-data").prop("disabled", false);
                  $(".isi_warning").html(data.responseText);
                  $(".error_data").focus()
                  $(".error_data").fadeIn();
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
                            $(".save-data").attr("disabled", "disabled");
                            $('#modal_payment_proof').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                 dtb_payment_proofs.draw();
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
