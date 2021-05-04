<?php

class DirkomController extends Controller {

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
                'actions' => array('addDireksi', 'addKomisaris', 'updateDireksi', 'updateKomisaris', 'delDireksi', 'delKomisaris'),
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
    public function actionAddDireksi($id_legalitas) {
        $model = new Direksi;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Direksi'])) {
            $model->attributes = $_POST['Direksi'];
            $model->id_legalitas = $id_legalitas;
            if ($model->save()) {
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $re = '//perusahaan/legalitas/detaillegalitas/id/'.$id_legalitas;
                // $this->redirect(array($re));
                // $this->redirect(array('//perusahaan/legalitas/index'));
                $data = array(
                    'header' => "Sukses",
                    'status' => 'success',
                    'message'=> 'Data Berhasil Disimpan'
                );
                echo json_encode($data);
                die();
            }
        }

        $this->renderPartial('create_direksi', array(
            'model' => $model,
            'id_legalitas' =>$id_legalitas,
            'mode' => 'create'
        ));
    }

    public function actionAddKomisaris($id_legalitas) {
        $model = new Komisaris;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Komisaris'])) {
            $model->attributes = $_POST['Komisaris'];
            $model->id_legalitas = $id_legalitas;
            if ($model->save()) {
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // // $this->redirect(array('//perusahaan/legalitas/index'));
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

        $this->renderPartial('create_komisaris', array(
            'model' => $model,
            'id_legalitas' =>$id_legalitas,
            'mode' => 'create'
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateDireksi($id) {
        $model = $this->loadDireksi($id);

        if (isset($_POST['Direksi'])) {
            $model->attributes = $_POST['Direksi'];
            if ($model->save()) {
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $id_legalitas = $model->id_legalitas;
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

        $this->renderPartial('update_direksi', array(
            'model' => $model,
            'id_legalitas' => $model->id_legalitas,
            'mode' => 'update'
        ));
    }

    public function actionUpdateKomisaris($id) {
        $model = $this->loadKomisaris($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Komisaris'])) {
            $model->attributes = $_POST['Komisaris'];
            if ($model->save()) {
                // $message = Yii::t('app', 'Data berhasil disimpan.');
                // Yii::app()->user->setFlash('success', $message);
                // $id_legalitas = $model->id_legalitas;
                // // $this->redirect(array('index'));
                // // $this->redirect(array('//perusahaan/legalitas/index'));
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

        $this->renderPartial('update_komisaris', array(
            'model' => $model,
            'id_legalitas' => $model->id_legalitas,
            'mode' => 'update'
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelDireksi($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadDireksi($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    public function actionDelKomisaris($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadKomisaris($id)->delete();

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

        $this->render('index', array(
            'direksi' => $direksi,
            'komisaris' => $komisaris
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadDireksi($id) {
        $model = Direksi::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadKomisaris($id) {
        $model = Komisaris::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'direksi-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
