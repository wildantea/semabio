<?php
//check if user hasn't upload paper yet
$check_paper = $db->fetch_single_row("tb_data_papers","id_abstract",$data_edit->id);
?>

<!-- Content Header (Page header) -->
              <section class="content-header">
                  <h1>Edit Abstract</h1>
                    <ol class="breadcrumb">
                        <li>
                        <a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a>
                        </li>
                        <li>
                        <a href="<?=base_index();?>submission/edit">Edit Abstract</a>
                        </li>
                        <li class="active">Edit Abstract</li>
                    </ol>
              </section>

              <!-- Main content -->
              <section class="content">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="box box-solid box-primary">
                          <div class="box-header">
                              <h3 class="box-title">Edit Abstract</h3>
                              <div class="box-tools pull-right">
                                  <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-pencil"></i></button>
                              </div>
                          </div>
                      <div class="box-body">
                       <div class="alert alert-danger error_data" style="display:none">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="isi_warning"></span>
                      </div>

        <form id="edit_add_abstract" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/submission/abstract/abstract_action.php?act=up">
                            <div class="form-group">
                        <label for="User" class="control-label col-lg-2">User <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <select  id="id_user" name="id_user" data-placeholder="Pilih User..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("sys_users") as $isi) {

                  if ($data_edit->id_user==$isi->id) {
                    echo "<option value='$isi->id' selected>$isi->full_name</option>";
                  } else {
                  echo "<option value='$isi->id'>$isi->full_name</option>";
                    }
               } ?>
              </select>
          </div>
                      </div><!-- /.form-group -->

              <div class="form-group">
                <label for="Presenter" class="control-label col-lg-2">Presenter <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="presenter_name" value="<?=$data_edit->presenter_name;?>" class="form-control" required>
                   <p class="help-block">The full name which will be printed in certificate, one person only.</p>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label for="Title" class="control-label col-lg-2">Title <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="title_abstract" value="<?=$data_edit->title_abstract;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="All Authors" class="control-label col-lg-2">All Authors <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="all_authors" value="<?=$data_edit->all_authors;?>" class="form-control" required>
                  <p class="help-block">Separate Authors with comma (,)</p>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Email Author" class="control-label col-lg-2">Email Author <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="email_author" value="<?=$data_edit->email_author;?>" class="form-control" required>
                  <p class="help-block">Separate Email with comma (,)</p>
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Affiliation" class="control-label col-lg-2">Affiliation <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="affiliation" value="<?=$data_edit->affiliation;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
          <div class="form-group">
              <label for="Abstract" class="control-label col-lg-2">Abstract <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <textarea id="editbox" name="content_abstract" class="editbox"required><?=$data_edit->content_abstract;?> </textarea>
              </div>
          </div><!-- /.form-group -->
          
              <div class="form-group">
                <label for="Keywords" class="control-label col-lg-2">Keywords <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" name="keywords_abstract" value="<?=$data_edit->keywords_abstract;?>" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                        <label for="Topic" class="control-label col-lg-2">Topic <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <select  id="id_scope" name="id_scope" data-placeholder="Pilih Topic..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("tb_ref_scope") as $isi) {

                  if ($data_edit->id_scope==$isi->id) {
                    echo "<option value='$isi->id' selected>$isi->scope_name</option>";
                  } else {
                  echo "<option value='$isi->id'>$isi->scope_name</option>";
                    }
               } ?>
              </select>
          </div>
                      </div><!-- /.form-group -->

<?php
if (!$check_paper) {
  ?>


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
  <?php
}
?>
              
                            <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                            <div class="form-group">
                                <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                                <div class="col-lg-10">
                                <a href="<?=base_index();?>submission" class="btn btn-default "><i class="fa fa-step-backward"></i> <?php echo $lang["cancel_button"];?></a>
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
        
    
    $("#edit_add_abstract").validate({
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
            } else if (element.hasClass("editbox")) {
                element.parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        rules: {
            
          id_user: {
          required: true,
          //minlength: 2
          },
        
          title_abstract: {
          required: true,
          //minlength: 2
          },
        
          all_authors: {
          required: true,
          //minlength: 2
          },
        
          email_author: {
          required: true,
          //minlength: 2
          },
        
          affiliation: {
          required: true,
          //minlength: 2
          },
        
          content_abstract: {
          required: true,
          //minlength: 2
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
            
          id_user: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          title_abstract: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          all_authors: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          email_author: {
          required: "This field is required",
          //minlength: "Your username must consist of at least 2 characters"
          },
        
          affiliation: {
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
