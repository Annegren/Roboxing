<?php

namespace App\Controller;

use App\Model\CombatManager;
use App\Model\RobotManager;
use App\Model\OrderManager;

class CombatController extends AbstractController
{

    /**
     * Show informations for a specific combat
     */
    public function show(int $id): string
    {
        $orderManager = new orderManager();
        $order = $orderManager->selectOneById($id);

        return $this->twig->render('Combat/show.html.twig', ['order' => $order]);
    }

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['type']) && !empty($_POST['date']) && !empty($_POST['name']) && !empty($_POST['accessoire']) && !empty($_POST['image'])) {
                $combat = [
                    'type' => $_POST['type'],
                    'date' => $_POST['date'],
                    'lieu' => $_SESSION['user']['image'],
                ];
                $robot = [
                    'name' => $_POST['name'],
                    'accessoire' => $_POST['accessoire'],
                    'image' => $_POST['image'],
                ];
                $combatManager = new CombatManager();
                $id1 = $combatManager->insert($combat);
                $robotManager = new RobotManager();
                $id2 = $robotManager->insert($robot);
                $order = [
                'robot_id' => $id2,
                'combat_id' => $id1,
                'user_id' => $_SESSION['user']['id']
                ];

                $orderManager = new OrderManager();
                $idOrder = $orderManager->insert($order);
            }
           header('Location:/combat/show/' . $idOrder);
        }
        return $this->twig->render('Combat/add.html.twig');
    }
}
