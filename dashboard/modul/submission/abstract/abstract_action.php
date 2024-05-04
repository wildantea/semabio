<?php
session_start();
include "../../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case 'input_note':
  //check if not exist
  $check_note = $db->check_exist("tb_data_note_abstract",array('id_abstract' => $_POST['id_abstract'],'id_reviewer' => $_SESSION['id_user']));
       $data = array(
        'notes' => $_POST['notes'],
        'id_abstract' => $_POST['id_abstract'],
        'id_reviewer' => $_SESSION['id_user'],
        'date_updated' => date('Y-m-d H:i:s')
      );
  if ($check_note) {
      $db->update('tb_data_note_abstract',$data,'id',$_POST['id_note']);
      $id = $_POST['id_note'];
      $db->update('tb_data_abstract',array('status_abstract' => $_POST['status_abstract'],'approved_by' => $_SESSION['id_user']),'id',$_POST['id_abstract']);
  } else {
      $db->insert('tb_data_note_abstract',$data);
      $id = $db->last_insert_id();
      $db->update('tb_data_abstract',array('status_abstract' => $_POST['status_abstract'],'approved_by' => $_SESSION['id_user']),'id',$_POST['id_abstract']);
  }
  //check if abstract is not accepted yet
  $abstract = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
  if ($abstract->status_abstract!='Diterima') {
    //check if payment is exist
        $payment = $db->fetch_single_row("tb_data_payment","id_abstract",$_POST['id_abstract']);
        if ($payment==false) {
            $get_due_date = $db->fetch_single_row("tb_ref_setting_conference","id",1);
            $invoice_urutan = $db->fetch_custom_single("select * from tb_data_payment order by inv_number desc");
            if ($invoice_urutan) {
              $invoice = $invoice_urutan->inv_number+1;
            } else {
              $invoice = 102;
            }
             $abstract = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
            //member
            $check_kat_member = $db->fetch_single_row('tb_data_member','id_user',$abstract->id_user);
            $setting_conference = $db->fetch_single_row("tb_ref_setting_conference","is_aktif",'Y');

            $kat_daftar = $db->fetch_single_row("kategori_daftar","id_kat",$check_kat_member->id_kat_member);
                if ($kat_daftar->biaya_daftar>0) {
                  $data_payment = array(
                    'id_abstract' => $abstract->id,
                    'inv_number' => $invoice,
                    'id_user' => $abstract->id_user,
                    'jumlah' => $kat_daftar->biaya_daftar,
                    'kode_unik' => $invoice,
                    'due_date' => substr($setting_conference->last_payment,0,10),
                    'inv_date' => date('Y-m-d'),
                    'status_payment' => 'unpaid'
                  );
                $db->insert('tb_data_payment',$data_payment);
            }
        }
                

  }
  echo $id;
    break;
  case 'verifikasi':
    $data = array(
      'verifikasi' => $_POST['verifikasi'],
      'tgl_verifikasi' => date('Y-m-d'),
      'alasan_ditolak' => '',
      'approved_by' => $_SESSION['id_user']
    );
    if ($_POST['verifikasi']=='Ditolak' or $_POST['verifikasi']=='Revisi') {
      $data['alasan_ditolak'] = $_POST['alasan_ditolak'];
    }
    $db->update('tb_data_abstract',$data,'id',$_POST['id_abstract']);
    echo $db->getErrorMessage();
    break;
  case 'input_note_paper':
  //check if not exist
  $check_note = $db->check_exist("tb_data_note_paper",array('id_abstract' => $_POST['id_abstract'],'id_reviewer' => $_SESSION['id_user']));
       $data = array(
        'notes' => $_POST['notes'],
        'id_abstract' => $_POST['id_abstract'],
        'id_reviewer' => $_SESSION['id_user'],
        'date_updated' => date('Y-m-d H:i:s')
      );

  if ($check_note) {
      $db->update('tb_data_note_paper',$data,'id',$_POST['id_note']);
      $id = $_POST['id_note'];
  } else {
      $db->insert('tb_data_note_paper',$data);
      $id = $db->last_insert_id();
  }
  echo $id;
  break;
  case "in":

$dir_name = str_replace(" ", "_", $_POST['presenter_name']);
  if (!is_dir("../../../../upload/papers/$dir_name")) {
          mkdir("../../../../upload/papers/$dir_name");
      }

 if(isset($_FILES["nama_file"]["name"])) {

 if (!preg_match("/.(docx|doc)$/i", $_FILES["nama_file"]["name"]) ) {

    action_response($lang["upload_file_error_extention"]."docx|doc"); 
    exit();

  }
}

$input = $_POST['content_abstract']; // Change 'user_input' to the actual name of your input field


$cleaned_input = strip_tags($input);
// Count the number of words in the input
$word_count = str_word_count($cleaned_input);


// Check if the number of words is more than 250
if ($word_count > 250) {
    action_response('Maximal Abstrak 250 Kata');
} 

//check if title is exist
$title_check = $db->fetch_custom_single("select * from tb_data_abstract where id_user=? and title_abstract=?",array("id_user" => $_POST["id_user"],"title_abstract" => $_POST["title_abstract"]));
if ($title_check) {
  action_response("Abstract dengan Judul ini sudah ada");
}


  $data = array(
      "id_user" => $_POST["id_user"],
      "title_abstract" => $_POST["title_abstract"],
      "all_authors" => $_POST["all_authors"],
      "affiliation" => $_POST["affiliation"],
      "content_abstract" => convert_ascii($_POST["content_abstract"]),
      "email_author" => $_POST["email_author"],
      "keywords_abstract" => $_POST["keywords_abstract"],
      "id_scope" => $_POST["id_scope"],
      "presenter_name" => $_POST["presenter_name"],
      "date_created" => date('Y-m-d H:i:s')
  );
      
    $in = $db->insert("tb_data_abstract",$data);
    echo $db->getErrorMessage();
    $last_id = $db->last_insert_id();


