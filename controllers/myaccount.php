<?php

class MyAccount extends Controller{

	function __construct(){
		parent::__construct();
	}
	
	public function index($page='')
    {
        $usermodel=new \pet4web\UsersQuery();
        $user=new \pet4web\Users();
        $model = new \pet4web\PetitionsQuery();
        if (isset($_SESSION['logg_in']) && $_SESSION['logg_in']) {
            if (!empty($_GET['page']))
                $page = $_GET['page'];
            else
                $page = 1;
            $user=$usermodel->findOneById($_SESSION['userid']);
            $this->view->userdata=$user;
            //var_dump($user);
            //die();

            $model->filterByUserid($_SESSION['userid']);
            $pages = $model->paginate($page, 5);
            $a = $pages->getResults()->getData();
            //var_dump($pages->getResults()->getData());
            //die();
            if ($pages->haveToPaginate()) {
                $links = $pages->getLinks();
                $this->view->pages = $links;
                $this->view->pagesExist=true;
            } else {
                $this->view->pagesExist = false;
            }
            $this->view->data = $pages->getResults()->getData();
            $this->view->render('account/index');
        } else {
            $_SESSION['error_message'] = "Please login to access your account!";
            header("Location:" . URL . 'index/');
        }
    }
    public function update(){
        $this->view->render('account/update');
    }
}