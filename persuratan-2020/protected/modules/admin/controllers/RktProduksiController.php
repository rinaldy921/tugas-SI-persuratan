<?php

class RktProduksiController extends Controller {

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
            $modelBibit = new RktBibit;
            $modelBibit->unsetAttributes();
            if (isset($_GET['RktBibit']))
                $modelBibit->attributes = $_GET['RktBibit'];
            $modelBibit->id_rkt = $rkt->id;

            $modelSiapLahan = new RktSiapLahan;
            $modelSiapLahan->unsetAttributes();
            if (isset($_GET['RktSiapLahan']))
                $modelSiapLahan->attributes = $_GET['RktSiapLahan'];
            $modelSiapLahan->id_rkt = $rkt->id;

            $modelTanam = new RktTanam;
            $modelTanam->unsetAttributes();
            if (isset($_GET['RktTanam']))
                $modelTanam->attributes = $_GET['RktTanam'];
            $modelTanam->id_rkt = $rkt->id;

            $modelSulam = new RktSulam;
            $modelSulam->unsetAttributes();
            if (isset($_GET['RktSulam']))
                $modelSulam->attributes = $_GET['RktSulam'];
            $modelSulam->id_rkt = $rkt->id;

            $modelJarang = new RktJarang;
            $modelJarang->unsetAttributes();
            if (isset($_GET['RktJarang']))
                $modelJarang->attributes = $_GET['RktJarang'];
            $modelJarang->id_rkt = $rkt->id;

            $modelDangir = new RktDangir;
            $modelDangir->unsetAttributes();
            if (isset($_GET['RktDangir']))
                $modelDangir->attributes = $_GET['RktDangir'];
            $modelDangir->id_rkt = $rkt->id;

            $modelPasar = new RktPasar;
            $modelPasar->unsetAttributes();
            if (isset($_GET['RktPasar']))
                $modelPasar->attributes = $_GET['RktPasar'];
            $modelPasar->id_rkt = $rkt->id;
            
            $modelPasarHhbk = new RktPasarHhbk;
            $modelPasarHhbk->unsetAttributes();
            if (isset($_GET['RktPasarHhbk']))
                $modelPasarHhbk->attributes = $_GET['RktPasarHhbk'];
            $modelPasarHhbk->id_rkt = $rkt->id;

            $modelPanenProduksi = new RktPanenProduksi;
            $modelPanenProduksi->unsetAttributes();
            if (isset($_GET['RktPanenProduksi']))
                $modelPanenProduksi->attributes = $_GET['RktPanenProduksi'];
            $modelPanenProduksi->id_rkt = $rkt->id;

            $modelPanenLahan = new RktPanenLahan;
            $modelPanenLahan->unsetAttributes();
            if (isset($_GET['RktPanenLahan']))
                $modelPanenLahan->attributes = $_GET['RktPanenLahan'];
            $modelPanenLahan->id_rkt = $rkt->id;

            $modelPanenHhbk = new RktPanenHhbk;
            $modelPanenHhbk->unsetAttributes();
            if (isset($_GET['RktPanenHhbk']))
                $modelPanenHhbk->attributes = $_GET['RktPanenHhbk'];
            $modelPanenHhbk->id_rkt = $rkt->id;
            
            $modelPemeliharaan = new RktPelihara;
            $modelPemeliharaan->unsetAttributes();
            if (isset($_GET['RktPelihara']))
                $modelPemeliharaan->attributes = $_GET['RktPelihara'];
            $modelPemeliharaan->id_rkt = $rkt->id;
            
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rkt/' . $id));
        }

        $this->render('index', array(
            'iup' => $iup,
            'model' => $rkt,
            'modelBibit' => $modelBibit,
            'modelSiapLahan' => $modelSiapLahan,
            'modelTanam' => $modelTanam,
            'modelSulam' => $modelSulam,
            'modelJarang' => $modelJarang,
            'modelDangir' => $modelDangir,
            'modelPanenProduksi' => $modelPanenProduksi,
            'modelPanenLahan' => $modelPanenLahan,
            'modelPanenHhbk' => $modelPanenHhbk,
            'modelPasar' => $modelPasar,
            'modelPasarHhbk' => $modelPasarHhbk,
            'modelPemeliharaan' => $modelPemeliharaan
        ));
    }

}
