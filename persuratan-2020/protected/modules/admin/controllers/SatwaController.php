<?php

class SatwaController extends Controller {

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

        $pokhut = new KelompokHutan('search');
        $pokhut->unsetAttributes();
        $pokhut->id_iuphhk = $id;

        $lahan = KeadaanLahan::model()->with(array('idIuphhk'))->find(array('condition' => 't.id_iuphhk=' . $id));
        $d_lahan = array();
        if ($lahan) {
            $total = $lahan->lahan_kering + $lahan->basah + $lahan->payau;
            $d_lahan[0]['jenis'] = 'Lahan Kering';
            $d_lahan[0]['jml'] = $lahan->lahan_kering;
            $d_lahan[0]['persen'] = ($lahan->lahan_kering != 0) ? Yii::app()->numberFormatter->formatPercentage($lahan->lahan_kering / $total) : "-";

            $d_lahan[1]['jenis'] = 'Basah';
            $d_lahan[1]['jml'] = $lahan->basah;
            $d_lahan[1]['persen'] = ($lahan->basah != 0) ? Yii::app()->numberFormatter->formatPercentage($lahan->basah / $total) : "-";

            $d_lahan[2]['jenis'] = 'Payau';
            $d_lahan[2]['jml'] = $lahan->payau;
            $d_lahan[2]['persen'] = ($lahan->payau != 0) ? Yii::app()->numberFormatter->formatPercentage($lahan->payau / $total) : "-";
        }

        $keadaan_lahan = new CArrayDataProvider($d_lahan, array(
            'keyField' => 'jenis',
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));

        $topografi = Topografi::model()->with(array('idIuphhk'))->find(array('condition' => 't.id_iuphhk=' . $id));
        if (empty($topografi))
            $topografi = new Topografi;

        $iklim = Iklim::model()->find(array('condition' => 'id_iuphhk=' . $id));
        if (empty($iklim))
            $iklim = new Iklim;

        $satwa = new IuphhkSatwa('search');
        $satwa->unsetAttributes();  // clear any default values
        if (isset($_GET['IuphhkSatwa']))
            $satwa->attributes = $_GET['IuphhkSatwa'];
        $satwa->id_iuphhk = $id;

        $this->render('index', array(
            'iup' => $iup,
            'pokhut' => $pokhut,
            'keadaan_lahan' => $keadaan_lahan,
            'topografi' => $topografi,
            'iklim' => $iklim,
            'satwa' => $satwa
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
}