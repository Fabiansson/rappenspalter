<?php

require_once '../repository/UserRepository.php';
require_once '../repository/AusgabeRepository.php';
require_once '../repository/EinnahmeRepository.php';

class HaushaltController
{

    /**
     * Einstigesseite (Anzeige vom Loginformular)
     */
    public function index()
    {
        $this->form();
    }

    /**
     * Login-Formular (nur falls nicht angemeldet)
     */
    public function form()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /haushalt/overview");
            return;
        }


        $view = new View('default_index');
        $view->title = "Login";
        $view->heading = "Login";
        $view->display();
    }

    public function create()
    {
        $view = new View('haushalt_create');
        $view->title = 'Haushalt erstellen';
        $view->heading = 'Haushalt erstellen';
        $view->display();
    }

    public function doCreate()
    {
        if ($_POST['signup']) {
            $userRepository = new UserRepository();
            if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['mail']) && !empty($_POST['mail'])) {
                $name = strtolower($_POST['username']);
                $password = $_POST['password'];
                $email = strtolower($_POST['mail']);

                $duplicate = $userRepository->checkDuplicate($name);
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL) && !$duplicate) {
                $userRepository = new UserRepository();
                $userRepository->create($name, $password, $email);
                header('Location: /haushalt');
            }
            else{
                ///////////////////HIER STEHENGEBLIEBEN//////////////////
            }
        }
    }

    public function delete()
    {
        $userRepository = new UserRepository();
        $userRepository->deleteById($_SESSION['user']->id);

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /haushalt');
    }

    /**
     * Benutzerübersicht
     */
    public function overview()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /haushalt");
            return;
        }

        $id = $_SESSION['user']->id;


        $view = new View('haushalt_index');
        $view->title = "Übresicht";
        $view->heading = "Willkommen " . lcfirst($_SESSION['user']->name);
        $view->name = lcfirst($_SESSION['user']->name);

        $ausgabenRepo = new AusgabeRepository();
        $ausgaben = $ausgabenRepo->getAusgaben($id);
        $alleAusgaben = $ausgaben->summe;

        $einnahmenRepo = new EinnahmeRepository();
        $einnahmen = $einnahmenRepo->getEinnahmen($id);
        $alleEinnahmen = $einnahmen->summe;

        $guthaben = ($_SESSION['user']->mntlEinnahmen) - ($_SESSION['user']->mntlAusgaben) - $alleAusgaben + $alleEinnahmen;
        $view->guthaben = $guthaben;

        $view->tagesbudget = $guthaben / 30;

        $view->display();

    }

    /**
     * Login-Aktion (keine HTML-Ausgabe, nur Umleitung)
     */
    public function login()
    {
        if (isset($_POST['login'])) {

            $name = strtolower($_POST['username']);
            $password = sha1($_POST['password']);

            $userRepo = new UserRepository();
            $user = $userRepo->readByName($name);

            if ($user != null && $user->password == $password) {
                // Login ok
                $_SESSION['user'] = $user;
                header("Location: /haushalt/overview");
                return;
            } else {
                $_SESSION['error'] = "Login failed";
                header("Location: /haushalt");
                return;
            }
        }
    }

    public function menu()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /haushalt");
            return;
        }

        $view = new View('haushalt_menu');
        $view->title = 'Menu';
        $view->heading = 'Menu';
        $view->mntlAusgaben = $_SESSION['user']->mntlAusgaben;
        $view->mntlEinnahmen = $_SESSION['user']->mntlEinnahmen;
        $view->display();
    }

    /**
     * Logout-Aktion (keine HTML-Ausgabe, nur Umleitung)
     */
    public function logout()
    {

        unset($_SESSION['user']);
        session_destroy();

        header('Location: /haushalt');
    }

    public function add()
    {
        if (isset($_POST['add']) && isset($_POST['wert']) && isset($_POST['auswahl'])) {
            $wert = $_POST['wert'];
            if ($_POST['auswahl'] == "ausgaben" && isset($_POST['kategorie'])) {
                $ausgabeRepo = new AusgabeRepository();
                $ausgabeRepo->addAusgabe($wert, $_POST['kategorie'], $_SESSION['user']->id);
                header("Location: /haushalt/overview");
            } elseif ($_POST['auswahl'] == "einnahmen") {
                $einnahmeRepo = new EinnahmeRepository();
                $einnahmeRepo->addEinnahme($wert, $_SESSION['user']->id);
                header("Location: /haushalt/overview");
            }

        }
    }

    public function setFinance()
    {
        if (isset($_POST['menuSubmit']) && isset($_POST['fixE']) && isset($_POST['fixA'])) {
            $einnahmen = $_POST['fixE'];
            $ausgaben = $_POST['fixA'];

            $userRepo = new UserRepository();
            $userRepo->setEinnahmen($einnahmen, $_SESSION['user']->id);
            $userRepo->setAusgaben($ausgaben, $_SESSION['user']->id);

            $_SESSION['user'] = $userRepo->readById($_SESSION['user']->id);

            header("Location: /haushalt/overview");


        }
    }
}