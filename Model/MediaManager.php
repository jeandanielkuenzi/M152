<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 07.02.2018
 * Time: 15:56
 */

/**
 * @brief Helper class pour gérer les medias
 * @author jean-daniel.knz@eduge.ch
 * @remark
 * @version 1.0.0
 */

require_once '../Model/Media.php';
class MediaManager
{
    private static $objInstance;

    /**
     * @brief    Class Constructor - Create a new PostManager if one doesn't exist
     *    Set to private so no-one can create a new instance via ' = new PostManager();'
     */
    private function __construct()
    {
        $this->media = array();
    }

    /** @brief Contient tout les post */
    private $media;

    /**
     * @brief    Retourne notre instance ou la crée
     * @return $objInstance;
     */
    public static function GetInstance()
    {
        if (!self::$objInstance) {
            try {
                self::$objInstance = new MediaManager();
            } catch (Exception $e) {
                echo "MediaManager Error: " . $e;
            }
        }
        return self::$objInstance;
    }# end method

    public function LoadAllMedias(){
        $sql = 'SELECT * FROM ' . DB_DBNAME . '.media';
        try {
            $stmt = Database::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $stmt->execute();

            while($row=$stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $in = new Media($row['idMedia'], $row['typeMedia'], $row['nomFichierMedia']);
                array_push($this->media, $in);
            } #end while
        } catch (PDOExeception $e) {
            echo "PostManager:LoadAllMedias Error : " . $e->getMessage();
            return false;
        }
        // Return le tableau de tout les commentaires
        return $this->media;
    }

    public function GetMediasByIdPost($inIdPost){
        $sql = 'SELECT * FROM ' . DB_DBNAME . '.media where idPost = :id';
        try {
            $mediaPost = array();
            $stmt = Database::prepare($sql);
            $stmt->execute(array(':id' => $inIdPost));

            while($row=$stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $in = new Media($row['idMedia'], $row['typeMedia'], $row['nomFichierMedia']);
                array_push($mediaPost, $in);
            } #end while
        } catch (PDOExeception $e) {
            echo "PostManager:LoadAllPost Error : " . $e->getMessage();
            return false;
        }
        // Return le tableau de tout les medias avec le bon idPost
        return $mediaPost;
    }

    public function UploadMedia($inTypeFile, $inNameFile, $inIdPost)
    {
        $sql = 'INSERT INTO ' . DB_DBNAME . '.media (typeMedia, nomFichierMedia, idPost) values (:tm, :nm, :id)';
        try {
            $stmt = Database::prepare($sql);
            $stmt->execute(array(':tm' => $inTypeFile, ':nm' => $inNameFile, ':id' => $inIdPost));
        } catch (PDOException $e) {
            echo "PostManager:UploadPost Error: " . $e->getMessage();
            return false;
        }
    }


    public function GetAllMedias() {
        return $this->media;
    }
}
