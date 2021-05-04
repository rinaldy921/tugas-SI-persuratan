<?php

class RktInfraMukimController extends Controller
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='//layouts/column2';

/**
* @return array action filters
*/
public function filters()
{
return array(
'accessControl', // perform access control for CRUD operations
);
}

	public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('inputJumlahInfraMukim','inputJumlahPeningkatanSdm','inputStatusKonflik','deleteKonflik'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
public function actionView($id)
{
$this->render('view',array(
'model'=>$this->loadModel($id),
));
}

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
$model=new RktInfraMukim;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['RktInfraMukim']))
{
$model->attributes=$_POST['RktInfraMukim'];
if($model->save()){
$message = Yii::t('app', 'Data berhasil disimpan.');
Yii::app()->user->setFlash('success', $message);
$this->redirect(array('index'));
}
}

$this->render('create',array(
'model'=>$model,
));
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id)
{
$model=$this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['RktInfraMukim']))
{
$model->attributes=$_POST['RktInfraMukim'];
if($model->save()){
$message = Yii::t('app', 'Data berhasil disimpan.');
Yii::app()->user->setFlash('success', $message);
$this->redirect(array('index'));
}
}

$this->render('update',array(
'model'=>$model,
));
}

/**
* Deletes a particular model.
* If deletion is successful, the browser will be redirected to the 'admin' page.
* @param integer $id the ID of the model to be deleted
*/
public function actionDelete($id)
{
if(Yii::app()->request->isPostRequest)
{
// we only allow deletion via POST request
$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
if(!isset($_GET['ajax']))
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
}
else
throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

    public function actionDeleteKonflik($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
        // we only allow deletion via POST request
            $konflik = RktKonflikSosial::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

	/**
	* Manages all models.
	*/
	public function actionIndex()
	{
        $rku = Rku::model()->find(array('condition'=>'edit_status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan()));
        $rkt = Rkt::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '. Yii::app()->user->idPerusahaan(). ' AND id_rku = '. $rku->id_rku,'order'=>'tahun_mulai DESC'));
        if(!isset($rkt)) {
            $message = Yii::t('app', 'Data RKT belum tersedia.');
            Yii::app()->user->setFlash('notice', $message);
            $this->redirect(array('//perusahaan/rkt/index'));
        }
        $tahun = $rkt->tahun_mulai;
        if(isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan().' AND status = 1 AND tahun_mulai = '. $_POST['Rkt']['tahun_mulai']. ' AND id_rku = '. $rku->id_rku, 'order'=>'tahun_mulai DESC' ));
            if(!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun '.$_POST['Rkt']['tahun_mulai'].' belum tersedia.');
                Yii::app()->user->setFlash('notice', $message);
                $this->redirect(array('//perusahaan/rkt/index'));
            }
            $tahun = $rkt->tahun_mulai;
        }
        
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['aksi']) && $_GET['aksi']==='updateGrid') {
                $tahun = $_GET['tahun'];
                $rkt = Rkt::model()->find(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan().' AND status = 1 AND tahun_mulai = '. $tahun. ' AND id_rku = '. $rku->id_rku, 'order'=>'tahun_mulai DESC' ));
                $tahun = $tahun;
            }
        }

		$jenisInfraMukim = MasterJenisInfraMukim::model()->findAll();
		$jenisSdm = MasterJenisPeningkatanSdm::model()->findAll();

		$inframukim = RktInfraMukim::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
		$sdm = RktPeningkatanSdm::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
		$kerjasama = RktKerjasamaKoperasi::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
		$bangunMitra = RktBangunMitra::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
        // $konflikSosial = RktKonflikSosial::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));

		if(isset($rkt)) {
            $idRkt = $rkt->id;

            // if(empty($inframukim)) {
            //     foreach($jenisInfraMukim as $jim) {
            //         // foreach($jenisTanaman as $jt) {
            //         $inframukim = new RktInfraMukim;
            //         $inframukim->id_rkt = $rkt->id;
            //         $inframukim->id_infra_mukim = $jim->id;
            //         // $bibit->id_jenis_tanaman = $jt->id;
            //         $inframukim->save();
            //         // }
            //     }
            // }
            // if(empty($sdm)) {
            //     foreach($jenisSdm as $jsdm) {
            //         // foreach($jenisTanaman as $jt) {
            //         $sdm = new RktPeningkatanSdm;
            //         $sdm->id_rkt = $rkt->id;
            //         $sdm->id_peningkatan_sdm = $jsdm->id;
            //         // $bibit->id_jenis_tanaman = $jt->id;
            //         $sdm->save();
            //         // }
            //     }
            // }
            if(empty($kerjasama)) {
            	$kerjasama = new RktKerjasamaKoperasi;
            	$kerjasama->id_rkt = $rkt->id;
            }
            if(empty($bangunMitra)) {
            	$bangunMitra = new RktBangunMitra;
            	$bangunMitra->id_rkt = $rkt->id;
            }
            if(isset($_POST['RktKerjasamaKoperasi'])) {
            	$kerjasama->attributes = $_POST['RktKerjasamaKoperasi'];
            	if($kerjasama->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('_index_kerjasama_ajax',array(
                            'model'=>$kerjasama,
                            'tahun'=>$tahun,
                            'idRkt'=>$idRkt
                        ));
                        Yii::app()->end();
                    }
	            	$message = Yii::t('app', 'Data berhasil disimpan.');
	                Yii::app()->user->setFlash('success', $message);
	                $this->redirect(array('index'));
	            }
            }if(isset($_POST['RktBangunMitra'])) {
            	$bangunMitra->attributes = $_POST['RktBangunMitra'];
            	if($bangunMitra->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('_index_bangunmitra_ajax',array(
                            'model'=>$bangunMitra,
                            'tahun'=>$tahun,
                            'idRkt'=>$idRkt
                        ));
                        Yii::app()->end();
                    }
	            	$message = Yii::t('app', 'Data berhasil disimpan.');
	                Yii::app()->user->setFlash('success', $message);
	                $this->redirect(array('index'));
	            }
            }

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

            $konflikSosial = new RktKonflikSosial;
            // $konflikSosial = 

            $modelKonflikSosial = new RktKonflikSosial;
            $modelKonflikSosial->unsetAttributes();
            if (isset($_GET['RktKonflikSosial']))
                $modelKonflikSosial->attributes = $_GET['RktKonflikSosial'];
            $modelKonflikSosial->id_rkt = $rkt->id;

            if(isset($_POST['RktKonflikSosial'])) {
                $konflikSosial->attributes = $_POST['RktKonflikSosial'];
                if($konflikSosial->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($konflikSosial);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }
        }
	// $model=new RktInfraMukim('search');
	// $model->unsetAttributes();  // clear any default values
	// if(isset($_GET['RktInfraMukim']))
	// $model->attributes=$_GET['RktInfraMukim'];

		$this->render('index',array(
            'model'=>$rkt,
            'tahun'=>$tahun,
            'konflikSosial'=>$konflikSosial,
            'modelKonflikSosial'=>$modelKonflikSosial,
			'modelInfraMukim'=>$modelInfraMukim,
			'modelKerjasama'=>$kerjasama,
			'modelSdm'=>$modelSdm,
			'modelBangunMitra'=>$bangunMitra,
			'idRkt'=>$idRkt
		));
	}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=RktInfraMukim::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

	public function actionInputJumlahInfraMukim() {
        $post = $_POST['pk'];
        $md = RktInfraMukim::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktInfraMukim');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktInfraMukim::model()->findByPk($post);
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputJumlahPeningkatanSdm() {
        $post = $_POST['pk'];
        $md = RktPeningkatanSdm::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktPeningkatanSdm');
        if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
            $model->error('Rencana tidak boleh kosong');die;
        } elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
            $model->error('Realisasi tidak boleh lebih dari 0');die;
        }

        $model->update();
        // if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
        //     $md->jumlah = 0;
        //     $md->realisasi = 0;
        //     $md->save();
        // } 
        // if($_POST['value']==null && $_POST['name'] == 'jumlah'){
        //     $md->jumlah = null;
        //     $md->realisasi = null;
        //     $md->save();
        // }

        $md = RktPeningkatanSdm::model()->findByPk($post);
        if(!isset($md->jumlah) && isset($md->realisasi)) {
            $md->realisasi = '';
            $md->persentase = '';
            $md->save();
        }
        if(isset($md->jumlah) && isset($md->realisasi)) {
            // if(floatval($md->jumlah) == 0) {
            //     $coba = '100.00';
            // } else {
                $coba = ($md->realisasi / $md->jumlah) * 100;
            // }
            $md->persentase = str_replace(',','.',$coba);
            $md->save();
        }
        if(empty($md->realisasi) || empty($md->jumlah)) {
            $md->persentase = '';
            $md->save();
        }
    }

    public function actionInputStatusKonflik() {
        $post = $_POST['pk'];
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktKonflikSosial');
        $model->update();
    }

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='rkt-infra-mukim-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
