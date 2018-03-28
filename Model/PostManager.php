<?php
/**
 * Auteur : Jean-Daniel Küenzi
 * Description :
 * Version : 1.0.0
 * Date : 24.01.2018
 * Copyright : M152
 */

require_once '../Model/Post.php';
require_once '../Model/MediaManager.php';

/**
 * @brief Helper class pour gérer les posts
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

    public function LoadAllPosts(){
        $sql = 'SELECT * FROM ' . DB_DBNAME . '.post';
        try {
            $stmt = Database::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $stmt->execute();

            while($row=$stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $in = new Post($row['idPost'], $row['commentaire'], $row['datePost']);
                $in->SetArrayMedias(MediaManager::GetInstance()->GetMediasByIdPost($in->GetId()));
                array_push($this->post, $in);
            } #end while
        } catch (PDOExeception $e) {
            echo "PostManager:LoadAllPost Error : " . $e->getMessage();
            return false;
        }
        // Return le tableau de tout les commentaires
        return $this->post;
    }

    public function GetPostById($inId){
        $sql = 'SELECT * FROM ' . DB_DBNAME . '.post where idPost = :id';
        try {
            $stmt = Database::prepare($sql);
            $stmt->execute(array(':id' => $inId));

            $postById = fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
        } catch (PDOExeception $e) {
            echo "PostManager:LoadAllPost Error : " . $e->getMessage();
            return false;
        }
        // Return le tableau de tout les commentaires
        return $postById;
    }

    public function UploadPost($inComment, $file)
    {
        $sql = 'INSERT INTO ' . DB_DBNAME . '.post (commentaire) values (:co)';
        $db = Database::getInstance();
        try {
            $response = false;
            $db->beginTransaction();
            $stmt = $db->prepare($sql);
            $stmt->execute(array(':co' => $inComment));

            $idPost = $db->LastInsertId();

            for($i=0; $i < count($file['name']); $i++) {
                $name = uniqid() . $idPost;
                MediaManager::GetInstance()->UploadMedia($file['type'][$i], $name, $idPost);
                $response = move_uploaded_file($file['tmp_name'][$i], '../Source/post/' . $name);
            }

            if ($response)
            $db->commit();
            else
            $db->rollBack();
        } catch (PDOException $e) {
            echo "PostManager:UploadPost Error: " . $e->getMessage();
            $db->rollBack();
            return false;
        }
    }

    public function GetAllPosts() {
        return $this->post;
    }
}