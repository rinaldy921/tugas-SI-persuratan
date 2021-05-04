<?php

class ProgresTataBatasController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'create', 'update', 'delete','getKeterangan'),
                'users' => array(Yii::app()->user->perusahaanRole()),
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
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionIndex() {
        // die("asd");
        $model = new ProgresTataBatas('search');
        // if (empty($model))
        //  $this->redirect(array('create'));
//            $model = array();
        $model->id_perusahaan = Yii::app()->user->idPerusahaan();
        
        

//        
//        
//        
        
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionGetKeterangan(){
        $idKet = $_POST['idKet'];
        
        
        $mstrTataBatas = MasterKetProgresTataBatas::model()->findAllByAttributes(array('id_progres_tata_batas'=>$idKet));
        $data=array();
        $data['status']=0;
        
        $res = array();
        $index=0;
        foreach($mstrTataBatas as $item){
            $res['id'] = $item->id_ket_progres;
            $res['ket'] = $item->nama_ket_progres;
            
            $data['data'][$index] = $res;
            $index++;
        }
        
        if($index>0){
 //           $data['result'] = $data;
            $data['status']=1;
        }
        
////        
//       print_r("<pre>");
//        print_r($data);
//        print_r("</pre>"); 
      
//        
        
        
        echo json_encode($data);
        die();
    }
    
    
    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new ProgresTataBatas;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";
        
            if (isset($_POST['ProgresTataBatas'])) {
            $model->attributes = $_POST['ProgresTataBatas'];
            $model->id_perusahaan = Yii::app()->user->idPerusahaan();
            
            $file_error = 0;
            if ($_FILES["pdf_progres_TB"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_progres_TB']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_progres_TB');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "progres_TB_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Dokumen Tata Batas harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
                    $message = Yii::t('app', 'Data berhasil disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                }
                else {
                    $message = Yii::t('app', 'Data Gagal disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                }
            }
        }
        
        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        
        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        if(isset($_POST['ProgresTataBatas']))
        {
            $model->attributes=$_POST['ProgresTataBatas'];
            $file_error = 0;
            if ($_FILES["pdf_progres_TB"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_progres_TB']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_progres_TB');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "progres_TB_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Dokumen Tata Batas harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
                    $message = Yii::t('app', 'Data berhasil disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                }
                else {
                    $message = Yii::t('app', 'Data Gagal disimpan.');
                    Yii::app()->user->setFlash('success', $message);
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'id_ganis' => $id_ganis
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all latest models.
     */
    public function actionLatest()
    {
        $this->layout = false;
        $dataProvider=new CActiveDataProvider('ProgresTataBatas');
        $dataProvider->criteria->order = 'id DESC';
        $dataProvider->criteria->limit = 4;
        $dataProvider->pagination = false;
        $this->render('latest',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Lists all models.
     */
    // public function actionIndex()
    // {
    //  $model=new IuphhkLaporanKeuangan('search');
    //  $model->unsetAttributes();  // clear any default values
    //  if(isset($_GET['IuphhkLaporanKeuangan']))
    //      $model->attributes=$_GET['IuphhkLaporanKeuangan'];
    //
    //  $this->render('index',array(
    //      'model'=>$model,
    //  ));
    // }

    /**
     * Lists all models.
     */
    public function actionList()
    {
        $dataProvider=new CActiveDataProvider('ProgresTataBatas');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new ProgresTataBatas('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ProgresTataBatas']))
            $model->attributes=$_GET['ProgresTataBatas'];

       
        
        
        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return IuphhkLaporanKeuangan the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=ProgresTataBatas::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param IuphhkLaporanKeuangan $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='progres-tata-batas-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
