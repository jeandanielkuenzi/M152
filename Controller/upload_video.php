<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 24.01.2018
 * Time: 15:11
 */

require_once '../Model/inc.all.php';

$flagError = false;
$extensions_autorisees = array('video/mp4', 'video/m4v', 'video/mov', 'video/avi', 'video/flv', 'video/mpg', 'video/wmv');
$error = array();

$commentVideo = "";
$file = array();

if (isset($_POST['commentVideo'])) {
    $commentVideo = trim(filter_input(INPUT_POST, 'commentVideo', FILTER_SANITIZE_STRING));
} else {
    $flagError = true;
}

if (isset($_FILES['video'])) {
    $file = $_FILES['video'];
} else {
    $flagError = true;
}

if ($commentVideo == "") {
    $flagError = true;
    $error['CommentVideo'] = "Veuillez entrer un commentaire valide !";
}

for($i=0; $i < count($file['name']); $i++) {
    if ($file['name'][$i] == "") {
        $flagError = true;
        $error['FileVideo'] = "Veuillez sélectionner une vidéo !";
    } else if (!(in_array($file['type'][$i], $extensions_autorisees))){
        $flagError = true;
        $error['FileVideo'] = "Veuillez sélectionner QUE des vidéos !";
    }
}

if (!$flagError) {
    try{
        PostManager::GetInstance()->UploadPost($commentVideo, $file);
        header('location: ./index.php');
    } catch (PDOException $e) {
        echo "PostManager:UploadPost Error: " . $e->getMessage();
    }
}