<?php
	//require_once("database.php");
	
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

	// $login = 'cir2';
	
	// //Connection à la base de donnée
	// $db = dbConnect();

	// if(!$db)	//Vérification de la connexion
	// 	header('HTTP/1.1 503 Service Unavailable');
	// else 
	// 	header('HTTP/1.1 200 OK');

	// $requestMethod = $_SERVER['REQUEST_METHOD'];	//On récupère la méthode
	// $request = substr($_SERVER['PATH_INFO'], 1); 
	// $request = explode('/', $request);
	// $requestRessource = array_shift($request);	//on "verifie" si c'est photos ou comments
	// $idCom = array_shift($request);	//id du commentaire
	// if ($idCom == ''){
	// 	$idCom = NULL;
	// }
	// $data = false;
	
	// if($requestRessource == 'photos') {
	// 	if ($idCom != NULL) {
	// 		$data = dbRequestPhoto($db, $idCom);	//Cherche une photo spécifique en large
	// 	} else {
	// 		$data = dbRequestPhotos($db);	//Cherche toutes les photos
	// 	}

	// 	encodeData($data);

	// } else if ($requestRessource == 'comments') {
	// 	switch($requestMethod) {
	// 		case 'GET':
	// 			if(isset($_GET['id'])) {
	// 				$data = dbRequestComments($db, $_GET['id']);	//Récupère tous les commentaires d'une photo
	// 			}
	// 		break;

	// 		case 'POST':
	// 			if (isset($_POST['id']) && isset($_POST['comment'])) {
	// 				$data = dbAddComment($db, $login, intval($_POST['id']), strip_tags($_POST['comment']));	//Ajoute un commentaire
	// 			}
	// 		break;

	// 		case 'PUT':
	// 			parse_str(file_get_contents('php://input'), $_PUT);
	// 			if (isset($_PUT['comment']) && $idCom != NULL) {
	// 				$data = dbModifyComment($db, $login, intval($idCom), strip_tags($_PUT['comment']));	//Modifie un commentaire
	// 			}
	// 		break;

	// 		case 'DELETE':
	// 			if ($idCom != NULL) {
	// 				$data = dbDeleteComment($db, $login, intval($idCom));		//Supprime un commentaire
	// 			}
	// 		break;
	// 	}

	// 	header('Content-Type: application/json');
	// 	header('Cache-control: no-store, no-cache, must-revalidate');
	// 	header('Pragma: no-cache');
	// 	if ($requestMethod == 'POST') {
	// 		header('HTTP/1.1 201 Created');
	// 	} else {
	// 		header('HTTP/1.1 200 OK');
	// 	}
	// 	echo json_encode($data);
	// 	exit;

	// }
	// header('HTTP/1.1 400 Bad Request');	


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
		$data = dbRequestUser($db, $_GET['mail']);
		$mail = $_GET['mail'];
	}
	
	if($requestRessource == 'cycliste'){
		$data = dbRequestCyclists($db, $_GET['mail']);
		// var_dump($data[0]['club']);
		if ($requestMethod == 'PUT' && $login != NULL){
			parse_str(file_get_contents('php://input'), $_PUT);
			if (isset($_PUT['mail']) && isset($_PUT['nom'])){
				$data = dbModifyCyclist($db, $_GET['mail'], strip_tags($_PUT['nom']), $prenom, $num_licence, $date_naissance, $club, $code_insee);
			}
		}
	}    
	
	if ($requestRessource == 'courses'){
		if ($requestMethod =='GET'){
			$data = dbRequestRace($db);
			//echo $data[0]['club'];
			//dbRequestOnList($db, $id, $_GET['mail'], $cluborga)
		}
		
		if ($requestMethod == 'POST'){
			//echo "oui";
			//if (isset($_POST['login']) ){
				// echo$_POST['login'];
				//echo "oui";
				// echo $_POST['libelle'];
				// echo $_POST['date'];
				// echo $_POST['nb_'];
				// echo $_POST['libelle'];
				// echo $_POST['libelle'];
				$data = dbAddRace($db, $_POST['libelle'], $_POST['date'], $_POST['nb_tour'], $_POST['distance'],  $_POST['nb_coureur'], $_POST['longueur_tour'],  $_POST['club']);
			//}
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
				// echo$_POST['mail'];
				// echo'oui';

				$data = dbAddCyclistToRace($db, $_POST['mail'], $_POST['id'], $_POST['dossart']);
			// }
		}
		
		
	}

  	if ($requestMethod == 'OPTIONS'){
	header('HTTP/1.1 200 OK');
	exit;
	}

	
  
	//encodeData($data);


	// Send data to the client.
	header('Content-Type: application/json; charset=utf-8');
	header('Cache-control: no-store, no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('HTTP/1.1 200 OK');
	echo json_encode($data);
	exit;

?>