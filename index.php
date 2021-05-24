<?php
session_start();
require 'controller/controller.php';

$msgError = [];
$errorConnect = [];

try {



  //////////////////// Check connection User //////////////////
  if (isset($_POST['btn-connect'])) {
    if (empty($_POST['email']) || empty($_POST['pass'])) {

      array_push($msgError, 'Vous devez renseigner votre email et votre mot de passe pour vous connecter.');
    } else {

      // Check Email
      if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {

        $errorConnect = "Votre email doit correspondre à l'exemple suivant: chateau@pinot.com";
      } else {

        // Get infos User
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
          $errorConnect = "Votre email ou mot de passe n'est pas valide.";
        }
      }
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
    } elseif (($_GET['action'] == "manageCave") && ($_SESSION['admin'] == 1)) {

      if (isset($_GET['set']) && !isset($_POST['btn-update-bottle']) && !isset($_GET['order'])) {

        // Display list bottles and form for settings
        if (is_numeric($_GET['set'])) {
          listBottles($_GET['action']);
        } else {
          array_push($msgError, 'L\'identifiant de la bouteille à modifier ne correspond pas.');

?>
          <a href="index.php?action=manageCave">Retour à Gestion de ma cave</a>
<?php

        }
      } elseif (isset($_GET['order']) && !isset($_GET['set'])) {

        // Sort list bottles
        if (!empty($_GET['order']) && !empty($_GET['column'])) {

          $column = htmlspecialchars(strip_tags($_GET['column']));

          // If Order is increasing ASC
          if ($_GET['order'] === 'ASC') {
            listBottles('manageCave', 'ASC', $column);

            // If order is descending DESC
          } elseif ($_GET['order'] === 'DESC') {
            listBottles('manageCave', 'DESC', $column);
          } elseif ($_GET['order'] === 'no') {
            listBottles('manageCave');
          }
        } else {
          array_push($msgError, 'Une erreur est survenue lors du trie.');
        }


        // Send to UPDATE settings bottle
      } elseif (isset($_GET['set']) && isset($_POST['btn-update-bottle'])) {
        if (!empty($_GET['set']) && is_numeric($_GET['set'])) {
          $id = (int)htmlspecialchars(strip_tags($_GET['set']));

          // Check name length and secure data
          if (isset($_POST['name']) && !empty($_POST['name'])) {
            if (strlen($_POST['name']) >= 5 && strlen($_POST['name']) <= 50) {
              $name = htmlspecialchars(strip_tags($_POST['name']));

              // Check year length and secure data
              if (isset($_POST['yearUpdate']) && !empty($_POST['yearUpdate'][0])) {
                if (is_numeric($_POST['yearUpdate'][0]) && ($_POST['yearUpdate'][0] >= 1900) && ($_POST['yearUpdate'][0] <= date("Y"))) {
                  $year = htmlspecialchars(strip_tags($_POST['yearUpdate'][0]));

                  // Check grapes and secure data(s)
                  if (isset($_POST['id_grapesUpdate_multiple'])) {
                    $grapes = "";
                    foreach ($_POST['id_grapesUpdate_multiple'] as $value) {
                      $grapes .= htmlspecialchars(strip_tags($value)) . " / ";
                    }

                    // Check country and secure data
                    if (isset($_POST['country']) && !empty($_POST['country'])) {
                      if (strlen($_POST['country']) >= 5 && strlen($_POST['country']) <= 50) {
                        $country = htmlspecialchars(strip_tags($_POST['country']));

                        // Check region and secure data
                        if (isset($_POST['region']) && !empty($_POST['region'])) {
                          if (strlen($_POST['region']) >= 5 && strlen($_POST['region']) <= 50) {
                            $region = htmlspecialchars(strip_tags($_POST['region']));

                            // Check message and secure data
                            if (isset($_POST['description']) && !empty($_POST['description'])) {
                              $description = nl2br(htmlspecialchars(strip_tags($_POST['description'])));
                              $newSettings = [
                                "id" => $id,
                                "name" => $name,
                                "year" => $year,
                                "grapes" => $grapes,
                                "country" => $country,
                                "region" => $region,
                                "description" => $description
                              ];

                              setBottle($newSettings);
                            } else {
                              array_push($msgError, 'Veuillez écrire une description de votre vin.');
                            }
                          } else {
                            array_push($msgError, 'La région doit comporter entre 5 et 50 caractères.');
                          }
                        } else {
                          array_push($msgError, 'Veuillez remplir le région de production du vin.');
                        }
                      } else {
                        array_push($msgError, 'Le pays doit comporter entre 5 et 50 caractères.');
                      }
                    } else {
                      array_push($msgError, 'Veuillez remplir le pays d\'origine de la bouteille.');
                    }
                  } else {
                    throw new Exception('Choisissez un cépage au minimum');
                  }
                } else {
                  throw new Exception('L\'année doit être comprise entre 1901 et l\'année en cours.');
                }
              } else {
                throw new Exception('Il manque l\'année.');
              }
            } else {
              throw new Exception('Le nom doit comporter entre 5 et 50 caractères.');
            }
          } else {
            throw new Exception('N\'oubliez pas de renseigner le nom de votre vin !');
            // array_push($msgError, 'N\'oubliez pas de renseigner le nom de votre vin !');
          }
        } else {
          array_push($msgError, 'L\identifiant de la bouteille ne correspond pas. Sélectionner un autre vin.');
        }

        // Display list bottles and manage links
      } else {
        listBottles($_GET['action']);
      }
    }
  } else {
    index();
  }
} catch (Exception $th) {
  $msgError = $th->getMessage();
  require 'view/errorView.php';
}

/* elseif (!empty($msgError)) {

  foreach ($msgError as $value) {
    ?>
    <p>
      <?= $value; ?>
    </p>
  <?php
    // echo json_encode($msgError);
  }

  ?>
  <a href="index.php?action=formconnect">Retour au formulaire de connexion</a>
<?php
} */