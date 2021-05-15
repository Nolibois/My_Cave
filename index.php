<?php
session_start();
require 'controller/controller.php';

$msgError = [];

//////////////////// Check connection User //////////////////
if (isset($_POST['btn-connect'])) {
  if (!empty($_POST['email']) && !empty($_POST['pass'])) {

    // Check Email
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

      $result = connectUser($_POST['email']);
      $infosUser = $result->fetch(PDO::FETCH_ASSOC);

      // Check password
      if (password_verify($_POST['pass'], $infosUser['password'])) {

        $_SESSION['id'] = $infosUser['id'];
        $_SESSION['firstname'] = $infosUser['first_name'];
        $_SESSION['lastname'] = $infosUser['last_name'];
        $_SESSION['email'] = $infosUser['email'];
        $_SESSION['admin'] = $infosUser['admin'];

        $result->closeCursor();
      } else {
        array_push($msgError, 'Vos email ou mot de passe ne sont pas valide.');
      }
    } else {
      array_push($msgError, 'Votre email doit correspondre à l\'exemple suivant: chateau@pinot.com');
    }
  } else {
    array_push($msgError, 'Vous devez renseigner votre email et votre mot de passe pour vous connecter.');
  }
}


/////////////////////// ACTIONS ///////////////////////////////////
if (isset($_GET['action'])) {

  // Ask to go page Connection
  if ($_GET['action'] == 'formconnect') {
    formConnect();

    // Ask for Disconnection
  } elseif ($_GET['action'] == 'disconnect') {
    disconnectUser();

    // List bottles
  } elseif ($_GET['action'] == 'bottles') {
    listBottles($_GET['action']);

    // List and manage Bottles
  } elseif (($_GET['action'] == "manageCave") && $_SESSION['admin'] == 1) {
    listBottles($_GET['action']);
  }
} elseif (!empty($msgError)) {
  foreach ($msgError as $value) {
?>
    <p>
      <?= $value; ?>
    </p>
  <?php
  }
  ?>
  <a href="index.php?action=formconnect">Retour au formulaire de connexion</a>
<?php
} else {
  index();
}
