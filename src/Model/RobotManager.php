<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class RobotManager extends AbstractManager
{
    public const TABLE = 'robot';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllByUser($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE user_id= :user_id");
        $statement->bindValue('user_id', $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(array $robot)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (name, accessoire, image) 
        VALUES (:name, :accessoire, :image,:user_id)");
        $statement->bindValue('name', $robot['name'], \PDO::PARAM_STR);
        $statement->bindValue('accessoire', $robot['accessoire'], \PDO::PARAM_STR);
        $statement->bindValue('image', $robot['image'], \PDO::PARAM_STR);
        $statement->execute();
        return (int) $this->pdo->lastInsertId();
    }

    public function update(array $robot): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name,`accessoire`=:accessoire, `image`=:image, WHERE id=:id");
        $statement->bindValue('id', $robot['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $robot['name'], \PDO::PARAM_STR);
        $statement->bindValue('accessoire', $robot['accessoire'], \PDO::PARAM_STR);
        $statement->bindValue('image', $robot['image'], \PDO::PARAM_STR);
        return $statement->execute();
    }
}
