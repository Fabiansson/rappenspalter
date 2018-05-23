<?php

require_once '../repository/UserRepository.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    public function index()
    {
        $userRepository = new UserRepository();

        $view = new View('user_index');
        $view->title = 'Haushalt';
        $view->heading = 'Haushalt';
        $view->haushalte = $userRepository->readAll();
        $view->display();
    }

    public function create()
    {
        $view = new View('user_create');
        $view->title = 'Haushalt erstellen';
        $view->heading = 'Haushalt erstellen';
        $view->display();
    }

    public function doCreate()
    {
        if ($_POST['send']) {
            $name = $_POST['haushalt'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            $userRepository = new UserRepository();
            $userRepository->create($name, $password, $email);
        }

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }

    public function delete()
    {
        $userRepository = new UserRepository();
        $userRepository->deleteById($_GET['id']);

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }
}
