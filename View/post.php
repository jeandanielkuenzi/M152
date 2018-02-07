<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post</title>
    <?php
        require_once './includeSource.php';
        if (isset($_POST['submit'])) {
            require_once '../Controller/upload_post.php';
        }
    ?>
</head>
<body>
<header>
<?php require_once "./navBar.php" ?>
</header>
<article class="main container">
    <fieldset>
        <legend>Upload</legend>
        <form method="post" action="#" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th><label for="comment">Commentaire :</label></th>
                    <td>
                        <textarea rows="4" cols="50" name="comment" id="comment" value="<?php if(isset($comment)) echo $comment ?>"></textarea>
                        <?php if (isset($error['Comment'])) echo '<span class="alert-danger">' . $error['Comment'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="picture">Image :</label></th>
                    <td>
                        <input type="file" accept="image/*" multiple="multiple" name="picture[]" id="picture">
                        <?php if (isset($error['File'])) echo '<span class="alert-danger">' . $error['File'] . '</span>' ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" id="submit" value="Uploader"></td>
                </tr>
            </table>
        </form>
    </fieldset>
</article>
</body>
</html>