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
        if (!isset($iuphhk)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }

        $sungai = new HidrologiSungai('search');
        $sungai->unsetAttributes();  // clear any default values
        if (isset($_GET['HidrologiSungai']))
            $sungai->attributes = $_GET['HidrologiSungai'];
        
        $sungai->id_iuphhk = $id;

        // Data Anak Sungai
        $mataAir = new HidrologiMataAir('search');
        $mataAir->unsetAttributes();  // clear any default values
        if (isset($_GET['HidrologiMataAir']))
            $mataAir->attributes = $_GET['HidrologiMataAir'];

        $mataAir->id_iuphhk = $id;
        
        // Data Waduk
        $waduk = new HidrologiWaduk('search');
        $waduk->unsetAttributes();  // clear any default values
        if (isset($_GET['HidrologiWaduk']))
            $waduk->attributes = $_GET['HidrologiWaduk'];

        $waduk->id_iuphhk = $id;

        $this->render('index', array(
            'iuphhk' => $iuphhk,
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
}
