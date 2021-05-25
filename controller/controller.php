<?php
require 'model/model.php';

///////////// Read Messages Error ///////////////
function displayError($msgError)
{
  foreach ($msgError as $value) {
    echo '- ' . $value . '<br>';
  }
?>
  <div>
    <a href="index?php">Retour à l'accueil</a>
  </div>
<?php
}


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

function listBottles($action, $order = NULL, $column = NULL)
{

  $result = getListBottles($order, $column);
  $listBottles = $result->fetchAll();
  $result->closeCursor();

  //// Redirect
  if ($action == 'bottles') {
    require 'view/listBottles.php';
  } elseif ($action == 'manageCave') {

    // Swap GET "order" ASC to DESC and DESC to ASC
    if ($order === 'ASC') {
      $order = 'DESC';
    } elseif ($order === 'DESC') {
      $order = 'ASC';
    } elseif ($order === NULL) {
      $order = "ASC";
    }

    require 'view/manageCave.php';
  }
}


//////////////////////// CREATE BOTTLE ///////////////////////
function addBottle($newBottle)
{

  createBottle($newBottle);
  $result = getListBottles();
  $listBottles = $result->fetchAll();
  $result->closeCursor();

  require 'view/manageCave.php';
}


//////////////////////// SET BOTTLE /////////////////////////

// Set bottle
function setBottle($arrayBottle)
{

  updateBottle($arrayBottle);
  unset($_GET['set']);
  listBottles("manageCave");
}
