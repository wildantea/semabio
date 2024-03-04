<?php
session_start();
include "../../../inc/config.php";
$data_profil_user = $db->fetch_single_row('sys_users','id',$_SESSION['id_user']);
?>
 <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
      <form id="input_abstract" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/submission/abstract/abstract_action.php?act=in">
            
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
                <label for="Institutions" class="control-label col-lg-2">Institution/Affiliation all authors <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="affiliation" placeholder="Institutions" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
          <div class="form-group">
              <label for="Content Of Abstract" class="control-label col-lg-2">Abstract <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <textarea id="content_abstract" name="content_abstract" class="editbox"></textarea>
                <p class="help-block">Abstract Maximal 250 Kata.</p>
              </div>
          </div><!-- /.form-group -->

   <div class="form-group">
                        <label for="city" class="control-label col-lg-2">Abstract File</label>
                        <div class="col-lg-10">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="file_name"  class="file-upload-data" required accept=".docx,.doc">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
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
            <select  id="id_scope" name="id_scope" data-placeholder="Choose Topic ..." class="form-control chzn-select" tabindex="2" required>
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
                  <input type="text" name="presenter_name" placeholder="Presenter" value="<?=$data_profil_user->full_name;?>" class="form-control" required>
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
                                <input type="file" name="nama_file"  class="file-upload-data" accept=".docx,.doc">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                    </div>
                      </div><!-- /.form-group -->

              <input type="hidden" name="id_user" value="<?=$data_profil_user->id;?>">
              
                      

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
     $(".editbox" ).ckeditor({
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
      removeButtons: 'Anchor,Styles,Source,Specialchar,PasteFromWord,Format,Table,HorizontalRule,About,Image'
  

 });
  
      //trigger validation onchange
      $('select').on('change', function() {
          $(this).valid();
      });
      //hidden validate because we use chosen select
      $.validator.setDefaults({ ignore: [] });
      //chosen select
      $(".chzn-select").chosen();
      $(".chzn-select-deselect").chosen({
          allow_single_deselect: true
      });
        
    
    $("#input_abstract").validate({
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
            } else if (element.hasClass("editbox")) {
                element.parent().append(error);
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
                   $(".isi_warning").text(data);
                   $(".error_data").focus()
                   $(".error_data").fadeIn();
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
                            $('#modal_abstract').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top").fadeIn(1000);
                            $(".notif_top").fadeOut(1000, function() {
                                dtb_abstract.draw();
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
