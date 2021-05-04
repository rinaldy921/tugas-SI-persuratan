<?php

class GeologiController extends Controller {

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
                'actions' => array('index'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('createBatuan', 'createTanah', 'updateBatuan', 'updateTanah'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delBatuan', 'delTanah'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateBatuan() {
        $model = new JenisBatuan;
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['JenisBatuan'])) {
            $model->attributes = $_POST['JenisBatuan'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data jenis batuan ditambah!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create_batuan', array(
            'model' => $model,
        ));
    }

    public function actionCreateTanah() {
        $model = new JenisTanah;
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['JenisTanah'])) {
            $model->attributes = $_POST['JenisTanah'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data jenis tanah berhasil ditambah!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create_tanah', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateBatuan($id) {
        $model = $this->loadModelBatuan($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['JenisBatuan'])) {
            $model->attributes = $_POST['JenisBatuan'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil diupdate!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('update_batuan', array(
            'model' => $model,
        ));
    }

    public function actionUpdateTanah($id) {
        $model = $this->loadModelTanah($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['JenisTanah'])) {
            $model->attributes = $_POST['JenisTanah'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil diupdate!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('update_tanah', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelBatuan($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModelBatuan($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDelTanah($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModelTanah($id)->delete();

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
        $batuan = new JenisBatuan('search');
        $batuan->unsetAttributes();  // clear any default values
        if (isset($_GET['AdmPemerintahan']))
            $batuan->attributes = $_GET['AdmPemerintahan'];

        $batuan->id_iuphhk = $id_iuphhk;

        // Administrasi Pemangkuan Hutan
        $tanah = new JenisTanah('search');
        $tanah->unsetAttributes();  // clear any default values
        if (isset($_GET['AdmPemangkuanHutan']))
            $tanah->attributes = $_GET['AdmPemangkuanHutan'];

        $tanah->id_iuphhk = $id_iuphhk;

        $this->render('index', array(
            'batuan' => $batuan,
            'tanah' => $tanah
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModelBatuan($id) {
        $model = JenisBatuan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelTanah($id) {
        $model = JenisTanah::model()->findByPk($id);
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

}
