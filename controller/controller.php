<?php
require 'model/model.php';


//////////// Home Page /////////////////////////////////
function index()
{
  require 'view/homeView.php';
}

///////////////////////// CONNECT USER ///////////////////////////
function formConnect()
{
  require 'view/connectUser.php';
}

function connectUser($email)
{
  $result = getUserInfos($email);
  return $result;
}

///////////////////////// DISCONNECT USER ////////////////////////

function disconnectUser()
{
  session_unset();
  session_destroy();

  require 'view/homeView.php';
}


//////////////////////// LIST BOTTLES /////////////////////////////

function listBottles($action)
{
  $result = getListBottles();
  $listBottles = $result->fetchAll();

  $result->closeCursor();

  //// Redirection
  if ($action == 'bottles') {
    require 'view/listBottles.php';
  } elseif ($action == 'manageCave') {
    require 'view/manageCave.php';
  }
}


/////////////////////// SET BOTTLE ///////////////////////

function setBottle($arrayBottle)
{
  updateBottle($arrayBottle);
}
