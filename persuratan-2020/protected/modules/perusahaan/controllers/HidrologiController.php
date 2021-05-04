<?php

class HidrologiController extends Controller {

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
                'actions' => array('index', 'addSungai', 'addMataAir','addWaduk', 'updateSungai', 'updateMataAir', 'updateWaduk', 'delMataAir', 'delSungai', 'delWaduk'),
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
    public function actionAddSungai() {
        $model = new HidrologiSungai;
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['HidrologiSungai'])) {
            $model->attributes = $_POST['HidrologiSungai'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('add_sungai', array(
            'model' => $model,
        ));
    }
    
    public function actionAddMataAir() {
        $model = new HidrologiMataAir;
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['HidrologiMataAir'])) {
            $model->attributes = $_POST['HidrologiMataAir'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('add_mata_air', array(
            'model' => $model,
        ));
    }
    
    public function actionAddWaduk() {
        $model = new HidrologiWaduk;
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['HidrologiWaduk'])) {
            $model->attributes = $_POST['HidrologiWaduk'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }

        $this->render('add_waduk', array(
            'model' => $model,
        ));
    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateSungai($id) {
        $model = $this->loadModelSungai($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['HidrologiSungai'])) {
            $model->attributes = $_POST['HidrologiSungai'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil diupdate!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }
        $this->render('update_sungai', array(
            'model' => $model
        ));
    }
    
    public function actionUpdateMataAir($id) {
        $model = $this->loadModelMataAir($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['HidrologiMataAir'])) {
            $model->attributes = $_POST['HidrologiMataAir'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil diupdate!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }
        $this->render('update_mata_air', array(
            'model' => $model
        ));
    }
    
    public function actionUpdateWaduk($id) {
        $model = $this->loadModelWaduk($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['HidrologiWaduk'])) {
            $model->attributes = $_POST['HidrologiWaduk'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil diupdate!');
                Yii::app()->user->setFlash('success', $message);
                $this->redirect(array('index'));
            }
        }
        $this->render('update_waduk', array(
            'model' => $model
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelSungai($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModelSungai($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionDelMataAir($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModelMataAir($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionDelWaduk($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModelWaduk($id)->delete();

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
        
        // Data Sungai dan Anak Sungai
        $sungai = new HidrologiSungai('search');
        $sungai->unsetAttributes();  // clear any default values
        if (isset($_GET['HidrologiSungai']))
            $sungai->attributes = $_GET['HidrologiSungai'];
        
        $sungai->id_iuphhk = $id_iuphhk;

        // Data Mata Air
        $mataAir = new HidrologiMataAir('search');
        $mataAir->unsetAttributes();  // clear any default values
        if (isset($_GET['HidrologiMataAir']))
            $mataAir->attributes = $_GET['HidrologiMataAir'];

        $mataAir->id_iuphhk = $id_iuphhk;
        
        // Data Waduk
        $waduk = new HidrologiWaduk('search');
        $waduk->unsetAttributes();  // clear any default values
        if (isset($_GET['HidrologiWaduk']))
            $waduk->attributes = $_GET['HidrologiWaduk'];

        $waduk->id_iuphhk = $id_iuphhk;

        $this->render('index', array(
            'sungai' => $sungai,
            'mataAir' => $mataAir,
            'waduk' => $waduk
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModelSungai($id) {
        $model = HidrologiSungai::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelMataAir($id) {
        $model = HidrologiMataAir::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function loadModelWaduk($id) {
        $model = HidrologiWaduk::model()->findByPk($id);
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
