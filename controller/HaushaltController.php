<?php

require_once '../repository/UserRepository.php';
require_once '../repository/AusgabeRepository.php';

class HaushaltController {

    /**
     * Einstigesseite (Anzeige vom Loginformular)
     */
    public function index() {
        $this->form();
    }

    /**
     * Login-Formular (nur falls nicht angemeldet)
     */
    public function form() {
        if (isset($_SESSION['user'])) {
            header("Location: /haushalt/overview");
            return;
        }


        $view = new View('default_index');
        $view->title = "Login";
        $view->heading = "Login";
        $view->display();
    }

    /**
     * Benutzerübersicht
     */
    public function overview() {
        if (!isset($_SESSION['user'])) {
            header("Location: /haushalt");
            return;
        }

        $id = $_SESSION['user']->id;


        $view = new View('haushalt_index');
        $view->title = "Overview";
        $view->heading = "Overview";
        $view->name = $_SESSION['user']->name;

        $ausgabenRepo = new AusgabeRepository();
        $ausgaben = $ausgabenRepo->getAusgaben($id);
        $alleAusgaben = $ausgaben->summe;
        $guthaben = ($_SESSION['user']->mntlEinnahmen) - ($_SESSION['user']->mntlAusgaben) - $alleAusgaben;
        $view->guthaben = $guthaben;

        $view->tagesbudget = $guthaben / 30;

        $view->display();

    }

    /**
     * Login-Aktion (keine HTML-Ausgabe, nur Umleitung)
     */
    public function login() {
        if (isset($_POST['login'])) {

            $name = $_POST['username'];
            $password = sha1( $_POST['password'] );

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

    /**
     * Logout-Aktion (keine HTML-Ausgabe, nur Umleitung)
     */
    public function logout() {

        unset($_SESSION['user']);
        session_destroy();

        header('Location: /haushalt');
    }

    public function add(){
        if(isset($_POST['add']) && isset($_POST['wert']) && isset($_POST['auswahl'])){
            $wert = $_POST['wert'];
            if($_POST['auswahl'] == "ausgaben" && isset($_POST['kategorie'])){
                $ausgabeRepo = new AusgabeRepository();
                $ausgabeRepo->addAusgabe($wert, $_POST['kategorie'], $_SESSION['user']->id);
                header("Location: /haushalt/overview");
            }elseif ($_POST['auswahl'] == "einnahmen"){
                $einnahmeRepo = new EinnahmeRepository();
                $einnahmeRepo->addEinnahme($wert, $_SESSION['user']->id);
                header("Location: /haushalt/overview");
            }

        }
    }
}