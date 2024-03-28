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
            <li class="active"><?php echo $lang["add_button"];?> Pengaturan Umum</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-solid box-primary">
          <div class="box-header">
            <h3 class="box-title"><?php echo $lang["add_button"];?> Pengaturan Umum</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
          </div>
          <div class="box-body">
           <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
            <form id="input_pengaturan_umum" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/pengaturan_umum/pengaturan_umum_action.php?act=in">
                      
              <div class="form-group">
                <label for="Conference Name" class="control-label col-lg-2">Conference Name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_name" placeholder="Conference Name" class="form-control" required>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label for="Conference Name" class="control-label col-lg-2">Conference Name Short <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_name_short" placeholder="Conference Name" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
          <div class="form-group">
              <label for="Conference Date" class="control-label col-lg-2">Conference Date <span style="color:#FF0000">*</span></label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker">
                    <input type="text" autocomplete="off" class="form-control tgl_picker_input" name="conference_date" required />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
               <!-- in case you need two column <div class="col-lg-1" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">S/d</div> -->
          </div><!-- /.form-group -->
          
              <div class="form-group">
                <label for="Conference Place" class="control-label col-lg-2">Conference Place <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_place" placeholder="Conference Place" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Description" class="control-label col-lg-2">Conference Description <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_desc" placeholder="Conference Description" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Website" class="control-label col-lg-2">Conference Website <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_site" placeholder="Conference Website" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Email" class="control-label col-lg-2">Conference Email <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                    <input type="text" data-rule-email="true" name="conference_email" placeholder="Conference Email" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
            
              <div class="form-group">
                <label for="Conference City" class="control-label col-lg-2">Conference City <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_city" placeholder="Conference City" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Chairman" class="control-label col-lg-2">Conference Chairman <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="conference_chairman" placeholder="Conference Chairman" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
          <div class="form-group">
              <label for="Email Activation on Register" class="control-label col-lg-2">Email Activation on Register </label>
              <div class="col-lg-10">
                <input name="email_activation" data-on-text="On" data-off-text="Off" class="make-switch" type="checkbox" checked>
              </div>
          </div><!-- /.form-group -->
          <div class="form-group">
                        <label for="Conference Logo" class="control-label col-lg-2">Conference Logo </label>
                        <div class="col-lg-10">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                              <img data-src="holder.js/100%x100%" alt="..." class="myImage">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                              <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="conference_logo" accept="image/*">
                              </span>
                              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                          </div>
                      </div><!-- /.form-group -->

          <div class="form-group">
              <label for="Due Date Invoice" class="control-label col-lg-2">Due Date Invoice </label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker">
                    <input type="text" autocomplete="off" class="form-control tgl_picker_input" name="due_date"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
               <!-- in case you need two column <div class="col-lg-1" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">S/d</div> -->
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="Invoice Date" class="control-label col-lg-2">Invoice Date </label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker">
                    <input type="text" autocomplete="off" class="form-control tgl_picker_input" name="inv_date"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
               <!-- in case you need two column <div class="col-lg-1" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">S/d</div> -->
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="LOA DATE" class="control-label col-lg-2">LOA DATE </label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker">
                    <input type="text" autocomplete="off" class="form-control tgl_picker_input" name="loa_date"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
               <!-- in case you need two column <div class="col-lg-1" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">S/d</div> -->
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="Last Date Payment" class="control-label col-lg-2">Last Date Payment <span style="color:#FF0000">*</span></label>
              <div class="col-lg-3">
                <div class="input-group date tgl_picker">
                    <input type="text" autocomplete="off" class="form-control tgl_picker_input" name="last_payment" required />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
               <!-- in case you need two column <div class="col-lg-1" style="font-weight:bold;padding-left: 0;padding-right: 0;width: 20px;padding-top: 5px;">S/d</div> -->
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="Is Non Presenter Free ?" class="control-label col-lg-2">Is Non Presenter Free ? </label>
              <div class="col-lg-10">
                <input name="is_non_presenter_free" data-on-text="On" data-off-text="Off" class="make-switch" type="checkbox" checked>
              </div>
          </div><!-- /.form-group -->
          
                      
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
        
    
    
        $("#modal_pengaturan_umum").scroll(function(){
          $(".tgl_picker").datepicker("hide");
          $(".tgl_picker").blur();
        });
        $(".tgl_picker").datepicker({ 
        format: "yyyy-mm-dd",
        autoclose: true, 
        todayHighlight: true
        }).on("change",function(){
          $(":input",this).valid();
        });
    $("#input_pengaturan_umum").validate({
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
            } else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            } else if (element.attr("accept") == "image/*") {
                element.parent().parent().parent().append(error);
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
                            $(".notif_top").fadeIn(1000);
                            $(".notif_top").fadeOut(1000, function() {
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
