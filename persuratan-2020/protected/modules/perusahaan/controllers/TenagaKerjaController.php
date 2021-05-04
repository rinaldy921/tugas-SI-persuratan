<?php

class TenagaKerjaController extends Controller {

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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('createTeknis','createNonTeknis', 'update'),
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
    public function actionCreateTeknis() {
        $model = new TenagaKerja;
        $model->kategori = 'Teknis';
        $model->perusahaan_id = Yii::app()->user->idPerusahaan();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['TenagaKerja'])) {
            $model->attributes = $_POST['TenagaKerja'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    public function actionCreateNonTeknis() {
        $model = new TenagaKerja;
        $model->kategori = 'Non Teknis';
        $model->perusahaan_id = Yii::app()->user->idPerusahaan();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['TenagaKerja'])) {
            $model->attributes = $_POST['TenagaKerja'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
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

        if (isset($_POST['TenagaKerja'])) {
            $model->attributes = $_POST['TenagaKerja'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
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
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

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

        $id = Yii::app()->user->idPerusahaan();
        $teknis = TenagaKerja::model()->find(array(
            'condition' => 'perusahaan_id=' . $id . ' AND kategori="Teknis"'
        ));

        if (empty($teknis))
            $teknis = array();

        $non_teknis = TenagaKerja::model()->find(array(
            'condition' => 'perusahaan_id=' . $id . ' AND kategori="Non Teknis"'
        ));

        if (empty($non_teknis))
            $non_teknis = array();

        $this->render('view', array(
            'teknis' => $teknis,
            'non_teknis' => $non_teknis
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = TenagaKerja::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tenaga-kerja-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
