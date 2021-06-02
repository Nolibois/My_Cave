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
    <a href="index?">Retour à l'accueil</a>
  </div>
<?php
}

///////////// Read x3 bottles ////////////////////
function randThree()
{

  $listIdBottles = [];
  $threeId = [];
  $result = getIdBottles();

  $idBottles = $result->fetchALL(PDO::FETCH_ASSOC);

  $result->closeCursor();

  // Get all id from bottles
  foreach ($idBottles as $value) {
    array_push($listIdBottles, $value['id']);
  }

  // Rand 3 keys
  $threeKeys = array_rand($listIdBottles, 3);

  // Get x3 id
  foreach ($threeKeys as $value) {
    array_push($threeId, $listIdBottles[$value]);
  }

  return $threeId;
}


//////////// Home Page /////////////////////////////////
function index()
{
  $threeId = randThree();

  $result1 = getBottle($threeId[0]);
  $bottle1 = $result1->fetch(PDO::FETCH_ASSOC);

  $result2 = getBottle($threeId[1]);
  $bottle2 = $result2->fetch(PDO::FETCH_ASSOC);

  $result3 = getBottle($threeId[2]);
  $bottle3 = $result3->fetch(PDO::FETCH_ASSOC);


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

  // require 'view/manageCave.php';
  header('location: index.php?action=manageCave');
}


//////////////////////// SET BOTTLE /////////////////////////

// Set bottle
function setBottle($arrayBottle, $picture = "")
{

  updateBottle($arrayBottle, $picture);
  unset($_GET['set']);
  listBottles("manageCave");
}


////////////////////////  DELETE /////////////////////////////////

//DELETE

function removeBottle($id)
{
  $rowsDeleted = deleteBottle($id);


  if ($rowsDeleted > 0) {
    listBottles("manageCave");
  } else {
    array_push($msgError, 'Une erreur c\'est produite lors de la demande d\'effacement de la bouteille.');
  }
}
