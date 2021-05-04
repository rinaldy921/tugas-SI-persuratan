<?php

class RkuController extends Controller {

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
                'actions' => array('index', 'view','indexRevRku','viewProduksi','viewPrasyarat','viewLingkungan','viewSosial',
                    'rktIndex','indexRevRkt'),
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

        $model = new Rku('search');
        $model->unsetAttributes();  // clear any default values
        $model->id_perusahaan = $iup->id_perusahaan;

        $this->render('index', array(
            'model' => $model,
            'iup' => $iup
        ));
    }

    public function actionIndexRevRku($id, $id_rku) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $s_silvikultur = RkuSistemSilvikultur::model()->find(array('condition' => 'id_rku='.$rku->id_rku));
            if(is_null($s_silvikultur))
            $s_silvikultur = new RkuSistemSilvikultur;

            $tanaman = new RkuTanamanSilvikultur('search');
            $tanaman->unsetAttributes();
            $tanaman->id_rku = $rku->id_rku;
            
            $potensiProduksi = RkuPotensiProduksi::model()->find(array('condition' => 'id_rku='.$rku->id_rku));
            if(is_null($potensiProduksi))
            $potensiProduksi = new RkuPotensiProduksi;
            
            $hhbk = new RkuHasilHutanNonkayuSilvikultur('search');
            $hhbk->unsetAttributes();
            $hhbk->id_rku = $rku->id_rku;
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rku/' . $id));
        }

        $this->render('sisil/index', array(
            'iup' => $iup,
            'model' => $rku,
            'silvikultur' => $s_silvikultur,
            'tanaman' => $tanaman,
            'potensiProduksi' => $potensiProduksi,
            'hhbk' => $hhbk  
        ));
    }

    public function actionViewPrasyarat($id, $id_rku) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $idRku = $rku->id_rku;

            $ganis = RkuGanis::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
            if (empty($ganis)) {
                foreach ($jenisGanis as $jg) {
                    $gans = new RkuGanis;
                    $gans->id_rku = $rku->id_rku;
                    $gans->id_ganis = $jg->id;
                    $gans->jumlah = $this->cekLuas($jg->id, $id);
                    $gans->save(false);
                }
            }  else {
                foreach ($ganis as $jg) {
                    $gan = RkuGanis::model()->find(array('condition' => 'id_rku = ' . $rku->id_rku.' AND id_ganis = ' . $jg->id_ganis));
                    $gan->jumlah = $this->cekLuas($jg->id_ganis, $id);
                    $gan->update(array('jumlah'));
                }
            }
            
            $modelGanis = new RkuSerapanTenagaKerja;
            $modelGanis->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuSerapanTenagaKerja']))
            $modelGanis->attributes = $_GET['RkuSerapanTenagaKerja'];
            $modelGanis->id_rku = $rku->id_rku;
            
