<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 24.01.2018
 * Time: 15:11
 */

require_once '../Model/inc.all.php';

$flagError = false;

$error = array();

$comment = "";
$file = array();
$date = "";

if (isset($_POST['comment'])) {
    $comment = trim(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING));
} else {
    $flagError = true;
}

if (isset($_FILES['picture'])) {
        $file = $_FILES['picture'];
} else {
    $flagError = true;
}

if ($comment == "") {
    $flagError = true;
    $error['Comment'] = "Veuillez entrer un commentaire valide !";
}

for($i=0; $i < count($file['name']); $i++) {
    if ($file['name'][$i] == "") {
        $flagError = true;
        $error['File'] = "Veuillez sélectionner une image !";
    }
}

if (!$flagError) {

    PostManager::GetInstance()->UploadPost($comment, $file['name']);
    $idPost = AppManager::GetInstance()->GetLastInsertId(); // Renvoi l'id du dernier post
    for($i=0; $i < count($file['name']); $i++) {
        MediaManager::GetInstance()->UploadMedia($file['type'][$i], $file['name'][$i], $idPost);
        move_uploaded_file($file['tmp_name'][$i], '../Source/post/' . $file['name'][$i]);
    }
    header('location: ./index.php');
}