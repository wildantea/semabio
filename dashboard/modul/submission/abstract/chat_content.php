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
$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
$dir_name = str_replace(" ", "_", $presenter_name->presenter_name);

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