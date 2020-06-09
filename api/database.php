<?php

  require_once('constants.php');

  
  function dbConnect(){
    try{
      $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',
        DB_USER, DB_PASSWORD);
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
      $request = 'SELECT club FROM club WHERE mail=:mail';
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
      $request = 'SELECT * FROM courses';
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
      $request = 'UPDATE participe SET temps=:temps, position=:position, points=:points, temps=:temps  WHERE mail=:coureur';
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
        $request ='SELECT cy.nom,cy.prenom, cy.club FROM cycliste cy, club cl, participe p, course co 
        WHERE p.mail = cy.mail AND cy.club =:cluborga AND p.id=:id';
      }else{
        $request ='SELECT cy.nom,cy.prenom, cy.club, co.libelle FROM cycliste cy, club cl, participe p, course co 
        WHERE p.mail = cy.mail AND cy.club !=:cluborga AND p.id=:id';
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

  function dbRequestCyclists($db, $club){
    try
    {
      $request = 'SELECT * FROM cycliste WHERE club=:club';
      $statement = $db->prepare($request);
      $statement->bindParam(':club', $club, PDO::PARAM_STR);
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

  // function dbDeleteComment($db, $userLogin, $id){
  //   try
  //   {
  //     $request = 'DELETE FROM comments WHERE id=:id AND userLogin=:userLogin';
  //     $statement = $db->prepare($request);
  //     $statement->bindParam(':id', $id, PDO::PARAM_INT);
  //     $statement->bindParam(':userLogin', $userLogin, PDO::PARAM_STR, 20);
  //     $statement->execute();
  //   }
  //   catch (PDOException $exception)
  //   {
  //     error_log('Request error: '.$exception->getMessage());
  //     return false;
  //   }
  //   return true;
  // }




?>

