<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
        require_once "./includeSource.php";
        require_once "../Model/inc.all.php";

        $allPost = PostManager::GetInstance()->LoadAllPosts();

        $audio_extension = array('audio/mp3', 'audio/wav', 'audio/m4a', 'audio/wma');
        $video_extension = array('video/mp4', 'video/m4v', 'video/mov', 'video/avi', 'video/flv', 'video/mpg', 'video/wmv');
    ?>
</head>
<body>
<header>
<?php require_once "./navBar.php" ?>
</header>
<!-- Introduction Row -->
<section class="userDisplay col-lg-2 col-md-2 col-sm-12">
    <h1 class="col-lg-12">Bienvenue !</h1>
    <img class="rounded-circle img-fluid" src="../Source/img/profil1.jpg">
</section>

<article class="main col-lg-10 col-md-10 col-sm-12 container">
    <!-- Team Members Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="col-lg-12">Post</h2>
        </div>
        <?php
            foreach ($allPost as $post){
                echo '<section id="' . $post->GetId() . '" class="col-lg-12 col-sm-12 col-md-12 text-center postContent"><fieldset class="fieldsetContent">';
                echo '<legend class="legendContent">Posté le ' . $post->GetDate() . '</legend>';
                $media = $post->GetArrayMedias();

                for ($i = 0; $i < count($media); $i++){

                    $type = $media[$i]->GetFileType();

                    if (in_array($type, $video_extension)){
                        echo '<video width="320" height="240" autoplay controls loop><source src="../Source/post/' . $media[$i]->GetFileName() . '" type="' . $type . '"></video>';
                    }
                    else if(in_array($type, $audio_extension)){
                        echo '<audio width="320" height="240" controls><source src="../Source/post/' . $media[$i]->GetFileName() . '" type="' . $type . '"></audio>';
                    }
                    else {
                        echo '<img class="rounded-circle img-fluid mx-auto postPicture" src="../Source/post/' . $media[$i]->GetFileName() . '">';
                    }

                }
                echo '<span class="spanPost">' . $post->GetComment() .'</span>';
                echo '<a href=""><i class="fas fa-trash-alt"></i></a>';
                echo '</<fieldset></section>';
        }
        ?>
    </div>
</article>
</body>
</html>