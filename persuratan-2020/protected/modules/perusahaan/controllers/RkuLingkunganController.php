<?php

class RkuLingkunganController extends Controller {

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
                'actions' => array('index', 'inputDamkar', 'deleteDamkar', 'deleteHamkit', 'deleteTekdam', 'deletePerambahan','deletePemantauan','deletePerlindungan'),
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
        $model = new RkuHamaPenyakit;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['RkuHamaPenyakit'])) {
            $model->attributes = $_POST['RkuHamaPenyakit'];
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

        if (isset($_POST['RkuHamaPenyakit'])) {
            $model->attributes = $_POST['RkuHamaPenyakit'];
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
    public function actionDeleteHamkit($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            RkuHamaPenyakit::model()->findByPk($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteDamkar($id) {
        if (Yii::app()->request->isPostRequest) {
            RkuAlatDamkar::model()->findByPk($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteTekdam($id) {
        if (Yii::app()->request->isPostRequest) {
            RkuTeknikPemadaman::model()->findByPk($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePerambahan($id) {
        if (Yii::app()->request->isPostRequest) {
            RkuPerambahanHutan::model()->findByPk($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionDeletePemantauan($id) {
        if (Yii::app()->request->isPostRequest) {
            RkuPemantauanLingkungan::model()->findByPk($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeletePerlindungan($id) {
        if (Yii::app()->request->isPostRequest) {
            RkuPerlindunganHutan::model()->findByPk($id)->delete();

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

//      Hama dan Penyakit
        $addHamkit = new RkuHamaPenyakit;
        $addHamkit->id_rku = $rku->id_rku;

        $hamkit = new RkuHamaPenyakit('search');
        $hamkit->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuHamaPenyakit']))
            $hamkit->attributes = $_GET['RkuHamaPenyakit'];
        $hamkit->id_rku = $rku->id_rku;

        if (isset($_POST['RkuHamaPenyakit'])) {
            $addHamkit->attributes = $_POST['RkuHamaPenyakit'];
            if ($addHamkit->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addHamkit);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

//        Teknik Pemadaman
        $addTekdam = new RkuTeknikPemadaman;
        $addTekdam->id_rku = $rku->id_rku;

        $tekdam = new RkuTeknikPemadaman('search');
        $tekdam->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuTeknikPemadaman']))
            $tekdam->attributes = $_GET['RkuTeknikPemadaman'];
        $tekdam->id_rku = $rku->id_rku;

        if (isset($_POST['RkuTeknikPemadaman'])) {
            $addTekdam->attributes = $_POST['RkuTeknikPemadaman'];
            if ($addTekdam->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addTekdam);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

//        Alat Pemadaman
        $addAlatDamkar = new RkuAlatDamkar;
        $addAlatDamkar->id_rku = $rku->id_rku;

        $alatDamkar = new RkuAlatDamkar('search');
        $alatDamkar->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuAlatDamkar']))
            $alatDamkar->attributes = $_GET['RkuAlatDamkar'];
        $alatDamkar->id_rku = $rku->id_rku;

        if (isset($_POST['RkuAlatDamkar'])) {
            $addAlatDamkar->attributes = $_POST['RkuAlatDamkar'];
            if ($addAlatDamkar->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addAlatDamkar);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

//        Perambahan Hutan
        $addPerambahan = new RkuPerambahanHutan;
        $addPerambahan->id_rku = $rku->id_rku;

        $perambahan = new RkuPerambahanHutan('search');
        $perambahan->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuPerambahanHutan']))
            $perambahan->attributes = $_GET['RkuPerambahanHutan'];
        $perambahan->id_rku = $rku->id_rku;

        if (isset($_POST['RkuPerambahanHutan'])) {
            $addPerambahan->attributes = $_POST['RkuPerambahanHutan'];
            if ($addPerambahan->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addPerambahan);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }


//        Perlindungan Hutan
        $addPerlindungan = new RkuPerlindunganHutan;
        $addPerlindungan->id_rku = $rku->id_rku;

        $perlindungan = new RkuPerlindunganHutan('search');
        $perlindungan->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuPerlindunganHutan']))
            $perlindungan->attributes = $_GET['RkuPerlindunganHutan'];
        $perlindungan->id_rku = $rku->id_rku;

        if (isset($_POST['RkuPerlindunganHutan'])) {
            $addPerlindungan->attributes = $_POST['RkuPerlindunganHutan'];
            if ($addPerlindungan->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addPerlindungan);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }


//        Pemantauan Lingkungan
        $addPemantauan = new RkuPemantauanLingkungan;
        $addPemantauan->id_rku = $rku->id_rku;

        $pemantauan = new RkuPemantauanLingkungan('search');
        $pemantauan->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuPemantauanLingkungan']))
            $pemantauan->attributes = $_GET['RkuPemantauanLingkungan'];
        $pemantauan->id_rku = $rku->id_rku;

        if (isset($_POST['RkuPemantauanLingkungan'])) {
            $addPemantauan->attributes = $_POST['RkuPemantauanLingkungan'];
            if ($addPemantauan->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($addPemantauan);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

        $this->render('index', array(
            'rku' => $rku,
            'hamkit' => $hamkit,
            'addHamkit' => $addHamkit,
            'tekdam' => $tekdam,
            'addTekdam' => $addTekdam,
            'addAlatDamkar' => $addAlatDamkar,
            'alatDamkar' => $alatDamkar,
            'perambahan' => $perambahan,
            'addPerambahan' => $addPerambahan,
            'pemantauan' => $pemantauan,
            'addPemantauan' => $addPemantauan,
            'perlindungan' => $perlindungan,
            'addPerlindungan' => $addPerlindungan,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RkuHamaPenyakit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rku-hama-penyakit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionInputDamkar() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RkuAlatDamkar');
        $model->update();
    }

}
