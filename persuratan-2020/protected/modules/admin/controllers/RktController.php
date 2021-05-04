<?php

class RktController extends Controller {

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
                'actions' => array('index', 'view','indexRevRkt','rktProduksiRev',
                                'rktLingkunganRev','rktSosialRev','doApproveRkt',
                                'approveRkt','unApproveRkt'),
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

        $rku = Rku::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . $iup->id_perusahaan));

        if (isset($rku)) {
            $model = new Rkt('search');
            $model->unsetAttributes();  // clear any default values
            $model->id_rku = $rku->id_rku;
        } else {
            $message = Yii::t('app', 'Data RKU belum diisi.');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rku/'.$id));
        }

        if (isset($_GET['Rkt']))
            $model->attributes = $_GET['Rkt'];

        $this->render('index', array(
            'model' => $model,
            'iup' => $iup
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */

    public function actionIndexRevRkt($id,$id_rkt) {
        $this->layout = '//layouts/main-fancy';
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id_rkt));
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id_rkt . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
            if (!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rkt/'.$id));
            }
        }
        $bloksektor = BlokSektor::model()->findAll(array('condition' => 'id_perusahaan = ' . $rkt->id_perusahaan));
        if (isset($rkt)) {
            $idRkt = $rkt->id;

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

        $this->render('test/index', array(
            // 'iup' => $iup,
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
            'idRkt' => $idRkt
        ));
    }

    public function actionRktProduksiRev($id, $id_rkt) {
        $this->layout = '//layouts/main-fancy';
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id_rkt));
        if (isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id_rkt . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
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

            $modelPanenAreal = new RktPanenAreal;
            $modelPanenAreal->unsetAttributes();
            if (isset($_GET['RktPanenAreal']))
                $modelPanenAreal->attributes = $_GET['RktPanenAreal'];
            $modelPanenAreal->id_rkt = $rkt->id;

            $modelPanenTanaman = new RktPanenVolumeTanaman;
            $modelPanenTanaman->unsetAttributes();
            if (isset($_GET['RktPanenVolumeTanaman']))
                $modelPanenTanaman->attributes = $_GET['RktPanenVolumeTanaman'];
            $modelPanenTanaman->id_rkt = $rkt->id;

            $modelPanenSiapLahan = new RktPanenVolumeSiapLahan;
            $modelPanenSiapLahan->unsetAttributes();
            if (isset($_GET['RktPanenVolumeSiapLahan']))
                $modelPanenSiapLahan->attributes = $_GET['RktPanenVolumeSiapLahan'];
            $modelPanenSiapLahan->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/' . $id));
        }

        $this->render('rktProduksi/index', array(
            // 'iup' => $iup,
            'model' => $rkt,
            'modelBibit' => $modelBibit,
            'modelSiapLahan' => $modelSiapLahan,
            'modelTanam' => $modelTanam,
            'modelSulam' => $modelSulam,
            'modelJarang' => $modelJarang,
            'modelDangir' => $modelDangir,
            'modelPanenAreal' => $modelPanenAreal,
            'modelPanenTanaman' => $modelPanenTanaman,
            'modelPanenSiapLahan' => $modelPanenSiapLahan,
            'modelPasar' => $modelPasar
        ));
    }

    public function actionRktLingkunganRev($id, $id_rkt) {
        $this->layout = '//layouts/main-fancy';
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id));
        // if (isset($_POST['Rkt'])) {
        //     $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . $id . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
        //     if (!isset($rkt)) {
        //         $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
        //         Yii::app()->user->setFlash('notice', $message);
        //         $this->redirect(array('//admin/rkt/' . $id));
        //     }
        // }
        if (isset($rkt)) {
            $dungtan = RktLingkunganDungtan::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
            if (empty($dungtan))
                $dungtan = new RktLingkunganDungtan;

            $dalmakit = RktLingkunganDalmakit::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
            if (empty($dalmakit))
                $dalmakit = new RktLingkunganDalmakit;

            $modelDalkar = new RktLingkunganDalkar;
            $modelDalkar->unsetAttributes();
            if (isset($_GET['RktLingkunganDalkar']))
                $modelDalkar->attributes = $_GET['RktLingkunganDalkar'];
            $modelDalkar->id_rkt = $rkt->id;

            $modelPantau = new RktPemantauanLingkungan;
            $modelPantau->unsetAttributes();
            if (isset($_GET['RktPemantauanLingkungan']))
                $modelPantau->attributes = $_GET['RktPemantauanLingkungan'];
            $modelPantau->id_rkt = $rkt->id;
        } else {
            $message = Yii::t('app', 'Data RKT Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//perusahaan/rkt/' . $id));
        }

        $this->render('rktLingkungan/index', array(
            // 'iup' => $iup,
            'model' => $rkt,
            'modelDungtan' => $dungtan,
            'modelDalmakit' => $dalmakit,
            'modelDalkar' => $modelDalkar,
            'modelPantau' => $modelPantau,
        ));
    }

    public function actionRktSosialRev($id, $id_rkt) {
        $this->layout = '//layouts/main-fancy';
        $rkt = Rkt::model()->find(array('condition' => 'id = ' . $id));
        // if (isset($_POST['Rkt'])) {
        //     $rkt = Rkt::model()->find(array('condition' => 'id_perusahaan = ' . $iup->id_perusahaan . ' AND tahun_mulai = ' . $_POST['Rkt']['tahun_mulai']));
        //     if (!isset($rkt)) {
        //         $message = Yii::t('app', 'Data RKT tahun ' . $_POST['Rkt']['tahun_mulai'] . ' belum tersedia.');
        //         Yii::app()->user->setFlash('notice', $message);
        //         $this->redirect(array('//admin/rkt/' . $id));
        //     }
        // }
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
            $this->redirect(array('//perusahaan/rkt/' . $id));
        }

        $this->render('rktSosial/index', array(
            // 'iup' => $iup,
            'model' => $rkt,
            'modelKonflikSosial' => $modelKonflikSosial,
            'modelInfraMukim' => $modelInfraMukim,
            'modelKerjasama' => $kerjasama,
            'modelSdm' => $modelSdm,
            'modelBangunMitra' => $bangunMitra,
        ));
    }
    
    
    
     public function actionDoApproveRkt($id) {
        if($id != ''){
            $resData = Rkt::model()->findByPk($id);
            if(isset($resData)){
                $resData->approval_status = 1;
                
                $resData->update();
            }
        }
        
        $data = array(
            'header' => "Sukses",
            'message' => "RKT Telah Di Setujui",
            'status' => "success"
        );
        
        $this->redirect(array('approveRkt'));
    }
    
    public function actionUnApproveRkt($id) {
        if($id != ''){
            $resData = Rkt::model()->findByPk($id);
            if(isset($resData)){
                $resData->approval_status = 0;
                
                $resData->update();
            }
        }
        
        $data = array(
            'header' => "Sukses",
            'message' => "RKT Telah Di Setujui",
            'status' => "success"
        );
        $this->redirect(array('approveRkt'));
    }
   
    
    public function actionApproveRkt() {
        $model = new Rkt('search');
        $modelDef = new Rkt;
        $model->unsetAttributes();
        $modelDef->unsetAttributes();
        $tahun = 2018;  //default
        
        
        if (isset($_GET['Rkt'])){
            $model->attributes = $_GET['Rkt'];
        }
        if (isset($_POST['tahun'])){
            $tahun = $_POST['tahun'];
        }
        $model->provinsiId = Yii::app()->user->findUser()->id_propinsi;
        $model->tahun_ke=$tahun;
        
        $model = $model->searchRktToApproval();
        
//        
//        print_r("<pre>");
//        print_r($model);
//        print_r("</pre>");
//        die();
        
        
        $this->render('rktApproval/index', array(
            'model' => $model,
            'tahun' => $tahun,
        ));
    }
}
