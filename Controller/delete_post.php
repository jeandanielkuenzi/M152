<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 28.03.2018
 * Time: 13:23
 */

require_once '../Model/inc.all.php';

$idPost;
$response = false;

if (isset($_POST['idPost'])){
    $idPost = $_POST['idPost'];
}

if ($idPost != null){
    $post = PostManager::GetInstance()->GetPostById($idPost);

    if ($post != null){
        $response = PostManager::GetInstance()->DeletePostByID($post->GetId());
    }
}
echo $response;