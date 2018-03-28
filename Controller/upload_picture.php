<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 24.01.2018
 * Time: 15:11
 */

require_once '../Model/inc.all.php';

$flagError = false;
$extensions_autorisees = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
$error = array();

$commentPicture = "";
$file = array();
$date = "";

if (isset($_POST['commentPicture'])) {
    $commentPicture = trim(filter_input(INPUT_POST, 'commentPicture', FILTER_SANITIZE_STRING));
} else {
    $flagError = true;
}

if (isset($_FILES['picture'])) {
        $file = $_FILES['picture'];
} else {
    $flagError = true;
}

if ($commentPicture == "") {
    $flagError = true;
    $error['CommentPicture'] = "Veuillez entrer un commentaire valide !";
}

echo count($file);

for($i=0; $i < count($file['name']); $i++) {
    if ($file['name'][$i] == "") {
        $flagError = true;
        $error['FilePicture'] = "Veuillez sélectionner une image !";
    } else if (!(in_array($file['type'][$i], $extensions_autorisees))){
        $flagError = true;
        $error['FilePicture'] = "Veuillez sélectionner QUE des images !";
    }
}

if (!$flagError) {
    try{
        PostManager::GetInstance()->UploadPost($commentPicture, $file);
        header('location: ./index.php');
    } catch (PDOException $e) {
        echo "PostManager:UploadPost Error: " . $e->getMessage();
    }
}