<?php

class SerapanTenagaKerjaController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    // public $layout='//layouts/column2';
    public $layout = false;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                // 'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'create', 'update', 'delete', 'inputJumlah'),
                'users' => array(Yii::app()->user->perusahaanRole()),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new RealisasiSerapanTenagaKerja;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // echo "<pre>";
        // print_r($_POST);
        // die();
        if (isset($_POST['RealisasiSerapanTenagaKerja'])) {
            $model->attributes = $_POST['RealisasiSerapanTenagaKerja'];
            $model->id_perusahaan = Yii::app()->user->idPerusahaan();
            try {
                if ($model->save())
                    $this->redirect(array('index'));
            } catch (Exception $e) {
                $e->getMessage();
                // echo $e;
                Yii::app()->user->setFlash('error', "Duplikat Data");
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RealisasiSerapanTenagaKerja'])) {
            $model->attributes = $_POST['RealisasiSerapanTenagaKerja'];
            $model->id_perusahaan = Yii::app()->user->idPerusahaan();
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all latest models.
     */
    public function actionLatest() {
        $this->layout = false;
        $dataProvider = new CActiveDataProvider('IuphhkTenagaKerja');
        $dataProvider->criteria->order = 'created DESC';
        $dataProvider->criteria->limit = 4;
        $dataProvider->pagination = false;
        $this->render('latest', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Lists all models.
     */
    // public function actionIndex()
    // {
    // 	$model=new RealisasiSerapanTenagaKerja('search');
    // 	$model->unsetAttributes();  // clear any default values
    // 	if(isset($_GET['RealisasiSerapanTenagaKerja']))
    // 		$model->attributes=$_GET['RealisasiSerapanTenagaKerja'];
    //
	// 	$model->id_perusahaan = Yii::app()->user->idPerusahaan();
    // 	$this->render('index',array(
    // 		'model'=>$model,
    // 	));
    // }

    public function actionIndex() 
        {
        $rku = Rku::model()->find(array(
			'condition'=>'edit_status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()
		));
        $rkt = Rkt::model()->find(array(
			'condition'=>'status = 1 AND id_perusahaan = :id_perusahaan AND id_rku = :id_rku',
			'params'=>array(
				':id_perusahaan'=>Yii::app()->user->idPerusahaan(),
				':id_rku'=>$rku->id_rku
			),
			'order'=>'tahun_mulai DESC'
		));
        if (!isset($rkt)) {
            echo "<div class='alert alert-danger'>Data RKT belum tersedia.</div>";
            exit;
        }
        $tahun = $rkt->tahun_mulai;
        $id_bulan = '1';
        $tahun_periode = $tahun;
        
        if (isset($_POST['FormPeriodeRealisasiPrasyarat'])) {
            $rkt = Rkt::model()->find(array(
                'condition' => 'id_perusahaan = :id_perusahaan AND status = 1 AND tahun_mulai = :tahun_mulai AND id_rku = :id_rku',
                'params' => array(
                    ':id_perusahaan' => Yii::app()->user->idPerusahaan(),
                    ':tahun_mulai' => $_POST['FormPeriodeRealisasiPrasyarat']['rkt'],
                    ':id_rku' => $rku->id_rku
                ),
                'order' => 'tahun_mulai DESC'
            ));
            if (!isset($rkt)) {
                echo "<div class='alert alert-danger'>Data RKT tahun " . $_POST['Rkt']['tahun_mulai'] . " belum tersedia.</div>";
                exit;
            }
            
            $tahun = $rkt->tahun_mulai;
            $tmpBulan = explode('_',$_POST['FormPeriodeRealisasiPrasyarat']['periode']);
	    $tahun_periode = substr($_POST['FormPeriodeRealisasiPrasyarat']['tahun_periode'], -4, 4);
            
            $id_bulan = $tmpBulan[0];
            $tahun = $tmpBulan[1];
        }
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['aksi']) && $_GET['aksi'] === 'updateGrid') {
                $tahun = $_GET['tahun'];
                $id_bulan = $_GET['id_bulan'];
                $tahun_periode = $_GET['tahun_periode'];
                $rkt = Rkt::model()->find(array(
                    'condition' => 'id_perusahaan = :id_perusahaan AND status = 1 AND tahun_mulai = :tahun_mulai AND id_rku = :id_rku',
                    'params' => array(
                        ':id_perusahaan' => Yii::app()->user->idPerusahaan(),
                        ':tahun_mulai' => $tahun,
                        ':id_rku' => $rku->id_rku
                    ),
                    'order' => 'tahun_mulai DESC'
                ));
                $tahun = $tahun;
            }
        }
        if (isset($rkt)) {
            $idRkt = $rkt->id;
            $md = RktSerapanTenagaKerja::model()->findAllByAttributes(array(
                'id_rkt' => $idRkt
            ));
            if ($md) {
                foreach ($md as $key => $value) {
                    $is_exist = RealisasiRktSerapanTenagaKerja::model()->findByAttributes(array(
                        'id_rkt_serapan_tenaga_kerja' => $value->id,
                        'id_bulan' => $id_bulan,
                        'tahun'=>$tahun,    
                    ));
                    if (!$is_exist) {
                        $realisasiBibit = new RealisasiRktSerapanTenagaKerja();
                        $realisasiBibit->id_rkt_serapan_tenaga_kerja = $value->id;
                        $realisasiBibit->id_bulan = $id_bulan;
                        $realisasiBibit->tahun = $tahun_periode;
                        $realisasiBibit->realisasi = 0;
                        $realisasiBibit->persentase = 0;
                        $realisasiBibit->created = new CDbExpression('NOW()');
                        $realisasiBibit->updated = new CDbExpression('NOW()');
                        $realisasiBibit->save();
                    }
                    //cek rkt bulan
                   $mRktBulan = new RktBulan();
                   $mRktBulan->updateRktBulan($idRkt,$tahun_periode,$id_bulan);
                }
            }
            $modelBibit = new RealisasiRktSerapanTenagaKerja();
            $modelBibit->unsetAttributes();
            if (isset($_GET['RealisasiRktSerapanTenagaKerja']))
                $modelBibit->attributes = $_GET['RealisasiRktSerapanTenagaKerja'];
            $modelBibit->id_rkt = $idRkt;
            $modelBibit->id_bulan = $id_bulan;
            $modelBibit->tahun = $tahun_periode;
        }

        $this->render('index', array(
            'model' => $rkt,
            'tahun' => $tahun,
            'id_bulan' => $id_bulan,
            'tahun_periode' => $tahun_periode,
            'modelSerapan' => $modelBibit
        ));        
    }

    public function actionInputJumlah() {
        $post = $_POST['pk'];
        $value = $_POST['value'];
        //die("test");
        $realisasi = RealisasiRktSerapanTenagaKerja::model()->findByPk($post);
        $_md = RktSerapanTenagaKerja::model()->findByPk($realisasi->id_rkt_serapan_tenaga_kerja);

        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RealisasiRktSerapanTenagaKerja');
        if ($_POST['name'] == 'realisasi') {
            if ((!isset($_md->jumlah) || $_md->jumlah == 0)) {
                $model->error('Rencana tidak boleh kosong');
                die;
            // } elseif (floatval($_md->jumlah) < $_POST['value']) {
            //     $model->error('Realisasi tidak boleh lebih dari ' . $_md->jumlah);
            //     die;
            }
        }
        $model->update();

        if (isset($_md->jumlah) && isset($realisasi->realisasi)) {
            $criteria = new CDbCriteria;
            $criteria->select = array(
                'COALESCE(SUM(t.realisasi), 0) AS realisasi'
            );
            $criteria->compare('t.id_rkt_serapan_tenaga_kerja', $realisasi->id_rkt_serapan_tenaga_kerja);
            $getRealisasi = RealisasiRktSerapanTenagaKerja::model()->find($criteria);

            $coba = ($getRealisasi->realisasi / $_md->jumlah) * 100;
            $coba = number_format($coba, 2);

            $realisasi->realisasi = $value;
            $realisasi->persentase = number_format((($value / $_md->jumlah) * 100), 2);
            $realisasi->updated = new CDbExpression('NOW()');
            $realisasi->save();

            $_md->realisasi = ($getRealisasi->realisasi);
            $_md->persentase = $coba;
            $_md->update();
        }
    }

    /**
     * Lists all models.
     */
    public function actionList() {
        $dataProvider = new CActiveDataProvider('IuphhkTenagaKerja');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    // public function actionAdmin()
    // {
    // 	$model=new IuphhkTenagaKerja('search');
    // 	$model->unsetAttributes();  // clear any default values
    // 	if(isset($_GET['IuphhkTenagaKerja']))
    // 		$model->attributes=$_GET['IuphhkTenagaKerja'];
    //
	// 	$this->render('admin',array(
    // 		'model'=>$model,
    // 	));
    // }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return IuphhkTenagaKerja the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RealisasiSerapanTenagaKerja::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param IuphhkTenagaKerja $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'iuphhk-tenaga-kerja-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
