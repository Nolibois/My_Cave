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

    if (isset($_GET['set']) && !isset($_POST['btn-update-bottle'])) {

      // Display list bottles and form for settings
      if (is_numeric($_GET['set'])) {
        listBottles($_GET['action']);
      } else {
        array_push($msgError, 'L\'identifiant de la bouteille à modifier ne correspond pas.');

        msgerrors($msgError);
?>
        <a href="index.php?action=manageCave">Retour à Gestion de ma cave</a>
  <?php

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
            if (isset($_POST['year']) && !empty($_POST['year'])) {
              if (is_numeric($_POST['year']) && ($_POST['year'] > 1901) && ($_POST['year'] <= date("Y"))) {
                $year = htmlspecialchars(strip_tags($_POST['year']));

                // Check grapes and secure data(s)
                if (isset($_POST['id_label_multiple'])) {
                  $grapes = "";
                  foreach ($_POST['id_label_multiple'] as $value) {
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
                  array_push($msgError, 'Choisissez un cépage au minimum');
                }
              } else {
                array_push($msgError, 'L\'année doit être comprise entre 1901 et l\'année en cours.');
              }
            } else {
              array_push($msgError, 'Il manque l\'année.');
            }
          } else {
            array_push($msgError, 'Le nom doit comporter entre 5 et 50 caractères.');
          }
        } else {
          array_push($msgError, 'N\'oubliez pas de renseigner le nom de votre vin !');
        }
      } else {
        array_push($msgError, 'L\identifiant de la bouteille ne correspond pas. Sélectionner un autre vin.');
      }

      // Display list bottles and manage links
    } else {
      listBottles($_GET['action']);
    }
  }
} elseif (!empty($msgError)) {

  msgerrors($msgError);

  ?>
  <a href="index.php?action=formconnect">Retour au formulaire de connexion</a>
<?php
} else {
  index();
}

var_dump($msgError);
