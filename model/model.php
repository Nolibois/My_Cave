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
function getListBottles($order = " ", $column = " ")
{
  // Options to sort ASC or DESC
  if (!empty($order) && !empty($column)) {

    // If != "name" then add sort "names" to ASC
    if ($column !== 'name') {
      $orderBy = "ORDER BY " . $column . " " . $order . ", name ASC";
    } else {
      $orderBy = "ORDER BY " . $column . " " . $order;
    }
  } else {
    $orderBy = " ";
  }

  $bdd = dbConnect();

  $result = $bdd->query("SELECT id, name, year, grapes, country, region, description, picture, date_creation, date_last_setting FROM bottles $orderBy");

  return $result;
}


///////// CREATE Bottle
function createBottle($newBottle)
{
  $bdd = dbConnect();

  $result = $bdd->prepare("INSERT INTO bottle (name, year, grapes, country, region, description) VALUES(:name, :year, :grapes, :country, :region, :description)");

  $bdd->exec($newBottle);
}

///////// UPDATE existing Bottle
function updateBottle($arrayBottle)
{
  $bdd = dbConnect();

  $req = $bdd->prepare('UPDATE bottles SET name = :name, year = :year, grapes = :grapes, country = :country, region = :region, description = :description, /* picture = :picture, */ date_last_setting = NOW() WHERE id = :id');

  $req->execute($arrayBottle);

  $req->closeCursor();
}


////////// DELETE

// Know number lines delete:
//$count = $bdd->rowCount();
