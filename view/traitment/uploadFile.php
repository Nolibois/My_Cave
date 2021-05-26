<?php

function uploadFile($file)
{
  $msgError = [];
  $fileError = false;
  $fileSize = false;
  $extChecked = "";
  $folderExist = "";
  $newNamePicture = "";


  if (isset($file) && !empty($file) && ($file['error'] != 4)) {

    // Check Errors
    switch ($file['error']) {
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
    if ($file['size'] <= 1000000) {
      $fileSize = true;
    } else {
      array_push($msgError, 'Votre image doit faire moins de 1Mo.');
    }

    // Check extension
    $infosFile = pathinfo($file['name']);
    $extension = $infosFile['extension'];
    $extAllowed = ["jpg", "jpeg", "png"];
    if (in_array($extension, $extAllowed)) {
      $extChecked = true;
    } else {
      $extChecked = false;
      array_push($msgError, 'Erreur: Le type d\'image accepté est JPG, JPEG, et PNG.');
    }

    // Check exist destination folder
    $pathFolderImg = "public/uploads/";
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
      $newNamePicture = $hashName . "." . $extension;
    } else {
      array_push($msgError, 'Tous les éléments n\'ont pas passé la vérification. Rechargez le fichier ou essayez-en un autre.');
    }
  } else {
    array_push($msgError, 'Le fichier image est manquant, cliquez sur "Choisir un fichier".');
  }

  if (!empty($msgError)) {
    return $msgError;
  } else {
    return $newNamePicture;
  }
}
