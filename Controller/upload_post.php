<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 24.01.2018
 * Time: 15:11
 */

require_once '../Model/AppManager.php';

$flagError = true;

$comment = "";
$file = "";
$date = "";

if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
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
    $errorComment = true;
}

if ($file == "") {
    $flagError = true;
    $errorComment = true;
}

if (!$flagError) {
    $date = date('d-m-y');

    AppManager::GetInstance()->UploadPost($comment, $file['name'], $file['type'], $date);
    move_uploaded_file($file['tmp_name'], '../Source/post/' . $file['name']);
    header('location: ./index.php');
} else {
    echo 'erreur';
}