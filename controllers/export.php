<?php
class Export extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        $sort=isset($_GET['sort'])?$_GET['sort']:NULL;
        $model=new \pet4web\PetitionsQuery();
        if(!is_null($sort)) {
            switch ($sort) {
                case "byname":
                    $pets = $model->orderByTitle()->find()->getData();
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
                    $pets = $model->orderByCreated('desc')->find()->getData();
            }
        }
        else{
            $pets=$model->orderByCreated('desc')->find()->getData();
        }
        $this->view->data = $pets;
        $this->view->render('export/html');
    }
}