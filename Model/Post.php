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
    public function __construct($inId = -1, $inComment = "", $inDate = "", $inMedia = array()) {
        $this->id = $inId;
        $this->comment = $inComment;
        $this->date = $inDate;
        $this->arrayMedias = $inMedia;
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
     * @return  La date du post
     */
    public function GetDate() {
        return $this->date;
    }

    /**
     * @brief	Getter
     * @return  Le tableau contenant les medias
     */
    public function GetArrayMedias() {
        return $this->arrayMedias;
    }

    /**
     * @brief	Setter
     * @return  Le tableau contenant les medias
     */
    public function SetArrayMedias($inArrayMedias) {
        $this->arrayMedias = $inArrayMedias;
    }

    /** @brief L'identifiant unique du post */
    private $id;

    /** @brief Le commentaire du post */
    private $comment;

    /** @brief La date du post */
    private $date;

    /** @brief Les medias du post */
    private $arrayMedias;
}