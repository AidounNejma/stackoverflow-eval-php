<?php

namespace App\Model;

use PDO;
use App\database\Database;
use DateTime;

class UserModel
{
    protected $id;

    protected $nickname;

    protected $email;

    protected $password;

    protected $gender;

    protected $status;

    protected $createdAt;

    protected $updatedAt;

    protected $pdo;

    const TABLE_NAME = 'users';

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getPDO();
    }


    #Trouver tous les utilisateurs
    public function findAll()
    {
        $sql = 'SELECT
                `id`
                ,`nickname`
                ,`email`
                ,`password`
                ,`gender`
                ,`status`
                ,`created_at`
                ,`updated_at`
                FROM ' . self::TABLE_NAME . '
                ORDER BY `id` ASC;
        ';

        $pdoStatement = $this->pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $result;
    }


    #Créer un nouvel utilisateur
    public function create($nickname, $email, $password, $gender, $createdAt)
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . '
                (`nickname`, `email`, `password`, `gender`, `created_at`)
                VALUES
                (:nickname, :email, :password, :gender, :created_at)
        ';

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->bindValue(':nickname', $nickname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':gender', $gender, PDO::PARAM_STR);
        $pdoStatement->bindValue(':created_at', $createdAt, PDO::PARAM_STR);

        $result = $pdoStatement->execute();

        if (!$result) {
            return false;
        }

        return $this->pdo->lastInsertId();
    }


    #Vérification pour qu'un utilisateur puisse s'inscrire (pour voir si le nickname ou l'email sont déjà présent en bdd)
    public function verification($email, $nickname)
    {

        $sql = 'SELECT
        `email`
        ,`nickname`
        FROM ' . self::TABLE_NAME . '
        WHERE `email` = "' . $email . '" OR `nickname` = "' . $nickname . '"';

        $pdoStatement = $this->pdo->query($sql);

        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!$result) {
            return false;
        }

        return $result;
    }


    #Permet la vérification de l'utilisateur pour le connecter
    public function login($email)
    {
        $sql = 'SELECT
                `email`
                ,`password`
                ,`id`
                FROM ' . self::TABLE_NAME . '
                WHERE email = "' . $email . '"';

        $pdoStatement = $this->pdo->query($sql);

        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        if (!$result) {
            return false;
        }

        return $result;
    }


    #Trouver un utilisateur via l'ID
    public function findById($id)
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = ' . $id;

        $pdoStatement = $this->pdo->query($sql);

        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
    }


    #Pour supprimer un user par son ID
    public function delete($id)
    {

        $sql = 'DELETE FROM ' . self::TABLE_NAME . ' WHERE id = ' . $id . ' ';

        $pdoStatement = $this->pdo->query($sql);

        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
    }


    #Pour edit un user par son ID
    public function update($id, $status, $updated_at)
    {

        $sql = 'UPDATE ' . self::TABLE_NAME . ' SET status = "' . $status . '", updated_at = "' . $updated_at . '" WHERE id = ' . $id . ' ';

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
     * Get the value of nickname
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set the value of nickname
     *
     * @return  self
     */
    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;

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
    public function setStatus(int $status)
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
    public function setCreatedAt(DateTime $createdAt)
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
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
