<?php
session_start();
include "../../inc/config.php";
$data_edit = $db->fetch_single_row("tb_ref_setting_conference","id",$_POST['id_data']);
?>
<style>
  .center-ckeditor {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
 .copy-btn {
    background-color: #007bff;
    color: white;
    border: none;
    display: inline-flex;
        margin-top: 5px;
    padding: 5px 10px;
    cursor: pointer;
  }
  .center-ckeditor textarea {
    max-width: 100%;
  }

  </style>
   <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
           <form id="edit_template" method="post" class="form-horizontal" action="<?=base_admin();?>modul/pengaturan_umum/pengaturan_umum_action.php?act=up_template_rejection">
<div class="form-group">
 <div class="col-lg-12">
    <span class="copy-btn" data-type="text" data-text="{{nama_pendaftar}}"><i class="fa fa-copy"></i> Nama Pendaftar</span> 
    <span class="copy-btn" data-type="text" data-text="{{judul_abstract}}"><i class="fa fa-copy"></i> Judul Abstract</span> 
    <span class="copy-btn" data-type="text" data-text="{{nama_seminar}}"><i class="fa fa-copy"></i> Nama Seminar</span>
    <span class="copy-btn" data-type="text" data-text="{{nama_seminar_pendek}}"><i class="fa fa-copy"></i> Nama Seminar Pendek</span>
     <span class="copy-btn" data-type="text" data-text="{{tanggal_verifikasi}}"><i class="fa fa-copy"></i> Tanggal Verifikasi</span>
    <span class="copy-btn" data-type="text" data-text="{{jumlah_bayar}}"><i class="fa fa-copy"></i> Jumlah Bayar</span>
    <span class="copy-btn" data-type="text" data-text="{{tahun}}"><i class="fa fa-copy"></i> Digit Tahun</span>
    <span class="copy-btn" data-type="text" data-text="{{tgl_lengkap}}"><i class="fa fa-copy"></i> Tanggal Lengkap (22 Juli 2022)</span>
    <span class="copy-btn" data-type="text" data-text="{{tgl_lengkap_hijriah}}"><i class="fa fa-copy"></i> Tanggal Lengkap Hijriah (18 Muharram 1444 H)</span>
    <span class="copy-btn" data-type="text" data-text="{{qr_code}}"><i class="fa fa-copy"></i>Qr Code</span>
         </div>
</div>
              <div class="form-group">
                <div class="col-lg-12 center-ckeditor">
                 <textarea id="editor1" name="isi_template_surat"><?=$data_edit->template_rejection ;?></textarea>
                </div>
              </div><!-- /.form-group -->

              <input type="hidden" name="id" value="<?=$data_edit->id;?>">

              <div class="form-group">
                <div class="col-lg-12">
                  <div class="modal-footer"> 
                  <button type="submit" class="btn btn-primary save-data"><i class="fa fa-save"></i> <?php echo $lang["submit_button"];?></button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                  </div>
                </div>
              </div><!-- /.form-group -->


            </form>


<script type="text/javascript">
/* CKEDITOR.addCss(
      'body.document-editor, div.cke_editable { width: 595px;height:442px;} ');*/


 $(document).ready(function(){


            $('[data-toggle="tooltip"]').tooltip();
            
            $(".copy-btn").click(function() {
                const textToCopy = $(this).data("text");
                const type = $(this).data('type');
                navigator.clipboard.writeText(textToCopy);
                
                const originalTitle = $(this).html();
                $(this).attr("data-original-title", "Copied!");
                $(this).tooltip('show');
                $('textarea#editor1').ckeditor().editor.insertText(textToCopy);
                const copyBtn = $(this);
                setTimeout(function() {
                    copyBtn.attr("data-original-title", originalTitle);
                    copyBtn.tooltip('hide');
                }, 1500);
            });
        });


   $("textarea#editor1" ).ckeditor({
  /*   filebrowserBrowseUrl: '<?=base_admin();?>assets/plugins/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '<?=base_admin();?>assets/plugins/ckfinder/ckfinder.html?type=Images',
    filebrowserUploadUrl: '<?=base_admin();?>assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '<?=base_admin();?>assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    */
      filebrowserBrowseUrl: '<?=base_admin();?>assets/plugins/kcfinder/browse.php?type=files',
  filebrowserImageBrowseUrl: '<?=base_admin();?>assets/plugins/kcfinder/browse.php?type=images',
  filebrowserFlashBrowseUrl: '<?=base_admin();?>assets/plugins/kcfinder/browse.php?type=flash',
  filebrowserUploadUrl: '<?=base_admin();?>assets/plugins/kcfinder/upload.php?type=files',
  filebrowserImageUploadUrl: '<?=base_admin();?>assets/plugins/kcfinder/upload.php?type=images',
  filebrowserFlashUploadUrl: '<?=base_admin();?>assets/plugins/kcfinder/upload.php?type=flash',
   filebrowserUploadMethod: "form",
      // Make the editing area bigger than default.
      height: '310mm',
      width: '310mm',

      // Allow pasting any content.
      allowedContent: true,

      // Fit toolbar buttons inside 3 rows.
      toolbarGroups: [{
          name: 'document',
          groups: ['mode', 'document', 'doctools']
        },
        {
          name: 'clipboard',
          groups: ['clipboard', 'undo']
        },
        {
          name: 'editing',
          groups: ['find', 'selection', 'spellchecker', 'editing']
        },
        {
          name: 'forms',
          groups: ['forms']
        },
        '/',
        {
          name: 'paragraph',
          groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
        },
        {
          name: 'links',
          groups: ['links']
        },
        {
          name: 'insert',
          groups: ['insert']
        },
        '/',
        {
          name: 'styles',
          groups: ['styles']
        },
        {
          name: 'basicstyles',
          groups: ['basicstyles', 'cleanup']
        },
        {
          name: 'colors',
          groups: ['colors']
        },
        {
          name: 'tools',
          groups: ['tools']
        },
        {
          name: 'others',
          groups: ['others']
        },
        {
          name: 'about',
          groups: ['about']
        }
      ],

      // Remove buttons irrelevant for pasting from external sources.
      removeButtons: 'ExportPdf,Form,Checkbox,Radio,TextField,Select,Textarea,Button,ImageButton,HiddenField,NewPage,CreateDiv,Flash,Iframe,About,ShowBlocks,Maximize',

      // An array of stylesheets to style the WYSIWYG area.
      // Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
      contentsCss: [
        '<?=base_admin();?>assets/plugins/ckeditor4/contents.css',
        '<?=base_admin();?>assets/plugins/ckeditor4/pasteword.css'
      ],
      fontSize_sizes : '8/8pt;9/9pt;10/10pt;11/11pt;12/12pt;14/14pt;15/15pt;16/16pt;18/18pt;20/20pt;22/22pt;24/24pt;26/26pt;28/28pt;36/36pt;48/48pt;72/72pt',
      enterMode : CKEDITOR.ENTER_BR,

      // This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
      bodyClass: 'document-editor'
    });




CKEDITOR.on("instanceReady", function(event) {
  event.editor.on("beforeCommandExec", function(event) {
    // Show the paste dialog for the paste buttons and right-click paste
    if (event.data.name == "paste") {
      event.editor._.forcePasteDialog = true;
    }
    // Don't show the paste dialog for Ctrl+Shift+V
    if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
      event.cancel();
    }
  })
});

      //hidden validate because we use chosen select
      $.validator.setDefaults({ ignore: ":hidden:not(select)" });
$("#edit_template").validate({
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
            } else if (element.hasClass("waktu")) {
               element.parent().parent().append(error);
            }
            else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            }
            else if (element.hasClass("select2")) {
               element.parent().append(error);
            }
            else if (element.hasClass("file-upload-data")) {
               element.parent().parent().parent().append(error);
            }  else if (element.hasClass("dosen-ke")) {
                  error.appendTo('.error-dosen');
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
                            //$(".save-data").attr("disabled", "disabled");
                            //$('#modal_pendaftaran').modal('hide');
                            $(".error_data").hide();
                            $(".notif_top_up").fadeIn(1000);
                            $(".notif_top_up").fadeOut(1000);
                          }
                    });
                }

            });
        }
    });

</script>
