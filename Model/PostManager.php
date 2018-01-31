<?php
/**
 * Auteur : Jean-Daniel Küenzi
 * Description :
 * Version : 1.0.0
 * Date : 24.01.2018
 * Copyright : M152
 */

require_once '../Model/Post.php';

/**
 * @brief Helper class pour gérer l'application
 * @author jean-daniel.knz@eduge.ch
 * @remark
 * @version 1.0.0
 */
class PostManager
{
    private static $objInstance;

    /**
     * @brief    Class Constructor - Create a new PostManager if one doesn't exist
     *    Set to private so no-one can create a new instance via ' = new PostManager();'
     */
    private function __construct()
    {
        $this->post = array();
    }

    /** @brief Contient tout les post */
    private $post;

    /**
     * @brief    Retourne notre instance ou la crée
     * @return $objInstance;
     */
    public static function GetInstance()
    {
        if (!self::$objInstance) {
            try {
                self::$objInstance = new PostManager();
            } catch (Exception $e) {
                echo "PostManager Error: " . $e;
            }
        }
        return self::$objInstance;
    }# end method

    public function LoadAllPost(){
        $sql = 'SELECT * FROM ' . DB_DBNAME . '.media';
        try {
            $stmt = Database::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $stmt->execute();

            while($row=$stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                //
                $in = new Post($row['idPost'], $row['commentaire'], $row['typeMedia'], $row['nomMedia'], $row['datePost']);
                array_push($this->post, $in);
            } #end while

        } catch (PDOExeception $e) {
            echo "PostManager:LoadAllPost Error : " . $e->getMessage();
            return false;
        }
        // Return le tableau de tout les commentaires
        return $this->post;
    }

    public function UploadPost($inComment, $inTypeFile, $inNameFile, $inDatePost)
    {
        $sql = 'INSERT INTO ' . DB_DBNAME . '.media (commentaire, typeMedia, nomMedia, datePost) values (:co, :tm, :nm, :dp)';
        try {
            $stmt = Database::prepare($sql);
            $stmt->execute(array(':co' => $inComment, ':tm' => $inTypeFile, ':nm' => $inNameFile, ':dp' => $inDatePost));
        } catch (PDOException $e) {
            echo "PostManager:UploadPost Error: " . $e->getMessage();
            return false;
        }
    }

    public function GetAllPost() {
        return $this->post;
    }
}
