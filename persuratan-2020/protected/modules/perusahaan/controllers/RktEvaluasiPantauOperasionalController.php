<?php

class RktEvaluasiPantauOperasionalController extends Controller
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
                'actions' => array(
                    'inputJumlahGanisOpr',
                    'inputJumlahGanisBerhasil'
                ),
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
$model=new RktEvaluasiPantauOperasional;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['RktEvaluasiPantauOperasional']))
{
$model->attributes=$_POST['RktEvaluasiPantauOperasional'];
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

if(isset($_POST['RktEvaluasiPantauOperasional']))
{
$model->attributes=$_POST['RktEvaluasiPantauOperasional'];
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

	/**
	* Manages all models.
	*/
	public function actionIndex()
	{
		$rkt = Rkt::model()->find(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan()));
		if(isset($_POST['Rkt'])) {
            $rkt = Rkt::model()->find(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan().' AND tahun_mulai = '. $_POST['Rkt']['tahun_mulai'] ));
            if(!isset($rkt)) {
                $message = Yii::t('app', 'Data RKT tahun '.$_POST['Rkt']['tahun_mulai'].' belum tersedia.');
                Yii::app()->user->setFlash('error', $message);
                $this->redirect(array('//perusahaan/rkt/index'));
            }
        }

		if(isset($rkt)) {
			$idRkt = $rkt->id;

			$ganisOpr = RktEvaluasiPantauOperasional::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
			$ganisBerhasil = RktEvaluasiKeberhasilan::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
			$jenisGanis = MasterJenisGanis::model()->findAll();

			if(empty($ganisOpr)) {
				foreach($jenisGanis as $jg) {
					$ganisOpr = new RktEvaluasiPantauOperasional;
					$ganisOpr->id_rkt = $rkt->id;
					$ganisOpr->id_ganis = $jg->id;
					$ganisOpr->save();
				}
			}
			if(empty($ganisBerhasil)) {
				foreach($jenisGanis as $jg) {
					$ganisBerhasil = new RktEvaluasiKeberhasilan;
					$ganisBerhasil->id_rkt = $rkt->id;
					$ganisBerhasil->id_ganis = $jg->id;
					$ganisBerhasil->save();
				}
			}

			$modelGanis = new RktEvaluasiPantauOperasional;
			$modelGanis->unsetAttributes();
			if (isset($_GET['RktEvaluasiPantauOperasional']))
	            $modelGanis->attributes = $_GET['RktEvaluasiPantauOperasional'];
			$modelGanis->id_rkt = $rkt->id;

			$modelGanisBerhasil = new RktEvaluasiKeberhasilan;
			$modelGanisBerhasil->unsetAttributes();
			if (isset($_GET['RktEvaluasiKeberhasilan']))
	            $modelGanisBerhasil->attributes = $_GET['RktEvaluasiKeberhasilan'];
			$modelGanisBerhasil->id_rkt = $rkt->id;

			if(isset($ganisOpr)) {
				$ganisOpr = RktEvaluasiPantauOperasional::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
				foreach($ganisOpr as $gn) {
					$id_ganis[] = $gn->id_ganis;
				}
	        	$jenisGanisz = MasterJenisGanis::model()->findAll('id NOT IN ('.implode(',',$id_ganis).')');
	        	if(!empty($jenisGanisz)) {
					foreach($jenisGanisz as $jgn) {
						$ganisOpr = new RktEvaluasiPantauOperasional;
						$ganisOpr->id_rkt = $rkt->id;
						$ganisOpr->id_ganis = $jgn->id;
						$ganisOpr->save();
					}
				}
	        }
	        if(isset($ganisBerhasil)) {
				$ganisBerhasil = RktEvaluasiPantauOperasional::model()->findAll(array('condition'=>'id_rkt = '.$rkt->id ));
				foreach($ganisBerhasil as $gn) {
					$id_ganis[] = $gn->id_ganis;
				}
	        	$jenisGanisz = MasterJenisGanis::model()->findAll('id NOT IN ('.implode(',',$id_ganis).')');
	        	if(!empty($jenisGanisz)) {
					foreach($jenisGanisz as $jgn) {
						$ganisBerhasil = new RktEvaluasiPantauOperasional;
						$ganisBerhasil->id_rkt = $rkt->id;
						$ganisBerhasil->id_ganis = $jgn->id;
						$ganisBerhasil->save();
					}
				}
	        }
		}

		$this->render('index',array(
			'model'=>$rkt,
			'modelGanisOpr'=>$modelGanis,
			'modelGanisBerhasil'=>$modelGanisBerhasil,
		));
	}

	public function actionInputJumlahGanisOpr() {
		$post = $_POST['pk'];
		$md = RktEvaluasiPantauOperasional::model()->findByPk($post);
		Yii::import('booster.components.TbEditableSaver');
		$model = new TbEditableSaver('RktEvaluasiPantauOperasional');
		if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
			$model->error('Rencana tidak boleh kosong');die;
		} elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
			$model->error('Realisasi tidak boleh lebih dari 0');die;
		}

		$model->update();
		// if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
		// 	$md->jumlah = 0;
		// 	$md->realisasi = 0;
		// 	$md->save();
		// } 
		// if($_POST['value']==null && $_POST['name'] == 'jumlah'){
		// 	$md->jumlah = null;
		// 	$md->realisasi = null;
		// 	$md->save();
		// }

		$md = RktEvaluasiPantauOperasional::model()->findByPk($post);
		if(isset($md->realisasi)) {
			// if(floatval($md->jumlah) == 0) {
			// 	$coba = '100.00';
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
	public function actionInputJumlahGanisBerhasil() {
		$post = $_POST['pk'];
		$md = RktEvaluasiKeberhasilan::model()->findByPk($post);
		Yii::import('booster.components.TbEditableSaver');
		$model = new TbEditableSaver('RktEvaluasiKeberhasilan');
		if($_POST['name'] == 'realisasi' && !isset($md->jumlah)) {
			$model->error('Rencana tidak boleh kosong');die;
		} elseif($_POST['name'] == 'realisasi' && floatval($md->jumlah) == '0' && floatval($md->jumlah) < $_POST['value']) {
			$model->error('Realisasi tidak boleh lebih dari 0');die;
		}

		$model->update();
		// if($_POST['name'] == 'jumlah' && $_POST['value'] == '0') {
		// 	$md->jumlah = 0;
		// 	$md->realisasi = 0;
		// 	$md->save();
		// } 
		// if($_POST['value']==null && $_POST['name'] == 'jumlah'){
		// 	$md->jumlah = null;
		// 	$md->realisasi = null;
		// 	$md->save();
		// }

		$md = RktEvaluasiKeberhasilan::model()->findByPk($post);
		if(isset($md->realisasi)) {
			// if(floatval($md->jumlah) == 0) {
			// 	$coba = '100.00';
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
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=RktEvaluasiPantauOperasional::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='rkt-evaluasi-pantau-operasional-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
