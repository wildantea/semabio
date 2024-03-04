<?php
	//doc route
	$app->get('/tes/doc',function() use ($db) {
		include "doc.php";
	});


	//login action
	$app->post('/tes/login', function() use ($app,$db) {
		auth_data($app,$db,"json");
	});

	//auth status
	$read_auth = ($db->fetch_single_row('sys_services','nav_act','tes')->read_auth=="Y")?$authenticate('xml'):"noauth";
	//url route
	$app->get('/tes',$read_auth, function() use ($app,$apiClass,$pg) {
		$data = $pg->query("select kabupaten.id_prov,kabupaten.nama_kab from kabupaten");
		if ($data==true) {
		$response['status'] = array();
		//meta data
		$response['meta']['total-records'] = $pg->total_record;
		$response['meta']['current-records'] = $pg->total_current_record;
		$response['meta']['total-pages'] = $pg->total_pages;
		$response['meta']['current-page'] = $pg->page;

		$response['results'] = array();
		foreach ($data as $dt) {
		//status code
		$response['status']['code'] = 200;
		$response['status']['message'] = "Ok";
			
		$row = array(
				'id_prov' => $dt->id_prov,
				'nama_kab' => $dt->nama_kab,
				);
		//result data
		array_push($response['results'],$row);

		}
		//paginations link
		$response['paginations'] = array();
		$response['paginations']['self'] = $pg->api_current_uri($apiClass->uri_segment(0));
		$response['paginations']['first'] = $pg->api_first($apiClass->uri_segment(0));
		$response['paginations']['prev'] = $pg->api_prev($apiClass->uri_segment(0));
		$response['paginations']['next'] = $pg->api_next($apiClass->uri_segment(0));
		$response['paginations']['last'] = $pg->api_last($apiClass->uri_segment(0));
		
        echoResponse(200, $response,"json");
		} else {
			$response['status']['code'] = 422;
			$response['status']['message'] = $pg->getErrorMessage();
			echoResponse(422, $response,"json");
		}
	});

	$app->get('/tes/:id',$read_auth, function($id) use ($app,$apiClass,$pg) {
	$data = $pg->query("select kabupaten.id_prov,kabupaten.nama_kab from kabupaten where id_kab=?",array('id_kab'=>$id));
	if ($data==true) {
		$response['status'] = array();

		if ($data->rowCount()>0) {
			$response['results'] = array();
			foreach ($data as $dt) {
			//status code
			$response['status']['code'] = 200;
			$response['status']['message'] = "Ok";
				
		$row = array(
				'id_prov' => $dt->id_prov,
				'nama_kab' => $dt->nama_kab,
				);
			//result data
			array_push($response['results'],$row);
			}
	        echoResponse(200, $response,"json");
		} else {
			$response['status']['code'] = 404;
            $response['status']["message"] = "The requested resource doesn't exists";
            echoResponse(404, $response,"json");
		}

	} else {
		$response['status']['code'] = 422;
		$response['status']['message'] = $pg->getErrorMessage();
		echoResponse(422, $response,"json");
	}
	});

	//auth status
	$create_auth = ($db->fetch_single_row('sys_services','nav_act','tes')->create_auth=="Y")?$authenticate('xml'):"noauth";
	//post tes
	$app->post('/tes',$create_auth, function() use ($app,$db,$apiClass) {
	 		$app = \Slim\Slim::getInstance();
	 		$request = $app->request();

	 		
	 		
		$validation = array(
		"id_prov" => array(
              "type" => "no",
              "alias" => "id_prov",
              "value" => $request->post("id_prov"),
              "allownull" => "",
		),
		"nama_kab" => array(
              "type" => "no",
              "alias" => "nama_kab",
              "value" => $request->post("nama_kab"),
              "allownull" => "",
		),
		);
	 		
		$data = array(
            "id_prov" => $request->post("id_prov"),
            "nama_kab" => $request->post("nama_kab"),
		);

	 		$val = $apiClass->assert($validation);

	 		if (empty($apiClass->errors())) {
	 			
	 			$in = $db->insert('kabupaten',$data);

	 			if ($in==true) {
	 			$id = $db->last_insert_id();
	 			$response['status']['code'] = 201;
                $response['status']["message"] = "tes created successfully";
                $response['status']["id"] = $id;
                echoResponse(201, $response,"json");
		 		} else {
					$response['status']['code'] = 422;
					$response['status']['message'] = $db->getErrorMessage();
					echoResponse(422, $response,"json");
		 		}
	 		} else {
					$response['status']['code'] = 422;
					foreach ($apiClass->errors() as $error) {
						$response['status']['message'] = $error;	
					}
					echoResponse(422, $response,"json");
	 		}

	});

	//auth status
	$update_auth = ($db->fetch_single_row('sys_services','nav_act','tes')->update_auth=="Y")?$authenticate('xml'):"noauth";

	//update tes
	$app->put('/tes/:id',$update_auth, function($id) use ($app,$db,$apiClass) {
	 		$app = \Slim\Slim::getInstance();
	 		$request = $app->request();
	 		
	 		$validation = array();
	 		$data = array();

	 		$data_stream = array();
			new lib\stream($data_stream);

	 		$_PUT = $data_stream['post'];
			$_FILES = $data_stream['file'];

	 		
        if (isset($_PUT["id_prov"])) {
          $id_prov_validation = array(
            "id_prov" => array(
              "type" => "no",
              "alias" => "id_prov",
              "value" => $_PUT["id_prov"],
              "allownull" => "",
        ));
        $id_prov_data =  array(
            "id_prov" => $_PUT["id_prov"]
        );
        $validation = array_merge($validation,$id_prov_validation);
        $data = array_merge($data,$id_prov_data);
        }
        if (isset($_PUT["nama_kab"])) {
          $nama_kab_validation = array(
            "nama_kab" => array(
              "type" => "no",
              "alias" => "nama_kab",
              "value" => $_PUT["nama_kab"],
              "allownull" => "",
        ));
        $nama_kab_data =  array(
            "nama_kab" => $_PUT["nama_kab"]
        );
        $validation = array_merge($validation,$nama_kab_validation);
        $data = array_merge($data,$nama_kab_data);
        }

	 	      if (!empty($data)) {

	        if (!empty($validation)) {
	          $val = $apiClass->assert($validation);

	          if (empty($apiClass->errors())) {
	          	
	            $up = $db->update("kabupaten",$data,"id_kab",$id);

	            if ($up==true) {
	              $response["status"]["code"] = 200;
	                      $response["status"]["message"] = ucwords("tes")." Updated successfully";
	                      echoResponse(200, $response,"json");
	            } else {
	              $response["status"]["code"] = 422;
	              $response["status"]["message"] = $apiClass->pdo->getErrorMessage();
	              echoResponse(422, $response,"json");
	            }
	          } else {
	              $response["status"]["code"] = 422;
	              foreach ($apiClass->errors() as $error) {
	                $response["status"]["message"] = $error;  
	              }
	              echoResponse(422, $response,"json");
	          }
	        } else {
	            $up = $db->update("kabupaten",$data,"$primary_key",$id);

	            if ($up==true) {
	              $response["status"]["code"] = 200;
	                      $response["status"]["message"] = ucwords("tes")." Updated successfully";
	                      echoResponse(200, $response,"json");
	            } else {
	              $response["status"]["code"] = 422;
	              $response["status"]["message"] = $db->getErrorMessage();
	              echoResponse(422, $response,"json");
	            }
	        }

	      } else {
	          $response["status"]["code"] = 422;
	                  $response["status"]["message"] = "Unprocessable Entity";
	                  echoResponse(422, $response,"json");
	      }
	});


