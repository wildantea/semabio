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
$show = 'style="display:none"';
if ($abstract->verifikasi=='Ditolak') {
  $show = 'style="display:block"';
}
$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
$dir_name = str_replace(" ", "_", $presenter_name->presenter_name);

$member = $db->fetch_single_row("tb_data_member","id_user",$presenter_name->id_user);

//check kat
$kategori_daftar = $db->fetch_single_row("kategori_daftar","id_kat",$member->id_kat_member);

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
        <section id="left-paper" class="col-lg-12 connectedSortable">
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

<form id="submit-note" class="form-horizontal">
<?php
if ($kategori_daftar->is_mahasiswa=='Y') {
  ?>
 <div class="form-group">
              <label for="Topic" class="control-label col-lg-2">BUKTI KTM</label>
  <div class="col-lg-3">
    <a href="<?=base_url();?>upload/ktm/<?=$member->ktm;?>" target="_blank"><img src="<?=base_url();?>upload/ktm/<?=$member->ktm;?>" width="200"></a>
  </div>
</div>
  <?php
}
?>

 <div class="form-group">
              <label for="Topic" class="control-label col-lg-2">Status</label>
            <div class="col-lg-3">

              <select name="status" class="form-control status chzn-select" tabindex="2" required>
  <?php
                     $option = array(
                              'Diterima' => 'Diterima',
                              'Ditolak' => 'Ditolak',
                              );
                     foreach ($option as $isi => $val) {

                        if ($abstract->status_abstract==$isi) {
                          echo "<option value='$data_edit->status_abstract' selected>$val</option>";
                        } else {
                       echo "<option value='$isi'>$val</option>";
                          }
                     } ?>
              </select>
              <div id="error_status"></div>
          </div>
                      </div><!-- /.form-group -->

   <div class="form-group show-alasan" <?=$show;?>>
  <label for="Topic" class="control-label col-lg-2">Alasan Ditolak</label>
   <div class="col-lg-10">
<textarea class="form-control isi-note" id="isi-note"><?=$abstract->alasan_ditolak;?></textarea>
</div>
</div>
<input type="hidden" id="id_abstract_val" name="id_abstract" value="<?=$_POST['id_abstract'];?>">
 <div class="form-group">
<label for="Topic" class="control-label col-lg-2">&nbsp;</label>
 <div class="col-lg-10">
  <span class="btn btn-primary submit-note"><i class="fa fa-save"></i> Verifikasi Abstract</span>
 </div>

</div>
</form>
<br>

          </div>
       
          <!-- /.box (chat box) -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
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
    if ($(this).val()=='Ditolak') {
      $(".show-alasan").show();
    } else {
      $(".show-alasan").hide();
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
         var alasan_ditolak = $('#isi-note').val();
          var id_abstract = $('#id_abstract_val').val();
          var id_note = $('#id_note_val').val();
          var verifikasi = $('.status').val();
               $.ajax({
                url : "<?=base_admin();?>modul/submission/abstract/abstract_action.php?act=verifikasi",
                type : "post",
                data : {alasan_ditolak:alasan_ditolak,id_abstract:id_abstract,verifikasi:verifikasi},
                success: function(data) {
                  $('#modal_verifikasi').modal('hide');
                  console.log(data);
                    $("#loadnya").hide();
                    $(".notif_top_up").fadeIn(1000);
                    $(".notif_top_up").fadeOut(1000, function() {
                      dtb_abstract.draw(false);
                  });
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