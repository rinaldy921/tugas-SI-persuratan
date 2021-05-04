<?php

class RktPrasyaratController extends Controller {

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
                $this->redirect(array('//admin/rkt/'.$id));
            }
        }
        $bloksektor = BlokSektor::model()->findAll(array('condition' => 'id_perusahaan = ' . $iup->id_perusahaan));
        if (isset($rkt)) {
            $idRkt = $rkt->id;
            
            $modelTenagaKerja = new RktSerapanTenagaKerja;
            $modelTenagaKerja->unsetAttributes();
            if (isset($_GET['RktSerapanTenagaKerja']))
                $modelTenagaKerja->attributes = $_GET['RktSerapanTenagaKerja'];
            $modelTenagaKerja->id_rkt = $rkt->id;
            
            $modelGanis = new RktGanis;
            $modelGanis->unsetAttributes();
            if (isset($_GET['RktGanis']))
                $modelGanis->attributes = $_GET['RktGanis'];
            $modelGanis->id_rkt = $rkt->id;

            $modelTataBatas = new RktTataBatas;
            $modelTataBatas->unsetAttributes();
            if (isset($_GET['RktTataBatas']))
                $modelTataBatas->attributes = $_GET['RktTataBatas'];
            $modelTataBatas->id_rkt = $rkt->id;

            $modelKawasan = new RktKawasanLindung;
            $modelKawasan->unsetAttributes();
            if (isset($_GET['RktKawasanLindung']))
                $modelKawasan->attributes = $_GET['RktKawasanLindung'];
            $modelKawasan->id_rkt = $rkt->id;

            $modelArealNonProduktif = new RktArealNonProduktif;
            $modelArealNonProduktif->unsetAttributes();
            if (isset($_GET['RktArealNonProduktif']))
                $modelArealNonProduktif->attributes = $_GET['RktArealNonProduktif'];
            $modelArealNonProduktif->id_rkt = $rkt->id;

            $modelArealProduktif = new RktArealProduktif('search');
            $modelArealProduktif->unsetAttributes();
            if (isset($_GET['RktArealProduktif']))
                $modelArealProduktif->attributes = $_GET['RktArealProduktif'];
            $modelArealProduktif->id_rkt = $rkt->id;

            $modelArealKerja = new RktArealKerja;
            $modelArealKerja->unsetAttributes();
            if (isset($_GET['RktArealKerja']))
                $modelArealKerja->attributes = $_GET['RktArealKerja'];
            $modelArealKerja->id_rkt = $rkt->id;

            $modelInventarisasi = new RktInventarisasi;
            $modelInventarisasi->unsetAttributes();
            if (isset($_GET['RktInventarisasi']))
                $modelInventarisasi->attributes = $_GET['RktInventarisasi'];
            $modelInventarisasi->id_rkt = $rkt->id;

            $modelPwh = new RktPwh;
            $modelPwh->unsetAttributes();
            if (isset($_GET['RktPwh']))
                $modelPwh->attributes = $_GET['RktPwh'];
            $modelPwh->id_rkt = $rkt->id;

            $modelMasterJenisPeralatan = new MasterJenisPeralatan;
            $modelMasterJenisSarpras = new MasterJenisSarpras;

            $modelMasukGunaAlat = new RktMasukGunaAlat('search');
            $modelMasukGunaAlat->unsetAttributes();
            if (isset($_GET['RktMasukGunaAlat']))
            $modelMasukGunaAlat->attributes = $_GET['RktMasukGunaAlat'];
            $modelMasukGunaAlat->id_rkt = $rkt->id;

            $modelBangunSarpras = new RktSarpras;
            $modelBangunSarpras->unsetAttributes();
            if (isset($_GET['RktSarpras']))
                $modelBangunSarpras->attributes = $_GET['RktSarpras'];
            $modelBangunSarpras->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rkt/'.$id));
        }

        $this->render('index', array(
            'iup' => $iup,
            'model' => $rkt,
            'ganis' => $modelGanis,
            'tatabatas' => $modelTataBatas,
            'tataruang' => $modelKawasan,
            'arealProduktif' => $modelArealProduktif,
            'arealKerja' => $modelArealKerja,
            'arealNonProduktif' => $modelArealNonProduktif,
            'inventarisasi' => $modelInventarisasi,
            'pwh' => $modelPwh,
            'masukGunaAlat' => $modelMasukGunaAlat,
            'bangunSarpras' => $modelBangunSarpras,
            'bloksektor' => $bloksektor,
            'idRkt' => $idRkt,
            'tenagaKerja' => $modelTenagaKerja,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
}
