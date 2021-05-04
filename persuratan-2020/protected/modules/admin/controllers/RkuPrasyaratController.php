<?php

class RkuPrasyaratController extends Controller {

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
        $jenisGanis = MasterJenisGanis::model()->findAll();
        $rku = Rku::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . $iup->id_perusahaan));
        if (isset($_POST['Rku'])) {
            $periode = explode("-", str_replace(" ", "", $_POST['Rku']['periode']));
            $rku = Rku::model()->find(array('condition' => 'status = 1 AND id_perusahaan = ' . $iup->id_perusahaan . ' AND tahun_mulai = ' . $periode[0]));
            if (!isset($rku)) {
                $message = Yii::t('app', 'Data RKU periode tahun ' . $_POST['Rku']['periode'] . ' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//admin/rku/' . $id));
            }
        }
        if (isset($rku)) {
            $idRku = $rku->id_rku;

            $ganis = RkuGanis::model()->findAll(array('condition' => 'id_rku = ' . $rku->id_rku));
//            print_r($ganis);die;
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
//                    echo $gan->jumlah;
                    $gan->update(array('jumlah'));
                }
            }
//            $modelGanis = new RkuGanis;
//            $modelGanis->unsetAttributes();
//            if (isset($_GET['RkuGanis']))
//                $modelGanis->attributes = $_GET['RkuGanis'];
//            $modelGanis->id_rku = $rku->id_rku;

            $modelGanis = new RkuSerapanTenagaKerja;
            $modelGanis->unsetAttributes();  // clear any default values
            if (isset($_GET['RkuSerapanTenagaKerja']))
                $modelGanis->attributes = $_GET['RkuSerapanTenagaKerja'];
            $modelGanis->id_rku = $rku->id_rku;
            
            
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

        $this->render('index', array(
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
            'sarpras' => $sarpras,
            'naker' => $gridSerapanNaker
        ));
    }

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
