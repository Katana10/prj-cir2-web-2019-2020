<?php

  require_once('constants.php');

  //fonction dbConnect 
  //type de valeur de retour : PDO
  //retourne un accès à une base de données, si connexion, sinon une erreur
  function dbConnect(){
    try{
      $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $exception){
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    
    return $db;
  }


  //fonction dbRequestUser 
  //vérification de l'utilisateur
  //si l'adresse mail est enregistrée dans la base de données, l'utilisateur a un accès autorisé
  function dbRequestUser($db, $mail){
    try{
      $request = 'SELECT * FROM club WHERE mail=:mail';
      $statement = $db->prepare($request);
      $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  //fonction dbRequestRace
  //attribut : $db de type PDO
  //retourne toutes les données contenues dans course de la BDD
  function dbRequestRace($db){
    try
    {
      $request = 'SELECT * FROM course';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }
  

  //function dbAddRace
  //Ajoute une nouvelle course à la base de données avec toutes les informations nécessaires
  function dbAddRace($db, $libelle, $dateco, $nb_tour, $distance, $nb_coureur, $longueur_tour, $club){
    try
    {
      $request = 'INSERT INTO course(libelle, date, nb_tour, distance, nb_coureur, longueur_tour, club) VALUES(:libelle, :dateco, :nb_tour, :distance, :nb_coureur, :longueur_tour, :club)';
      $statement = $db->prepare($request);
      // echo"non";
      $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR);
      $statement->bindParam(':dateco', $dateco, PDO::PARAM_STR);
      $statement->bindParam(':nb_tour', $nb_tour, PDO::PARAM_INT);
      $statement->bindParam(':distance', $distance, PDO::PARAM_INT);
      $statement->bindParam(':nb_coureur', $nb_coureur, PDO::PARAM_INT);
      $statement->bindParam(':longueur_tour', $longueur_tour, PDO::PARAM_INT);
      $statement->bindParam(':club', $club, PDO::PARAM_STR);
      // echo"oui";
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }


  //fonction dbAddCyclistToRace
  //Ajoute un cycliste à une course dans la base de données
  function dbAddCyclistToRace($db, $mail, $id, $dossart){
    try
    {
      $request = 'INSERT INTO participe(mail, id, dossart)
        VALUES(:coureur, :id, :dossart)';
      // echo 'oui';
      $statement = $db->prepare($request);
      $statement->bindParam(':coureur', $mail, PDO::PARAM_STR);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->bindParam(':dossart', $dossart, PDO::PARAM_INT);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }


  //fonction dbAddRaceTime
  //Ajoute un temps, une position et des points à un coureur qui participe à une course
  function dbAddRaceTime($db, $id, $mail, $position, $temps, $points){
    try
    {
      $request = 'UPDATE participe SET temps=:temps, position=:position, points=:points WHERE mail=:coureur AND id=:id';
      $statement = $db->prepare($request);
      $statement->bindParam(':temps', $temps, PDO::PARAM_STR);
      $statement->bindParam(':position', $position, PDO::PARAM_INT);
      $statement->bindParam(':points', $points, PDO::PARAM_INT);
      $statement->bindParam(':coureur', $mail, PDO::PARAM_STR);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);

      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }


  //dbRequestRanking
  //retourne le classement de tous les cyclistes
  function dbRequestRanking($db, $id){
    try
    {
      $request = 'SELECT * FROM participe WHERE id=:id';
      $statement = $db->prepare($request);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }


  //fonction dbResquestOnList
  //retourne tous les cyclistes d'un meme club qui participe à une course 
  //ou affiche tous les cyclistes participants si club organisateur
  function dbRequestOnList($db, $id, $club, $cluborga){
    try
    {
      if ($club == $cluborga){
        $request ='SELECT p.temps, p.point, p.id, cy.nom, cy.prenom
                   FROM participe p
                   JOIN cycliste cy ON cy.mail = p.mail
                   WHERE id=:id';
           $statement = $db->prepare($request);
          $statement->bindParam(':id', $id, PDO::PARAM_INT);

      }else{
        $request ='SELECT p.temps, p.point, p.id, cy.nom, cy.prenom 
        FROM participe p
        JOIN cycliste cy ON cy.mail = p.mail  
        JOIN club cl ON cl.club = cy.club 
        WHERE cl.club =:club AND p.id =:id';
        $statement = $db->prepare($request);
          $statement->bindParam(':club', $club, PDO::PARAM_STR);
          $statement->bindParam(':id', $id, PDO::PARAM_INT);
      }
      
      //$statement->bindParam(':club', $club, PDO::PARAM_STR);
      $statement->execute();
      
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }


  //fonction dbRequestCyclists
  //retourne tous les cyclistes d'un club
  function dbRequestCyclists($db, $mail){
    try
    {
      //$request = 'SELECT * FROM cycliste cy WHERE club=:club';
      $request="SELECT * FROM cycliste cy, club cl WHERE cl.mail=:mail AND cy.club =cl.club";
      $statement = $db->prepare($request);
      $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
      $statement->execute();
      
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }


  //fonction dbModifyCyclist
  //modifie les données d'un cycliste
  function dbModifyCyclist($db, $mail, $nom, $prenom, $num_licence, $date_naissance, $club, $code_insee){
    try
    {
      $request = 'UPDATE cycliste 
      SET nom=:nom, prenom=:prenom, num_licence=:num_licence, date_naissance=:date_naissance, club=:club, code_insee=:code_insee   
      WHERE mail=:mail';
      $statement = $db->prepare($request);
      $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
      $statement->bindParam(':num_licence', $num_licence, PDO::PARAM_INT);
      $statement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
      $statement->bindParam(':nom', $nom, PDO::PARAM_STR);
      $statement->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
      $statement->bindParam(':club', $club, PDO::PARAM_STR);
      $statement->bindParam(':code_insee', $code_insee, PDO::PARAM_INT);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }





?>

