<?php 
session_start();
include "../../../inc/config.php";
//update read status
$stat = $db->query("select tb_data_abstract_chat.id  from tb_data_abstract_chat
inner join sys_users on tb_data_abstract_chat.id_user=sys_users.id
where  sys_users.group_level='reviewer' 
and tb_data_abstract_chat.is_read='N' and tb_data_abstract_chat.id_abstract=".$_POST['id_abstract']);
foreach ($stat as $up_read) {
  $db->update('tb_data_abstract_chat',array('is_read' => 'Y'),'id',$up_read->id);
}

$abstract = $db->fetch_custom_single('select * from tb_data_abstract where id=?',array('id_abstract' => $_POST['id_abstract']));
$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
$dir_name = str_replace(" ", "_", $presenter_name->presenter_name);
?>
<style type="text/css">
  .help-block {
    color: #dd4b39;
}
.isi_abstract > p {
  font-size: 15px;
}
</style>
 <div class="row">
        <!-- Left col -->
        <section id="left-paper" class="col-lg-7 connectedSortable">
          <!-- /.nav-tabs-custom -->

          <!-- TO DO List -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body">

<h3 class="box-title" style="text-align: center;font-weight: bold;font-family: times;"><?=$abstract->title_abstract;?></h3>
<h4 style="text-align: center;font-weight: bold;font-family: times;"><?=$abstract->all_authors;?></h4>

<div class="box-body" style="font-family: times;">
 <span class="isi_abstract" style="font-family: times;"> <b>Abstract: </b><?=$abstract->content_abstract;?>
 </span>
 <h5 style="font-family: times;"> <b>Keyword: </b><?=$abstract->keywords_abstract;?>
 </h5>
</div>

            </div>
<?php
$abstract_message = "";
/*if ($_SESSION['group_level']=='presenter') {
  ?>
<h4>Notes from reviewer</h4>
<textarea class="form-control" readonly=""><?=$abstract->message;?></textarea>
  <?php
} else */
if($_SESSION['group_level']=='reviewer') {
    $get_notes = $db->fetch_custom_single("select * from tb_data_note_abstract where id_abstract=? and id_reviewer=?",array('id_abstract' => $abstract->id,'id_reviewer' => $_SESSION['id_user']));

    $abstract_message = $get_notes->notes;
    ?>
<form id="submit-note" class="form-horizontal">
   <div class="form-group">
  <label for="Topic" class="control-label col-lg-2">Catatan</label>
   <div class="col-lg-10">
<textarea class="form-control isi-note" id="isi-note"><?=$abstract_message;?></textarea>
</div>
</div>
 <div class="form-group">
              <label for="Topic" class="control-label col-lg-2">Status</label>
            <div class="col-lg-10">

              <select name="status" class="form-control status" tabindex="2" required>
                <option value="">Pilih Status</option>
  <?php
                     $option = array(
                              'Revised' => 'Revisi',
                              'Accepted' => 'Diterima',
                              'Rejected' => 'Tolak',
                              );
                     foreach ($option as $isi => $val) {

                        if ($abstract->status_abstract==$isi) {
                          echo "<option value='$abstract->status_abstract' selected>$val</option>";
                        } else {
                       echo "<option value='$isi'>$val</option>";
                          }
                     } ?>
              </select>
              <div id="error_status"></div>
          </div>
                      </div><!-- /.form-group -->

<input type="hidden" id="id_abstract_val" name="id_abstract" value="<?=$_POST['id_abstract'];?>">
<input type="hidden" id="id_reviewer_val" name="id_reviewer" value="<?=$_SESSION['id_user'];?>">
<input type="hidden" id="id_note_val" name="id_note" value="<?=$get_notes->id;?>">
 <div class="form-group">
<label for="Topic" class="control-label col-lg-2">&nbsp;</label>
 <div class="col-lg-10">
  <span class="btn btn-primary submit-note"><i class="fa fa-save"></i> Kirim Review</span>
 </div>

</div>
</form>
<br>
    <?php
  } else {
    $notes = $db->query("select * from tb_data_note_abstract where id_abstract=$abstract->id and id_reviewer in (select id_reviewer from tb_data_reviewer 
inner join sys_users on tb_data_reviewer.id_reviewer=sys_users.id where id_abstract=$abstract->id ) order by id_reviewer asc");
    $reviewer_inc=1;
   
      ?>
<div class="row">
  <div class="col-md-12">
    <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    Reviewer Notes
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <?php
             foreach ($notes as $nt) {
              ?>
            <li>
             <i class="fa fa-user bg-aqua"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?=tgl_time($nt->date_updated);?> </span>

                <h3 class="timeline-header"><a href="#">Reviewer <?=$reviewer_inc;?></a></h3>

                <div class="timeline-body">
                  <?=$nt->notes;?>
                </div>
              </div>
            </li>
            <?php
 $reviewer_inc++;
    }?>
          </ul>
  </div>
</div>
<?php
  }
?>

          </div>
       
          <!-- /.box (chat box) -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

             <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">Chat History</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="refresh">
                <div class="btn-group" data-toggle="btn-toggle">
                  <button type="button" class="btn btn-default btn-sm active refresh-chat"><i class="fa fa-refresh text-green"></i>
                  </button>
                </div>
              </div>
            </div>
            <img style="display: none" src="<?=base_admin();?>modul/submission/ajax-loader.gif" class="loader-chat"/>
            <div class="box-body chat chat-content" id="chat-box" style="overflow-y: scroll;height: 500px;">
              
              <!-- chat item -->
              <?php
              $data_pesan = $db->query("select tb_data_abstract_chat.*,function_get_reviewer_name(id_abstract,id_user) as reviewer,function_get_author_name(id_user) as author,function_get_group_level(id_user) as group_level,function_get_photo(id_user) as foto
from tb_data_abstract_chat where id_abstract=? order by date_created asc",array('id_abstract' => $_POST['id_abstract']));
              foreach ($data_pesan as $pesan) {
                if ($pesan->group_level=='reviewer') {
                  if ($_SESSION['group_level']=='presenter') {
                    $nama = 'Reviewer';
                  } elseif($_SESSION['group_level']=='reviewer') {
                    $nama = $pesan->reviewer;
                  } else {
                    $nama = 'Reviewer';
                  }
                  
                }  elseif ($pesan->group_level=='presenter') {
                  if ($_SESSION['group_level']=='reviewer') {
                    $nama = 'Author';
                  } elseif ($_SESSION['group_level']=='presenter') {
                    $nama = $pesan->author;
                  } else {
                    $nama = 'Author';
                  }
                  
                } else {
                  $nama = 'Admin';

                }
                  ?>
              
           <div class="item">
                <img src="../../upload/back_profil_foto/<?=$pesan->foto;?>" alt="user image" class="online">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?=$pesan->date_created;?></small>
                    <?=$nama;?>
                  </a>
                  <?=$pesan->pesan;?>
                </p>
                <?php
                 if ($pesan->has_file=='Y') {
                ?>
                <div class="attachment">
                  <h4>Attachments:</h4>

                  <p class="filename">
                     <?=$pesan->file_name;?>
                  </p>

                  <div class="pull-right">
                  <a target="_blank" href="<?=base_url();?>upload/abstracts/<?=$dir_name;?>/<?=$pesan->id_abstract;?>/<?=$pesan->file_name;?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Download Document"><i class="fa fa-cloud-download"></i></a>
                  </div>
                </div>
                <?php
              }
              ?>
                <!-- /.attachment -->
              </div>
                  <?php
              }
              ?>
              <!-- /.item -->
            </div>
            <!-- /.chat -->
            <div class="box-footer">
              <form id="send_message" action="<?=base_admin();?>modul/submission/abstract/chat_action.php?act=in">
              <div class="input-group">
                <input type="text" name="message" class="form-control pesan" placeholder="Type message..." required="">

                <input type="hidden" name="id_abstract" value="<?=$_POST['id_abstract'];?>">
                <span class="input-group-addon attach-file" data-toggle="tooltip" title="Attach File" style="cursor: pointer;"><i class="fa fa-paperclip"></i> Upload File</span>
                <div class="input-group-btn">
                  
                 <button type="submit" class="btn btn-success" data-toggle="tooltip" title="Send Message">Send</button>
                </div>
              </div>
              <div class="fileinput fileinput-new attachment-file" data-provides="fileinput" style="    margin-top: 5px;display: none">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="file_name"  class="file-upload-data file-data">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                      </div><!-- /.form-group -->
 </form>
            </div>
          </div>


        </section>
        <!-- right col -->
      </div>
<script type="text/javascript">
  $('.attach-file').click(function(){
      $('.attachment-file').toggle('fast', function() {
          if($(this).is(':hidden')) { 
              $('.file-data').prop('required',false);
          }
          else {
              $('.file-data').prop('required',true);
          }
      });

      //$('.attachment-file').toggle();
      $('.fileinput').fileinput('clear');
  });
  $('.status').on('change', function() {
    if ($(this).val()!='') {
      $("#error_status").parent().parent().removeClass('has-error');
      $("#error_status").html('');
    } else {
      $(this).parent().parent().addClass('has-error');
      $("#error_status").html('<span for="semester_up" class="help-block">Pilih Status Abstract.</span>');
    }
  });
  $('.submit-note').click( function() {
      if($(".status").val()=="") {
         $(this).parent().parent().addClass('has-error');
         $("#error_status").html('<span for="semester_up" class="help-block">Pilih Status Abstract.</span>');
      } else {
        $("#loadnya").show();
         $("#error_status").parent().parent().removeClass('has-error');
         $("#error_status").html('');
         var notes = $('#isi-note').val();
          var id_abstract = $('#id_abstract_val').val();
          var id_note = $('#id_note_val').val();
          var status_abstract = $('.status').val();
               $.ajax({
                url : "<?=base_admin();?>modul/submission/abstract/abstract_action.php?act=input_note",
                type : "post",
                data : {notes:notes,id_abstract:id_abstract,id_note:id_note,status_abstract:status_abstract},
                success: function(data) {
                  console.log(data);
                  dtb_abstract.draw(false);
                   $('#id_note_val').val(data);
                    $("#loadnya").hide();
                    $(".notif_top_up").fadeIn(1000);
                    $(".notif_top_up").fadeOut(1000);
              }
            });
      }
  });

$('.refresh-chat').click(function(){
  $(".loader-chat").show();
        $.ajax({
          "method" : "post",
          "data" : {id_abstract:<?=$_POST['id_abstract'];?>},
          "url" : "<?=base_admin();?>modul/submission/abstract/chat_content.php",
          success : function(data) {
            $(".loader-chat").hide();
            $(".chat-content").html(data);
          }
      });
    });
  function get_chat(id_abstract) {
      $.ajax({
          "method" : "post",
          "data" : {id_abstract:id_abstract},
          "url" : "<?=base_admin();?>modul/submission/abstract/chat_content.php",
          success : function(data) {
            $(".chat-content").html(data);
          }
      });
  }

  
    $(document).ready(function() {
      $("textarea.editbox" ).ckeditor(); 
       $.validator.setDefaults({ ignore: [] });
    $("#send_message").validate({
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
            }
            else if (element.hasClass("file-upload-data")) {
               element.parent().parent().parent().append(error);
            }  else if (element.hasClass("ckeditor")) {
                element.parent().append(error);
            }
            else if (element.hasClass("pesan")) {
            
            } 

             else {
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
                },
                success: function(responseText) {
                  $("#loadnya").hide();
                  console.log(responseText);
                      $.each(responseText, function(index) {
                        $('.pesan').val('');
                        $('.fileinput').fileinput('clear');
                        $('.file-data').prop('required',false);
                         $('.attachment-file').hide();
                          console.log(responseText[index].status);
                          get_chat(responseText[index].id_abstract);
                    });
                }

            });
        }
    });
});
</script>