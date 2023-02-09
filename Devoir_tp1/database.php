<?php

try {
  $dbName = 'devoir_tp1';
  $host = 'localhost';
  $utilisateur = 'root';
  $motDePasse = '';
  $port='3308'; //port MySQL
  $dns = 'mysql:host='.$host .';dbname='.$dbName.';port='.$port;
  $bd = new PDO( $dns, $utilisateur, $motDePasse );
  $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  
  die('<p> The connection failed. Erreur['.$e->getCode().'] : '
   . $e->getMessage().'</p>');
 }
  ?>
