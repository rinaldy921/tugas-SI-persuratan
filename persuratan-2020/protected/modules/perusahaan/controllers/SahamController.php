<?php

class SahamController extends Controller {

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
                'actions' => array('create', 'update', 'updateSaham', 'updateModal'),
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
    public function actionIndex() {
        // $saham = Saham::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        // $modal = Permodalan::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan()));
        // if (!isset($saham) || !isset($modal)) {
        //     $this->redirect(array('//perusahaan/saham/create'));
        // }
        $model = new Saham('search');
        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['Saham']))
        $model->id_perusahaan = Yii::app()->user->idPerusahaan();

        $this->render('view', array(
            'model' => $model,
            // 'modal' => $modal
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id_legalitas) {
        $modal = new Permodalan;
        $modal->id_perusahaan = Yii::app()->user->idPerusahaan();
        $modal->id_legalitas = $id_legalitas;
        $model = new Saham;
        $model->id_perusahaan = Yii::app()->user->idPerusahaan();
        $model->id_legalitas = $id_legalitas;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Saham']) && isset($_POST['Permodalan'])) {
            $model->attributes = $_POST['Saham'];
            // var_dump($_POST['Permodalan']['jenis']);die();

            $model->jenis      = $_POST['Permodalan']['jenis'];

            // $modal->attributes = $_POST['Permodalan'];
            if ($model->validate()) {
                $model->save();

                // var_dump($model);die();
                // $cek = Permodalan::model()->find(array('condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan() .' AND id_legalitas = ' .$id_legalitas ));
                // if (is_null($cek)) {
                //     $modal->save(false);
                // } else {
                //     $cek->jenis = $modal->jenis;
                //     $cek->update(array('jenis'));
                // }

                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $re = '//perusahaan/legalitas/detaillegalitas/id/'.$id_legalitas;
                // $this->redirect(array($re));
                $data = array(
                    'header' => "Sukses",
                    'status' => 'success',
                    'message'=> 'Data Berhasil Disimpan'
                );
                echo json_encode($data);
                die();
            }
        }

        $this->renderPartial('create', array(
            'model' => $model,
            'modal' => $modal,
            'id_legalitas' => $id_legalitas
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

        if (isset($_POST['Saham'])) {
            $model->attributes = $_POST['Saham'];
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
//    public function actionIndex() {
//        $model = new Saham('search');
//        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['Saham']))
//            $model->attributes = $_GET['Saham'];
//
//        $this->render('index', array(
//            'model' => $model,
//        ));
//    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Saham::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'saham-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpdateSaham() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('Saham');
        $model->update();
    }

    public function actionUpdateModal() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('Permodalan');
        $model->update();
    }

}
