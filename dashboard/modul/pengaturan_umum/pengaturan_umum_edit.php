<?php
$last_payment = substr($data_edit->last_payment,0,10);
$time_selesai = substr($data_edit->last_payment , -8);
$time_selesai = substr($time_selesai,0,5);
$tgl_akhir_label = getHariFromDate($data_edit->last_payment ).', '.tgl_indo($last_payment);
$loa_date = getHariFromDate($data_edit->loa_date ).', '.tgl_indo($data_edit->loa_date);
?>
<style type="text/css">
  .modal-abs {
  width: 98%;
  padding: 0;
}

.modal-content-abs {
  height: 99%;
}
#modal_pendaftaran {
      z-index: 1500;
}
</style>
<!-- Content Header (Page header) -->
              <section class="content-header">
                  <h1>Pengaturan Umum</h1>
                    <ol class="breadcrumb">
                        <li>
                        <a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a>
                        </li>
                        <li>
                        <a href="<?=base_index();?>pengaturan-umum">Pengaturan Umum</a>
                        </li>
                        <li class="active"><?php echo $lang["edit"];?> Pengaturan Umum</li>
                    </ol>
              </section>

              <!-- Main content -->
              <section class="content">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="box box-solid box-primary">
                          <div class="box-header">
                              <h3 class="box-title"><?php echo $lang["edit"];?> Pengaturan Umum</h3>
                              <div class="box-tools pull-right">
                                  <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-pencil"></i></button>
                              </div>
                          </div>
                      <div class="box-body">
                       <div class="alert alert-danger error_data" style="display:none">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="isi_warning"></span>
                      </div>
                          <form id="edit_pengaturan_umum" method="post" class="form-horizontal" action="<?=base_admin();?>modul/pengaturan_umum/pengaturan_umum_action.php?act=up">
                            
              <div class="form-group">
                <label for="Conference Name" class="control-label col-lg-2">Conference Name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_name" value="<?=$data_edit->conference_name;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label for="Conference Name" class="control-label col-lg-2">Conference Name Short<span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_name_short" value="<?=$data_edit->conference_name_short;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
              <label for="Conference Date" class="control-label col-lg-2">Conference Date <span style="color:#FF0000">*</span></label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker">
                    <input type="text" autocomplete="off" class="form-control tgl_picker_input" value="<?=$data_edit->conference_date;?>" name="conference_date" required />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
          </div><!-- /.form-group -->
          
              <div class="form-group">
                <label for="Conference Place" class="control-label col-lg-2">Conference Place <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_place" value="<?=$data_edit->conference_place;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Description" class="control-label col-lg-2">Conference Description <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_desc" value="<?=$data_edit->conference_desc;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Website" class="control-label col-lg-2">Conference Website <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_site" value="<?=$data_edit->conference_site;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Email" class="control-label col-lg-2">Conference Email <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text"  data-rule-email="true" name="conference_email" value="<?=$data_edit->conference_email;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference City" class="control-label col-lg-2">Conference City <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_city" value="<?=$data_edit->conference_city;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Chairman" class="control-label col-lg-2">Conference Chairman <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_chairman" value="<?=$data_edit->conference_chairman;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
            <div class="form-group">
                <label for="Email Activation on Register" class="control-label col-lg-2">Email Activation on Register </label>
                <div class="col-lg-10">
                <?php if ($data_edit->email_activation=="Y") {
                ?>
                  <input name="email_activation" data-on-text="On" data-off-text="Off" class="make-switch" type="checkbox" checked>
                <?php
              } else {
                ?>
                  <input name="email_activation" data-on-text="On" data-off-text="Off" class="make-switch" type="checkbox">
                <?php
              }?>

                </div>
            </div><!-- /.form-group -->

      <div class="form-group">
                        <label for="nama_foto" class="control-label col-lg-2">Conference Logo</label>
                        <div class="col-lg-10">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px;">
                             <img src="<?=base_url();?>upload/logo/<?=$data_edit->conference_logo?>">
                            </div>
                                <div class="fileinput-preview fileinput-exists thumbnail tesd" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new">Select Image</span> <span class="fileinput-exists">Select Image</span>
                                <input type="file" name="conference_logo" id="upload_image"  accept="image/*">
                              </span>
                              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove Image</a>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.form-group -->
