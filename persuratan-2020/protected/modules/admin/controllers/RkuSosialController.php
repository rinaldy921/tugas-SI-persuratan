<?php

class RkuSosialController extends Controller {

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

        $this->render('index', array(
            'iup' => $iup,
            'model' => $rku,
            'mukim' => $mukim,
            'lembaga' => $lembaga,
            'fungsos' => $fungsos,
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
