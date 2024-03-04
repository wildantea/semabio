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
                  <a target="_blank" href="<?=base_url();?>upload/papers/<?=$dir_name;?>/<?=$pesan->file_name;?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Download Document"><i class="fa fa-cloud-download"></i></a>
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