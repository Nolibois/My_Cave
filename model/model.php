<?php
require_once '../view/dbconnect.php';

////////// Read infos user to connection
function connectUser($email)
{
  $bdd = dbconnect();

  $result = $bdd->query("SELECT id, first_name, last_name, email, password, admin FROM users Where email = '$email' ");

  return $result;
}
