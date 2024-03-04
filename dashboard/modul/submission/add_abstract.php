<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Submission</h1>
        <ol class="breadcrumb">
            <li>
              <a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a>
            </li>
            <li>
              <a href="<?=base_index();?>add-abstract">Add Submission</a>
            </li>
            <li class="active"><?php echo $lang["add_button"];?> Add Submission</li>
        </ol>
    </section>

    <?php
    $data_profil_user = $db->fetch_single_row('sys_users','id',$_SESSION['id_user']);
    ?>

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-solid box-primary">
          <div class="box-header">
            <h3 class="box-title">Add New Submission</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
          </div>
          <div class="box-body">
           <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
        <form id="input_add_abstract" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/submission/abstract/abstract_action.php?act=in">

              <div class="form-group">
                <label for="Title" class="control-label col-lg-2">Title <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="title_abstract" placeholder="Title" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="All Authors" class="control-label col-lg-2">Name All Authors <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="all_authors" placeholder="All Authors" class="form-control" required>
                  <p class="help-block">Separate Authors with comma (,)</p>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Email Author" class="control-label col-lg-2">Email All Author <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="email_author" placeholder="Email Author" class="form-control" required>
                   <p class="help-block">Separate Email with comma (,)</p>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Affiliation" class="control-label col-lg-2">Institution/Affiliation all authors <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="affiliation" placeholder="Affiliation" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
      
          <div class="form-group">
              <label for="Content Of Abstract" class="control-label col-lg-2">Abstract <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <textarea id="content_abstract" name="content_abstract" id="editboxs" class="editboxs" required=""></textarea>
                 <p class="help-block">Max 250 words.</p>
              </div>
          </div><!-- /.form-group -->

   <div class="form-group">
                        <label for="city" class="control-label col-lg-2">Abstract File <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="file_name"  class="file-upload-data abstract-file" required accept=".docx,.doc">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                            <span class="help-block">Allowed File Type docx,doc</span>
                          </div>
                    </div>
                      </div><!-- /.form-group -->
          
              <div class="form-group">
                <label for="Keywords" class="control-label col-lg-2">Keywords <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="keywords_abstract" placeholder="Keywords" class="form-control" required>
                   <p class="help-block">Separate keywords with comma (,)</p>
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                        <label for="Topic" class="control-label col-lg-2">Topic <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
            <select  id="id_scope" name="id_scope" data-placeholder="Pilih Topic ..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("tb_ref_scope") as $isi) {
                  echo "<option value='$isi->id'>$isi->scope_name</option>";
               } ?>
              </select>
            </div>
                      </div><!-- /.form-group -->

              <div class="form-group">
                <label for="Presenter" class="control-label col-lg-2">Presenter <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="presenter_name" placeholder="Presenter" class="form-control" value="<?=$data_profil_user->full_name;?>" required>
                  <p class="help-block">The full name which will be printed in certificate, one person only.</p>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                        <label for="city" class="control-label col-lg-2">Full Paper</label>
                        <div class="col-lg-10">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="nama_file"  class="file-upload-data">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                    </div>
                      </div><!-- /.form-group -->
                 <input type="hidden" name="id_user" value="<?=$data_profil_user->id;?>">
           
                      
              <div class="form-group">
                <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                <div class="col-lg-10">
             <a href="<?=base_index();?>add-abstract" class="btn btn-default "><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
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
 $(".editboxs").ckeditor({
    toolbarGroups: [{
            "name": "basicstyles",
            "groups": ["basicstyles"]
        },
        {
            "name": "paragraph",
            "groups": ["list"]
        },
        {
            "name": "document",
            "groups": ["mode"]
        },
        {
            "name": "insert",
            "groups": ["insert"]
        },
        {
            "name": "styles",
            "groups": ["styles"]
        },
        {
            "name": "about",
            "groups": ["about"]
        }
    ],
    // Remove the redundant buttons from toolbar groups defined above.
    removeButtons: 'Anchor,Styles,Source,Specialchar,PasteFromWord,Format,Table,HorizontalRule,About,Image,Strike'

});
 $('.editboxs').ckeditorGet().on('key', function(e) {
    $('.editboxs').valid();
});



    
     $('.abstract-file').on('change', function() {
          $(this).valid();
      });

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
    $("#input_add_abstract").validate({
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
      /*  errorPlacement: function(error, element) {
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
            } else if (element.hasClass("editbox")) {
                element.parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },*/

errorPlacement: function(error, element) {
            if (element.hasClass("chzn-select")) {
                var id = element.attr("id");
                error.insertAfter("#" + id + "_chosen");
            } else if (element.attr("accept") == "image/*") {
                element.parent().parent().parent().append(error);
            } else if (element.hasClass("waktu")) {
               element.parent().parent().append(error);
            }
            else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            } else if (element.hasClass("select2-hidden-accessible")) {
               element.parent().append(error);
            }
            else if (element.hasClass("file-upload-data")) {
               element.parent().parent().parent().append(error);
            }  else if (element.hasClass("dosen-ke")) {
                  error.appendTo('.error-dosen');
            } else if (element.hasClass("editboxs")) {
                element.parent().append(error);
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
            
          title_abstract: {
          required: true,
          //minlength: 2
          },
        
          all_authors: {
          required: true,
          //minlength: 2
          },
        
          institution: {
          required: true,
          //minlength: 2
          },
        
          content_abstract:{
             required: true,
        },
        
          keywords_abstract: {
          required: true,
          //minlength: 2
          },
        
          id_scope: {
          required: true,
          //minlength: 2
          },
        
          presenter_name: {
          required: true,
          //minlength: 2
          },
        
        },
         messages: {
            
          title_abstract: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          all_authors: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          institution: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          content_abstract: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          keywords_abstract: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          id_scope: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          presenter_name: {
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
