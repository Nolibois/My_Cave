<?php
require_once 'dbconnect.php';

////////// Read infos user to connection
function connectUser($email)
{
  $bdd = dbconnect();

  $result = $bdd->query("SELECT id, first_name, last_name, email, password, admin FROM users Where email = '$email' ");

  return $result;
}

///////// Get list bottles 
function getListBottles()
{
  $bdd = dbConnect();

  $result = $bdd->query("SELECT name, year, grapes, country, region, description, picture FROM bottles");

  return $result;
}
