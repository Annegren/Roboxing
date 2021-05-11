<?php

namespace App\Controller;

use App\Model\CombatManager;

class CombatController extends AbstractController
{
    /**
     * List combats
     */
    public function index(): string
    {
        $combatManager = new CombatManager();
        $combats = $combatManager->selectAll('name');

        return $this->twig->render('combat/index.html.twig', ['combats' => $combats]);
    }


    /**
     * Show informations for a specific combat
     */
    public function show(int $id): string
    {
        $combatManager = new combatManager();
        $combat = $combatManager->selectOneById($id);

        return $this->twig->render('combat/show.html.twig', ['combat' => $combat]);
    }


    /**
     * Edit a specific combat
     */
    public function edit(int $id): string
    {
        $combatManager = new combatManager();
        $combat = $combatManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $combat = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $combatManager->update($combat);
            header('Location: /combat/show/' . $id);
        }

        return $this->twig->render('combat/edit.html.twig', [
            'combat' => $combat,
        ]);
    }


    /**
     * Add a new combat
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $combat = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $combatManager = new combatManager();
            $id = $combatManager->insert($combat);
            header('Location:/combat/show/' . $id);
        }

        return $this->twig->render('combat/add.html.twig');
    }


    /**
     * Delete a specific combat
     */
    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $combatManager = new combatManager();
            $combatManager->delete($id);
            header('Location:/combat/index');
        }
    }
}
