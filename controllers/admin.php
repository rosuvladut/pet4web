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
                if(isset($_POST['exportorder'])&&$_POST['export']=='csv') {
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
                    die();
                }
                else if(isset($_POST['exportorder'])&&$_POST['export']=='pdf') {
                    try
                    {
                        switch($_POST['exportorder']){
                            case "byname":
                                $html=file_get_contents(URL."export/index?sort=byname");
                                break;
                            case "bycatasc":
                                $html=file_get_contents(URL."export/index?sort=bycatasc");
                                break;
                            case "bycatdesc":
                                $html=file_get_contents(URL."export/index?sort=bycatdesc");
                                break;
                            case "bysignasc":
                                $html=file_get_contents(URL."export/index?sort=bysignasc");
                                break;
                            case "bysigndesc":
                                $html=file_get_contents(URL."export/index?sort=bysigndesc");
                                break;
                            case "bytargetdesc":
                                $html=file_get_contents(URL."export/index?sort=bytargetdesc");
                                break;
                            case "bytargetasc":
                                $html=file_get_contents(URL."export/index?sort=bytargetasc");
                                break;
                            case "bydateasc":
                                $html=file_get_contents(URL."export/index?sort=bydateasc");
                                break;
                            case "bydatedesc":
                                $html=file_get_contents(URL."export/index?sort=bydatedesc");
                                break;
                            default:
                                $html=file_get_contents(URL."export/index?sort=byname");
                        }
//
                        // create an API client instance
                        $client = new Pdfcrowd("visy199", "acb72a42ef66c540da6a41a2e3eaa3ba");

                        // convert a web page and store the generated PDF into a $pdf variable
                        $pdf = $client->convertHtml($html);

                        // set HTTP response headers
                        header("Content-Type: application/pdf");
                        header("Cache-Control: max-age=0");
                        header("Accept-Ranges: none");
                        header("Content-Disposition: attachment; filename=\"petitions.pdf\"");

                        // send the generated PDF
                        echo $pdf;
                    }
                    catch(PdfcrowdException $why)
                    {
                        echo "Pdfcrowd Error: " . $why;
                    }
                    die();
                }
                else{
                    $model=new \pet4web\PetitionsQuery();
                    switch($_POST['exportorder']){
                        case "byname":
                            $pets=$model->orderByTitle()->find()->getData();
                            break;
                        case "bycatasc":
                            $pets = $model->orderByCategory()->find()->getData();
                            break;
                        case "bycatdesc":
                            $pets = $model->orderByCategory('desc')->find()->getData();
                            break;
                        case "bysignasc":
                            $pets = $model->orderBySigned()->find()->getData();
                            break;
                        case "bysigndesc":
                            $pets = $model->orderBySigned('desc')->find()->getData();
                            break;
                        case "bytargetdesc":
                            $pets = $model->orderByTarget('desc')->find()->getData();
                            break;
                        case "bytargetasc":
                            $pets = $model->orderByTarget()->find()->getData();
                            break;
                        case "bydateasc":
                            $pets = $model->orderByCreated()->find()->getData();
                            break;
                        case "bydatedesc":
                            $pets = $model->orderByCreated('desc')->find()->getData();
                            break;
                        default:
                            $pets=$model->orderByCreated('desc')->find()->getData();
                    }
                    $filename = 'petitions.phtml';
                    header('Content-disposition: attachment; filename=' . $filename);
                    header('Content-type: text/html');
                    $this->view->data = $pets;
                    $this->view->render('export/html');
                    die();
                }
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