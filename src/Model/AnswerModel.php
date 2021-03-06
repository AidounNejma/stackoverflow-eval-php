<?php

namespace App\Model;

use PDO;
use App\database\Database;
use DateTime;

class AnswerModel
{
    protected $id;

    protected $content;

    protected $status;

    protected $createdAt;

    protected $updatedAt;

    protected $userId;

    protected $questionId;

    protected $pdo;

    const TABLE_NAME = 'answers';

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getPDO();
    }

    #Trouver toutes les réponses
    public function findAll()
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . '
                ORDER BY `id` ASC;
        ';

        $pdoStatement = $this->pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $result;
    }

    #Trouver par l'id de la question
    public function findByQuestion($id)
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . '
        WHERE question_id = '. $id. ' ORDER BY created_at DESC';
        
        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        foreach($result as $r)
        {
            $r->setUserId($r->user_id);
        
        }
        
        return $result;
    }

    #Pour trouver toutes les réponses avec le statut publié
    public function findAllWithStatus($id){
    
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE `question_id` = '. $id. ' AND `status` = "published" ORDER BY created_at DESC';

        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        foreach($result as $r)
        {
            $r->setUserId($r->user_id);
        
        }
        
        return $result;
    }

    #Pour supprimer une reponse par son ID
    public function delete($id){
        
        $sql = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = '.$id. ' ';

        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $result;
    }

    #Pour edit une reponse par son ID
    public function update($id, $status, $updated_at){
        
        $sql = 'UPDATE ' . self::TABLE_NAME . ' SET status = "'.$status. '", updated_at = "'.$updated_at.'" WHERE id = '.$id. ' ';

        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $result;
    }

    #Créer une réponse
    public function create($content, $userId, $questionId)
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . '
                (`content`, `user_id`, `question_id`)
                VALUES
                (:content, :user_id, :question_id)
        ';

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->bindValue(':content', $content, PDO::PARAM_STR);
        $pdoStatement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $pdoStatement->bindValue(':question_id', $questionId, PDO::PARAM_INT);

        $result = $pdoStatement->execute();
        
        if (!$result) {
            return false;
        }

        return $this->pdo->lastInsertId();
    }

    #Compter le nombre de réponse
    public function countAnswers($id){
        
        $sql = 'SELECT count(*) FROM ' . self::TABLE_NAME . '
        WHERE question_id = '. $id;
        
        $pdoStatement = $this->pdo->query($sql);
        
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
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
    public function setId(int $id)
    {
        $this->id = $id;

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
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of note
     */ 
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @return  self
     */ 
    public function setNote(int $note)
    {
        $this->note = $note;

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
    public function setStatus(string $status)
    {
        $this->status = $status;

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
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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

    /**
     * Get the value of questionId
     */ 
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set the value of questionId
     *
     * @return  self
     */ 
    public function setQuestionId(int $questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }
}