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
            $export=isset($_POST['exported'])?$_POST['exported']:NULL;
            if($export) {
//                var_dump($_POST);
//                die();
                //print_r($petmodel->orderByTitle()->find()->toCSV());
                if(isset($_POST['exportorder'])) {
                    switch($_POST['exportorder']){
                        case "byname":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByTitle()->find()->toCSV());
                            break;
                        case "bycatasc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByCategory()->find()->toCSV());
                            break;
                        case "bycatdesc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByCategory('desc')->find()->toCSV());
                            break;
                        case "bysignasc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderBySigned()->find()->toCSV());
                            break;
                        case "bysigndesc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderBySigned('desc')->find()->toCSV());
                            break;
                        case "bytargetdesc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByTarget('desc')->find()->toCSV());
                            break;
                        case "bytargetasc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByTarget()->find()->toCSV());
                            break;
                        case "bydateasc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByCreated()->find()->toCSV());
                            break;
                        case "bydatedesc":
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByCreated('desc')->find()->toCSV());
                            break;
                        default:
                            header('Content-Type: text/csv; charset=utf-8');
                            header('Content-Disposition: attachment; filename=petitiondata.csv');
                            print_r($petmodel->orderByCreated('desc')->find()->toCSV());
                    }
                }
                die();
            }
            $petmodel = new \pet4web\PetitionsQuery();
            $petitionpages = $petmodel->paginate($petpage, 10);
            if(isset($_GET['sort'])) {
                switch($_GET['sort']){
                    case "byname":
                        $petitionpages=$petmodel->orderByTitle()->paginate($petpage,10);
                        break;
                    case "bycatasc":
                        $petitionpetpages = $petmodel->orderByCategory()->paginate($petpage, 10);
                        break;
                    case "bycatdesc":
                        $petitionpages = $petmodel->orderByCategory('desc')->paginate($petpage, 10);
                        break;
                    case "bysignasc":
                        $petitionpages = $petmodel->orderBySigned()->paginate($petpage, 10);
                        break;
                    case "bysigndesc":
                        $petitionpages = $petmodel->orderBySigned('desc')->paginate($petpage, 10);
                        break;
                    case "bytargetdesc":
                        $petitionpages = $petmodel->orderByTarget('desc')->paginate($petpage, 10);
                        break;
                    case "bytargetasc":
                        $petitionpages = $petmodel->orderByTarget()->paginate($petpage, 10);
                        break;
                    case "bydateasc":
                        $petitionpages = $petmodel->orderByCreated()->paginate($petpage, 10);
                        break;
                    case "bydatedesc":
                        $petitionpages = $petmodel->orderByCreated('desc')->paginate($petpage, 10);
                        break;
                }
            }
            else{
                $petitionpages = $petmodel->orderByCreated('desc')->paginate($petpage, 10);
            }
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