<?php

class Login extends Controller{

	function __construct(){
		parent::__construct();
	}

	public function index($arg = false){
		$this->view->render('login/index');
	}

	function in(){
		if(isset($_POST['username']) && isset($_POST['passwd'])){
			$model = new \pet4web\UsersQuery();
            $user=$model->findByEmail($_POST['username'])->toArray();
            if(empty($user[0]['Email'])){
                $this->view->ErrorMessage = "Email not registered!";
            }
            else if(password_verify($_POST['passwd'],$user[0]['Password'])){
                $_SESSION['logg_in'] = true;
                $_SESSION['userid']=$user[0]['Id'];
                $this->view->SuccessMessage = "Successfully logged in!";
                header("Location:" . URL . 'index/');
            }
            else{
                //$this->view->ErrorMessage = "Wrong password!";\
                $_SESSION['error_message']="Wrong password!";
                //sleep(3);
                //header("Location:" . URL . 'login/index');
            }
			$this->view->render('login/result');
		}
	}

	function register(){
		if(isset($_POST['username']) && isset($_POST['passwd'])&&isset($_POST['name'])&&isset($_POST['date'])&&isset($_POST['country'])) {
            $exists=new \pet4web\UsersQuery();
            if(empty($_POST['username'])||empty($_POST['passwd'])||empty($_POST['name']||empty($_POST['date'])||empty($_POST['country']))){
                $_SESSION["error_message"] = "Please specify register details!";
                header("Location:" . URL . 'login/register');
            }
            else {
                if (!empty($exists->findByEmail($_POST['username'])->getData())) {
                    $_SESSION["error_message"] = "Already registered.";
                    header("Location:" . URL . 'login/register');
                } else {
                    $model = new \pet4web\Users();
                    $model->setEmail($_POST['username']);
                    $model->setPassword(password_hash($_POST['passwd'], PASSWORD_DEFAULT));
                    $model->setName($_POST['name']);
                    $model->setBirth($_POST['date']);
                    $model->setType('user');
                    $model->setCountry($_POST['country']);
                    if ($model->save()) {
                        $_SESSION['logg_in'] = true;
                        $_SESSION['userid']=$model->getId();
                        $_SESSION["success_message"] = "Successfully registered.";
                           header("Location:" . URL);
                    }
                }
            }
        }
		else{
			$this->view->render('login/register');
		}
	}
}