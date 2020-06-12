<?php

	//fonction encodeData
	//encode en JSON les données envoyées
	function encodeData($data) {
		header('Content-Type: application/json');
		header('Cache-control: no-store, no-cache, must-revalidate');
		header('Pragma: no-cache');
		if ($data != NULL) {
			header('HTTP/1.1 200 OK');
			echo json_encode($data);
			exit();
		} else {
			header('HTTP/1.1 500 Internal Server Error');
			exit();
		}
	}


	require_once('database.php');
	
	
	// Connexion à la bdd.
	$db = dbConnect();
	if (!$db){
		header ('HTTP/1.1 503 Service Unavailable');
		exit;
	}

	// verification de la requête.
	$requestMethod = $_SERVER['REQUEST_METHOD'];
	$request = substr($_SERVER['PATH_INFO'], 1);
	$request = explode('/', $request);
	$requestRessource = array_shift($request);
	

	// verification de l'id associé à la requête.
	$id = array_shift($request);
  	if ($id == ''){
	  $id = NULL;
	}
	$data = false;

	// select request.
	if ($requestRessource == 'user'){
		$data = dbRequestUser($db, $_GET['mailco']);
		$mail = $_GET['mailco'];
	}
	
	if($requestRessource == 'cycliste'){
		if ($requestMethod == 'GET'){
			if(isset($_GET['mailco']) ){
				$data = dbRequestCyclists($db, $_GET['mailco']);
			}
		
		}
		if ($requestMethod == 'PUT'){
			echo'ouiiii';
			parse_str(file_get_contents('php://input'), $_PUT);
			echo $_GET['mail'];
			$data = dbModifyCyclist($db, $_GET['mail'], strip_tags($_PUT['nom']), $prenom, $num_licence, $date_naissance, $club, $code_insee);
			
		}
	}    
	
	if ($requestRessource == 'courses'){
		if ($requestMethod =='GET'){
			$data = dbRequestRace($db);

		}
		
		if ($requestMethod == 'POST'){
			
				$data = dbAddRace($db, $_POST['libelle'], $_POST['date'], $_POST['nb_tour'], $_POST['distance'],  $_POST['nb_coureur'], $_POST['longueur_tour'],  $_POST['club']);

		}
	}

	if($requestRessource == 'participants'){
		if ($requestMethod == 'GET'){
			if(isset($_GET['id']) && isset($_GET['club'])){
				$cluborga = dbRequestRace($db);
				$cluborga = $cluborga[$_GET['id']-1]['club'];
				$data = dbRequestOnList($db, $_GET['id'], $_GET['club'], $cluborga);
			}
			
			
		}
		if ($requestMethod == 'POST'){

			$data = dbAddCyclistToRace($db, $_POST['mail'], $_POST['id'], $_POST['dossart']);
		}
		
		
	}

  	if ($requestMethod == 'OPTIONS'){
	header('HTTP/1.1 200 OK');
	exit;
	}

	// Send data to the client.
	header('Content-Type: application/json; charset=utf-8');
	header('Cache-control: no-store, no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('HTTP/1.1 200 OK');
	echo json_encode($data);
	exit;

?>
