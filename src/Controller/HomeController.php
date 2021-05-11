<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\UserManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Home/index.html.twig');
    }

    public function register()
    {
        $userManager = new UserManager();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!empty($_POST['username'])) {
                $user = $userManager->searchUser($_POST['username']);
                if ($user) {
                    $errors['username'] = "Ce pseudo existe déjà.";
                }
            } else {
                $errors['username'] = "Username required.";
            }

            if (!empty($_POST['password'])) {
                if (strlen($_POST['password']) < 4 || strlen($_POST['password']) > 10) {
                    $errors['password'] = "Le mot de passe doit contenir entre 4 et 10 caractères!";
                }
            } else {
                $errors['password'] = "Un mot de passe est requis";
            }

            if (!empty($_POST['check_password'])) {
                if ($_POST['password'] != $_POST['check_password']) {
                    $errors['password'] = "Les mots de passe ne correspondent pas !";
                }
            } else {
                $errors['check_password'] = "Veuillez entrer une nouvelle fois votre mot de passe";
            }

            if (empty($errors)) {
                $user = [
                    'username' => $_POST['username'],
                    'password' => md5($_POST['password']),
                ];
                $id = $userManager->insert($user);
                if ($id) {
                    $_SESSION['user'] = $userManager->selectOneById($id);
                    header('Location: /');
                } else {
                    header('Location: /');
                }
            }
        }

        return $this->twig->render(
            'Home/register.html.twig',
            [
                'user' => $userManager->selectAll(),
                'errors' => $errors
            ]
        );
    }

    public function login()
    {
        $userManager = new UserManager();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (empty($_POST['username'])) {
                $errors['username'] = "Votre pseudo est requis";
            }

            if (empty($_POST['password'])) {
                $errors['password'] = "Un mot de passe est requis";
            }
            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $user = $userManager->searchUser($_POST['username']);
                if ($user) {
                    if ($user['password'] === md5($_POST['password'])) {
                        $_SESSION['user'] = $user;
                        header('Location: /');
                    } else {
                        $errors['password1'] = "Mot de passe invalide";
                    }
                } else {
                    $errors['username1'] = "Ce pseudo n'existe pas !";
                }
            }
        }
        return $this->twig->render(
            'Home/login.html.twig',
            [
                'user' => $userManager->selectAll(),
                'errors' => $errors
            ]
        );
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }

    public function payment()
    {
        return $this->twig->render('Home/payment.html.twig');
    }

    public function contact()
    {
        return $this->twig->render('Home/contact.html.twig');
    }

    public function pari()
    {
        return $this->twig->render('Home/pari.html.twig');
    }

    public function about()
    {
        return $this->twig->render('Home/about.html.twig');
    }
}
