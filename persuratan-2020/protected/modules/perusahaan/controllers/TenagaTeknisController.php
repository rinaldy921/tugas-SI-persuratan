<?php

class TenagaTeknisController extends Controller {

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

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'create', 'delete', 'view',
                    'ganisphpl', 'AddGanisPHPL', 'DeleteGanisPHPL',
                ),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new IuphhkTenagaKerja;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        if (isset($_POST['IuphhkTenagaKerja'])) {
            $model->attributes = $_POST['IuphhkTenagaKerja'];

            $file_error = 0;
            if ($_FILES["pdf_sertifikat_ganis"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_sertifikat_ganis']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_sertifikat_ganis');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Sertifikat_GANIS_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Sertifikat GANIS harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
                    
                    if($model->is_aktif == 0){
                    $model->tgl_keluar = NULL;
                    }
                    
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
//            
//            if ($file_error == 0) {
//                
//                if($model->is_aktif == 0){
//                    $model->tgl_keluar = NULL;
//                }
//                
//                if ($model->save()) {
//                    $message = Yii::t('app', 'Data berhasil disimpan.');
//                    Yii::app()->user->setFlash('success', $message);
//                    $this->redirect(array('index'));
//                }
//            } else {
//                $message = Yii::t('app', 'Data Gagal disimpan, Karena File Gagal Diupload. ' . $msg);
//                Yii::app()->user->setFlash('success', $message);
//                $this->redirect(array('index'));
//            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        if (isset($_POST['IuphhkTenagaKerja'])) {
            $model->attributes = $_POST['IuphhkTenagaKerja'];

            $file_error = 0;
            if ($_FILES["pdf_sertifikat_ganis"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_sertifikat_ganis']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_sertifikat_ganis');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Sertifikat_GANIS_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Sertifikat GANIS harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
                    
                    if($model->is_aktif == 0){
                    $model->tgl_keluar = NULL;
                    }                    
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

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDeleteGanisPHPL($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $model = SertifikatGanis::model()->findByPk($id)->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    

    public function actionAddGanisPHPL($id) {
        $modelSertifikat = IuphhkTenagaKerja::model()->findByPk($id);
        
        $id_ganis = isset($_GET['id_ganis']) ? $_GET['id_ganis'] : "";
        if ($id_ganis != "") {
            $model = SertifikatGanis::model()->findByPk($id_ganis);
        } else {
            $model = new SertifikatGanis;
        }

        $buton_hide = false;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        if (isset($_POST['SertifikatGanis'])) {
            $model->attributes = $_POST['SertifikatGanis'];
            $model->id_iuphhk_tenaga_kerja = $modelSertifikat->id;
            // var_dump($model);die();

            $file_error = 0;
            if ($_FILES["pdf_sim_ganis"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_sim_ganis']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_sim_ganis');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "SIM_GANIS_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_reg = $new_path;
                } else {
                    $file_error++;
                    $msg = Yii::t('app', 'Type File SIM GANIS harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
            
            if ($_FILES["pdf_sk_ganis"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_sk_ganis']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_sk_ganis');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);

                $new_name1 = "SK_GANIS_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) .$new_path1;
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->file_sk = $new_path1;
                } else {
                    $file_error++;
                    $msg = Yii::t('app', 'Type File SK GANIS harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
            
//                        print_r($model); die();

            if ($file_error == 0) {
//                print_r($model); die();
                
                if ($model->save()) {
//                    $modelcek = SertifikatGanis::model()->findAllByAttributes(array('id_iuphhk_tenaga_kerja' => $model->id_iuphhk_tenaga_kerja));
//                    if (count($modelcek) == 4) {
//                        $buton_hide = true;
//                    }

                    $data = array(
                        'header' => "Success",
                        "message" => "Data berhasil disimpan",
                        'status' => "success",
                        'buton_hide' => $buton_hide
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Data gagal disimpan " . $msg,
                        'status' => "error",
                        'buton_hide' => $buton_hide
                    );
                }
            } else {
                $data = array(
                    'header' => "Error",
                    "message" => "Data gagal disimpan " . $msg,
                    'status' => "error",
                    'buton_hide' => $buton_hide
                );
            }
            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_ganis_phpl', array(
            'model' => $model,
            'modelSertifikat' => $modelSertifikat,
            'id_ganis' => $id_ganis
        ));
    }

    public function actionGanisphpl($id) {
        $modelSertifikat = IuphhkTenagaKerja::model()->findByPk($id);

        $model = new SertifikatGanis('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SertifikatGanis']))
            $model->attributes = $_GET['SertifikatGanis'];

        $model->id_iuphhk_tenaga_kerja = $id;

        $this->render('ganis_phpl', array(
            'model' => $model,
            'modelSertifikat' => $modelSertifikat
        ));
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteVlk($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $model = SertifikasiVlk::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $daftarGanis = new IuphhkTenagaKerja('search');
        $daftarGanis->unsetAttributes();  // clear any default values
        if (isset($_GET['IuphhkTenagaKerja']))
            $daftarGanis->attributes = $_GET['IuphhkTenagaKerja'];
        $daftarGanis->id_perusahaan = Yii::app()->user->idPerusahaan();
        
//        $syaratGanis = new IuphhkTenagaKerja('getDaftarRealisasiGanis');
//        $syaratGanis->unsetAttributes();  // clear any default values
//        if (isset($_GET['IuphhkTenagaKerja']))
//            $syaratGanis->attributes = $_GET['IuphhkTenagaKerja'];
//        $syaratGanis->id_perusahaan = Yii::app()->user->idPerusahaan();
        
        $syaratGanis = IuphhkTenagaKerja::model()->getDaftarRealisasiGanisByPerusahaanId($perusahaan->id_perusahaan= Yii::app()->user->idPerusahaan());
        

        $modelVlk = new SertifikasiVlk('search');
        $modelVlk->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikasiVlk']))
            $modelVlk->attributes = $_GET['SertifikasiVlk'];
        $modelVlk->id_perusahaan = Yii::app()->user->idPerusahaan();

        $this->render('index', array(
            'daftarGanis' => $daftarGanis,
            'syaratGanis' => $syaratGanis,
            'modelVlk' => $modelVlk
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = IuphhkTenagaKerja::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sertifikasi-phpl-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    

}
