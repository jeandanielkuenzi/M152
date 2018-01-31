<?php
/**
 * Auteur : Jean-Daniel Küenzi
 * Description :
 * Version : 1.0.0
 * Date : 24.01.2018
 * Copyright : M152
 */

require_once '../database/database.php';

/**
 * @brief Helper class pour gérer l'application
 * @author jean-daniel.knz@eduge.ch
 * @remark
 * @version 1.0.0
 */
class AppManager
{


    private static $objInstance;

    /**
     * @brief    Class Constructor - Create a new EAppManager if one doesn't exist
     *    Set to private so no-one can create a new instance via ' = new EAppManager();'
     */
    private function __construct()
    {

    }


    /**
     * @brief    Retourne notre instance ou la crée
     * @return $objInstance;
     */
    public static function GetInstance()
    {
        if (!self::$objInstance) {
            try {
                self::$objInstance = new AppManager();
            } catch (Exception $e) {
                echo "AppManager Error: " . $e;
            }
        }
        return self::$objInstance;
    }# end method

    public static function GetAllPost(){

    }

    public static function UploadPost($inComment, $inTypeFile, $inNameFile, $inDatePost)
    {
        $sql = 'INSERT INTO ' . DB_DBNAME . '.media (commentaire, typeMedia, nomMedia, datePost) values (:co, :tm, :nm, :dp)';
        try {
            $stmt = Database::prepare($sql);
            $stmt->execute(array(':co' => $inComment, ':tm' => $inTypeFile, ':nm' => $inNameFile, ':dp' => $inDatePost));
        } catch (PDOException $e) {
            echo "AppManager:UploadPost Error: " . $e->getMessage();
            return false;
        }
    }
}
