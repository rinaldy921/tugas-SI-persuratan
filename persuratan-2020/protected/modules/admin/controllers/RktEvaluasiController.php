<?php

class RktEvaluasiController extends Controller {

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
                'actions' => array('index'),
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
        $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . $iup->id_perusahaan));
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . $iup->id_perusahaan . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rkt/' . $id));
            }
        }
        if (isset($rkt)) {
            $modelGanis = new RktEvaluasiPantauOperasional;
            $modelGanis->unsetAttributes();
            if (isset($_GET['RktEvaluasiPantauOperasional']))
                $modelGanis->attributes = $_GET['RktEvaluasiPantauOperasional'];
            $modelGanis->id_rkt = $rkt->id;

            $modelGanisBerhasil = new RktEvaluasiKeberhasilan;
            $modelGanisBerhasil->unsetAttributes();
            if (isset($_GET['RktEvaluasiKeberhasilan']))
                $modelGanisBerhasil->attributes = $_GET['RktEvaluasiKeberhasilan'];
            $modelGanisBerhasil->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rkt/' . $id));
        }

        $this->render('index', array(
            'iup' => $iup,
            'model' => $rkt,
            'modelGanisOpr' => $modelGanis,
            'modelGanisBerhasil' => $modelGanisBerhasil,
        ));
    }

}
