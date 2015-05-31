<?php

class Petition extends Controller{
    function __construct(){
        parent::__construct();
    }

    function index($page=''){
        $model=new \pet4web\PetitionsQuery();
        if(!empty($_GET['page']))
            $page=$_GET['page'];
        else
            $page=1;
        $pages=$model->paginate($page,5);
        //var_dump($pages->getLinks());
        //die();
        if($pages->haveToPaginate()) {
            $links = $pages->getLinks();
            $this->view->pages = $links;
            $this->view->pagesExist=true;
        }
        else{
            $this->view->pagesExist=false;
        }
        //var_dump($pages->getResults()->getData());
        $this->view->data=$pages->getResults()->getData();
        $this->view->render('petition/petitions');
    }
    function sign($petid){
        //$userModel=new \pet4web\Signatures();
        $sign=new \pet4web\Signatures();
        $petdet=new \pet4web\PetitionsQuery();
        $islogged=isset($_SESSION['logg_in'])?$_SESSION['logg_in']:NULL;
        //var_dump($islogged);
        if(!empty($_POST)) {
            if ($islogged) {
                $petsigns = $petdet->findOneById($petid)->toArray();
                $petdet = $petdet->findOneById($petid);
                $petdet->setSigned($petsigns['Signed'] + 1);
                $sign->setSigned(true);
                $sign->setUserid($_SESSION['userid']);
                $sign->setPetid($petid);
                //$pet->setSigned($petdet[0]->getSigned()+1);
                if ($sign->save() && $petdet->save()) {
                    $_SESSION['success_message'] = "Your vote has been submited!";
                }
            } else {
                $_SESSION['error_message'] = "Please login to sign for this petition!";
            }
        }
        header("Location:" . URL . 'petition/petitiondetail/'.$petid);
    }

    function petitiondetail($petid){
        $model=new \pet4web\PetitionsQuery();
        $comm=new \pet4web\Comments();
        $comms=new \pet4web\CommentsQuery();
        $sign=new \pet4web\SignaturesQuery();
        //var_dump($sign->find());
        if(isset($_SESSION['logg_in'])&&!is_null($sign->joinUsers()->select('Users.id')->where('Users.id=?',$_SESSION['userid'])->findOne())&&
            !is_null($sign->joinPetitions()->select('Petitions.id')->where('Petitions.id=?',$petid)->findOne())){
                $this->view->signed=true;
        }
        else{
            $this->view->signed=false;
        }
        if(isset($_POST['content'])) {
            if(empty($_POST['content'])) {
                $_SESSION['error_message'] = "Comment can't be empty!";
            }
            else {
                if(!empty($_SESSION['logg_in'])||$_SESSION['logg_in']==true){
                    $comm->setUserid($_SESSION['userid']);
                    $comm->setMessage($_POST['content']);
                    $comm->setPetid($petid);
                    if($comm->save())
                        $_SESSION['success_message']="Your comment has been posted!";
                }
                else {
                    $_SESSION['error_message']="You must be logged in to post a new comment!";
                }
            }
        }
        $pet=$model->findById($petid)->toArray();
        //var_dump($comms->findByPetid($petid)->toArray()[0]['Userid']);
        $this->view->data=$pet;

        //Petition comments
        $comments=$comms->findByPetid($petid)->toArray();
        if(!empty($comments)) {
            $postedby = $comms->join('Users')->select('Users.name')->find()->getData();
            foreach ($comments as $row) {
                $a[] = $row['Message'];
            }
            $commentsdata = array_combine($a, $postedby);
            $this->view->comms = $commentsdata;
        }
        $usermodel=new \pet4web\UsersQuery();
        $this->view->startedpet=$usermodel->findById($pet[0]['Userid'])->getData();

        $this->view->render('petition/petition');
    }

    function newpetition(){
        if(empty($_SESSION['logg_in'])){
            $_SESSION["error_message"] = "Please login to create a new petition!";
            header("Location:" . URL . 'login/index');
        }
        else{
            //echo $_SESSION['userid'];
            //die();
            if(isset($_POST['name'])&&isset($_POST['message'])&&isset($_POST['category'])&&isset($_POST['target'])) {
                if (empty($_POST['name']) || empty($_POST['message']) || empty($_POST['category'])||empty($_POST['target'])) {
                    $_SESSION["error_message"] = "All forms are required!";
                    header("Location:" . URL . 'petition/newpetition');
                }
                else{
                    $model=new \pet4web\Petitions();
                    $model->setTitle($_POST['name']);
                    $model->setMessage($_POST['message']);
                    $model->setState('active');
                    $model->setTarget($_POST['target']);
                    $model->setSigned(0);
                    $model->setUserid($_SESSION['userid']);
                    $model->setCategory($_POST['category']);
                    if($model->save()){
                        $_SESSION["success_message"] = "New petition successfully created!";
                        header("Location:" . URL . 'petition/index');
                    }
                }
            }
            else{
                $this->view->render('petition/newpetition');
            }
        }
    }

    public function delete($petid=''){
        if (isset($_SESSION['logg_in']) && $_SESSION['logg_in']){
            $petmodel=new \pet4web\PetitionsQuery();
            $pet=$petmodel->filterById($petid)->findOneByUserid($_SESSION['userid']);

            $sign=new \pet4web\SignaturesQuery();
            $sign=$sign->filterByPetid($petid)->find()->getData();
            foreach($sign as $row){
                $row->delete();
            };
            $pet->delete();
            if($pet->isDeleted()){
                $_SESSION['success_message']="Petition successfully deleted!";
            }
            else{
                $_SESSION['error_message']="Petition couldn't be deleted!";
            }
            header("Location:" . URL . 'myaccount/index');
        }
        else {
            $_SESSION['error_message'] = "Please login to access your account!";
            header("Location:" . URL . 'login/index');
        }
    }
}