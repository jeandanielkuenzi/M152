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
<header>
<?php require_once "./navBar.php" ?>
</header>
<article class="main col-lg-12 container">

    <!-- Introduction Row -->
    <h1 class="my-4">Bienvenue !</h1>
    <img class="img-fluid" src="../Source/img/profil1.jpg">

    <!-- Team Members Row -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="my-4">Post</h2>
        </div>
        <?php
            foreach ($allPost as $post){
                echo '<section id="' . $post->GetId() . '" class="col-lg-4 col-sm-6 text-center mb-4 postContent">';
                echo '<figure class=""><img class="rounded-circle img-fluid d-block mx-auto postPicture" src="../Source/post/' . $post->GetFileName() . '">';
                echo '<figcaption>' . $post->GetComment() . ', posté le ' . $post->GetDate() . '</figcaption>';
                echo '</figure></section>';
        }
        ?>
    </div>
</article>
</body>
</html>