if (isset($_FILES['file_name'])) {

 $data_chat = array(
      "id_abstract" => $last_id,
      "id_user" => $_POST["id_user"],
      "pesan" => 'File Abstract',
      "date_created" => date('Y-m-d H:i:s'),
      "is_read" => 'N'
  );


 
    if (!is_dir("../../../../upload/abstracts/$dir_name")) {
          mkdir("../../../../upload/abstracts/$dir_name");
      }
      if (!is_dir("../../../../upload/abstracts/$dir_name/$last_id")) {
          mkdir("../../../../upload/abstracts/$dir_name/$last_id");
      }
   if (!preg_match("/.(docx|doc)$/i", $_FILES["file_name"]["name"]) ) {

      action_response($lang["upload_file_error_extention"]."docx|doc"); 
      exit();

    }
    
    $renamer = "abstract_01";
    $temp = explode(".", $_FILES["file_name"]["name"]);
    $newfilename = $renamer . '.' . end($temp);
    $data_chat['has_file']= 'Y';
    $data_chat["file_name"] = $newfilename;

    move_uploaded_file($_FILES["file_name"]["tmp_name"], "../../../../upload/abstracts/$dir_name/$last_id/".$newfilename);

    $in = $db->insert("tb_data_abstract_chat",$data_chat);
     echo $db->getErrorMessage();

}

 if(isset($_FILES["nama_file"]["name"])) {

    if (!is_dir("../../../../upload/papers/$dir_name/$last_id")) {
          mkdir("../../../../upload/papers/$dir_name/$last_id");
      }  

      $datas = array(
          "id_abstract" => $last_id,
          "id_user" => $_POST["id_user"],
          "has_file" => 'Y',
          "message" => "First time upload paper",
          "status_paper" => 'Reviewed',
          "date_created" => date('Y-m-d H:i:s')
      );
    $renamer = "paper_01";
    $temp = explode(".", $_FILES["nama_file"]["name"]);
    $newfilename = $renamer . '.' . end($temp);

    $datas["file_name"] = $newfilename;
    $in = $db->insert("tb_data_papers",$datas);

    move_uploaded_file($_FILES["nama_file"]["tmp_name"], "../../../../upload/papers/$dir_name/$last_id/".$newfilename);
  
}
    action_response($db->getErrorMessage());
    break;
  case "delete":
    $presenter_name = $db->fetch_single_row("tb_data_abstract","id",$_GET["id"]);
    $dir_name = str_replace(" ", "_", $presenter_name->presenter_name);
    $db->deleteDirectory("../../../../upload/papers/".$dir_name."/".$_GET['id']);
    $db->delete("tb_data_abstract","id",$_GET["id"]);
    action_response($db->getErrorMessage());

    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_data_abstract","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":


if ($_POST['presenter_name_old']!=$_POST['presenter_name']) {
  $dir_name_new = str_replace(" ", "_", $_POST['presenter_name']);
  $dir_name_old = str_replace(" ", "_", $_POST['presenter_name_old']);
  if (!is_dir("../../../../upload/papers/$dir_name_old")) {
          mkdir("../../../../upload/papers/$dir_name_new");
  } else {
    //echo "../../../../upload/papers/$dir_name_old";
    rename("../../../../upload/papers/$dir_name_old", "../../../../upload/papers/$dir_name_new");
  }
//rename(realpath(dirname(__FILE__)).'/myoldfolder',realpath(dirname(__FILE__)).'/mynewfolder');

}

   if(isset($_FILES["nama_file"]["name"])) {

 if (!preg_match("/.(docx|doc)$/i", $_FILES["nama_file"]["name"]) ) {

    action_response($lang["upload_file_error_extention"]."docx|doc"); 
    exit();

  }

}
    
   $data = array(
      "title_abstract" => $_POST["title_abstract"],
      "all_authors" => $_POST["all_authors"],
      "affiliation" => $_POST["affiliation"],
      "content_abstract" => convert_ascii($_POST["content_abstract"]),
      "email_author" => $_POST["email_author"],
      "keywords_abstract" => $_POST["keywords_abstract"],
      "id_scope" => $_POST["id_scope"],
      "presenter_name" => $_POST["presenter_name"],
   );
   
   
    
    $up = $db->update("tb_data_abstract",$data,"id",$_POST["id"]);

    $last_id = $_POST['id'];

     if(isset($_FILES["nama_file"]["name"])) {

    $presenter_name = $db->fetch_single_row("tb_data_abstract","id",$last_id);
    $presenter_name = $presenter_name->presenter_name;

    $dir_name = str_replace(" ", "_", $presenter_name);

  if (!is_dir("../../../../upload/papers/$dir_name")) {
          mkdir("../../../../upload/papers/$dir_name");
      }
      

    if (!is_dir("../../../../upload/papers/$dir_name/$last_id")) {
          mkdir("../../../../upload/papers/$dir_name/$last_id");
      }  

      $datas = array(
          "id_abstract" => $last_id,
          "id_user" => $_POST["id_user"],
          "has_file" => 'Y',
          "message" => "First time upload paper",
          "status_paper" => 'Reviewed',
          "date_created" => date('Y-m-d H:i:s')
      );
    $renamer = "paper_01";
    $temp = explode(".", $_FILES["nama_file"]["name"]);
    $newfilename = $renamer . '.' . end($temp);

    $datas["file_name"] = $newfilename;
    $in = $db->insert("tb_data_papers",$datas);

    move_uploaded_file($_FILES["nama_file"]["tmp_name"], "../../../../upload/papers/$dir_name/$last_id/".$newfilename);
  
}

    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>