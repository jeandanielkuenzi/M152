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
    $date = date('y-m-d');

    PostManager::GetInstance()->UploadPost($comment, $file['type'], $file['name'], $date);
    for($i=0; $i < count($file['name']); $i++) {
        move_uploaded_file($file['tmp_name'], '../Source/post/' . $file['name']);
    }
    header('location: ./index.php');
}