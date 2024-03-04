
		<?php
		session_start();
		include "../../inc/config.php";
		$data = array(
		array(
				'level' => 'admin',
				'level_name' => 'admin',
				'deskripsi' => 'Super Administrator'
				),
				array(
				'level' => 'users',
				'level_name' => 'users',
				'deskripsi' => 'user'
				),
				);

		//check group exist
				foreach ($data as $dt) {
			$check = $db->check_exist("sys_group_users",array("level" => $dt["level"]));
			if ($check==false) {
				$data = array(
					"level" => $dt["level"],
					"level_name" => $dt["level_name"],
					"deskripsi" => $dt["deskripsi"]
					);
				$db->insert("sys_group_users",$data);
			}
		}
		
		//insert page
		$db->query("insert into sys_menu (nav_act,page_name,url,main_table,icon,urutan_menu,parent,dt_table,tampil,type_menu) values('kabupaten','kabupaten','kabupaten','kabupaten','','1','0','Y','Y','page')")
		$last_id = $db->last_insert_id();
		
		//insert menu role
		$data = array(
		array(
				'id_menu' => $last_id,
				'group_level' => 'admin',
				'read_act' => 'Y',
				'insert_act' => 'Y',
				'update_act' => 'Y',
				'delete_act' => 'Y'
				),
				array(
				'id_menu' => $last_id,
				'group_level' => 'users',
				'read_act' => 'N',
				'insert_act' => 'N',
				'update_act' => 'N',
				'delete_act' => 'N'
				),
				);

		?>
		