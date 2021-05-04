<?php

class SertifikasiController extends Controller {

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
                'actions' => array('index', 'view','doApproveSertifikat',
                            'unApproveSertifikat','kelolaSertifikatGanis',
                            'aktifasiphpl','aktifasivlk','batalaktifasiphpl','batalaktifasivlk',
                            'doblokirsertifikatphpl','doblokirsertifikatsvlk'),
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

    public function actionIndex($id) {
        $iuphhk = Iuphhk::model()->findByPk($id);

        $model = Perusahaan::model()->find(array('condition' => 'id_perusahaan=' . $iuphhk->id_perusahaan));
        if (empty($iuphhk))
            $model = new Perusahaan;

        $sertifikasiPhpl = new SertifikasiPhpl('search');
        $sertifikasiPhpl->unsetAttributes();
        $sertifikasiPhpl->id_perusahaan = $model->id_perusahaan;

        $sertifikasiVlk = new SertifikasiVlk('search');
        $sertifikasiVlk->unsetAttributes();
        $sertifikasiVlk->id_perusahaan = $model->id_perusahaan;


        // print_r("<pre>");
        // print_r($perusahaanCabang);
        // print_r("</pre>");

        $this->render('index', array(
            'model' => $model,
            'iuphhk' => $iuphhk,
            'sertifikasiPhpl' => $sertifikasiPhpl,
            'sertifikasiVlk' => $sertifikasiVlk,
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
    
     public function actionDoApproveSertifikat($id) {         
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
            'message' => "RKT Telah Di Setujui",
            'status' => "success"
        );
        
        $this->redirect(array('kelolaSertifikatGanis'));
    }
    
    
    //--------------SERTIFIKASI GANIS APPROVE BY BPHP
    
     public function actionDoblokirsertifikatPhpl($id) {         
         $sertifikatphpl = SertifikasiPhpl::model()->findByPk($id);
         $sertifikatphpl->is_verified = 2;  
         $sertifikatphpl->update($id, $sertifikatphpl);
         
         $iuphhk = Iuphhk::model()->findAllByAttributes(array('id_perusahaan'=>$sertifikatphpl['id_perusahaan']));
                         
        $data = array(
            
            'message' => "Sertifikat berhasil di bekukan",
            'status' => "success"
        );
        
        $this->redirect(array('sertifikasi/index','id'=>$iuphhk['0']['id_iuphhk']));    
    }
    
    public function actionDoblokirsertifikatsvlk($id) {         
         $sertifikatphpl = SertifikasiVlk::model()->findByPk($id);
         $sertifikatphpl->is_verified = 2;  
         $sertifikatphpl->update($id, $sertifikatphpl);
         
         $iuphhk = Iuphhk::model()->findAllByAttributes(array('id_perusahaan'=>$sertifikatphpl['id_perusahaan']));
                         
        $data = array(
            
            'message' => "Sertifikat berhasil di bekukan",
            'status' => "success"
        );
        
        $this->redirect(array('sertifikasi/index','id'=>$iuphhk['0']['id_iuphhk']));    
    }
    
    
    
    
    public function actionUnApproveSertifikat($id) {
        if($id != ''){
            $resData = SertifikatGanis::model()->findByPk($id);
            if(isset($resData)){
                $resData->approval_status = 0;
                
                $resData->update();
            }
        }
        
        $data = array(
            'header' => "Sukses",
            'message' => "RKT Telah Di Setujui",
            'status' => "success"
        );
        $this->redirect(array('kelolaSertifikatGanis'));
    }
   
    public function actionKelolaSertifikatGanis() {
        
        $toApprove = new SertifikatGanis('searchToApprove');
        $toApprove->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikatGanis']))
          $toApprove->attributes = $_GET['SertifikatGanis'];
          $toApprove->id_bphp = Yii::app()->user->findUser()->id_bphp;
          $toApprove = $toApprove->searchToApprove();

        $toUnApprove = new SertifikatGanis('searchToUnApprove');
        $toUnApprove->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikatGanis']))
            $toUnApprove->attributes = $_GET['SertifikatGanis'];
        $toUnApprove->id_bphp = Yii::app()->user->findUser()->id_bphp;
        $toUnApprove = $toUnApprove->searchToUnApprove();
        
        $this->render('kelolaSertifikat/index_tab', array(
            'toApprove' => $toApprove,
            'toUnApprove' => $toUnApprove,
        ));
    }
    
    
    
    /**
     * created by : Dian Purnomo
     * date : 27 February 2019
     * @param type $idRKU
     */
    public function actionAktifasiphpl($id){
         $sertifikatphpl = SertifikasiPhpl::model()->findByPk($id);
         $sertifikatphpl->is_verified = 1;  
         $sertifikatphpl->update($id, $sertifikatphpl);
         
         $iuphhk = Iuphhk::model()->findAllByAttributes(array('id_perusahaan'=>$sertifikatphpl['id_perusahaan']));
         
//         print_r("<pre>");
//         print_r($iuphhk['0']['id_iuphhk']);
//         print_r("</pre>");
//         exit(1);
                
        $data = array(
            
            'message' => "Data Berhasil Di Verifikasi",
            'status' => "success"
        );
        
        $this->redirect(array('sertifikasi/index','id'=>$iuphhk['0']['id_iuphhk']));
        //return json_encode($data);
        //die();
    }
    
    
    /**
     * created by : Dian Purnomo
     * date : 27 February 2019
     * @param type $idRKU
     */
    public function actionBatalaktifasiphpl($id){
         $sertifikatphpl = SertifikasiPhpl::model()->findByPk($id);
         $sertifikatphpl->is_verified = 0;  
         $sertifikatphpl->update($id, $sertifikatphpl);
         
         $iuphhk = Iuphhk::model()->findAllByAttributes(array('id_perusahaan'=>$sertifikatphpl['id_perusahaan']));
                         
        $data = array(
            
            'message' => "Data Berhasil Di Verifikasi",
            'status' => "success"
        );
        
        $this->redirect(array('sertifikasi/index','id'=>$iuphhk['0']['id_iuphhk']));
        //return json_encode($data);
        //die();
    }
    
    
     /**
     * created by : Dian Purnomo
     * date : 27 February 2019
     * @param type $idRKU
     */
    public function actionAktifasivlk($id){
         $sertifikat = SertifikasiVlk::model()->findByPk($id);
         $sertifikat->is_verified = 1;  
         $sertifikat->update($id, $sertifikat);
         
         $iuphhk = Iuphhk::model()->findAllByAttributes(array('id_perusahaan'=>$sertifikat['id_perusahaan']));
          
//         print_r("<pre>");
//         print_r($iuphhk['0']['id_iuphhk']);
//         print_r("</pre>");
//         exit(1);
         
        $data = array(
            
            'message' => "Data Berhasil Di Verifikasi",
            'status' => "success"
        );
        
        $this->redirect(array('sertifikasi/index','id'=>$iuphhk['0']['id_iuphhk']));
        //return json_encode($data);
        //die();
    }
    
    
    /**
     * created by : Dian Purnomo
     * date : 27 February 2019
     * @param type $idRKU
     */
    public function actionBatalaktifasivlk($id){
         $sertifikat = SertifikasiVlk::model()->findByPk($id);
         $sertifikat->is_verified = 0;  
         $sertifikat->update($id, $sertifikat);
         
          $iuphhk = Iuphhk::model()->findAllByAttributes(array('id_perusahaan'=>$sertifikat['id_perusahaan']));
        
//         print_r("<pre>");
//         print_r($iuphhk['0']['id_iuphhk']);
//         print_r("</pre>");
//         exit(1);
         
         
        $data = array(
            
            'message' => "Data Berhasil Di Verifikasi",
            'status' => "success"
        );
        
        $this->redirect(array('sertifikasi/index','id'=>$iuphhk['0']['id_iuphhk']));
        //return json_encode($data);
        //die();
    }
    
    
//    public function actionKelolaSertifikatGanis() {
//        $model = new SertifikatGanis('searchToApprove');
//        $model->unsetAttributes();
//        //$tahun = 2018;  //default
//        
//        
////        if (isset($_GET['Rkt'])){
////            $model->attributes = $_GET['Rkt'];
////        }
////        if (isset($_POST['tahun'])){
////            $tahun = $_POST['tahun'];
////        }
//        $model->id_bphp = Yii::app()->user->findUser()->id_bphp;
////        $model->tahun_ke=$tahun;
//        
//        $model = $model->searchToApprove();
//        
////        
////        print_r("<pre>");
////        print_r($model);
////        print_r("</pre>");
////        die();
//        
//        
//        $this->render('kelolaSertifikat/index_tab', array(
//            'model' => $model,
////            'tahun' => $tahun,
//        ));
//    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
}
