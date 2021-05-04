<?php

class RkuSilvikulturController extends Controller {

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
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'deleteSistem'),
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
        $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan=' . Yii::app()->user->idPerusahaan()));
        if (!isset($rku)) {
            $message = Yii::t('app', 'Silahkan isi RKU terlebih dahulu');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rku/index'));
        }
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'edit_status = 1 AND id_perusahaan = ' . Yii::app()->user->idPerusahaan() . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rku/index'));
            }
        }
        $model = new RkuSistemSilvikultur;
        $model->id_rku = $rku->id_rku;

        $modelSis = new RkuSistemSilvikultur('search');
        $modelSis->unsetAttributes();
        if(isset($_GET['RkuSistemSilvikultur']))
            $modelSis->attributes = $_GET['RkuSistemSilvikultur'];
        $modelSis->id_rku = $rku->id_rku;
        // $model = RkuSistemSilvikultur::model()->find(array(
        //     'condition' => 'id_rku=' . $rku->id_rku
        // ));
        // if (empty($model)) {
        //     $model = new RkuSistemSilvikultur;
        //     $model->id_rku = $rku->id_rku;
        // }

//        potensi Produksi
        $potensi_produksi = RkuPotensiProduksi::model()->find(array(
            'condition' => 'id_rku=' . $rku->id_rku
        ));
        if (empty($potensi_produksi)) {
            $potensi_produksi = new RkuPotensiProduksi;
            $potensi_produksi->id_rku = $rku->id_rku;
        }

//        tanaman silvikultur
        $tanaman = new RkuTanamanSilvikultur;
        $tanaman->id_rku = $rku->id_rku;

        $model2 = new RkuTanamanSilvikultur('search');
        $model2->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuTanamanSilvikultur']))
            $model2->attributes = $_GET['RkuTanamanSilvikultur'];
        $model2->id_rku = $rku->id_rku;

        $model_hhbk = new RkuHasilHutanNonkayuSilvikultur;
        $model_hhbk->id_rku = $rku->id_rku;

        $model_hhbk2 = new RkuHasilHutanNonkayuSilvikultur('search');
        //debug($model_hhbk2);
        //exit();
        
        $model_hhbk2->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuHasilHutanNonkayuSilvikultur']))
            $model_hhbk2->attributes = $_GET['RkuHasilHutanNonkayuSilvikultur'];
        $model_hhbk2->id_rku = $rku->id_rku;

        if (isset($_POST['RkuHasilHutanNonkayuSilvikultur'])) {
            $model_hhbk->attributes = $_POST['RkuHasilHutanNonkayuSilvikultur'];
            if ($model_hhbk->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($tanaman);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['RkuSistemSilvikultur'])) {
            $model->attributes = $_POST['RkuSistemSilvikultur'];
            if ($model->save()) {
                // $page = 2;
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $this->redirect(array('create'));
                if (Yii::app()->request->isAjaxRequest) {
                    // $this->renderPartial('_form_ajax',array(
                    //     'model'=>$model,
                    //     'tanaman'=>$tanaman,
                    // ));
                    echo CJSON::encode(array(
                        'status' => 'Tersimpan',
                        'id_jenis_silvikultur' => $model->id_jenis_silvikultur,
                        'jumlah' => $model->jumlah
                    ));
                    Yii::app()->end();
                }
            }
        }

//        Add Nama Tanaman
        if (isset($_POST['RkuTanamanSilvikultur'])) {
            $tanaman->attributes = $_POST['RkuTanamanSilvikultur'];
            if ($tanaman->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($tanaman);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }

//        add potensi produksi
        if (isset($_POST['RkuPotensiProduksi'])) {
            $potensi_produksi->attributes = $_POST['RkuPotensiProduksi'];
            if ($potensi_produksi->save()) {
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $this->redirect(array('create'));
                echo CJSON::encode(array(
                    'status' => ' Tersimpan',
                    'potensi_produksi' => $potensi_produksi
                ));
                Yii::app()->end();
            }
        }

        $this->render('create', array(
            'rku' => $rku,
            'model' => $model,
            'modelSis' => $modelSis,
            'tanaman' => $tanaman,
            'model2' => $model2,
            'potensi_produksi' => $potensi_produksi,
            'model_hhbk' => $model_hhbk,
            'model_hhbk2' =>$model_hhbk2
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

        if (isset($_POST['RkuSistemSilvikultur'])) {
            $model->attributes = $_POST['RkuSistemSilvikultur'];
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
            if($_GET['ajax'] == "rkuSilvikultur-hhbk-grid") {
                $model = RkuHasilHutanNonkayuSilvikultur::model()->findByPk($id);
                $model->delete();
            } else {
                $model = RkuTanamanSilvikultur::model()->findByPk($id);
                $model->delete();
            }
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteSistem($id) {
        if(Yii::app()->request->isPostRequest) {
            $model = RkuSistemSilvikultur::model()->findByPk($id);
            $model->delete();

            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $this->redirect(array('create'));
        $model = new RkuSistemSilvikultur('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RkuSistemSilvikultur']))
            $model->attributes = $_GET['RkuSistemSilvikultur'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = RkuSistemSilvikultur::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rku-sistem-silvikultur-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    
     
        
        

}
