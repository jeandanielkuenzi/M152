<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <?php
        require_once "./includeSource.php";
        require_once "../Model/inc.all.php";

        $allPost = PostManager::GetInstance()->LoadAllPost();
    ?>
</head>
<body>
<header class="container">
<?php require_once "./navBar.php" ?>
</header>
<article class="main col-lg-12 container">
    <h1>Bienvenue !</h1>
    <img src="../Source/img/profil1.jpg">
        <?php
            foreach ($allPost as $post){
                echo '<section id="' . $post->GetId() . '" class="postContent">';
                echo '<img class="postPicture" src="../Source/post/' . $post->GetFileName() . '">';
                echo '<p>' . $post->GetComment() . '</p>';
                echo '</section>';
        }
        ?>
</article>
</body>
</html>