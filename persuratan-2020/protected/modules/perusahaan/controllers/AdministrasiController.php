<?php

class AdministrasiController extends Controller {

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
            array('allow',
                'actions' => array('delPemerintahan', 'delPemangkuanHutan', 'index', 'view', 'createPemerintahan', 'createPemangkuanHutan', 'updatePemerintahan', 'updatePemangkuanHutan'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('getKabupaten', 'getKecamatan'),
                'users' => array('*'),
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
    public function actionCreatePemerintahan() {
        $model = new AdmPemerintahan;
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['AdmPemerintahan'])) {
            $model->provinsi = $_POST['AdmPemerintahan']['provinsi'];
//            echo !empty($_POST['AdmPemerintahan']['kecamatan']) ? $_POST['AdmPemerintahan']['kecamatan'] : 'kosong';die;
            $model->kabupaten = !empty($_POST['AdmPemerintahan']['kabupaten']) ? $_POST['AdmPemerintahan']['kabupaten'] : null;
            $model->kecamatan = !empty($_POST['AdmPemerintahan']['kecamatan']) ? $_POST['AdmPemerintahan']['kecamatan'] : null;
            $model->id_perusahaan = Yii::app()->user->idPerusahaan();
//            print_r($model);die;
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create_pemerintahan', array(
            'model' => $model,
        ));
    }

    public function actionCreatePemangkuanHutan() {
        $model = new AdmPemangkuanHutan;
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['AdmPemangkuanHutan'])) {
            $model->attributes = $_POST['AdmPemangkuanHutan'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data Pemangkuan Hutan berhasil ditambah!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create_pemangkuan', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdatePemerintahan($id) {
        $model = $this->loadModelPemerintahan($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['AdmPemerintahan'])) {
            $model->attributes = $_POST['AdmPemerintahan'];
            $model->kabupaten = !empty($_POST['AdmPemerintahan']['kabupaten']) ? $_POST['AdmPemerintahan']['kabupaten'] : null;
            $model->kecamatan = !empty($_POST['AdmPemerintahan']['kecamatan']) ? $_POST['AdmPemerintahan']['kecamatan'] : null;
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil diupdate!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $data['oldkab'] = array();
        if (isset($model->provinsi) && !empty($model->provinsi)) {
            $kab = Kabupaten::model()->findAll(array('select' => 'id_kabupaten, nama', 'condition' => "provinsi_id = " . $model->provinsi));
            foreach ($kab as $d) {
                $data['oldkab'][] = array('id' => $d->id_kabupaten, 'text' => $d->nama);
            }
        }
        $data['oldkec'] = array();
        if (isset($model->kabupaten) && !empty($model->kabupaten)) {
            $kec = Kecamatan::model()->findAll(array('select' => 'id_kecamatan, nama', 'condition' => "kabupaten_id = " . $model->kabupaten));
            foreach ($kec as $d) {
                $data['oldkec'][] = array('id' => $d->id_kecamatan, 'text' => $d->nama);
            }
        }

        $this->render('update_pemerintahan', array(
            'model' => $model,
            'data' => $data
        ));
    }

    public function actionUpdatePemangkuanHutan($id) {
        $model = $this->loadModelPemangkuan($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['AdmPemangkuanHutan'])) {
            $model->attributes = $_POST['AdmPemangkuanHutan'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil diupdate!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $data['oldkab'] = array();
        if (isset($model->dinhut_prov) && !empty($model->dinhut_prov)) {
            $kab = Kabupaten::model()->findAll(array('select' => 'id_kabupaten, nama', 'condition' => "provinsi_id = " . $model->dinhut_prov));
            foreach ($kab as $d) {
                $data['oldkab'][] = array('id' => $d->id_kabupaten, 'text' => $d->nama);
            }
        }
        $this->render('update_pemangkuan', array(
            'model' => $model,
            'data' => $data
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelPemerintahan($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModelPemerintahan($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDelPemangkuanHutan($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModelPemangkuan($id)->delete();

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
        $id_iuphhk = !is_null(Yii::app()->user->idIuphhk()) ? Yii::app()->user->idIuphhk() : 0;
        // Administrasi Pemerintahan
        $pemerintahan = new AdmPemerintahan('search');
        $pemerintahan->unsetAttributes();  // clear any default values
        if (isset($_GET['AdmPemerintahan']))
            $pemerintahan->attributes = $_GET['AdmPemerintahan'];

        $pemerintahan->id_iuphhk = $id_iuphhk;

        // Administrasi Pemangkuan Hutan
        $pemangkuan = new AdmPemangkuanHutan('search');
        $pemangkuan->unsetAttributes();  // clear any default values
        if (isset($_GET['AdmPemangkuanHutan']))
            $pemangkuan->attributes = $_GET['AdmPemangkuanHutan'];

        $pemangkuan->id_iuphhk = $id_iuphhk;

        $this->render('index', array(
            'pemerintahan' => $pemerintahan,
            'pemangkuan' => $pemangkuan
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModelPemangkuan($id) {
        $model = AdmPemangkuanHutan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelPemerintahan($id) {
        $model = AdmPemerintahan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'adm-pemerintahan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetKabupaten($id) {
        $this->layout = false;
        if (Yii::app()->request->isAjaxRequest) {
            $kab = Kabupaten::model()->findAll(array('select' => 'id_kabupaten, nama', 'condition' => "t.provinsi_id = $id"));
            $data = array();
            foreach ($kab as $d) {
                $data[] = array('id' => $d->id_kabupaten, 'text' => $d->nama);
            }
            echo CJSON::encode($data);
        }
    }

    public function actionGetKecamatan($id) {
        $this->layout = false;
        if (Yii::app()->request->isAjaxRequest) {
            $kec = Kecamatan::model()->findAll(array('select' => 'id_kecamatan, nama', 'condition' => "t.kabupaten_id = $id"));
            $data = array();
            foreach ($kec as $d) {
                $data[] = array('id' => $d->id_kecamatan, 'text' => $d->nama);
            }
            echo CJSON::encode($data);
        }
    }
    
    public function testEuy($param) {
        
    }
    
    protected function testdeui($param) {
        
    }

}
