<?php

class Search extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index($arg = false)
    {

        //$this->view->render('search/index');
    }

    public function doSearch()
    {
        if (isset($_REQUEST['search']) && $_REQUEST['search']) {
            $model = new \pet4web\PetitionsQuery();
            $result = $model->findByTitle($_REQUEST['search'] . '%')->getData();
            //var_dump($result);
            //die();
            if (is_array($result) && count($result)) {
                $this->view->data = $result;
                $this->view->render('search/result');
            } else {
                $_SESSION['error_message'] = "No results found!";
                header("Location: " . URL);
            }

        }
    }
}