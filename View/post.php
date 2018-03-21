<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post</title>
    <?php
        require_once './includeSource.php';
        if (isset($_POST['submitPicture'])) {
            require_once '../Controller/upload_picture.php';
        }
        if (isset($_POST['submitVideo'])) {
            require_once '../Controller/upload_video.php';
        }
        if (isset($_POST['submitAudio'])) {
            require_once '../Controller/upload_audio.php';
        }
    ?>
</head>
<body>
<header>
<?php require_once "./navBar.php" ?>
</header>
<section class="container">
    <fieldset class="fieldsetForm">
        <legend class="legendForm">Image</legend>
        <form method="post" action="#" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th><label for="comment">Commentaire :</label></th>
                    <td>
                        <textarea rows="4" cols="50" name="commentPicture" id="commentPicture"><?php if(isset($commentPicture)) echo $commentPicture ?></textarea>
                        <?php if (isset($error['CommentPicture'])) echo '<span class="alert-danger">' . $error['CommentPicture'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="picture">Image :</label></th>
                    <td>
                        <input type="file" accept="image/*" multiple="multiple" name="picture[]" id="picture">
                        <?php if (isset($error['FilePicture'])) echo '<span class="alert-danger">' . $error['FilePicture'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitPicture" id="submitPicture" value="Uploader"></td>
                </tr>
            </table>
        </form>
    </fieldset>

    <fieldset class="fieldsetForm">
        <legend class="legendForm">Vidéo</legend>
        <form method="post" action="#" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th><label for="comment">Commentaire :</label></th>
                    <td>
                        <textarea rows="4" cols="50" name="commentVideo" id="commentVideo"><?php if(isset($commentVideo)) echo $commentVideo ?></textarea>
                        <?php if (isset($error['CommentVideo'])) echo '<span class="alert-danger">' . $error['CommentVideo'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="video">Vidéo :</label></th>
                    <td>
                        <input type="file" accept="video/*" multiple="video" name="video[]" id="video">
                        <?php if (isset($error['FileVideo'])) echo '<span class="alert-danger">' . $error['FileVideo'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitVideo" id="submitVideo" value="Uploader"></td>
                </tr>
            </table>
        </form>
    </fieldset>

    <fieldset class="fieldsetForm">
        <legend class="legendForm">Audio</legend>
        <form method="post" action="#" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th><label for="comment">Commentaire :</label></th>
                    <td>
                        <textarea rows="4" cols="50" name="commentAudio" id="commentAudio"><?php if(isset($commentAudio)) echo $commentAudio ?></textarea>
                        <?php if (isset($error['CommentAudio'])) echo '<span class="alert-danger">' . $error['CommentAudio'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="audio">Audio :</label></th>
                    <td>
                        <input type="file" accept="audio/*" multiple="multiple" name="audio[]" id="audio">
                        <?php if (isset($error['FileAudio'])) echo '<span class="alert-danger">' . $error['FileAudio'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitAudio" id="submitAudio" value="Uploader"></td>
                </tr>
            </table>
        </form>
    </fieldset>
</section>
</body>
</html>