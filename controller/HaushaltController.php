<?php

require_once '../repository/UserRepository.php';
require_once '../repository/AusgabeRepository.php';
require_once '../repository/EinnahmeRepository.php';

class HaushaltController {

    /**
     * Einstigesseite (Anzeige vom Loginformular)
     *
     */
    public function index() {
        $this->form();
    }

    /**
     * Login-Formular (prüft ob angemeldet oder nicht, sonst zum Login Formular)
     */
    public function form() {
        if (isset($_SESSION['user'])) {
            header("Location: /haushalt/overview");
            return;
        }


        $view = new View('default_index');
        $view->title = "Login";
        $view->heading = "Login";
        $view->error = (isset($_SESSION['error'])) ? $_SESSION['error'] : "";
        $view->display();
        unset($_SESSION['error']);
    }

    public function create() {
        $view = new View('haushalt_create');
        $view->title = 'Haushalt erstellen';
        $view->heading = 'Haushalt erstellen';
        $view->error = (isset($_SESSION['error'])) ? $_SESSION['error'] : "";
        $view->display();
        unset($_SESSION['error']);
    }

    /**
     * Diese Methode erstellt den eigentlichen Benutzer.
     * @throws Exception
     */
    public function doCreate() {
        if ($_POST['signup']) {
            $userRepository = new UserRepository();

            //Überprüft die Eingaben des Benutzers grob
            if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['mail']) && !empty($_POST['mail'])) {
                $name = strtolower($_POST['username']);
                $password = $_POST['password'];
                $email = strtolower($_POST['mail']);

                $duplicate = $userRepository->checkDuplicate($name);

                //Hier wird sichergestellt, dass das Passwort einen gewissen Sicherheitsstandart hat.
                if (!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $password)) {
                    $_SESSION['error'] = "Das Passwort muss aus min. 8 Zeichen bestehen und min. ein Gross- und Kleinbuchstabe enthalten.";
                    $this->create();
                    return;
                }
                //Überprüft ob eine gültige Email eingegeben wurde und ob der Benutzer noch nicht exisitert.
                if (filter_var($email, FILTER_VALIDATE_EMAIL) && !$duplicate) {
                    $userRepository = new UserRepository();
                    $userRepository->create($name, $password, $email);
                    header('Location: /haushalt');
                } else {
                    $_SESSION['error'] = "Dieser Benutzername bzw Email exisitieren bereits oder Email ist ungültig!";
                    $this->create();
                    return;
                }
            }
        } else {
            $_SESSION['error'] = "Haushalt kann so nicht erstellt werden!";
            header('Location: /haushalt');
        }
    }

    /**
     * Diese Methode löscht einen Benutzer.
     */
    public function delete() {
        if (isset($_POST['delete'])) {
            $userRepository = new UserRepository();
            $userRepository->deleteById($_SESSION['user']->id);
            $this->logout();
        } else {
            $_SESSION['error'] = "Haushalt kann nicht gelöscht werden!";
            header('Location: /haushalt');
        }
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
        $view->title = "Übresicht";
        $view->heading = "Willkommen " . ucfirst($_SESSION['user']->name);
        $view->name = ucfirst($_SESSION['user']->name);
        $view->error = (isset($_SESSION['error'])) ? $_SESSION['error'] : "";

        $ausgabenRepo = new AusgabeRepository();
        $ausgaben = $ausgabenRepo->getAusgaben($id);
        $alleAusgaben = $ausgaben->summe;

        $einnahmenRepo = new EinnahmeRepository();
        $einnahmen = $einnahmenRepo->getEinnahmen($id);
        $alleEinnahmen = $einnahmen->summe;

        //Berechnet das übrige Guthaben indem die monatlichen Einnahmen - die mntl. Ausgaben und die Aus- und Einnahmen aus diesem Monat beachtet werden.
        $guthaben = ($_SESSION['user']->mntlEinnahmen) - ($_SESSION['user']->mntlAusgaben) - $alleAusgaben + $alleEinnahmen;
        $view->guthaben = number_format((float)$guthaben, 2, '.', '');

        $view->tagesbudget = number_format(((float)$guthaben / 30), 2, '.', '');

        $view->display();
        unset($_SESSION['error']);

    }

    /**
     * Login-Aktion (keine HTML-Ausgabe, nur Umleitung)
     */
    public function login() {
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
                $_SESSION['error'] = "Banutzername oder Passwort ist falsch.";
                header("Location: /haushalt");
                return;
            }
        } else {
            $_SESSION['error'] = "Bereits eingelogt!";
            header('Location: /haushalt');
        }
    }

    /**
     * Diese Methode ruft das Menu auf wo der Haushalt gelöscht werden kann und die fixen monatlichen Ein- und Ausgaben egetragen werden könnnen.
     */
    public function menu() {
        if (!isset($_SESSION['user'])) {
            header("Location: /haushalt");
            return;
        }

        $view = new View('haushalt_menu');
        $view->title = 'Menu';
        $view->heading = 'Menu';
        $view->mntlAusgaben = $_SESSION['user']->mntlAusgaben;
        $view->mntlEinnahmen = $_SESSION['user']->mntlEinnahmen;
        $view->error = (isset($_SESSION['error'])) ? $_SESSION['error'] : "";
        $view->display();
        unset($_SESSION['error']);
    }

    /**
     * Logout-Aktion (keine HTML-Ausgabe, nur Umleitung)
     */
    public function logout() {

        unset($_SESSION['user']);
        session_destroy();

        header('Location: /haushalt');
    }

    /**
     * Diese Methode dient dazu zum Hinzufügen von Ein- und Ausgaben
     */
    public function add() {
        if (isset($_POST['add']) && isset($_POST['wert']) && isset($_POST['auswahl'])) {
            if (preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $_POST['wert'])) {
                $wert = $_POST['wert'];
                var_dump($wert);
                if ($_POST['auswahl'] == "ausgaben" && isset($_POST['kategorie'])) {
                    $ausgabeRepo = new AusgabeRepository();
                    $ausgabeRepo->addAusgabe($wert, $_POST['kategorie'], $_SESSION['user']->id);
                    header("Location: /haushalt/overview");
                } elseif (isset($_POST['wert']) && $_POST['auswahl'] == "einnahmen") {
                    $einnahmeRepo = new EinnahmeRepository();
                    $einnahmeRepo->addEinnahme($wert, $_SESSION['user']->id);
                    header("Location: /haushalt/overview");
                }
            } else {
                $_SESSION['error'] = "Ungültige Eingabe!";
                header('Location: /haushalt');
            }
        } else {
            $_SESSION['error'] = "Ungültige Auswahl!";
            header('Location: /haushalt');
        }
    }

    /**
     * Diese Methode setzt die fixen monatlichen Ein- und Ausgaben aus dem Menu.
     */
    public function setFinance() {
        if (isset($_POST['menuSubmit']) && isset($_POST['fixE']) && isset($_POST['fixA'])) {
            $einnahmen = $_POST['fixE'];
            $ausgaben = $_POST['fixA'];

            if (preg_match('/^\d+$/', $einnahmen) && preg_match('/^\d+$/', $ausgaben)) {

                $userRepo = new UserRepository();
                $userRepo->setEinnahmen($einnahmen, $_SESSION['user']->id);
                $userRepo->setAusgaben($ausgaben, $_SESSION['user']->id);

                $_SESSION['user'] = $userRepo->readById($_SESSION['user']->id);

                header("Location: /haushalt/overview");
            } else {
                $_SESSION['error'] = "Ungültige eingabe";
                header('Location: /haushalt/menu');
            }
        } else {
            $_SESSION['error'] = "Konnte nicht übermittelt werden!";
            header('Location: /haushalt/menu');
        }
    }

    public function pageNotFound() {
        $view = new View('pageNotFound');
        $view->title = '404';
        $view->heading = 'Die Seite konnte nicht gefunden werden!';
        $view->display();
    }
}