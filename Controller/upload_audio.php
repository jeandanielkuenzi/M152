<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 14.03.2018
 * Time: 12:52
 */

require_once '../Model/inc.all.php';

$flagError = false;
$extensions_autorisees = array('audio/mp3', 'audio/wav', 'audio/m4a', 'audio/wma');
$error = array();

$commentAudio = "";
$file = array();
$date = "";

if (isset($_POST['commentAudio'])) {
    $commentAudio = trim(filter_input(INPUT_POST, 'commentAudio', FILTER_SANITIZE_STRING));
} else {
    $flagError = true;
}

if (isset($_FILES['audio'])) {
    $file = $_FILES['audio'];
} else {
    $flagError = true;
}

if ($commentAudio == "") {
    $flagError = true;
    $error['CommentAudio'] = "Veuillez entrer un commentaire valide !";
}

for($i=0; $i < count($file['name']); $i++) {
    if ($file['name'][$i] == "") {
        $flagError = true;
        $error['FileAudio'] = "Veuillez sélectionner un audio !";
    } else if (!(in_array($file['type'][$i], $extensions_autorisees))){
        $flagError = true;
        $error['FileAudio'] = "Veuillez sélectionner QUE des audios !";
    }
}

if (!$flagError) {
    try{
        PostManager::GetInstance()->UploadPost($commentAudio, $file);
        header('location: ./index.php');
    } catch (PDOException $e) {
        echo "PostManager:UploadPost Error: " . $e->getMessage();
    }
}