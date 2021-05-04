<?php

class RktLingkunganDungtanController extends Controller
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
                'actions' => array('inputJumlahDalkar','deletePantau', 'deleteDalmakit'),
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
$model=new RktLingkunganDungtan;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['RktLingkunganDungtan']))
{
$model->attributes=$_POST['RktLingkunganDungtan'];
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

if(isset($_POST['RktLingkunganDungtan']))
{
$model->attributes=$_POST['RktLingkunganDungtan'];
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

    public function actionDeletePantau($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            RktPemantauanLingkungan::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteDalmakit($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            RktLingkunganDalmakit::model()->findByPk($id)->delete();

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
		if(isset($rkt)) {
            $idRkt = $rkt->id;

            // $jenisDalkar = MasterJenisDalkar::model()->findAll();

            $dungtan = RktLingkunganDungtan::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
            $dalmakit = RktLingkunganDalmakit::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
            $dalkar = RktLingkunganDalkar::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));

            if(empty($dungtan)) {
            	$dungtan = new RktLingkunganDungtan;
            	$dungtan->id_rkt = $rkt->id;
            }if(empty($dalmakit)) {
            	$dalmakit = new RktLingkunganDalmakit;
            	$dalmakit->id_rkt = $rkt->id;
            }

            // if(empty($dalkar)) {
            //     foreach($jenisDalkar as $jd) {
            //         // foreach($jenisTanaman as $jt) {
            //             $dalkar = new RktLingkunganDalkar;
            //             $dalkar->id_rkt = $rkt->id;
            //             $dalkar->id_dalkar = $jd->id;
            //             // $bibit->id_jenis_tanaman = $jt->id;
            //             $dalkar->save();
            //         // }
            //     }
            // }

            if(isset($_POST['RktLingkunganDungtan'])) {
                $dungtan->attributes = $_POST['RktLingkunganDungtan'];
                if($dungtan->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('_index_dungtan_ajax',array(
                            'model'=>$dungtan,
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
            if(isset($_POST['RktLingkunganDalmakit'])) {
            	$dalmakit->attributes = $_POST['RktLingkunganDalmakit'];
            	if($dalmakit->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->renderPartial('_index_dalmakit_ajax',array(
                            'model'=>$dalmakit,
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

            $modelDalkar = new RktLingkunganDalkar;
            $modelDalkar->unsetAttributes();
            if (isset($_GET['RktLingkunganDalkar']))
                $modelDalkar->attributes = $_GET['RktLingkunganDalkar'];
            $modelDalkar->id_rkt = $rkt->id;

            $pantauLingkungan = new RktPemantauanLingkungan;

            $modelPantau = new RktPemantauanLingkungan;
            $modelPantau->unsetAttributes();
            if (isset($_GET['RktPemantauanLingkungan']))
                $modelPantau->attributes = $_GET['RktPemantauanLingkungan'];
            $modelPantau->id_rkt = $rkt->id;

            if(isset($_POST['RktPemantauanLingkungan'])) {
                $pantauLingkungan->attributes = $_POST['RktPemantauanLingkungan'];
                if($pantauLingkungan->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                        echo CJSON::encode(array('status' => 'success'));
                        Yii::app()->end();
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($pantauLingkungan);
                        if ($error != '[]') {
                            echo $error;
                        }
                        Yii::app()->end();
                    }
                }
            }

        }

		// $model=new RktLingkunganDungtan('search');
		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['RktLingkunganDungtan']))
		// 	$model->attributes=$_GET['RktLingkunganDungtan'];

		$this->render('index',array(
            'model'=>$rkt,
            'tahun'=>$tahun,
			'modelDungtan'=>$dungtan,
			'modelDalmakit'=>$dalmakit,
			'modelDalkar'=>$modelDalkar,
            'pantauLingkungan'=>$pantauLingkungan,
            'modelPantau'=>$modelPantau,
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
$model=RktLingkunganDungtan::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

	public function actionInputJumlahDalkar() {
        $post = $_POST['pk'];
        $md = RktLingkunganDalkar::model()->findByPk($post);
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktLingkunganDalkar');
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

        $md = RktLingkunganDalkar::model()->findByPk($post);
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

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='rkt-lingkungan-dungtan-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
