<?php


class MenuController{

    public function index()
    {
        $view = new View('menu_index');
        $view->title = 'Startseite';
        $view->heading = 'Menu';
        $view->display();

    }
}