<input type="hidden" name="isi_gambar" class="isi_gambar">
              <div class="form-group">
              <label for="LOA DATE" class="control-label col-lg-2">LOA DATE </label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker" data-target="loa_date">
                    <input type="text" autocomplete="off" class="form-control readonly tgl_picker_input" readonly value="<?=$loa_date;?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                     <input type="hidden" name="loa_date" value="<?=$data_edit->loa_date;?>">
                </div>
              </div>
          </div><!-- /.form-group -->
          
              <div class="form-group">
              <label for="Last Date Payment" class="control-label col-lg-2">Last Date Payment <span style="color:#FF0000">*</span></label>
          <div class="col-lg-3 col-xs-7">
          <div class="input-group date tgl_picker" data-target="last_payment">
              <input type="text" class="form-control tgl_picker_input" readonly  required value="<?=$tgl_akhir_label;?>">
              <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
              
              </div>
              <input type="hidden" name="last_payment" value="<?=$last_payment;?>">
          </div>
             <div class="col-lg-2 col-xs-5" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">Jam</div> 

                <div class="col-lg-2 col-xs-4">
                  <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" min="01:00" max="23:59" value="<?=$time_selesai;?>" required>
                </div>
          </div><!-- /.form-group -->
          
            <div class="form-group">
                <label for="Ada Judul" class="control-label col-lg-2">Template LOA </label>
                <div class="col-lg-5">
                  <span class="btn btn-primary btn-sm template-surat edit-template-loa" data-id="<?=$data_edit->id;?>"><i class="fa fa-envelope"></i> Edit Template LOA</span>
                </div>
            </div><!-- /.form-group -->

            <div class="form-group">
                <label for="Ada Judul" class="control-label col-lg-2">Template PENOLAKAN </label>
                <div class="col-lg-5">
                  <span class="btn btn-primary btn-sm template-surat edit-template-rejection" data-id="<?=$data_edit->id;?>"><i class="fa fa-envelope"></i> Edit Template PENOLAKAN</span>
                </div>
            </div><!-- /.form-group -->
            
                            <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                            <div class="form-group">
                                <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                                <div class="col-lg-10">
                                <a href="<?=base_index();?>pengaturan-umum" class="btn btn-default "><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                                </div>
                            </div><!-- /.form-group -->
                          </form>
                      </div>
                  </div>
              </div>
              </section><!-- /.content -->
  <div style="display: none" class="modal" id="uploadimageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span></button> <h4 class="modal-title judul">Crop</h4> </div> <div class="modal-body" id="isi_rumpun_dosen">
                <div class="row">
            <div class="col-md-12 text-center">
              <div id="image_demo"></div>
              <p><button class="btn btn-success crop_image">Crop & Upload Image</button></p>
            </div>
          </div>
        </div>
         </div> 
       </div><!-- /.modal-content --> 
       </div><!-- /.modal-dialog --> 
    <div class="modal" id="modal_pendaftaran" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg modal-abs"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title"> Pendaftaran</h4> </div> <div class="modal-body" id="isi_pendaftaran"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
 <script type="text/javascript" src="<?=base_admin();?>assets/plugins/croppie/croppie.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_admin();?>assets/plugins/croppie/croppie.css">       
 <script type="text/javascript">
 $(document).ready(function(){
  
      $(".edit-template-loa").click(function(){
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);
        jenis = currentBtn.data("jenis");
        $(".modal-title").html("Edit Template LOA");
        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/pengaturan_umum/edit_template_loa.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_pendaftaran").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_pendaftaran').modal({ keyboard: false,backdrop:'static' });

    });
      $(".edit-template-rejection").click(function(){
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);
        jenis = currentBtn.data("jenis");
        $(".modal-title").html("Edit Template Penolakan");
        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/pengaturan_umum/edit_template_rejection.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_pendaftaran").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_pendaftaran').modal({ keyboard: false,backdrop:'static' });

    });

/*  $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:'100%',
      height:100,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:100
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $('.tesd').html('<img src="'+response+'" style="max-height:150px">');
      $('.isi_gambar').val(response);

       $('#uploadimageModal').modal('hide');
    })
  });
*/
    
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
        
    
    
        $("#modal_pengaturan_umum").scroll(function(){
          $(".tgl_picker").datepicker("hide");
          $(".tgl_picker").blur();
        });
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
/*        $(".tgl_picker").datepicker({ 
        format: "yyyy-mm-dd",
        autoclose: true, 
        todayHighlight: true
        }).on("change",function(){
          $(":input",this).valid();
        });*/
    $("#edit_pengaturan_umum").validate({
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
            
          conference_name: {
          required: true,
          //minlength: 2
          },
        
          conference_date: {
          required: true,
          //minlength: 2
          },
        
          conference_place: {
          required: true,
          //minlength: 2
          },
        
          conference_desc: {
          required: true,
          //minlength: 2
          },
        
          conference_site: {
          required: true,
          //minlength: 2
          },
        
          conference_email: {
          required: true,
          //minlength: 2
          },
        
          conference_city: {
          required: true,
          //minlength: 2
          },
        
          conference_chairman: {
          required: true,
          //minlength: 2
          },
        
          last_payment: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          conference_name: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          conference_date: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          conference_place: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          conference_desc: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          conference_site: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          conference_email: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          conference_city: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          conference_chairman: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          last_payment: {
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
