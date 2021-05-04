<?php

class RktSosialController extends Controller {

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
        $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . $iup->id_perusahaan,'order'=>'tahun_mulai DESC'));
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . $iup->id_perusahaan . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai'],'order'=>'tahun_mulai DESC'));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rkt/' . $id));
            }
        }
        if (isset($rkt)) {
            $modelInfraMukim = new RktInfraMukim;
            $modelInfraMukim->unsetAttributes();
            if (isset($_GET['RktInfraMukim']))
                $modelInfraMukim->attributes = $_GET['RktInfraMukim'];
            $modelInfraMukim->id_rkt = $rkt->id;

            $modelSdm = new RktPeningkatanSdm;
            $modelSdm->unsetAttributes();
            if (isset($_GET['RktPeningkatanSdm']))
                $modelSdm->attributes = $_GET['RktPeningkatanSdm'];
            $modelSdm->id_rkt = $rkt->id;


            $modelKonflikSosial = new RktKonflikSosial;
            $modelKonflikSosial->unsetAttributes();
            if (isset($_GET['RktKonflikSosial']))
                $modelKonflikSosial->attributes = $_GET['RktKonflikSosial'];
            $modelKonflikSosial->id_rkt = $rkt->id;
            
            $kerjasama = RktKerjasamaKoperasi::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
            if(empty($kerjasama))
                $kerjasama = new RktKerjasamaKoperasi;
            
            $bangunMitra = RktBangunMitra::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
            if(empty($bangunMitra))
                $bangunMitra = new RktBangunMitra;
            
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rkt/' . $id));
        }

        $this->render('index', array(
            'iup' => $iup,
            'model' => $rkt,
            'modelKonflikSosial' => $modelKonflikSosial,
            'modelInfraMukim' => $modelInfraMukim,
            'modelKerjasama' => $kerjasama,
            'modelSdm' => $modelSdm,
            'modelBangunMitra' => $bangunMitra,
        ));
    }

}
