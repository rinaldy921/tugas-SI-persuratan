<?php

class RkuFungsosController extends Controller {

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
                'actions' => array('index', 'deleteMukim', 'deleteLembaga', 'deleteFungsos','inputMukim', 'inputLembaga'),
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
        $model = new RkuInfraMukim;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['RkuInfraMukim'])) {
            $model->attributes = $_POST['RkuInfraMukim'];
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

        if (isset($_POST['RkuInfraMukim'])) {
            $model->attributes = $_POST['RkuInfraMukim'];
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
    public function actionDeleteMukim($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuInfraMukim::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteLembaga($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuKelembagaan::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteFungsos($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuFungsos::model()->findByPk($id)->delete();

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
        $rku = Rku::model()->find(array('condition' => 'edit_status=1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        if (!isset($rku)) {
            $message = Yii::t('app', 'Silahkan isi RKU terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/index'));
        }
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rku/index'));
            }
        }

//        infra mukim
        $addMukim = new RkuInfraMukim;
        $addMukim->id_rku = $rku->id_rku;

        $mukim = new RkuInfraMukim('search');
        $mukim->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuInfraMukim']))
            $mukim->attributes = $_GET['RkuInfraMukim'];
        $mukim->id_rku = $rku->id_rku;

        if (isset($_POST['RkuInfraMukim'])) {
            $addMukim->attributes = $_POST['RkuInfraMukim'];
            if ($addMukim->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addMukim);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

//        Kelembagaan
        $addLembaga = new RkuKelembagaan;
        $addLembaga->id_rku = $rku->id_rku;

        $lembaga = new RkuKelembagaan('search');
        $lembaga->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuKelembagaan']))
            $lembaga->attributes = $_GET['RkuKelembagaan'];
        $lembaga->id_rku = $rku->id_rku;

        if (isset($_POST['RkuKelembagaan'])) {
            $addLembaga->attributes = $_POST['RkuKelembagaan'];
            if ($addLembaga->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addLembaga);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
//        Fungsos
        $addFungsos = new RkuFungsos;
        $addFungsos->id_rku = $rku->id_rku;

        $fungsos = new RkuFungsos('search');
        $fungsos->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuFungsos']))
            $fungsos->attributes = $_GET['RkuFungsos'];
        $fungsos->id_rku = $rku->id_rku;

        if (isset($_POST['RkuFungsos'])) {
            $addFungsos->attributes = $_POST['RkuFungsos'];
            if ($addFungsos->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addFungsos);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

        $this->render('index', array(
            'rku' => $rku,
            'mukim' => $mukim,
            'addMukim' => $addMukim,
            'lembaga' => $lembaga,
            'addLembaga' => $addLembaga,
            'fungsos' => $fungsos,
            'addFungsos' => $addFungsos
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RkuInfraMukim::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rku-infra-mukim-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionInputMukim() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuInfraMukim');
        $model->update();
    }

    public function actionInputLembaga() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuKelembagaan');
        $model->update();
    }

}
