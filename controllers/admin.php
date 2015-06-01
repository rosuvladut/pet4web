<?php
class Admin extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function admincheck(){
        $users=new \pet4web\UsersQuery();
        $users->filterByType('admin')->findOneById($_SESSION['userid']);
    }

    public function index(){
        $this->view->render('admin/index');
    }

}