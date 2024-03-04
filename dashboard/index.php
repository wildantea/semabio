<?php
session_start();

include "inc/config.php";

require_once "inc/url.php";

if (isset($_SESSION['login'])) {

//call header file
include  "header.php";
//switch for static menu
switch (uri_segment(1)) {
	case '':
		include "modul/home/home.php";
		break;
	//begin case system menu
	//show only if user is admin
	case 'page-service':
	include "system/service/service.php";
	break;
	case 'excel-generator':
	include "system/excel/service.php";
	break;
	case 'service-permission':
	include "modul/root_module/service_permission/service_permission.php";
	break;
	case 'page':
	include "system/page/page.php";
	break;
	case 'filter':
		include "system/page/filter/filter.php";
		break;
	case 'group-permission':
		include "modul/root_module/menu_management/menu_management.php";
	break;
	case 'user-group':
		include "modul/root_module/user_group/user_group.php";
		break;
	case 'user-managements':
		include "modul/root_module/user_managements/user_managements.php";
		break;
	//end case system menu
	case 'change-password':
		include "modul/root_module/change_password/change_pass.php";
		break;
	case 'profil':
		include "modul/root_module/profil/profil.php";
		break;

	/*default:
		include "modul/root_module/home/home.php";
		break;*/
}

     //dynamic menu from database
	//jika url yang di dipanggil ada di role user, include page
	foreach ($db->fetch_all('sys_menu') as $isi) {
		if (in_array($isi->url, $role_user)) {

               		if (uri_segment(1)!='' && uri_segment(1)==$isi->url) {

					include "modul/".$isi->nav_act."/".$isi->nav_act.".php";
					}
               }
	}


include "footer.php";

} else {
	redirect(base_admin()."login.php");
}
?>
