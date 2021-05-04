<?php

class IuphhkTutupLahanController extends Controller {

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
                'actions' => array('index', 'input'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update','createTutupLahan'),
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
        $model = new IuphhkTutupLahan;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['IuphhkTutupLahan'])) {
            $model->attributes = $_POST['IuphhkTutupLahan'];
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

        if (isset($_POST['IuphhkTutupLahan'])) {
            $model->attributes = $_POST['IuphhkTutupLahan'];
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
            IuphhkTutupLahan::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

//     public function actionDelete($id) {
//         if (Yii::app()->request->isPostRequest) {
// // we only allow deletion via POST request
//             $this->loadModel($id)->delete();

// // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//             if (!isset($_GET['ajax']))
//                 $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//         } else
//             throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
//     }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $jenisPenutupan = MasterJenisTutupLahan::model()->findAll();
        $tutupLahan = IuphhkTutupLahan::model()->find(array('condition' => 'id_iuphhk = ' . Yii::app()->user->idIuphhk()));
//        print_r($tutupLahan);die;


		// auto generate nya di hide
        /* if (empty($tutupLahan)) {
            foreach ($jenisPenutupan as $key) {
                $add = new IuphhkTutupLahan;
                $add->id_iuphhk = Yii::app()->user->idIuphhk();
                $add->id_penutupan_lahan = $key->id;
                $add->save();
            }
        } else {
            foreach ($jenisPenutupan as $key) {
                $cek = IuphhkTutupLahan::model()->find(array('condition' => 'id_iuphhk = ' . Yii::app()->user->idIuphhk() . ' AND id_penutupan_lahan = ' . $key->id));
                if (empty($cek)) {
                    $add = new IuphhkTutupLahan;
                    $add->id_iuphhk = Yii::app()->user->idIuphhk();
                    $add->id_penutupan_lahan = $key->id;
                    $add->save();
                }
            }
        } */

        $model = new IuphhkTutupLahan('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['IuphhkTutupLahan']))
            $model->attributes = $_GET['IuphhkTutupLahan'];
        $model->id_iuphhk = Yii::app()->user->idIuphhk();

        $this->render('index', array(
            'model' => $model,
        ));
    }
	
	
	public function actionCreateTutupLahan() {

        $model = new IuphhkTutupLahan;
		$model->Scenario='inputForm';
       
        
        if (isset($_POST['IuphhkTutupLahan'])) {
            $model->attributes = $_POST['IuphhkTutupLahan'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
       
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = IuphhkTutupLahan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'iuphhk-tutup-lahan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionInput() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('IuphhkTutupLahan');
        $model->update();
    }

}