//            $modelGanis = new RkuGanis;
//            $modelGanis->unsetAttributes();
//            if (isset($_GET['RkuGanis']))
//                $modelGanis->attributes = $_GET['RkuGanis'];
//            $modelGanis->id_rku = $rku->id_rku;

            $modelTataBatas = new RkuTataBatas;
            $modelTataBatas->unsetAttributes();
            if (isset($_GET['RkuTataBatas']))
                $modelTataBatas->attributes = $_GET['RkuTataBatas'];
            $modelTataBatas->id_rku = $rku->id_rku;

            $modelKawasan = new RkuKawasanLindung;
            $modelKawasan->unsetAttributes();
            if (isset($_GET['RkuKawasanLindung']))
                $modelKawasan->attributes = $_GET['RkuKawasanLindung'];
            $modelKawasan->id_rku = $rku->id_rku;

            $modelArealNonProduktif = new RkuArealNonProduktif;
            $modelArealNonProduktif->unsetAttributes();
            if (isset($_GET['RkuArealNonProduktif']))
                $modelArealNonProduktif->attributes = $_GET['RkuArealNonProduktif'];
            $modelArealNonProduktif->id_rku = $rku->id_rku;

            $modelArealProduktif = new RkuArealProduktif('search');
            $modelArealProduktif->unsetAttributes();
            if (isset($_GET['RkuArealProduktif']))
                $modelArealProduktif->attributes = $_GET['RkuArealProduktif'];
            $modelArealProduktif->id_rku = $rku->id_rku;

            $modelArealKerja = new RkuArealKerja;
            $modelArealKerja->unsetAttributes();
            if (isset($_GET['RkuArealKerja']))
                $modelArealKerja->attributes = $_GET['RkuArealKerja'];
            $modelArealKerja->id_rku = $rku->id_rku;

            $modelPwh = new RkuPwh;
            $modelPwh->unsetAttributes();
            if (isset($_GET['RkuPwh']))
                $modelPwh->attributes = $_GET['RkuPwh'];
            $modelPwh->id_rku = $rku->id_rku;
            
            $peralatan = new RkuPeralatan;
            $peralatan->unsetAttributes();
            if (isset($_GET['RkuPeralatan']))
                $peralatan->attributes = $_GET['RkuPeralatan'];
            $peralatan->id_rku = $rku->id_rku;
            
            $sarpras = new RkuSarpras;
            $sarpras->unsetAttributes();
            if (isset($_GET['RkuSarpras']))
                $sarpras->attributes = $_GET['RkuSarpras'];
            $sarpras->id_rku = $rku->id_rku;
            
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rku/' . $id));
        }

        $this->render('prasyarat/index', array(
            'iup' => $iup,
            'model' => $rku,
            'ganis' => $modelGanis,
            'tatabatas' => $modelTataBatas,
            'tataruang' => $modelKawasan,
            'arealProduktif' => $modelArealProduktif,
            'arealKerja' => $modelArealKerja,
            'arealNonProduktif' => $modelArealNonProduktif,
            'pwh' => $modelPwh,
            'idRku' => $idRku,
            'peralatan' => $peralatan,
            'sarpras' => $sarpras
        ));
    }

    public function actionViewProduksi($id, $id_rku) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {

            $modelBibit = new RkuBibit();
            $modelBibit->unsetAttributes();
            if (isset($_GET['RkuBibit']))
                $modelBibit->attributes = $_GET['RkuBibit'];
            $modelBibit->id_rku = $rku->id_rku;
            
            $siapLahan = new RkuPenyiapanLahan('search');
            $siapLahan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPenyiapanLahan']))
                $siapLahan->attributes = $_GET['RkuPenyiapanLahan'];
            $siapLahan->id_rku = $rku->id_rku;

            $penanaman = new RkuTanam('search');
            $penanaman->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuTanam']))
                $penanaman->attributes = $_GET['RkuTanam'];
            $penanaman->id_rku = $rku->id_rku;

            $pemeliharaan = new RkuPelihara('search');
            $pemeliharaan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPelihara']))
                $pemeliharaan->attributes = $_GET['RkuPelihara'];
            $pemeliharaan->id_rku = $rku->id_rku;

            $panen = new RkuPanen('search');
            $panen->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPanen']))
                $panen->attributes = $_GET['RkuPanen'];
            $panen->id_rku = $rku->id_rku;
            
            $hhbk = new RkuHasilHutanNonkayu('search');
            $hhbk->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuHasilHutanNonkayu']))
                $hhbk->attributes = $_GET['RkuHasilHutanNonkayu'];
            $hhbk->id_rku = $rku->id_rku;
            
            $pasar = new RkuPasar('search');
            $pasar->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPasar']))
                $pasar->attributes = $_GET['RkuPasar'];
            $pasar->id_rku = $rku->id_rku;
            
            $pasarHhbk = new RkuPasarHhbk('search');
            $pasarHhbk->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPasarHhbk']))
                $pasarHhbk->attributes = $_GET['RkuPasarHhbk'];
            $pasarHhbk->id_rku = $rku->id_rku;
            
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rku/' . $id));
        }

        $this->render('produksi/index', array(
            'iup' => $iup,
            'model' => $rku,
            'modelBibit' => $modelBibit,
            'siapLahan' => $siapLahan,
            'penanaman' => $penanaman,
            'pemeliharaan' => $pemeliharaan,
            'panen' => $panen,
            'hhbk' => $hhbk,
            'pasar' => $pasar,
            'pasarHhbk' => $pasarHhbk,
        ));
    }

    public function actionViewLingkungan($id, $id_rku) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $idRku = $rku->id_rku;

            $hamkit = new RkuHamaPenyakit('search');
            $hamkit->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuHamaPenyakit']))
                $hamkit->attributes = $_GET['RkuHamaPenyakit'];
            $hamkit->id_rku = $rku->id_rku;

            $tekdam = new RkuTeknikPemadaman('search');
            $tekdam->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuTeknikPemadaman']))
                $tekdam->attributes = $_GET['RkuTeknikPemadaman'];
            $tekdam->id_rku = $rku->id_rku;

            $alatDamkar = new RkuAlatDamkar('search');
            $alatDamkar->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuAlatDamkar']))
                $alatDamkar->attributes = $_GET['RkuAlatDamkar'];
            $alatDamkar->id_rku = $rku->id_rku;

            $perambahan = new RkuPerambahanHutan('search');
            $perambahan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPerambahanHutan']))
                $perambahan->attributes = $_GET['RkuPerambahanHutan'];
            $perambahan->id_rku = $rku->id_rku;

            $perlindungan = new RkuPerlindunganHutan('search');
            $perlindungan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPerlindunganHutan']))
                $perlindungan->attributes = $_GET['RkuPerlindunganHutan'];
            $perlindungan->id_rku = $rku->id_rku;
            
            $pemantauan = new RkuPemantauanLingkungan('search');
            $pemantauan->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuPemantauanLingkungan']))
                $pemantauan->attributes = $_GET['RkuPemantauanLingkungan'];
            $pemantauan->id_rku = $rku->id_rku;
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rku/' . $id));
        }

        $this->render('lingkungan/index', array(
            'iup' => $iup,
            'model' => $rku,
            'hamkit' => $hamkit,
            'tekdam' => $tekdam,
            'alatDamkar' => $alatDamkar,
            'perambahan' => $perambahan,
            'pemantauan' => $pemantauan,
            'perlindungan' => $perlindungan,
        ));
    }

    public function actionViewSosial($id, $id_rku) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'id_rku = ' . $id_rku . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $idRku = $rku->id_rku;

            $mukim = new RkuInfraMukim('search');
            $mukim->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuInfraMukim']))
                $mukim->attributes = $_GET['RkuInfraMukim'];
            $mukim->id_rku = $rku->id_rku;

            $lembaga = new RkuKelembagaan('search');
            $lembaga->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuKelembagaan']))
                $lembaga->attributes = $_GET['RkuKelembagaan'];
            $lembaga->id_rku = $rku->id_rku;
            
            $fungsos = new RkuFungsos('search');
            $fungsos->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuFungsos']))
            $fungsos->attributes = $_GET['RkuFungsos'];
            $fungsos->id_rku = $rku->id_rku;
            
        } else {
            $message = Yii::t('app', 'Data RKU Belum ada');
            Yii::app()->user->setFlash('error', $message);
            $this->redirect(array('//admin/rku/' . $id));
        }

        $this->render('sosial/index', array(
            'iup' => $iup,
            'model' => $rku,
            'mukim' => $mukim,
            'lembaga' => $lembaga,
            'fungsos' => $fungsos,
        ));
    }

    public function actionRktIndex($id, $id_rku) {
        $iup = Iuphhk::model()->findByPk($id);
        if (!isset($iup)) {
            $message = Yii::t('app', 'Data IUPHHK yang anda pilih belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//admin/iuphhk/index'));
        }
        $rku = Rku::model()->findByPk($id_rku);
        $rkt = new Rkt;
        $rkt->unsetAttributes();
        $rkt->id_rku = $id_rku;

        $this->render('rkt/index',array(
            'model'=>$rkt,
            'iup'=>$iup,
            'rku'=>$rku
        ));
    }

    public function actionIndexRevRkt($id, $id_rkt) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.admin.controllers.RktController');
        RktController::actionIndexRevRkt($id, $id_rkt);
    }

    public function actionRktProduksiRev($id, $id_rkt) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.admin.controllers.RktController');
        RktController::actionRktProduksiRev($id, $id_rkt);
    }

    public function actionRktLingkunganRev($id, $id_rkt) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.admin.controllers.RktController');
        RktController::actionRktLingkunganRev($id, $id_rkt);
    }

    public function actionRktSosialRev($id, $id_rkt) {
        $this->layout = '//layouts/main-fancy';
        Yii::import('application.modules.admin.controllers.RktController');
        RktController::actionRktSosialRev($id, $id_rkt);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */

    protected function cekLuas($id, $iup) {
        $iuphhk = Iuphhk::model()->findByPk($iup);
        $masterGanis = MasterJenisGanis::model()->find(array('condition' => 'id = ' . $id));
        if (isset($iuphhk)) {
            if ($iuphhk->luas < floatval(50000)) {
                $hasil = empty($masterGanis->val1) ? null : $masterGanis->val1;
            } elseif ($iuphhk->luas >= floatval(50000) && $iuphhk->luas <= floatval(100000)) {
                $hasil = empty($masterGanis->val2) ? null : $masterGanis->val2;
            } elseif ($iuphhk->luas >= floatval(100000) && $iuphhk->luas <= floatval(200000)) {
                $hasil = empty($masterGanis->val3) ? null : $masterGanis->val3;
            } elseif ($iuphhk->luas > floatval(200000)) {
                $hasil = empty($masterGanis->val4) ? null : $masterGanis->val4;
            }
        }
        return $hasil;
    }
}
