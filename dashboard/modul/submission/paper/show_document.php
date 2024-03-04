<?php
session_start();
include "../../../inc/config.php";
$id_paper = $_POST['id_paper'];
$paper = $db->fetch_single_row("tb_data_papers","id",$id_paper);
$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$paper->id_abstract);
$dir_name = str_replace(" ", "_", $presenter_name->presenter_name);
?>
 <span class="close-doc" data-toggle="tooltip" title="close document" style="text-align: left"><i class="fa fa-times fa-6" style="text-align: left"></i></span>
          <div class="box box-solid">
            <div class="box-body">
              <iframe style="width: 100%;height: 100vh;" src='https://docs.google.com/viewer?url=<?=base_url();?>upload/papers/<?=$dir_name;?>/<?=$presenter_name->id;?>/<?=$paper->file_name;?>&embedded=true' frameborder='0' id="isi_document"></iframe>
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
    $get_notes = $db->fetch_custom_single("select * from tb_data_note_paper where id_abstract=? and id_reviewer=?",array('id_abstract' => $paper->id_abstract,'id_reviewer' => $_SESSION['id_user']));
    $abstract_message = $get_notes->notes;
    ?>
<form id="submit-note">
<h4>Write Notes</h4>
<textarea class="form-control isi-note" id="isi-note"><?=$abstract_message;?></textarea>
<br>
<input type="hidden" id="id_abstract_val" name="id_abstract" value="<?=$paper->id_abstract;?>">
<input type="hidden" id="id_reviewer_val" name="id_reviewer" value="<?=$_SESSION['id_user'];?>">
<input type="hidden" id="id_note_val" name="id_note" value="<?=$get_notes->id;?>">
<span class="btn btn-primary submit-note">Submit</span>
</form>
    <?php
  } else {
    $notes = $db->query("select * from tb_data_note_paper where id_abstract=$paper->id_abstract and id_reviewer in (select id_reviewer from tb_data_reviewer 
inner join sys_users on tb_data_reviewer.id_reviewer=sys_users.id where id_abstract=$paper->id_abstract) order by id_reviewer asc ");
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

<script type="text/javascript">
   $('#isi_document').on('load', function () {
            $('.loader-document').hide();
        });
  $('.submit-note').click( function() {
      $("#loadnya").show();
      var notes = $('#isi-note').val();
      var id_abstract = $('#id_abstract_val').val();
      var id_note = $('#id_note_val').val();
           $.ajax({
            url : "<?=base_admin();?>modul/submission/abstract/abstract_action.php?act=input_note_paper",
            type : "post",
            data : {notes:notes,id_abstract:id_abstract,id_note:id_note},
            success: function(data) {
              console.log(data);
                $('#id_note_val').val(data);
                $("#loadnya").hide();
                $(".notif_top_up").fadeIn(1000);
                $(".notif_top_up").fadeOut(1000);
          }
        });

  });


      $(".close-doc").on('click', function() {
        $('.modal-paper').removeAttr( 'style' );
        $('#left-paper').removeClass('col-lg-5').addClass('col-lg-12');
        $('.modal-content-paper').removeAttr( 'style' );
                $(".document-view").hide();
                $(".document-view").html('');
    });
</script>