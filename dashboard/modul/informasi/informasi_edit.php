<!-- Content Header (Page header) -->
              <section class="content-header">
                  <h1>Informasi</h1>
                    <ol class="breadcrumb">
                        <li>
                        <a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a>
                        </li>
                        <li>
                        <a href="<?=base_index();?>informasi">Informasi</a>
                        </li>
                        <li class="active"><?php echo $lang["edit"];?> Informasi</li>
                    </ol>
              </section>

              <!-- Main content -->
              <section class="content">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="box box-solid box-primary">
                          <div class="box-header">
                              <h3 class="box-title"><?php echo $lang["edit"];?> Informasi</h3>
                              <div class="box-tools pull-right">
                                  <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-pencil"></i></button>
                              </div>
                          </div>
                      <div class="box-body">
                       <div class="alert alert-danger error_data" style="display:none">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="isi_warning"></span>
                      </div>
                          <form id="edit_informasi" method="post" class="form-horizontal" action="<?=base_admin();?>modul/informasi/informasi_action.php?act=up">
                            
            <div class="form-group">
                <label for="Jenis Informasi" class="control-label col-lg-2">Jenis Informasi <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                    <select id="kat_informasi" name="kat_informasi" data-placeholder="Pilih Jenis Informasi..." class="form-control chzn-select" tabindex="2" required>
                      <option value=""></option>
                     <?php
                     $option = array(
'B' => 'Informasi Sebelum Bayar',

'A' => 'Informasi Setelah Bayar',
);
                     foreach ($option as $isi => $val) {

                        if ($data_edit->kat_informasi==$isi) {
                          echo "<option value='$data_edit->kat_informasi' selected>$val</option>";
                        } else {
                       echo "<option value='$isi'>$val</option>";
                          }
                     } ?>
                    </select>
                  </div>
            </div><!-- /.form-group -->
            
          <div class="form-group">
              <label for="Isi Informasi" class="control-label col-lg-2">Isi Informasi <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <textarea id="editbox" name="isi_informasi" class="editbox"required><?=$data_edit->isi_informasi;?> </textarea>
              </div>
          </div><!-- /.form-group -->
          
            <div class="form-group">
                <label for="Tampil" class="control-label col-lg-2">Tampil <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                <?php if ($data_edit->is_aktif=="Y") {
                ?>
                  <input name="is_aktif" data-on-text="On" data-off-text="Off" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="is_aktif" data-on-text="On" data-off-text="Off" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->
            
                            <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                            <div class="form-group">
                                <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                                <div class="col-lg-10">
                                <a href="<?=base_index();?>informasi" class="btn btn-default "><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
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
        
    
    $("#edit_informasi").validate({
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
            
          kat_informasi: {
          required: true,
          //minlength: 2
          },
        
          isi_informasi: {
          required: true,
          //minlength: 2
          },
        
          is_aktif: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          kat_informasi: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          isi_informasi: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          is_aktif: {
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
