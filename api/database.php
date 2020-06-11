<?php

  require_once('constants.php');

  
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

  // function dbRequestPhotos($db){
  //   try{
  //     $request = 'SELECT id, small AS src FROM photos';
  //     $statement = $db->prepare($request);
  //     $statement->execute();
  //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  //   }catch (PDOException $exception){
  //     error_log('Request error: '.$exception->getMessage());
  //     return false;
  //   }
  //   return $result;
  // }

 
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
  
  function dbAddRace($db, $libelle, $date, $nb_tour, $distance, $nb_coureur, $longueur_tour, $club){
    try
    {
      $request = 'INSERT INTO course(libelle, date, nb_tour, distance, nb_coureur, longueur_tour, club) VALUES(:libelle, :date, :nb_tour, :distance, :nb_coureur, :longueur_tour, :club)';
      $statement = $db->prepare($request);
      $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR);
      $statement->bindParam(':date', $date, PDO::PARAM_STR);
      $statement->bindParam(':distance', $distance, PDO::PARAM_INT);
      $statement->bindParam(':nb_coureur', $nb_coureur, PDO::PARAM_INT);
      $statement->bindParam(':longueur_tour', $longueur_tour, PDO::PARAM_INT);
      $statement->bindParam(':club', $club, PDO::PARAM_STR);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  function dbAddCyclistToRace($db, $mail, $id, $dossart){
    try
    {
      $request = 'INSERT INTO participe(mail, id, dossart)
        VALUES(:coureur, :id, :dossart)';
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

  function dbAddRaceTime($db, $mail, $position, $temps, $points){
    try
    {
      $request = 'UPDATE participe SET temps=:temps, position=:position, points=:points WHERE mail=:coureur';
      $statement = $db->prepare($request);
      $statement->bindParam(':coureur', $mail, PDO::PARAM_STR);
      $statement->bindParam(':position', $position, PDO::PARAM_INT);
      $statement->bindParam(':points', $points, PDO::PARAM_INT);
      $statement->bindParam(':temps', $temps, PDO::PARAM_STR);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

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

  function dbRequestOnList($db, $id, $club, $cluborga){
    try
    {
      if ($club == $cluborga){
        
        $request ='SELECT cy.nom,cy.prenom, cy.club, co.libelle, p.temps p.dossart, p.place, p.point FROM cycliste cy, club cl, participe p, course co
        WHERE p.mail = cy.mail AND cy.club =:cluborga AND p.id=:id';
      }else{
        $request ='SELECT * FROM cycliste cy, club cl, participe p, course co  WHERE p.mail = cy.mail AND cy.club =:club AND p.id=:id';
        
      }
      $statement = $db->prepare($request);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->bindParam(':club', $club, PDO::PARAM_STR);
      $statement->bindParam(':cluborga', $cluborga, PDO::PARAM_STR);
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

