<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
        require_once "./includeSource.php";
        require_once "../Model/inc.all.php";
        require_once "./depetePopup.html";

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
    <section class="row">
        <?php
            foreach ($allPost as $post){
                echo '<section id="' . $post->GetId() . '" class="col-lg-12 col-md-12 col-sm-12 text-center postContent"><fieldset class="fieldsetContent col-lg-6 col-md-6 col-sm-12">';
                echo '<legend class="legendContent">Posté le ' . $post->GetDate() . '</legend>';

                $active = false;
                $media = $post->GetArrayMedias();
                $id = "carousel" . $post->GetId();

                echo '<section id="' . $id . '" class="carousel slide" data-ride="carousel" data-interval="false">';

                echo '<section class="carousel-inner" role="listbox">';
                for ($i = 0; $i < count($media); $i++){

                    $type = $media[$i]->GetFileType();

                    if (!$active) {
                        echo '<section class="carousel-item active">';
                        $active = !$active;
                    } else {
                        echo '<section class="carousel-item">';
                    }

                    if (in_array($type, $video_extension)){
                        echo '<video class="postMedia embed-responsive embed-responsive-16by9" autoplay controls loop><source src="../Source/post/' . $media[$i]->GetFileName() . '" type="' . $type . '"></video>';
                    }
                    else if(in_array($type, $audio_extension)){
                        echo '<audio class="" controls><source src="../Source/post/' . $media[$i]->GetFileName() . '" type="' . $type . '"></audio>';
                    }
                    else {
                        echo '<figure class="figure">';
                        echo '<img class="figure-img img-fluid rounded postMedia" src="../Source/post/' . $media[$i]->GetFileName() . '" alt="" type="' . $type . '">';
                        echo '</figure>';
                    }

                    echo '</section>';
                }
                echo '</section>';

                if (count($media) > 1) { // On affiche pas les flêches si il y a qu'un seul media
                    echo '<a class="carousel-control-prev" href="#' . $id . '" role="button" data-slide="prev">';
                    echo '<i class="fas fa-arrow-alt-circle-left slideArrow"></i>';
                    echo '</a>';

                    echo '<a class="carousel-control-next" href="#' . $id . '" role="button" data-slide="next">';
                    echo '<i class="fas fa-arrow-alt-circle-right slideArrow"></i>';
                    echo '</a>';
                }

                echo '</section>';

                echo '<figcaption class="figure-caption">' . $post->GetComment() .'</figcaption>';
                echo '<a href="" id="' . $post->GetId() . '" class="btn btn-danger deleteLink" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i></a>';
                echo '</fieldset></section>';
        }
        ?>
    </section>
</article>

</body>
<script>
    $(document).ready(function(){

        function redirectionIndex(params)
        {
            //window.location.href = "index.php";
            var htmlpost =  $(".postContent[id='" + params + "']");
            $(htmlpost).remove();
            //displayMessage(false, "Le post a bien été supprimé");
        }

        /** Delete post **/
        $(".deleteLink").click(function()
        {
            $("#deleteModal").modal("toggle");
            var idPost = $(this).attr("id");

            $("#btnDeleteModal").click(function()
            {
                ELibrary.get_data("../Controller/delete_post.php", redirectionIndex, {'idPost' : idPost});
            });
        });

    });
</script>
</html>