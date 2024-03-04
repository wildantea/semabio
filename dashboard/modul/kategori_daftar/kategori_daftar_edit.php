<?php
include "../../inc/config.php";
$data_edit = $db->fetch_single_row("kategori_daftar","id_kat",$_POST['id_data']);
$tgl_awal = substr($data_edit->tanggal_open,0,10);
$tgl_selesai = substr($data_edit->tanggal_close,0,10);

$time_awal = substr($data_edit->tanggal_open, -8);
$time_awal = substr($time_awal,0,5);
$time_selesai = substr($data_edit->tanggal_close, -8);
$time_selesai = substr($time_selesai,0,5);

$tgl_awal_label = getHariFromDate($data_edit->tanggal_open).', '.tgl_indo($tgl_awal);
$tgl_akhir_label = getHariFromDate($data_edit->tanggal_close).', '.tgl_indo($tgl_selesai);

?>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="edit_kategori_daftar" method="post" class="form-horizontal" action="<?=base_admin();?>modul/kategori_daftar/kategori_daftar_action.php?act=up">

   <div class="form-group">
                        <label for="Jenis Partisipasi" class="control-label col-lg-3">Jenis Partisipasi <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-9">
              <select  id="id_jenis_partisipasi" name="id_jenis_partisipasi" data-placeholder="Pilih Jenis Partisipasi..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenis_partisipasi") as $isi) {

                  if ($data_edit->id_jenis_partisipasi==$isi->id) {
                    echo "<option value='$isi->id' selected>$isi->jenis_partisipasi</option>";
                  } else {
                  echo "<option value='$isi->id'>$isi->jenis_partisipasi</option>";
                    }
               } ?>
              </select>
          </div>
                      </div><!-- /.form-group -->
              <div class="form-group">
                <label for="Nama Kategori" class="control-label col-lg-3">Nama Kategori <span style="color:#FF0000">*</span></label>
                <div class="col-lg-9">
                  <input type="text" name="nama_kategori" value="<?=$data_edit->nama_kategori;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
           


   <div class="form-group">
                <label for="Nominal Tagihan" class="control-label col-lg-3">Nominal Biaya <span style="color:#FF0000">*</span></label>
                               <div class="col-lg-4">
<div class="input-group">
            <div class="input-group-addon">Rp.</div>
            <input id="auto" type="text" name="biaya_daftar" class="form-control grouping" data-a-sep="." data-a-dec="," required=""  value="<?=$data_edit->biaya_daftar;?>">

          </div>
          <span class="help-block">Isi 0 jika tidak ada biaya</span>
                 
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
              <label for="Last Date Payment" class="control-label col-lg-3">Tanggal Buka Daftar  <span style="color:#FF0000">*</span></label>
          <div class="col-lg-4 col-xs-7">
          <div class="input-group date tgl_picker" data-target="tanggal_open">
              <input type="text" class="form-control tgl_picker_input" name="tanggal_open1" readonly  required value="<?=$tgl_awal_label;?>">
              <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
              
              </div>
              <input type="hidden" name="tanggal_open" value="<?=$tgl_awal;?>">
          </div>
             <div class="col-lg-3 col-xs-5" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">Jam</div> 

                <div class="col-lg-3 col-xs-4">
                  <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" min="00:00" max="23:59" value="00:00" required>
                </div>
          </div><!-- /.form-group -->


              <div class="form-group">
              <label for="Last Date Payment" class="control-label col-lg-3">Tanggal Tutup Daftar <span style="color:#FF0000">*</span></label>
          <div class="col-lg-4 col-xs-7">
          <div class="input-group date tgl_picker" data-target="tanggal_close">
              <input type="text" class="form-control tgl_picker_input" name="tanggal_close1" readonly  required value="<?=$tgl_akhir_label;?>">
              <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
              
              </div>
              <input type="hidden" name="tanggal_close" value="<?=$tgl_selesai;?>">
          </div>
             <div class="col-lg-3 col-xs-5" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">Jam</div> 

                <div class="col-lg-3 col-xs-4">
                  <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" min="00:01" max="23:59" value="23:59" required>
                </div>
          </div><!-- /.form-group -->
          

            <div class="form-group">
                <label for="Active" class="control-label col-lg-3">Apakah Mahasiswa ? </label>
                <div class="col-lg-9">
                <?php if ($data_edit->is_mahasiswa=="Y") {
                ?>
                  <input name="is_mahasiswa" data-on-text="Ya" data-off-text="Bukan" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="is_mahasiswa" data-on-text="Ya" data-off-text="Bukan" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->

          
              <input type="hidden" name="id" value="<?=$data_edit->id_kat;?>">

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
       $('#auto').autoNumeric("init",{vMin: '0', vMax: '999999999' });
         $(".tgl_picker").datepicker({
        format: "DD, dd MM yyyy",
        autoclose: true,
        language: "id",
        todayHighlight: true,
        forceParse : false
        }).on("change",function(){
          var val = $(this).datepicker('getDate');
          var formatted = moment(val).format('YYYY-MM-DD');
          var target = $(this).data('target');
          //$(`[name="${target}"]`).val(formatted);
          $("input[name='"+target+"']").val(formatted);
          console.log(target);
          $(":input",this).valid();
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
        
    
        $("#modal_kategori_daftar").scroll(function(){
          $(".tgl_picker").datepicker("hide");
          $(".tgl_picker").blur();
        });
    $("#edit_kategori_daftar").validate({
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
            
          nama_kategori: {
          required: true,
          //minlength: 2
          },
        
          id_jenis_partisipasi: {
          required: true,
          //minlength: 2
          },
        
          biaya_daftar: {
          required: true,
          //minlength: 2
          },
        
          tanggal_open: {
          required: true,
          //minlength: 2
          },
        
          tanggal_close: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          nama_kategori: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          id_jenis_partisipasi: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          biaya_daftar: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          tanggal_open: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          tanggal_close: {
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
                            $('#modal_kategori_daftar').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000, function() {
                                 dtb_kategori_daftar.draw();
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
