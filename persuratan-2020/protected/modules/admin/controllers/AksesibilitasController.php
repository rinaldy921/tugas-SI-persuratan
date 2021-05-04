<?php

class AksesibilitasController extends Controller {

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
        $iuphhk = Iuphhk::model()->findByPk($id);

        $model = Perusahaan::model()->find(array('condition' => 'id_perusahaan=' . $iuphhk->id_perusahaan));
        if (empty($iuphhk))
            $model = new Perusahaan;

        $aksesibilitas = new Aksesibilitas('search');
        $aksesibilitas->unsetAttributes();
        $aksesibilitas->id_perusahaan = $model->id_perusahaan;

        // print_r("<pre>");
        // print_r($perusahaanCabang);
        // print_r("</pre>");

        $this->render('index', array(
            'model' => $model,
            'iuphhk' => $iuphhk,
            'aksesibilitas' => $aksesibilitas,
        ));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function loadModel($id) {
        $model = PerusahaanCabang::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
}
