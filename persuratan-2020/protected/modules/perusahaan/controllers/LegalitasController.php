<?php

class LegalitasController extends Controller {

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
                'actions' => array('index', 'view', 'Detaillegalitas'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
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
        $model = new LegalitasPerusahaan;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LegalitasPerusahaan'])) {
            $model->attributes = $_POST['LegalitasPerusahaan'];
            $file_error = 0;

            $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
            $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
            $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
            $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
            if (!is_dir($ngepath)) {
                mkdir($ngepath, 0777, true);
            }

            if ($_FILES["pdf_surat_kemenkumham"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_surat_kemenkumham']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_surat_kemenkumham');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);

                $new_name1 = "S_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) .$new_path1;
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->pdf_surat_kemenkumham = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Surat Kemenkumham harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($_FILES["pdf_akte_legalitas"]["error"] == 0) {
                $ukuran_file2 = $_FILES['pdf_akte_legalitas']['size'];
                $file2 = CUploadedFile::getInstanceByName('pdf_akte_legalitas');
                $ran2 = rand();
                $ext2 = $file2->getExtensionName();
                $realName2 = pathinfo($file2->name, PATHINFO_FILENAME);
                $replaceFile2 = str_replace(' ', '_', $realName2);

                $new_name2 = "A_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/PDF/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) .$new_path2;
                if (!empty($file2) && strtolower($ext2) == "pdf" && $ukuran_file2 <= 5242880) {
                    $file2->saveAs($name2);
                    $model->pdf_akte_legalitas = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Akte Perusahaan harus PDF dengan ukuran maksimal 5 Mb');
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['LegalitasPerusahaan'])) {
            $model->attributes = $_POST['LegalitasPerusahaan'];

            $file_error = 0;

            $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
            $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
            $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
            $ngepath = Yii::app()->params->uploadPath . '/PDF/' . $p;
            if (!is_dir($ngepath)) {
                mkdir($ngepath, 0777, true);
            }

            if ($_FILES["pdf_surat_kemenkumham"]["error"] == 0) {
                $ukuran_file1 = $_FILES['pdf_surat_kemenkumham']['size'];
                $file1 = CUploadedFile::getInstanceByName('pdf_surat_kemenkumham');
                $ran1 = rand();
                $ext1 = $file1->getExtensionName();
                $realName1 = pathinfo($file1->name, PATHINFO_FILENAME);
                $replaceFile1 = str_replace(' ', '_', $realName1);

                $new_name1 = "S_" . $replaceFile1 . '_' . $ran1 . '.' . $ext1;
                $new_path1 = '/files/PDF/' . $p . '/' . $new_name1;
                $name1 = dirname(Yii::app()->request->scriptFile) .$new_path1;
                if (!empty($file1) && strtolower($ext1) == "pdf" && $ukuran_file1 <= 2097152) {
                    $file1->saveAs($name1);
                    $model->pdf_surat_kemenkumham = $new_path1;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Surat Kemenkumham harus PDF dengan ukuran maksimal 2 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($_FILES["pdf_akte_legalitas"]["error"] == 0) {
                $ukuran_file2 = $_FILES['pdf_akte_legalitas']['size'];
                $file2 = CUploadedFile::getInstanceByName('pdf_akte_legalitas');
                $ran2 = rand();
                $ext2 = $file2->getExtensionName();
                $realName2 = pathinfo($file2->name, PATHINFO_FILENAME);
                $replaceFile2 = str_replace(' ', '_', $realName2);

                $new_name2 = "A_" . $replaceFile2 . '_' . $ran2 . '.' . $ext2;
                $new_path2 = '/files/PDF/' . $p . '/' . $new_name2;
                $name2 = dirname(Yii::app()->request->scriptFile) .$new_path2;
                if (!empty($file2) && strtolower($ext2) == "pdf" && $ukuran_file2 <= 5242880) {
                    $file2->saveAs($name2);
                    $model->pdf_akte_legalitas = $new_path2;
                } else {
                    $file_error++;
                    $message = Yii::t('app', 'Type File Akte Perusahaan harus PDF dengan ukuran maksimal 5 Mb');
                    Yii::app()->user->setFlash('error', $message);
//                    $this->redirect(array('create'));
//                    Yii::app()->end();
                }
            }

            if ($file_error == 0) {
                if ($model->save()) {
//                    $file1->saveAs($name1);
//                    $file2->saveAs($name2);
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);//->delete();
            $dir = Direksi::model()->findAllByAttributes(array('id_legalitas'=>$model->id_legalitas));
            $kom = Komisaris::model()->findAllByAttributes(array('id_legalitas'=>$model->id_legalitas));
            $sah = Saham::model()->findAllByAttributes(array('id_legalitas'=>$model->id_legalitas));
            $prm = Permodalan::model()->findAllByAttributes(array('id_legalitas'=>$model->id_legalitas));
            foreach ($dir as $key => $value) {
                $value->delete();
            }
            foreach ($kom as $key => $value) {
                $value->delete();
            }
            foreach ($sah as $key => $value) {
                $value->delete();
            }
            foreach ($prm as $key => $value) {
                $value->delete();
            }
            $model->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new LegalitasPerusahaan('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['LegalitasPerusahaan']))
            $model->attributes = $_GET['LegalitasPerusahaan'];

        $model->perusahaan_id = Yii::app()->user->idPerusahaan();

        //Tab Saham
        $saham = Saham::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        $modal_saham = Permodalan::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        // if (!isset($saham) || !isset($modal_saham)) {
        //     $this->redirect(array('//perusahaan/saham/create'));
        // }
        $model_saham = new Saham('search');
        $model_saham->unsetAttributes();
        $model_saham->id_perusahaan = Yii::app()->user->idPerusahaan();


        //Tab Pengurus
        $direksi = new Direksi('search');
        $komisaris = new Komisaris('search');
        $direksi->unsetAttributes();  // clear any default values
        if (isset($_GET['Direksi']))
            $direksi->attributes = $_GET['Direksi'];
        $direksi->perusahaan_id = Yii::app()->user->idPerusahaan();
        $komisaris->unsetAttributes();  // clear any default values
        if (isset($_GET['Komisaris']))
            $komisaris->attributes = $_GET['Komisaris'];
        $komisaris->perusahaan_id = Yii::app()->user->idPerusahaan();

        // $this->render('index', array(
        //     'direksi' => $direksi,
        //     'komisaris' => $komisaris
        // ));

        $this->render('index', array(
            'model' => $model,
            'model_saham' => $model_saham,
            'modal_saham' => $modal_saham,
            'direksi' => $direksi,
            'komisaris' => $komisaris
        ));
    }

    public function actionDetaillegalitas($id) {
        $model = new LegalitasPerusahaan('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['LegalitasPerusahaan']))
            $model->attributes = $_GET['LegalitasPerusahaan'];

        $model->perusahaan_id = Yii::app()->user->idPerusahaan();
        $model->id_legalitas = $id;

        //Tab Saham
        $saham = Saham::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_legalitas = ' . $id));
        $modal_saham = Permodalan::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND id_legalitas = ' . $id));
        // if (!isset($saham) || !isset($modal_saham)) {
        //     $this->redirect(array('//perusahaan/saham/create'));
        // }
        $model_saham = new Saham('search');
        $model_saham->unsetAttributes();
        $model_saham->id_perusahaan = Yii::app()->user->idPerusahaan();
        $model_saham->id_legalitas = $id;

        //Tab Pengurus
        $direksi = new Direksi('search');
        $komisaris = new Komisaris('search');
        $direksi->unsetAttributes();  // clear any default values
        if (isset($_GET['Direksi']))
            $direksi->attributes = $_GET['Direksi'];
        $direksi->perusahaan_id = Yii::app()->user->idPerusahaan();
        $direksi->id_legalitas = $id;

        $komisaris->unsetAttributes();  // clear any default values
        if (isset($_GET['Komisaris']))
            $komisaris->attributes = $_GET['Komisaris'];
        $komisaris->perusahaan_id = Yii::app()->user->idPerusahaan();
        $komisaris->id_legalitas = $id;

        $this->render('detaillegalitas', array(
            'model' => $this->loadModel($id),
            'model_saham' => $model_saham,
            'modal_saham' => $modal_saham,
            'direksi' => $direksi,
            'komisaris' => $komisaris,
            'id_legalitas' => $id
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = LegalitasPerusahaan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'legalitas-perusahaan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
