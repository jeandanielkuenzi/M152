<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 07.02.2018
 * Time: 15:50
 */

class Media
{
    /**
     * @brief   Class Constructor
     */
    public function __construct($inId = -1, $inType = "", $inFileName) {
        $this->id = $inId;
        $this->fileType = $inType;
        $this->fileName = $inFileName;
    }

    /**
     * @brief	Est-ce que cet objet est valide
     * @return  True si valide, autrement false
     */
    public function isValid() {
        return ($this->id == -1) ? false : true;
    }

    /**
     * @brief	Getter
     * @return  L'ID du media
     */
    public function GetId() {
        return $this->id;
    }

    /**
     * @brief	Getter
     * @return  Le type du fichier
     */
    public function GetFileType() {
        return $this->fileType;
    }

    /**
     * @brief	Getter
     * @return  Le nom du fichier
     */
    public function GetFileName() {
        return $this->fileName;
    }

    /** @brief L'identifiant unique du media */
    private $id;

    /** @brief Le type du fichier  */
    private $fileType;

    /** @brief Le nom du fichier du post */
    private $fileName;
}