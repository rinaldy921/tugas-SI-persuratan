<?php

class SertifikasiPhplController extends Controller {

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
                'actions' => array('update', 'create', 'createVlk', 'updateVlk', 'delete', 'view', 'deleteVlk',
                    'penilikanphpl', 'AddPenilikanPHPL', 'DeletePenilikanPHPL',
                    'penilikanvlk', 'AddPenilikanVLK', 'DeletePenilikanVLK',
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
        $model = new SertifikasiPhpl;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        if (isset($_POST['SertifikasiPhpl'])) {
            $model->attributes = $_POST['SertifikasiPhpl'];

            $file_error = 0;
            if ($_FILES["pdf_sertifikat_phpl"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_sertifikat_phpl']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_sertifikat_phpl');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Sertifikat_PHPL_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
            if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Sertifikat PHPL harus PDF dengan ukuran maksimal 2 Mb');
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

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionCreateVlk() {
        $model = new SertifikasiVlk;

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        if (isset($_POST['SertifikasiVlk'])) {
            $model->attributes = $_POST['SertifikasiVlk'];

            $file_error = 0;
            if ($_FILES["pdf_sertifikat_vlk"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_sertifikat_vlk']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_sertifikat_vlk');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Sertifikat_VLK_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
            if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Sertifikat VLK harus PDF dengan ukuran maksimal 2 Mb');
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

        $this->render('createVLK', array(
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
        //$msg = "";


        if (isset($_POST['SertifikasiPhpl'])) {
            $model->attributes = $_POST['SertifikasiPhpl'];
            $file_error = 0;
            
            if ($_FILES["pdf_sertifikat_phpl"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_sertifikat_phpl']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_sertifikat_phpl');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Sertifikat_PHPL_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                                
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
            if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Sertifikat PHPL harus PDF dengan ukuran maksimal 2 Mb');
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

//        print_r("<pre>");
//        print_r($model);
//        print_r("</pre>");        exit(1);
        
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdateVlk($id) {
        $model = SertifikasiVlk::model()->findByPk($id);

        $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
        $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
        $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
        $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
        if (!is_dir($ngepath)) {
            mkdir($ngepath, 0777, true);
        }
        $msg = "";

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['SertifikasiVlk'])) {
            // var_dump($_POST['SertifikasiPhpl']);die;
            $model->attributes = $_POST['SertifikasiVlk'];

            $file_error = 0;
            if ($_FILES["pdf_sertifikat_vlk"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_sertifikat_vlk']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_sertifikat_vlk');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Sertifikat_VLK_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
          if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Sertifikat VLK harus PDF dengan ukuran maksimal 2 Mb');
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

        $this->render('update_vlk', array(
            'model' => $model,
        ));
    }

    public function actionDeletePenilikanPHPL($id, $id_setifikat) {
        $model = PenilikanPhpl::model()->findByPk($id)->delete();
        $re = '//perusahaan/sertifikasiPhpl/penilikanphpl/id/' . $id_setifikat;
        $this->redirect(array($re));
    }

    public function actionAddPenilikanPHPL($id) {
        $modelSertifikat = SertifikasiPhpl::model()->findByPk($id);

        $id_penilikan = isset($_GET['id_penilikan']) ? $_GET['id_penilikan'] : "";
        if ($id_penilikan != "") {
            $model = PenilikanPhpl::model()->findByPk($id_penilikan);
        } else {
            $model = new PenilikanPhpl;
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

        if (isset($_POST['PenilikanPhpl'])) {
            $model->attributes = $_POST['PenilikanPhpl'];
            $model->id_sertifikat_phpl = $modelSertifikat->id;
            // var_dump($model);die();
            $file_error = 0;
            if ($_FILES["pdf_penilikan_phpl"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_penilikan_phpl']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_penilikan_phpl');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Penilikan_PHPL_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
            if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $msg = Yii::t('app', 'Type File Dokumen Penilikan PHPL harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $msg);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }
           
            if ($file_error == 0) {
                if ($model->save()) {
                    $modelcek = PenilikanPhpl::model()->findAllByAttributes(array('id_sertifikat_phpl' => $model->id_sertifikat_phpl));
                    if (count($modelcek) == 4) {
                        $buton_hide = true;
                    }

                    $data = array(
                        'header' => "Success",
                        "message" => "Data berhasil disimpan",
                        'status' => "success",
                        'buton_hide' => $buton_hide
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Data gagal disimpan. " . $msg,
                        'status' => "error",
                        'buton_hide' => $buton_hide
                    );
                }
            } else {
                $data = array(
                    'header' => "Error",
                    "message" => "Data gagal disimpan. " . $msg,
                    'status' => "error",
                    'buton_hide' => $buton_hide
                );
            }
            echo json_encode($data);
            die();
        }

        $this->renderPartial('_form_penilikan_phpl', array(
            'model' => $model,
            'modelSertifikat' => $modelSertifikat,
            'id_penilikan' => $id_penilikan
        ));
    }

    public function actionPenilikanphpl($id) {
        $modelSertifikat = SertifikasiPhpl::model()->findByPk($id);

        $model = new PenilikanPhpl('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['PenilikanPhpl']))
            $model->attributes = $_GET['PenilikanPhpl'];

        $model->id_sertifikat_phpl = $id;

        $this->render('penilikan_phpl', array(
            'model' => $model,
            'modelSertifikat' => $modelSertifikat
        ));
    }

    public function actionPenilikanvlk($id) {
        $modelSertifikat = SertifikasiVlk::model()->findByPk($id);

        $model = new PenilikanVlk('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['PenilikanVlk']))
            $model->attributes = $_GET['PenilikanVlk'];

        $model->id_sertifikat_vlk = $id;

        $this->render('penilikan_vlk', array(
            'model' => $model,
            'modelSertifikat' => $modelSertifikat
        ));
    }

    public function actionAddPenilikanVLK($id) {
        $id_penilikan = isset($_GET['id_penilikan']) ? $_GET['id_penilikan'] : "";

        $modelSertifikat = SertifikasiVlk::model()->findByPk($id);

        if ($id_penilikan != "") {
            $model = PenilikanVlk::model()->findByPk($id_penilikan);
        } else {
            $model = new PenilikanVlk;
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

        if (isset($_POST['PenilikanVlk'])) {
            $model->attributes = $_POST['PenilikanVlk'];
            $model->id_sertifikat_vlk = $modelSertifikat->id;

            $file_error = 0;
            if ($_FILES["pdf_phpl"]["error"] == 0) {
                $ukuran_file = $_FILES['pdf_phpl']['size'];
                $file = CUploadedFile::getInstanceByName('pdf_phpl');
                $ran = rand();
                $ext = $file->getExtensionName();
                $realName = pathinfo($file->name, PATHINFO_FILENAME);
                $replaceFile = str_replace(' ', '_', $realName);

                $new_name = "Penilikan VLK_" . $replaceFile . '_' . $ran . '.' . $ext;
                $new_path = '/files/PDF/' . $p . '/' . $new_name;
                $name = dirname(Yii::app()->request->scriptFile) .$new_path;
                if (!empty($file) && strtolower($ext) == "pdf" && $ukuran_file <= 2097152) {
                    $file->saveAs($name);
                    $model->file_doc = $new_path;
                } else {
                    $file_error++;
                    $msg = Yii::t('app', 'Type File Dokumen Penilikan PHPL harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $msg);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
                    $modelcek = PenilikanVlk::model()->findAllByAttributes(array('id_sertifikat_vlk' => $model->id_sertifikat_vlk));
                    if (count($modelcek) == 2) {
                        $buton_hide = true;
                    }
                    $data = array(
                        'header' => "Success",
                        "message" => "Data berhasil disimpan",
                        'status' => "success",
                        'buton_hide' => $buton_hide
                    );
                } else {
                    $data = array(
                        'header' => "Error",
                        "message" => "Data gagal disimpan",
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

        $this->renderPartial('_form_penilikan_vlk', array(
            'model' => $model,
            'modelSertifikat' => $modelSertifikat,
            'id_penilikan' => $id_penilikan
        ));
    }

    public function actionDeletePenilikanVLK($id, $id_setifikat) {
        $model = PenilikanVlk::model()->findByPk($id)->delete();
        $re = '//perusahaan/sertifikasiPhpl/penilikanvlk/id/' . $id_setifikat;
        $this->redirect(array($re));
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
        $model = new SertifikasiPhpl('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikasiPhpl']))
            $model->attributes = $_GET['SertifikasiPhpl'];
        $model->id_perusahaan = Yii::app()->user->idPerusahaan();

        $modelVlk = new SertifikasiVlk('search');
        $modelVlk->unsetAttributes();  // clear any default values
        if (isset($_GET['SertifikasiVlk']))
            $modelVlk->attributes = $_GET['SertifikasiVlk'];
        $modelVlk->id_perusahaan = Yii::app()->user->idPerusahaan();

        $this->render('index', array(
            'model' => $model,
            'modelVlk' => $modelVlk
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = SertifikasiPhpl::model()->findByPk($id);
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
