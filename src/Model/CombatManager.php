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
class CombatManager extends AbstractManager
{
    public const TABLE = 'combat';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $combat): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (`lieu`,`date`,`type`) 
        VALUES (:lieu,:date,:type)");
        $statement->bindValue('lieu', $combat['lieu'], \PDO::PARAM_STR);
        $statement->bindValue('date', $combat['date'], \PDO::PARAM_STR);
        $statement->bindValue('type', $combat['type'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Update combat in database
     */
    public function update(array $combat): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
        " SET `lieu` = :lieu,`date` = :date,`type` = :type WHERE id=:id");
        $statement->bindValue('id', $combat['id'], \PDO::PARAM_INT);
        $statement->bindValue('lieu', $combat['lieu'], \PDO::PARAM_STR);
        $statement->bindValue('date', $combat['date'], \PDO::PARAM_STR);
        $statement->bindValue('type', $combat['type'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
