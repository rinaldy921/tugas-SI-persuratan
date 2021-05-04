<?php

class DataIzinController extends Controller {

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
            // $this->redirect(array('//admin/iuphhk/index'));
        }
        $iuphhkRevisi = new Iuphhk('searchrevisi');
        $iuphhkRevisi->id_parent = $iuphhk->id_iuphhk;

        // if (empty($iup))
        //     $iup = new Iuphhk;
        // print_r("<pre>");
        // print_r($iup);
        // print_r("</pre>");
        
        $this->render('index', array(
            // 'model' => $model,
            'iuphhk'   => $iuphhk,
            'iuphhkRevisi'   => $iuphhkRevisi,
        ));
    }

    // /**
    //  * Returns the data model based on the primary key given in the GET variable.
    //  * If the data model is not found, an HTTP exception will be raised.
    //  * @param integer the ID of the model to be loaded
    //  */
    // public function loadModel($id) {
    //     $model = Iuphhk::model()->findByPk($id);
    //     if ($model === null)
    //         throw new CHttpException(404, 'The requested page does not exist.');
    //     return $model;
    // }




    // public function actionIndex($id) 
    // {
    //     // $model = Perusahaan::model()->findByPk($id);
    //     $model = Iuphhk::model()->find(array(
    //         'condition' => 'id_iuphhk =' . $id
    //     ));

    //     $iuphhk = Iuphhk::model()->find(array('condition' => 'id_perusahaan=' . $model->id_perusahaan));
    //     if (empty($iuphhk))
    //         $iuphhk = new Iuphhk;

    //     // $iuphhk = new Iuphhk ('search');
    //     //$iuphhk->id_perusahaan = $model->id_perusahaan;

    //     $iuphhkRevisi = new Iuphhk('searchrevisi');
    //     $iuphhkRevisi->id_parent = $iuphhk->id_iuphhk;

    //     // print_r("<pre>");
    //     // print_r($model);

    //     // print_r("</pre>");

    //     $this->render('index', array(
    //         'model' => $model,
    //         'iuphhk' => $iuphhk,
    //         'iuphhkRevisi' => $iuphhkRevisi,
    //     ));
    // }
//     public function actionIndex($id) {
//         $iup = Iuphhk::model()->findByPk($id);
//         // if (!isset($iup)) {
//         //     $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
//         //     Yii::app()->user->setFlash('notice', $message);
//         //     $this->redirect(array('//admin/iuphhk/index'));
//         // }

// // //        $model = new Perusahaan('search');
// //         $model->unsetAttributes();
// //         $model->id_perusahaan = $iup->id_perusahaan;

//         $model = new PerusahaanCabang('search');
//         $model->unsetAttributes();
//         $model->perusahaan_id = $iup->id_perusahaan;


//         // $model = PerusahaanCabang::model()->findAll(array('condition' => 'perusahaan_id=' . $iup->id_perusahaan));
//         // if (empty($model))
//         //     $model = new PerusahaanCabang;

        
//         // print_r("<pre>");
//         // print_r($model);

//         // print_r("</pre>");

//         $this->render('index', array(
//             'iup' => $iup,
//             'model' => $model
//         ));
//     }

    // public function actionView($id) {
    //     $this->render('view', array(
    //         'model' => $this->loadModel($id),
    //     ));
    // }

    // public function loadModel($id) {
    //     $model = Perusahaan::model()->findByPk($id);
    //     if ($model === null)
    //         throw new CHttpException(404, 'The requested page does not exist.');
    //     return $model;
    // }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
}
