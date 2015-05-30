<?php

class MyAccount extends Controller{

	function __construct(){
		parent::__construct();
	}

    public function islogged(){
        if (isset($_SESSION['logg_in']) && $_SESSION['logg_in']){
            return true;
        }
        else{
            return false;
        }
    }
	
	public function index($page='')
    {
        $usermodel=new \pet4web\UsersQuery();
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
        $usermodel=new \pet4web\UsersQuery();
        if(MyAccount::islogged()) {
            $user = $usermodel->findOneById($_SESSION['userid']);
            $this->view->userdata = $user;
            if(isset($_POST['submit'])&&isset($_POST['pass'])&&!empty($_POST['pass']))
            {
                $usermodel=$usermodel->findOneById($_SESSION['userid']);
                if(password_verify($_POST['pass'],$usermodel->getPassword())) {
                    if(isset($_POST['email2'])&&!empty($_POST['email2']))
                        $usermodel->setEmail($_POST['email2']);
                    if(isset($_POST['pass2'])&&!empty($_POST['pass2']))
                        $usermodel->setPassword(password_hash($_POST['pass2'], PASSWORD_DEFAULT));
                    if(isset($_POST['name2'])&&!empty($_POST['name2']))
                        $usermodel->setName($_POST['name2']);
                    if(isset($_POST['date2'])&&!empty($_POST['date2']))
                        $usermodel->setBirth($_POST['date2']);
                    if(isset($_POST['country2'])&&!empty($_POST['country2']))
                        $usermodel->setCountry($_POST['country2']);
                    if ($usermodel->save()) {
                        $_SESSION["success_message"] = "Successfully updated!";
                    }
                }
                else{
                    $_SESSION['error_message']="Current password is incorrect!";
                }
            }
            else if(isset($_POST['submit'])&&empty($_POST['pass'])){
                $_SESSION['error_message']="Please insert current password to update your account details!";
            }
            $this->view->render('account/update');
        }
        else{
            $_SESSION['error_message'] = "Please login to access your account!";
            header("Location:" . URL . 'index/');
        }
    }
}