<?php
session_start();

require 'controller/controller.php';
require 'view/traitment/uploadFile.php';
// require 'view/errorView.php';


$msgError = [];
$errorConnect = [];
$pathFolderImg = "public/uploads/";


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

    //////////////// Display a selection bottle ///////
  } elseif (($_GET['action'] == 'bottle') && (isset($_GET['set']))) {

    if (is_numeric($_GET['set'])) {

      oneBottle($_GET['set']);
    } else {
      array_push($msgError, 'Un problème est survenu lors de l\'exécution du caroussel.');
    }


    ////////////// List and manage Bottles ////////////
  } elseif (($_GET['action'] == "manageCave") && ($_SESSION['admin'] == 1)) {


    if (isset($_GET['set']) && !isset($_POST['btn-update-bottle']) && !isset($_GET['order']) && !isset($_POST['btn-delete-bottle'])) {

      // Display list bottles AND form for settings
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


      ////// UPDATE settings bottle
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

      // Check PICTURE
      if (isset($_FILES['picture'])) {
        $checkFile = uploadFile($_FILES['picture']);

        if (is_string($checkFile)) {
          $picture = $checkFile;
        } elseif (is_array($checkFile)) {
          foreach ($checkFile as $msg) {
            array_push($msgError, $msg);
          }
        }
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
      if (count($newSettings) == 7 && !isset($picture)) {

        setBottle($newSettings);
      } elseif (count($newSettings) == 7 && isset($picture)) {
        move_uploaded_file($_FILES['picture']['tmp_name'], "public/uploads/" . $picture);

        setBottle($newSettings, $picture);
      } else {
        array_push($msgError, 'Le nombre de champs à renseigner ne correspond pas.');
      }

      // DELETE a Bottle
    } elseif (isset($_GET['set']) && isset($_GET['picture']) && isset($_POST['btn-delete-bottle'])) {

      // Check ID
      if (is_numeric($_GET['set'])) {
        $id['id'] = $_GET['set'];
      } else {
        array_push($msgError, 'L\'identifiant de la bouteille à modifier ne correspond pas.');
      }


      // Check picture name
      if (isset($id['id']) && file_exists($pathFolderImg . $_GET['picture'])) {
        unlink($pathFolderImg . $_GET['picture']);
        removeBottle($id);
      } else {
        array_push($msgError, 'Le nom du fichier image n\'existe pas.');
      }


      // Display list bottles and manage links
    } else {
      listBottles($_GET['action']);
    }




    ///// CREATE a new bottle
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
      $checkFile = uploadFile($_FILES['picture']);
      if ($checkFile) {
        $newSettings['picture'] = $checkFile;
      }

      // List infos to Create into an array
      if (count($newSettings) == 7) {
        move_uploaded_file($_FILES['picture']['tmp_name'], $pathFolderImg . $newSettings['picture']);
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
