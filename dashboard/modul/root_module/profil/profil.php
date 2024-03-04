
<?php
switch (uri_segment(2)) {
  case 'change-password':
    include "change_pass.php";
    break;
	case "edit":
    include "profil_edit.php";
		break;
	default:
	if ($_SESSION['group_level']=='presenter' or $_SESSION['group_level']=='participant') {
     include "modul/submission/profile_view.php";
  	} else {
		include "profil_view.php";
	}
		break;
}

?>
