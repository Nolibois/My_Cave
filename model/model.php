<?php
require_once 'dbconnect.php';


////////// Read infos user to connection
function getUserInfos($email)
{
  $bdd = dbconnect();

  $result = $bdd->query("SELECT id, first_name, last_name, email, password, admin FROM users Where email = '$email' ");

  return $result;
}


////////// Get id bottles
function getIdBottles()
{

  $bdd = dbConnect();

  $result = $bdd->query("SELECT id FROM bottles");

  return $result;
}


////////// Get one bottle
function getBottle($id)
{

  $bdd = dbConnect();

  $result = $bdd->query("SELECT  picture, name, year, grapes, country, region, description FROM bottles WHERE id = $id");

  return $result;
}


///////// Get list bottles 
function getListBottles($order = "", $column = "")
{
  $orderBy = "";

  // Options to sort ASC or DESC
  if (!empty($order) && !empty($column)) {

    // If != "name" then add sort "names" to ASC
    if ($column !== 'name') {
      $orderBy = "ORDER BY " . $column . " " . $order . ", name ASC";
    } else {
      $orderBy = "ORDER BY " . $column . " " . $order;
    }
  }

  $bdd = dbConnect();

  $result = $bdd->query("SELECT id, name, year, grapes, country, region, description, picture, date_creation, date_last_setting FROM bottles $orderBy");

  return $result;
}


///////// CREATE Bottle
function createBottle($newBottle)
{
  $bdd = dbConnect();

  $result = $bdd->prepare("INSERT INTO bottles (name, year, grapes, country, region, description, picture) VALUES(:name, :year, :grapes, :country, :region, :description, :picture)");

  $result->execute($newBottle);

  $result->closeCursor();
}


///////// UPDATE existing Bottle
function updateBottle($arrayBottle, $picture)
{
  $bdd = dbConnect();

  $namePicture = "";

  if (!empty($picture)) {
    $arrayBottle['picture'] = $picture;
    $namePicture = ", picture = :picture";
  } else {
    $picture = "";
    $namePicture = "";
  }

  $req = $bdd->prepare("UPDATE bottles SET name = :name, year = :year, grapes = :grapes, country = :country, region = :region, description = :description $namePicture WHERE id = :id");

  $req->execute($arrayBottle);

  $req->closeCursor();
}


////////// DELETE
function deleteBottle($id)
{
  $bdd = dbConnect();

  $req = $bdd->prepare("DELETE FROM bottles WHERE id = :id");
  $req->execute($id);

  // Know number lines delete:
  $count = $req->rowCount();
  return $count;
}
