<?php

namespace App\Model;

use PDO;
use App\database\Database;
use DateTime;

class QuestionModel
{

    protected $id;

    protected $title;

    protected $content;

    protected $status;

    protected $technology;

    protected $createdAt;

    protected $updatedAt;

    protected $userId;

    protected $pdo;

    const TABLE_NAME = 'questions';

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getPDO();

    }

    #Récupérer toutes les questions
    public function findAll()
    {
        $sql = 'SELECT
                `id`
                ,`title`
                ,`content`
                ,`status`
                ,`technology`
                ,`created_at`
                ,`updated_at`
                ,`user_id`
                FROM ' . self::TABLE_NAME . '
                ORDER BY `created_at` DESC;
        ';

        $pdoStatement = $this->pdo->query($sql);

        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
    }

    #Permet de faire la recherche, la pagination et le filtre par tag
    public function findByPage($page, $search, $tag)
    {
        if($search){
            
            $like = "WHERE `title` LIKE '%" .$search. "%' ";
        }
        else{
            $like = "";
        }

        if($tag){
            
            $like = "WHERE `technology` LIKE '%" .$tag. "%' ";
        }
        else{
            $like = "";
        }

        $sql = 'SELECT
                `id`
                ,`title`
                ,`content`
                ,`status`
                ,`technology`
                ,`created_at`
                ,`updated_at`
                ,`user_id`
                FROM ' . self::TABLE_NAME . ' '. $like .
                ' ORDER BY `created_at` DESC 
                LIMIT '. ($page-1) * 5 . ', 5;
        ';

        $pdoStatement = $this->pdo->query($sql);

        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
    }

    #Pour trouver une question par son ID
    public function findById($id){
        
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = '.$id;

        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $result;
    }


    #Pour supprimer une question par son ID
    public function delete($id){
        
        $sql = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = '.$id. ' ';

        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $result;
    }

    #Pour edit une question par son ID
    public function update($id, $status, $updated_at){
        
        $sql = 'UPDATE ' . self::TABLE_NAME . ' SET status = "'.$status. '", updated_at = "'.$updated_at.'" WHERE id = '.$id. ' ';

        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $result;
    }

    #Pour ajouter une nouvelle question dans la base de données
    public function create($title, $content, $technology, $userId)
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . '
                (`title`, `content`, `technology`, `user_id`)
                VALUES
                (:title, :content, :technology, :user_id)
        ';

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->bindValue(':title', $title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':content', $content, PDO::PARAM_STR);
        $pdoStatement->bindValue(':technology', $technology, PDO::PARAM_STR);
        $pdoStatement->bindValue(':user_id', $userId, PDO::PARAM_INT);


        $result = $pdoStatement->execute();
        
        if (!$result) {
            return false;
        }

        return $this->pdo->lastInsertId();
    }
    
    #Récupérer les noms des colonnes
    public function getMeta()
    {
        $sql = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "' . self::TABLE_NAME . '"';

        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $result;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of technology
     */ 
    public function getTechnology()
    {
        return $this->technology;
    }

    /**
     * Set the value of technology
     *
     * @return  self
     */ 
    public function setTechnology($technology)
    {
        $this->technology = $technology;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }


}
