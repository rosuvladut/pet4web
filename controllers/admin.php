<?php
class Admin extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function admincheck(){
        $users=new \pet4web\UsersQuery();
        $users=$users->filterByType('admin')->findOneById($_SESSION['userid']);
        if(!is_null($users)) {
            if ($_SESSION['userid'] == $users->getId())
                return true;
            else
                return false;
        }
    }

    public function index()
    {
        if (Admin::admincheck()) {
            $usermodel=new \pet4web\UsersQuery();
            $petmodel = new \pet4web\PetitionsQuery();
            if (!empty($_GET['page']))
                $petpage = $_GET['page'];
            else
                $petpage = 1;

            //all petitions
            $petitionpages = $petmodel->paginate($petpage, 10);
            if ($petitionpages->haveToPaginate()) {
                $links = $petitionpages->getLinks();
                $this->view->petpages = $links;
                $this->view->petpagesExist=true;
            } else {
                $this->view->petpagesExist = false;
            }
            $this->view->petdata = $petitionpages->getResults()->getData();

            //all members
            if (!empty($_GET['page2']))
                $userpage = $_GET['page2'];
            else
                $userpage = 1;
            $userpages=$usermodel->paginate($userpage,10);
            if ($userpages->haveToPaginate()) {
                $links = $userpages->getLinks();
                $this->view->userpages = $links;
                $this->view->userpagesExist=true;
            }
            else {
                $this->view->userpagesExist = false;
            }
            //var_dump($userpages->getResults()->getData());
            //die();
            $this->view->userdata = $userpages->getResults()->getData();

            $this->view->render('admin/index');
        }
        else{
            $_SESSION['error_message']="You don't have administrator privileges!";
            header("Location:" . URL . 'myaccount/index');
        }
    }
}