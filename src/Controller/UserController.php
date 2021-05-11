<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\RobotManager;
use App\Model\OrderManager;

/**
 * Class UserController
 *
 */
class UserController extends AbstractController
{

    /**
     * Display user listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function profil()
    {
        $robotManager = new RobotManager();
        $robots = $robotManager->selectAllByUser($_SESSION['user']['id']);
        $orderManager = new OrderManager();
        $orders = $orderManager->selectAllByUser($_SESSION['user']['id']);

        return $this->twig->render('Admin/User/index.html.twig', ['robots' => $robots,'orders' => $orders]);
    }
}