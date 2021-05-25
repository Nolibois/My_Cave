<?php
session_start();
require 'controller/controller.php';
// require 'view/errorView.php';


$msgError = [];
$errorConnect = [];


/////////////////////// ACTIONS ///////////////////////////////////
if (isset($_GET['action'])) {

  /////////////// Go to page Connection //////////////
  if ($_GET['action'] == 'formConnect') {
    if (!isset($_POST['btn-connect'])) {
      formConnect();

      ////////////// Check connection User //////////////
    } else {

      if (empty($_POST['email']) || empty($_POST['pass'])) {

        array_push($msgError, 'Vous devez renseigner votre email et votre mot de passe pour vous connecter.');
      } else {

        // Check Email
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {

          array_push($msgError, "Votre email doit correspondre à l'exemple suivant: chateau@pinot.com");
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

            index();
          } else {
            array_push($msgError, "Votre email ou mot de passe n'est pas valide.");
          }
        }
      }
    }


    /////////////// Ask for Disconnection ///////////////
  } elseif ($_GET['action'] == 'disconnect') {
    disconnectUser();

    ///////////////// List bottles //////////////////////
  } elseif ($_GET['action'] == 'bottles') {
    listBottles($_GET['action']);

    ////////////// List and manage Bottles ////////////
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


      // UPDATE settings bottle
    } elseif (isset($_GET['set']) && isset($_POST['btn-update-bottle'])) {

      // Init an array to get infos
      $newSettings = [];

      // Get ID
      if (!empty($_GET['set']) && is_numeric($_GET['set'])) {
        $id = (int)htmlspecialchars(strip_tags($_GET['set']));
        $newSettings['id'] = $id;
      } else {
        array_push($msgError, 'L\identifiant de la bouteille ne correspond pas. Sélectionner un autre vin.');
      }

      // Check NAME length and secure data
      if (isset($_POST['name']) && !empty($_POST['name'])) {
        if (strlen($_POST['name']) >= 5 && strlen($_POST['name']) <= 50) {
          $name = htmlspecialchars(strip_tags($_POST['name']));
          $newSettings['name'] = $name;
        } else {
          array_push($msgError, 'Le nom doit comporter entre 5 et 50 caractères.');
        }
      } else {
        array_push($msgError, 'N\'oubliez pas de renseigner le nom de votre vin !');
      }

      // Check YEAR length and secure data
      if (isset($_POST['yearUpdate']) && !empty($_POST['yearUpdate'][0])) {
        if (is_numeric($_POST['yearUpdate'][0]) && ($_POST['yearUpdate'][0] >= 1900) && ($_POST['yearUpdate'][0] <= date("Y"))) {
          $year = htmlspecialchars(strip_tags($_POST['yearUpdate'][0]));

          $newSettings['year'] = $year;
        } else {
          array_push($msgError, 'L\'année doit être comprise entre 1901 et l\'année en cours.');
        }
      } else {
        array_push($msgError, 'Il manque l\'année.');
      }

      // Check GRAPES and secure data(s)
      if (isset($_POST['id_grapesUpdate_multiple'])) {
        $grapes = "";
        foreach ($_POST['id_grapesUpdate_multiple'] as $value) {
          $grapes .= htmlspecialchars(strip_tags($value)) . " / ";
        }

        $newSettings['grapes'] = $grapes;
      } else {
        array_push($msgError, 'Choisissez un cépage au minimum');
      }

      // Check COUNTRY and secure data
      if (isset($_POST['country']) && !empty($_POST['country'])) {
        if (strlen($_POST['country']) >= 5 && strlen($_POST['country']) <= 50) {
          $country = htmlspecialchars(strip_tags($_POST['country']));

          $newSettings['country'] = $country;
        } else {
          array_push($msgError, 'Le pays doit comporter entre 5 et 50 caractères.');
        }
      } else {
        array_push($msgError, 'Veuillez remplir le pays d\'origine de la bouteille.');
      }

      // Check REGION and secure data
      if (isset($_POST['region']) && !empty($_POST['region'])) {
        if (strlen($_POST['region']) >= 5 && strlen($_POST['region']) <= 50) {
          $region = htmlspecialchars(strip_tags($_POST['region']));

          $newSettings['region'] = $region;
        } else {
          array_push($msgError, 'La région doit comporter entre 5 et 50 caractères.');
        }
      } else {
        array_push($msgError, 'Veuillez remplir le région de production du vin.');
      }


      // Check MESSAGE and secure data
      if (isset($_POST['description']) && !empty($_POST['description'])) {
        $description = nl2br(htmlspecialchars(strip_tags($_POST['description'])));

        $newSettings['description'] = $description;
      } else {
        array_push($msgError, 'Veuillez écrire une description de votre vin.');
      }

      // List infos to Update into an array
      if (count($newSettings) == 7) {

        setBottle($newSettings);
      } else {
        array_push($msgError, 'Le nombre de champs à renseigner ne correspond pas.');
      }


      // Display list bottles and manage links
    } else {
      listBottles($_GET['action']);
    }

    // CREATE a new bottle
  } elseif ((isset($_GET['action']) == 'create') && (($_SESSION['admin']) == 1)) {
    if (isset($_POST['btn-create'])) {

      // Init an array to get infos
      $newSettings = [];

      // Check name
      if (isset($_POST['name']) && !empty($_POST['name'])) {
        if (strlen($_POST['name']) >= 5 && strlen($_POST['name']) <= 50) {
          $name = htmlspecialchars(strip_tags($_POST['name']));
          $newSettings['name'] = $name;
        } else {
          array_push($msgError, 'Le nom doit comporter entre 5 et 50 caractères.');
        }
      } else {
        array_push($msgError, 'N\'oubliez pas de renseigner le nom de votre vin !');
      }


      // Check year
      if (isset($_POST['year']) && !empty($_POST['year'][0])) {
        if (is_numeric($_POST['year'][0]) && ($_POST['year'][0] >= 1900) && ($_POST['year'][0] <= date("Y"))) {
          $year = htmlspecialchars(strip_tags($_POST['year'][0]));

          $newSettings['year'] = $year;
        } else {
          array_push($msgError, 'L\'année doit être comprise entre 1901 et l\'année en cours.');
        }
      } else {
        array_push($msgError, 'Il manque l\'année.');
      }

      // Check grapes
      if (isset($_POST['id_grapes_multiple'])) {
        $grapes = "";
        foreach ($_POST['id_grapes_multiple'] as $value) {
          $grapes .= htmlspecialchars(strip_tags($value)) . " / ";
        }

        $newSettings['grapes'] = $grapes;
      } else {
        array_push($msgError, 'Choisissez un cépage au minimum');
      }

      // Check country
      if (isset($_POST['country']) && !empty($_POST['country'])) {
        if (strlen($_POST['country']) >= 5 && strlen($_POST['country']) <= 50) {
          $country = htmlspecialchars(strip_tags($_POST['country']));

          $newSettings['country'] = $country;
        } else {
          array_push($msgError, 'Le pays doit comporter entre 5 et 50 caractères.');
        }
      } else {
        array_push($msgError, 'Veuillez remplir le pays d\'origine de la bouteille.');
      }

      // Check region
      if (isset($_POST['region']) && !empty($_POST['region'])) {
        if (strlen($_POST['region']) >= 5 && strlen($_POST['region']) <= 50) {
          $region = htmlspecialchars(strip_tags($_POST['region']));

          $newSettings['region'] = $region;
        } else {
          array_push($msgError, 'La région doit comporter entre 5 et 50 caractères.');
        }
      } else {
        array_push($msgError, 'Veuillez remplir le région de production du vin.');
      }

      // Check description
      if (isset($_POST['description']) && !empty($_POST['description'])) {
        $description = nl2br(htmlspecialchars(strip_tags($_POST['description'])));

        $newSettings['description'] = $description;
      } else {
        array_push($msgError, 'Veuillez écrire une description de votre vin.');
      }


      // Check picture
      if (isset($_FILES['picture']) && !empty($_FILES['picture']) && ($_FILES['picture']['error'] != 4)) {

        // Check Errors
        switch ($_FILES['picture']['error']) {
          case '0':
            $fileError = true;
            break;

          case '3':
            array_push($msgError, 'Le fichier image a été téléchargé SEULEMENT en partie. Il risuqe de ne pas s\'afficher correctement.');
            break;

          case '7':
            array_push($msgError, 'Problème à l\'enregistrment sur le serveur. Réessayé ou recommencer ultérieurement. Veuillez nous excuser pour ce désagrément.');
            break;

          default:

            break;
        }

        // Check size
        if ($_FILES['picture']['size'] <= 1000000) {
          $fileSize = true;
        } else {
          array_push($msgError, 'Votre image doit faire moins de 1Mo.');
        }

        // Check extension
        $extChecked = "";
        $infosFile = pathinfo($_FILES['picture']['name']);
        $extension = $infosFile['extension'];
        $extAllowed = ["jpg", "jpeg", "png"];
        if (in_array($extension, $extAllowed)) {
          $extChecked = true;
        } else {
          $extChecked = false;
          array_push($msgError, 'Erreur: Le type d\'image accepté est JPG, JPEG, et PNG.');
        }

        // Check exist destination folder
        $folderExist = "";
        $pathFolderImg = "public/img/";
        if (is_dir($pathFolderImg)) {
          $folderExist = true;
        } else {
          mkdir($pathFolderImg, 0733, true);
          $folderExist = true;

          if (!mkdir($pathFolderImg, 0733, true)) {
            $folderExist = false;
            array_push($msgError, 'Erreur: Le dossier de destination ne peut pas être créé. Contactez l\'administrateur.');
          }
        }

        // Hash file name before to save
        $nameFile = strstr($infosFile['basename'], "." . $extension, true);
        $hashName = sha1($nameFile);

        // Upload
        if ($fileError && $fileSize && $extChecked && $folderExist) {
          $newSettings['picture'] = $hashName . "." . $extension;
        } else {
          array_push($msgError, 'Tous les éléments n\'ont pas passé la vérification. Rechargez le fichier ou essayez-en un autre.');
        }
      } else {
        array_push($msgError, 'Le fichier image est manquant, cliquez sur "Choisir un fichier".');
      }


      // List infos to Create into an array
      if (count($newSettings) == 7) {
        move_uploaded_file($_FILES['picture']['tmp_name'], $pathFolderImg . $hashName . "." . $extension);
        addBottle($newSettings);
      } else {
        array_push($msgError, 'Le nombre de champs à renseigner ne correspond pas.');
      }
    }
  }
} else {
  index();
}

// Errors Messages
if (!empty($msgError)) {
  displayError($msgError);
}
