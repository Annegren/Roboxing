<?php

namespace App\Controller;

use App\Model\RobotManager;

class RobotController extends AbstractController
{
    /**
     * Show informations for a specific robot
     */
    public function show(int $id): string
    {
        $robotManager = new RobotManager();
        $robot = $robotManager->selectOneById($id);

        return $this->twig->render('Robot/show.html.twig', ['robot' => $robot]);
    }


    /**
     * Edit a specific robot
     */
    public function edit(int $id): string
    {
        $robotManager = new RobotManager();
        $robot = $robotManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $robot = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $robotManager->update($robot);
            header('Location: /robot/show/' . $id);
        }

        return $this->twig->render('Robot/edit.html.twig', [
            'robot' => $robot,
        ]);
    }


    /**
     * Add a new robot
     */
    public function add()
    {
        if (isset($_SESSION['user'])) {
            $robotManager = new RobotManager();
            $errors = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!empty($_POST['name']) && !empty($_POST['accessoire']) && !empty($_POST['image'])) {
                    $robot = [
                        'name' => $_POST['name'],
                        'accessoire' => $_POST['accessoire'],
                        'image' => $_POST['image'],
                    ];

                    $id = $robotManager->insert($robot);
                } else {
                    $errors[] = "Tous les champs sont requis";
                }
            }
            return $this->twig->render('Robot/add.html.twig', ['errors' => $errors,'robot' => $robot]);
        } else {
            header('Location: /');
        }
    }


    /**
     * Delete a specific robot
     */
    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $robotManager = new RobotManager();
            $robotManager->delete($id);
            header('Location:/robot/index');
        }
    }
}
