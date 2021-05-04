<?php

class PendudukController extends Controller {

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
                'users' => array(Yii::app()->user->adminRole()),
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

    /**
     * Manages all models.
     */
    public function actionIndex($id) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }

        $modelPenduduk = new IuphhkDataPenduduk('search');
        $modelPenduduk->unsetAttributes();
        $modelPenduduk->id_iuphhk = $id;

        $modelAgama = IuphhkAgama::model()->find(array(
            'condition' => 'id_iuphhk=' . $id
        ));
        if ($modelAgama === null)
            $modelAgama = new IuphhkAgama;

        $modelPekerjaan = IuphhkPekerjaanPenduduk::model()->find(array(
            'condition' => 'id_iuphhk=' . $id
        ));
        if ($modelPekerjaan === null)
            $modelPekerjaan = new IuphhkPekerjaanPenduduk;

        $this->render('index', array(
            'iup' => $iup,
            'modelPenduduk' => $modelPenduduk,
            'modelAgama' => $modelAgama,
            'modelPekerjaan' => $modelPekerjaan
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
}