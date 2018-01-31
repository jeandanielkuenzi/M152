<?php
/**
 * Created by PhpStorm.
 * User: KUENZIJ_INFO
 * Date: 31.01.2018
 * Time: 13:28
 */

class Post
{
    /**
     * @brief   Class Constructor
     */
    public function __construct($inId = -1, $inComment = "", $inType = "", $inFileName, $inDate = "") {
        $this->id = $inId;
        $this->comment = $inComment;
        $this->fileType = $inType;
        $this->fileName = $inFileName;
        $this->date = $inDate;
    }

    /**
     * @brief	Est-ce que cet objet est valide
     * @return  True si valide, autrement false
     */
    public function isValid() {
        return ($inId == -1) ? false : true;
    }

    /**
     * @brief	Getter
     * @return  L'ID du post
     */
    public function GetId() {
        return $this->id;
    }

    /**
     * @brief   Getter
     * @return  Le commentaire
     */
    public function GetComment()
    {
        return $this->comment;
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

    /**
     * @brief	Getter
     * @return  La date du post
     */
    public function GetDate() {
        return $this->date;
    }

    /** @brief L'identifiant unique du post */
    private $id;

    /** @brief Le commentaire du post */
    private $comment;

    /** @brief Le type du fichier  */
    private $fileType;

    /** @brief Le nom du fichier du post */
    private $fileName;

    /** @brief La date du post */
    private $date;
}