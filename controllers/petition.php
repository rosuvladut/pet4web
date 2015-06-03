<?php

class Petition extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index($page = '')
    {
//        var_dump($_GET);
//        var_dump($_SERVER);
//        die();
        $model = new \pet4web\PetitionsQuery();
        if (!empty($_GET['page']))
            $page = $_GET['page'];
        else
            $page = 1;
        $pages = $model->paginate($page, 10);
        if(isset($_GET['sort'])) {
            switch($_GET['sort']){
                case "byname":
                    $pages=$model->orderByTitle()->paginate($page,10);
                    break;
                case "bycatasc":
                    $pages = $model->orderByCategory()->paginate($page, 10);
                    break;
                case "bycatdesc":
                    $pages = $model->orderByCategory('desc')->paginate($page, 10);
                    break;
                case "bysignasc":
                    $pages = $model->orderBySigned()->paginate($page, 10);
                    break;
                case "bysigndesc":
                    $pages = $model->orderBySigned('desc')->paginate($page, 10);
                    break;
                case "bytargetdesc":
                    $pages = $model->orderByTarget('desc')->paginate($page, 10);
                    break;
                case "bytargetasc":
                    $pages = $model->orderByTarget()->paginate($page, 10);
                    break;
                case "bydateasc":
                    $pages = $model->orderByCreated()->paginate($page, 10);
                    break;
                case "bydatedesc":
                    $pages = $model->orderByCreated('desc')->paginate($page, 10);
                    break;
            }
        }
        else{
            $pages = $model->orderByCreated('desc')->paginate($page, 10);
        }
        if ($pages->haveToPaginate()) {
            $links = $pages->getLinks();
            $this->view->pages = $links;
            $this->view->pagesExist = true;
        } else {
            $this->view->pagesExist = false;
        }
        //$nrpages=ceil($pages->getNbResults()/1);
        //var_dump($nrpages);
        //die();
        $this->view->data = $pages->getResults()->getData();
        $this->view->render('petition/petitions');
    }

    function sign($petid)
    {
        //$userModel=new \pet4web\Signatures();
        $sign = new \pet4web\Signatures();
        $petdet = new \pet4web\PetitionsQuery();
        $islogged = isset($_SESSION['logg_in']) ? $_SESSION['logg_in'] : NULL;
        //var_dump($islogged);
        if (!empty($_POST)) {
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
        header("Location:" . URL . 'petition/petitiondetail/' . $petid);
    }

    function petitiondetail($petid)
    {
        $model = new \pet4web\PetitionsQuery();
        $comm = new \pet4web\Comments();
        $comms = new \pet4web\CommentsQuery();
        $sign = new \pet4web\SignaturesQuery();
        //var_dump($sign->find());
        if (isset($_SESSION['logg_in']) && !is_null($sign->joinUsers()->select('Users.id')->where('Users.id=?', $_SESSION['userid'])->findOne()) &&
            !is_null($sign->joinPetitions()->select('Petitions.id')->where('Petitions.id=?', $petid)->findOne())
        ) {
            $this->view->signed = true;
        } else {
            $this->view->signed = false;
        }
        if (isset($_POST['content'])) {
            if (empty($_POST['content'])) {
                $_SESSION['error_message'] = "Comment can't be empty!";
            } else {
                $logged=isset($_SESSION['logg_in'])?$_SESSION['logg_in']:NULL;
                if (!empty($logged) || $logged == true) {
                    $comm->setUserid($_SESSION['userid']);
                    $comm->setMessage($_POST['content']);
                    $comm->setPetid($petid);
                    if ($comm->save())
                        $_SESSION['success_message'] = "Your comment has been posted!";
                } else {
                    $_SESSION['error_message'] = "You must be logged in to post a new comment!";
                }
            }
        }
        $pet = $model->findOneById($petid);
        //var_dump($comms->findByPetid($petid)->toArray()[0]['Userid']);

        $this->view->data = $pet;

        //Petition comments
        $comments = $comms->findByPetid($petid)->toArray();
        if (!empty($comments)) {
            $postedby = $comms->join('Users')->select('Users.name')->find()->getData();
            foreach ($comments as $row) {
                $a[] = $row['Message'];
            }
            $commentsdata = array_combine($a, $postedby);
            $this->view->comms = $commentsdata;
        }
        //search who started petition
        $usermodel = new \pet4web\UsersQuery();
        $this->view->startedpet = $usermodel->findOneById($pet->getUserid());

        $this->view->render('petition/petition');
    }

    function newpetition()
    {
        if (empty($_SESSION['logg_in'])) {
            $_SESSION["error_message"] = "Please login to create a new petition!";
            header("Location:" . URL . 'login/index');
        } else {
            //echo $_SESSION['userid'];
            //die();
            if (isset($_POST['name']) && isset($_POST['message']) && isset($_POST['category']) && isset($_POST['target'])) {
                if (empty($_POST['name']) || empty($_POST['message']) || empty($_POST['category']) || empty($_POST['target'])) {
                    $_SESSION["error_message"] = "All forms are required!";
                    header("Location:" . URL . 'petition/newpetition');
                } else {
                    $model = new \pet4web\Petitions();
                    $model->setTitle($_POST['name']);
                    $model->setMessage($_POST['message']);
                    $model->setState('active');
                    $model->setTarget($_POST['target']);
                    $model->setSigned(0);
                    $model->setUserid($_SESSION['userid']);
                    $model->setCategory($_POST['category']);
                    $model->setCreated(time());
                    if ($model->save()) {
                        $_SESSION["success_message"] = "New petition successfully created!";
                        header("Location:" . URL . 'petition/index');
                    }
                }
            } else {
                $this->view->render('petition/newpetition');
            }
        }
    }

    public function delete($petid = '')
    {
        if (isset($_SESSION['logg_in']) && $_SESSION['logg_in']) {
            $petmodel = new \pet4web\PetitionsQuery();

            $pet = $petmodel->filterById($petid)->findOne();

            //deletes signatures for selected petition
            $sign = new \pet4web\SignaturesQuery();
            $sign = $sign->filterByPetid($petid)->find()->getData();
            foreach ($sign as $row) {
                $row->delete();
            };

            $comms=new \pet4web\CommentsQuery();
            $comms=$comms->filterByPetid($petid)->find()->getData();
            foreach ($comms as $comm)
            {
                $comm->delete();
            };
//            var_dump($comms);
//            die();
            if(!empty($pet)) {
                $pet->delete();
                if ($pet->isDeleted()) {
                    $_SESSION['success_message'] = "Petition successfully deleted!";
                } else {
                    $_SESSION['error_message'] = "Petition couldn't be deleted!";
                }
            }
            header("Location:" . URL . 'myaccount/index');
        } else {
            $_SESSION['error_message'] = "Please login to access your account!";
            header("Location:" . URL . 'login/index');
        }
    }

    function edit($petid = '')
    {
        if (isset($_SESSION['logg_in']) && $_SESSION['logg_in']) {
            $pet = new \pet4web\PetitionsQuery();
            $pet = $pet->filterById($petid)->findOne();
            $this->view->data = $pet;
            if (isset($_POST['name'])&&!empty($_POST['name'])) {
                $pet->setTitle($_POST['name']);
            }
            if (isset($_POST['message'])&&!empty($_POST['message'])) {
                $pet->setMessage($_POST['message']);
            }
            if (isset($_POST['target'])&&!empty($_POST['target'])) {
                $pet->setTarget($_POST['target']);
            }
            if (isset($_POST['category'])&&!empty($_POST['category'])) {
                $pet->setCategory($_POST['category']);
            }
            if (!empty($pet)&&$pet->save()) {
                $_SESSION["success_message"] = "Petition successfully edited!";
            }
            $this->view->render('petition/editpetition');
        }
    }
}