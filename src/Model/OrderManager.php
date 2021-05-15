<?php

namespace App\Model;

class OrderManager extends AbstractManager
{
    public const TABLE = 'order';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT robot.id,robot.name,image,accessoire,combat.id,lieu,date,type,user.id,username FROM `order` JOIN combat ON combat.id=order.combat_id JOIN robot ON robot.id=order.robot_id JOIN user ON user.id=order.user_id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     *
     */
    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT order.id AS id,robot.id,robot.name,image,accessoire,combat.id,lieu,date,type FROM `order` JOIN combat ON combat.id=order.combat_id JOIN robot ON robot.id=order.robot_id JOIN user ON user.id=order.user_id WHERE order.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $order)
    {
        $statement = $this->pdo->prepare("INSERT INTO `order` (user_id, combat_id, robot_id) 
         VALUES (:user_id, :combat_id, :robot_id)");
        $statement->bindValue('user_id', $order['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('combat_id', $order['combat_id'], \PDO::PARAM_INT);
        $statement->bindValue('robot_id', $order['robot_id'], \PDO::PARAM_INT);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function selectAllByUser(int $id)
    {
        $statement = $this->pdo->prepare("SELECT robot.id,robot.name,image,accessoire,combat.id,lieu,date,type,user.id,username FROM " . self::TABLE . " JOIN `robot` ON robot.id=order.robot_id WHERE user_id= :user_id");
        $statement->bindValue('user_id', $id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }
}
