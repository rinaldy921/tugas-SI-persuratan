<?php

class PersetujuanGanisController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index','setujuiGanis','tolakGanis'),
                'users' => array(Yii::app()->user->adminRole()),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */

    /**
     * Manages all models.
     */

    public function actionIndex() {
        
        $usulanGanis = new SertifikatGanis('searchUsulanGanis');
        $usulanGanis->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikatGanis']))
            $usulanGanis->attributes = $_GET['SertifikatGanis'];
        
        $usulanGanis->id_bphp = Yii::app()->user->findUser()->id_bphp;
        
//            $usulanGanis = $usulanGanis->searchUsulanGanis();

        $ganisSetuju = new SertifikatGanis('searchGanisSetujui');
        $ganisSetuju->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikatGanis']))
            $ganisSetuju->attributes = $_GET['SertifikatGanis'];
        
        $ganisSetuju->id_bphp = Yii::app()->user->findUser()->id_bphp;
//        $ganisSetuju = $ganisSetuju->searchGanisSetujui();
        
        $ganisTolak = new SertifikatGanis('searchGanisTolak');
        $ganisTolak->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikatGanis']))
            $ganisTolak->attributes = $_GET['SertifikatGanis'];
        
        $ganisTolak->id_bphp = Yii::app()->user->findUser()->id_bphp;
//        $ganisTolak = $ganisTolak->searchGanisTolak();
        
        $this->render('index', array(
            'usulanGanis' => $usulanGanis,
            'ganisSetuju' => $ganisSetuju,
            'ganisTolak' => $ganisTolak,
        ));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function loadModel($id) {
        $model = PerusahaanCabang::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    
    
    
    //--------------SERTIFIKASI GANIS APPROVE BY BPHP
    
     public function actionSetujuiGanis($id) {         
        if($id != ''){
            $resData = SertifikatGanis::model()->findByPk((int)$id);
            
//             print_r("<pre>");       print_r($resData); print_r("</pre>"); die(); 
            
            
            if(isset($resData)){
                $resData->approval_status = 1;
                
                $resData->update();
            }
        }
        
        $data = array(
            'header' => "Sukses",
            'message' => "Data Ganis Disetujui",
            'status' => "success"
        );
        
        $this->redirect(array('#'));
    }
    
    public function actionTolakGanis($id) {
        if($id != ''){
            $resData = SertifikatGanis::model()->findByPk($id);
            if(isset($resData)){
                $resData->approval_status = 2;
                
                $resData->update();
            }
        }
        
        $data = array(
            'header' => "Sukses",
            'message' => "Data Ganis Ditolak",
            'status' => "success"
        );
        $this->redirect(array('#'));
    }
}


