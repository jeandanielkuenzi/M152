<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 21.02.2018
 * Time: 14:38
 */

class AppManager
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
                self::$objInstance = new AppManager();
            } catch (Exception $e) {
                echo "AppManager Error: " . $e;
            }
        }
        return self::$objInstance;
    }# end method

    public function GetLastInsertId(){
        try{
            $db = Database::getInstance();
            $id = $db->lastInsertId();
        } catch (Exception $e) {
            echo "AppManager Error:GetLastInsertId " . $e;
        }
        return $id;
    }
}