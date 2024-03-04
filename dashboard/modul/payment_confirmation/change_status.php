<?php
session_start();
include "../../inc/config.php";
$data_edit = $db->fetch_custom_single("select * from tb_data_payment_proof where id=?",array("id" => $_POST['id_data']));
$papers = $db->query("select tp.id_user, ta.title_abstract,ta.presenter_name,fungsi_get_jenis_pendaftar(tp.id_user) as reg_as
from tb_data_abstract ta right join tb_data_payment tp
on ta.id=tp.id_abstract
inner join tb_data_payment_detail td on tp.id=td.payment_id
where td.payment_proof_id=?",array('id' => $_POST['id_data']));

$inv = "";
$total_payment = 0;
$paper = array();
$presenter_name = array();
foreach ($papers as $dt) {
  $paper[] = $dt->title_abstract;
  $presenter_name[] = $dt->presenter_name;
}
$user = $db->fetch_single_row("sys_users","id",$data_edit->id_user);
?>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="edit_abstract" method="post" class="form-horizontal" action="<?=base_admin();?>modul/payment_confirmation/payment_confirmation_action.php?act=up_status">
       <div class="form-group">
                <label for="Invoice Number" class="control-label col-lg-2">Akun</label>
                <div class="col-lg-4">
                <input type="text" class="form-control" value="<?=$user->full_name;?>" readonly>
                </div>
              </div><!-- /.form-group -->
              <input type="hidden" name="email_user" value="<?=$user->email;?>">

              
              <?php
              if ($dt->reg_as=='presenter') {
                
             
              $no = 1;
              $label_paper = "";
              $i=0;
              foreach ($paper as $pr) {
                 ?>
                 <div class="form-group">
                <label for="Total" class="control-label col-lg-2">Paper <?=$no;?></label>
                <div class="col-lg-10">
                <div class="input-group">
                <span class="input-group-addon">Presenter</span>
                <input type="text" name="title" value="<?=$presenter_name[$i];?>" class="form-control" readonly>
              </div>
                </div>
              </div><!-- /.form-group -->
                 <div class="form-group">
                <label for="Total" class="control-label col-lg-2">&nbsp;</label>
                <div class="col-lg-10">
                <div class="input-group">
                <span class="input-group-addon">Title</span>
                <input type="text" name="title" value="<?=$pr;?>" class="form-control" readonly>
              </div>
                </div>
              </div><!-- /.form-group -->
              <?php
              $i++;
              $no++;
              }
               }
              ?>
       <div class="form-group">
                <label for="Invoice Number" class="control-label col-lg-2">Jumlah</label>
                <div class="col-lg-4">
                  <div class="input-group">
                <span class="input-group-addon">Rp. </span>
                <input type="text" class="form-control" value="<?=number_format($data_edit->jumlah,0,",",".");?>" readonly>
                <input type="hidden" name="jumlah" value="<?=$total_payment;?>">
              </div>
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
              <label for="Topic" class="control-label col-lg-2">Status Bayar<span style="color:#FF0000">*</span></label>
            <div class="col-lg-10">
              <select name="status" class="form-control" tabindex="2">
  <?php
                     $option = array(
'unverified' => 'Unverified',
'verified' => 'Verified',
'invalid' => 'Invalid'
);
                     foreach ($option as $isi => $val) {

                        if ($data_edit->status_payment==$isi) {
                          echo "<option value='$data_edit->status_payment' selected>$val</option>";
                        } else {
                       echo "<option value='$isi'>$val</option>";
                          }
                     } ?>
              </select>
          </div>
                      </div><!-- /.form-group -->
              <input type="hidden" name="id" value="<?=$data_edit->id;?>">

              <div class="form-group">
                <div class="col-lg-12">
                  <div class="modal-footer"> 
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang["cancel_button"];?></button>
                  <button type="submit" class="btn btn-primary save-data"><i class="fa fa-save"></i> Change Status</button>
                  </div>
                </div>
              </div><!-- /.form-group -->

            </form>

<script type="text/javascript">
    
    $(document).ready(function() {
    
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
         submitHandler: function(form) {
            $("#loadnya").show();
            $(form).ajaxSubmit({
                url : $(this).attr("action"),
                dataType: "json",
                type : "post",
                error: function(data ) { 
                  $("#loadnya").hide();
                  console.log(data); 
                  $(".save-data").prop("disabled", false);
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