//auth status
$delete_auth = ($db->fetch_single_row('sys_services','nav_act','tes')->delete_auth=="Y")?$authenticate('xml'):"noauth";

	//delete tes
	$app->delete('/tes/delete/:id',$delete_auth, function($id) use ($app,$db,$apiClass) {
			$single_data = $db->fetch_single_row("kabupaten","id_kab",$id);
			
	 		$up = $db->delete('kabupaten','id_kab',$id);

	 		if ($up==true) {
	 			$response['status']['code'] = 200;
                $response['status']["message"] = "tes Deleted successfully";
                echoResponse(200, $response,"json");
	 		} else {
				$response['status']['code'] = 422;
				$response['status']['message'] = $db->getErrorMessage();
				echoResponse(422, $response,"json");
	 		}

	});

	//search tes
	$app->get('/tes/search/:search',$read_auth, function($search) use ($app,$db,$pg,$apiClass) {
          $search_condition = $db->getRawWhereFilterForColumns($search, array('kabupaten.id_prov','kabupaten.nama_kab',));
          $search_condition = "where $search_condition";
	 	$data = $pg->query("select kabupaten.id_prov,kabupaten.nama_kab from kabupaten $search_condition");
	 	if ($data==true) {
	 		$response['status'] = array();
	 		$response['results'] = array();
	 		foreach ($data as $dt) {
				//status code
				$response['status']['code'] = 200;
				$response['status']['message'] = "Ok";
				
		$row = array(
				'id_prov' => $dt->id_prov,
				'nama_kab' => $dt->nama_kab,
				);
				//result data
				array_push($response['results'],$row);	 			
	 		}
	 				//paginations link
		$response['paginations'] = array();
		$response['paginations']['self'] = $pg->api_current_uri($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['first'] = $pg->api_first($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['prev'] = $pg->api_prev($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['next'] = $pg->api_next($apiClass->uri_segment(0),$apiClass->uri_segment(2));
		$response['paginations']['last'] = $pg->api_last($apiClass->uri_segment(0),$apiClass->uri_segment(2));
			echoResponse(200, $response,"json");
	 	} else {
			$response['status']['code'] = 422;
			$response['status']['message'] = $db->getErrorMessage();
			echoResponse(422, $response,"json");
	 	}
	});

	