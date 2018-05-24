<?php


class BudgetController{

    public function index()
    {
        $view = new View('budget_index');
        $view->title = 'Startseite';
        $view->heading = 'Budget';
        $view->display();

    }
}
