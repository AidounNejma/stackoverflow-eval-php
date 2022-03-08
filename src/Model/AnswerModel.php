<?php

namespace App\Model;

use PDO;
use App\database\Database;
use DateTime;

class AnswerModel
{
    protected $id;

    protected $content;

    protected $note;

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

    public function findAll()
    {
        $sql = 'SELECT
                `id`
                ,`content`
                , `note`
                , `status`
                , `created_at`
                , `updated_at`
                , `user_id`
                , `question_id`
                FROM ' . self::TABLE_NAME . '
                ORDER BY `id` ASC;
        ';

        $pdoStatement = $this->pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $result;
    }

    public function create($content, $note, $status, $createdAt, $updatedAt, $userId, $questionId)
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . '
                (`content`, `note`, `status`, `created_at`, `updated_at`, `user_id`, `question_id`)
                VALUES
                (:content, :note, :status, :created_at, :updated_at, :user_id, :question_id)
        ';

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->bindValue(':content', $content, PDO::PARAM_STR);
        $pdoStatement->bindValue(':note', $note, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $status, PDO::PARAM_STR);
        $pdoStatement->bindValue(':created_at', $createdAt, PDO::PARAM_STR);
        $pdoStatement->bindValue(':updated_at', $updatedAt, PDO::PARAM_STR);
        $pdoStatement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $pdoStatement->bindValue(':questionId', $questionId, PDO::PARAM_STR);

        $result = $pdoStatement->execute();
        
        if (!$result) {
            return false;
        }

        return $this->pdo->lastInsertId();
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
    public function setCreatedAt(Datetime $createdAt)
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
    public function setUpdatedAt(Datetime $updatedAt)
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