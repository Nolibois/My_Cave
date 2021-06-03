<?php
require_once 'dbconnect.php';


////////// Read infos user to connection
function getUserInfos($email)
{
  $bdd = dbconnect();

  $result = $bdd->query("SELECT id, first_name, last_name, email, password, admin FROM users Where email = '$email' ");

  return $result;
}

///////// Get list bottles 
function getListBottles()
{
  $bdd = dbConnect();

  $result = $bdd->query("SELECT id, name, year, grapes, country, region, description, picture, date_creation, date_last_setting FROM bottles");

  return $result;
}

///////// UPDATE existing Bottle
function updateBottle($arrayBottle)
{
  $bdd = dbConnect();

  $req = $bdd->prepare('UPDATE bottles SET name = :name, year = :year, grapes = :grapes, country = :country, region = :region, description = :description, picture = :picture, date_last_setting = NOW() WHERE id = :id');

  $req->execute($arrayBottle);

  $req->closeCursor();
}
