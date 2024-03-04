 <?php
session_start();
include "../../../inc/config.php";

//update read status
$stat = $db->query("select count(tb_data_papers.read),tb_data_papers.id from tb_data_papers
inner join tb_data_abstract on tb_data_papers.id_abstract=tb_data_abstract.id
inner join sys_users on tb_data_papers.id_user=sys_users.id
where  sys_users.group_level='reviewer' 
and tb_data_papers.read='N' and tb_data_abstract.id=".$_POST['id_abstract']);
foreach ($stat as $up_read) {
  $db->update('tb_data_papers',array('tb_data_papers.read' => 'Y'),'id',$up_read->id);
}
$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
$dir_name = str_replace(" ", "_", $presenter_name->presenter_name);

?>
<style type="text/css">
  .help-block {
    color: #dd4b39;
}
</style>
 <div class="row">
        <!-- Left col -->
        <section id="left-paper" class="col-lg-12 connectedSortable">
          <!-- /.nav-tabs-custom -->

          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-file"></i>
              <h3 class="box-title">Papers File History</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                                      <table id="dtb_paper" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th>Filename</th>
                                  <th>Description</th>
                                  <th>Uploader</th>
                                  <th>Date</th>
                                  <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        
                        
                        <div id="input_paper_form" style="display: none">
                          
                        </div>
            </div>
          </div>
          <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">Chat History with Reviewer</h3>

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
              $data_pesan = $db->query("select tb_data_papers.*,function_get_reviewer_name(id_abstract,id_user) as reviewer,function_get_author_name(id_user) as author,function_get_group_level(id_user) as group_level,function_get_photo(id_user) as foto
from tb_data_papers where id_abstract=? order by date_created asc",array('id_abstract' => $_POST['id_abstract']));
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
           <div class="item" id="chat_id_<?=$pesan->id;?>">
                <img src="../../upload/back_profil_foto/<?=$pesan->foto;?>" alt="user image" class="online">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?=$pesan->date_created;?></small>
                    <?=$nama;?>
                  </a>
                  <?=$pesan->message;?>
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
                    <a data-id='<?=$pesan->id;?>' class="btn btn-primary btn-sm open-document" data-toggle="tooltip" title="Open document"><i class="fa fa-eye"></i> Open</a>
                    <a target="_blank" href="<?=base_url();?>upload/papers/<?=$dir_name;?>/<?=$pesan->id_abstract;?>/<?=$pesan->file_name;?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Download Document"><i class="fa fa-cloud-download"></i></a>
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
              <form id="send_message" action="<?=base_admin();?>modul/submission/paper/chat_action.php?act=in">
              <div class="input-group">
                <input type="text" name="message" class="form-control pesan" placeholder="Type message..." required="">

                <input type="hidden" name="id_abstract" value="<?=$_POST['id_abstract'];?>">

                <div class="input-group-btn">
                   <span class="btn btn-default attach-file" data-toggle="tooltip" title="Attach file"><i class="fa fa-paperclip"></i> Upload File</span>
                  <button type="submit" class="btn btn-success">Send</button>
                </div>
              </div>
              <p>
                <div id="isi_attachment"></div>

 </form>
            </div>
          </div>
          <!-- /.box (chat box) -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
       <img style="display: none" src="<?=base_admin();?>modul/submission/ajax-loader.gif" class="loader-document"/>
        <section class="col-lg-7 connectedSortable document-view" style="display: none">

          <!-- Map box -->

          <!-- /.box -->


        </section>
        <!-- right col -->
      </div>
<script type="text/javascript">
 $(".add-paper").click(function(){
        $(".loader-paper-add").show();
              if ($("#input_paper_form").is(':visible')) {
                $(this).find('.fa').toggleClass('fa-minus fa-plus');
                $("#input_paper_form").html('');
                $("#input_paper_form").slideUp();
                $(".loader-paper-add").hide();
              } else {
                $(this).find('.fa').toggleClass('fa-plus fa-minus');
                $.ajax({
                    type : "post",
                    url :'<?=base_admin();?>modul/submission/paper/add_paper.php',
                    data : {id_abstract:<?=$_POST['id_abstract'];?>},
                    success : function(data) {
                      $(".loader-paper-add").hide();
                        $("#input_paper_form").html(data);
                        $("#input_paper_form").slideDown();
                    }
                });
              }
});

$('.refresh-chat').click(function(){
    $(".loader-chat").show();
        $.ajax({
          "method" : "post",
          "data" : {id_abstract:<?=$_POST['id_abstract'];?>},
          "url" : "<?=base_admin();?>modul/submission/paper/chat_content.php",
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
          "url" : "<?=base_admin();?>modul/submission/paper/chat_content.php",
          success : function(data) {
            $(".chat-content").html(data);
          }
      });
  }

$("#chat-box").on('click','.open-document',function(event) {
        event.preventDefault();
        var currentBtn = $(this);
$('.loader-document').show();
        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/submission/paper/show_document.php",
            type : "post",
            data : {id_paper:id},
            success: function(data) {
                $('.modal-paper').css("width","98%","padding", "0");
                $('.modal-content-paper').css("height","99%");
                $('#left-paper').removeClass('col-lg-12').addClass('col-lg-5');
                $(".document-view").html(data);
                $(".document-view").show();
          }
        });

    });

    $(".table").on('click','.open-document',function(event) {
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');
        $('.loader-document').show();

        $.ajax({
            url : "<?=base_admin();?>modul/submission/paper/show_document.php",
            type : "post",
            data : {id_paper:id},
            success: function(data) {
                $('.modal-paper').css("width","98%","padding", "0");
                $('.modal-content-paper').css("height","99%");
                $('#left-paper').removeClass('col-lg-12').addClass('col-lg-5');
                $(".document-view").html(data);
                $(".document-view").show();
          }
        });

    });



  var dtb_paper = $("#dtb_paper").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            'searching' : false,
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
/*                 "columnDefs": [ 
              
            {
            "targets": [4],
              "orderable": false,
              "searchable": false,
              "className": "all",
              "render": function(data, type, full, meta){
                return '<a href="<?=base_index();?>abstract/detail/'+data+'"  class="btn btn-success btn-sm" data-toggle="tooltip" title="Open document"><i class="fa fa-eye"></i></a>';
               }
            },
            ],*/
      
            'ajax':{
              url :'<?=base_admin();?>modul/submission/paper/paper_file.php',
            type: 'post',  // method  , by default get
              data: function ( d ) {
                    d.id = <?=$_POST['id_abstract'];?>
                  },

            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });



  $(".attach-file").click(function(){
    if( $('#isi_attachment').is(':empty') ) {
            $.ajax({
          "method" : "post",
          "url" : "<?=base_admin();?>modul/submission/paper/attachment.php",
          success : function(data) {
            $("#isi_attachment").html(data);
          }
      });
    } else {
      $("#isi_attachment").html('');
    }

  });
  
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
                   dtb_paper.draw();
                  console.log(responseText);
                      $.each(responseText, function(index) {
                        $('.pesan').val('');
                        $('#isi_attachment').html('');
                          console.log(responseText[index].status);
                          get_chat(responseText[index].id_abstract);
                          /*$('html, body').animate({
                              //scrollTop: $("#chat_id_"+responseText[index].id).offset().top
                              //scrollTop: $("#myDiv").offset().top

                          }, 2000);*/

                           $("#chat-box").animate({ scrollTop: $('#chat-box').prop("scrollHeight")}, 1000);
                    });
                }

            });
        }
    });
});
</script>