<?php
/**
 * @brief Helper class encapsulating
 * @author jean-daniel.knz@eduge.ch
 * @version 1.0.0
 */
require_once '../database/databaseParam.php';

class Database
{
    private static $pdoInstance;

    /**
     * @brief Class Constructor - Create a new database connection if one doesn't exist
     * Set to private so no-one can create a new instance via ' = new KDatabase();'
     */
    private function __construct()
    {
    }

    /**
     * @brief Like the constructor, we make __clone private so nobody can clone the instance
     */
    private function __clone()
    {
    }

    /**
     * @brief Returns DB instance or create initial connection
     *
     * @return $pdoInstance;
     */
    public static function getInstance()
    {
        if (!self::$pdoInstance) {
            try {

                $dsn = DB_DBTYPE . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DBNAME;
                self::$pdoInstance = new PDO ($dsn, DB_USER, DB_PASS, array(
                    'charset' => 'utf8'
                ));
                self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "KDatabase Error: " . $e->getMessage();
            }
        }
        return self::$pdoInstance;
    }

    // end method

    /**
     * @brief Passes on any static calls to this class onto the singleton PDO instance
     *
     * @param $chrMethod The
     *            method to call
     * @param $arrArguments The
     *            method's parameters
     * @return $mix The method's return value
     */
    final public static function __callStatic($chrMethod, $arrArguments)
    {
        $pdo = self::getInstance();
        return call_user_func_array(array(
            $pdo,
            $chrMethod
        ), $arrArguments);
    }

    // end method
}