<?php

class DataiuphhkController extends Controller {

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
                'actions' => array('index', 'create', 'update', 'delete'),
                'users' => array(Yii::app()->user->adminRole()),
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
    public function actionCreate() {
        $model = new Iuphhk;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Iuphhk'])) {
            $model->attributes = $_POST['Iuphhk'];
            $jml_blok = $_POST['Iuphhk']['blok'];
            $sektor = isset($_POST['Iuphhk']['sektor']) ? $_POST['Iuphhk']['sektor'] : NULL;
            $blokcustom = isset($_POST['Iuphhk']['blokcustom']) ? $_POST['Iuphhk']['blokcustom'] : NULL;
            // var_dump($blokcustom[0]);die;
            if ($model->save()) {
                if($blokcustom == NULL) {
                    $this->generateBlok($model->id_iuphhk, $model->id_perusahaan, NULL, $jml_blok);
                } else {
                    $this->generateSektorBlok($model->id_iuphhk, $model->id_perusahaan, $sektor, $blokcustom);
                }
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

        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }

        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Iuphhk'])) {
            $model->attributes = $_POST['Iuphhk'];
            if ($model->save()) {
                $message = Yii::t('app', 'Data berhasil disimpan.');
                Yii::app()->user->setFlash('success', $message);
                $re = 'dataiuphhk/'.$id;
                $this->redirect(array($re));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'iup'   => $iup
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
    public function actionIndex($id) {
        $model = Iuphhk::model()->find(array(
            'condition' => 'id_iuphhk =' . $id
        ));
        if (empty($model))
            $this->redirect(array('create'));
//            $model = array();
        $this->render('index', array(
            'model' => $model,
            'iup'   => $model
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Iuphhk::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'iuphhk-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function generateBlok($iuphhk, $perusahaan, $sektor, $blok) {
        for ($i = 1; $i <= $blok; $i++) {
            $model = new BlokSektor;
            $model->id_iuphhk = $iuphhk;
            $model->id_perusahaan = $perusahaan;
            $model->id_sektor = $sektor;
            $model->id_blok = $i;
            $model->save();
        }
        return true;
    }

    function generateSektorBlok($iuphhk,$perusahaan,$sektor,$blok) {
        // var_dump($sektor);die;
        foreach($blok as $key => $value) {
            // var_dump($value);die;
            for($i = 0; $i < (int) $value; $i++) {
                $model = new BlokSektor;
                $model->id_iuphhk = $iuphhk;
                $model->id_perusahaan = $perusahaan;
                $model->id_sektor = $key + 1;
                $model->id_blok = $i + 1;
                $model->save();
            }
        }
        // for($i = 1; $i < (int) $sektor; $i++) {
        //     // var_dump((int) $blok[$i - 1]);die;
        //     for($j = 1; $j < (int) $blok[$i - 1]; $j++) {
        //         $model = new BlokSektor;
        //         $model->id_iuphhk = $iuphhk;
        //         $model->id_perusahaan = $perusahaan;
        //         $model->id_sektor = $i;
        //         $model->id_blok = $j;
        //         $model->save();
        //     }
        // }
    }

}
