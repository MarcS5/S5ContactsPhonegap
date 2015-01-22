<?php
include('lib/includeAll.php');

	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Access-Control-Allow-Headers: Content-Type');
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

	header('Content-Type: application/json');
	
	switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			$queryString = explode("/", $_SERVER['REQUEST_URI']);
			$id = explode("?", $queryString[2]);
			$id = isset($id[1]) ? $id[1] : 0;
		
			if (!$id){
				echo $_dal->getContacts();
			} else {
				if ($_dal->contactExists($id)){
					echo substr($_dal->getContacts($id), 1, -1);
				} else { $response = array("status" => false, "hideForm" => true, "message" => "Invalid ID"); }
			}
			
			if (isset($response))
				echo json_encode($response);
				
			break;
			
		case "POST":
			$data = json_decode(file_get_contents("php://input"), true);
			
			try {
				include('process/contact-process.php');
			} catch (Exception $e) {
				$response = array("status" => false, "message" => $e->getMessage());
			}
			
			echo json_encode($response);
			break;
			
		case "DELETE":
			$queryString = explode("/", $_SERVER['REQUEST_URI']);
			$id = explode("?", $queryString[2]);
			$id = isset($id[1]) ? $id[1] : 0;
			
			try {
				if ($id){
					if ($_dal->contactExists($id)){
						$_dal->removeContact($id);
						$response = array("status" => true, "message" => "User deleted");
					} else { $response = array("status" => false, "hideForm" => true, "message" => "Invalid ID"); }
				}
			} catch (Exception $e) {
				$response = array("status" => false, "message" => $e->getMessage());
			}
			
			echo json_encode($response);
			break;
	}
?>
