<?php

class MasterBphpController extends Controller
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
		array(
			'allow', // allow authenticated user to perform 'create' and 'update' actions
			'actions' => array('create', 'update'),
			'users' => array(Yii::app()->user->adminRole()),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
			'actions' => array('admin', 'delete'),
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
public function actionView($id)
{
	$wilayah = new BphpWilayahKerja;
	$wilayah->id_master_bphp = $id;

	$this->render('view',array(
		'model'=>$this->loadModel($id),
		'wilayah'=>$wilayah
	));
}

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
	$model = new MasterBphp;
	$wilayah = new BphpWilayahKerja;
	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if(isset($_POST['MasterBphp']))
	{
		$pesan = array();
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$model->attributes = $_POST['MasterBphp'];
			if($model->save()){
				foreach($model->getErrors() as $key=>$val){
					$pesan[] = $key . " : " . implode(", ", $val);
				}
			}
			if(count($_POST['BphpWilayahKerja']['id_provinsi']) > 0){
				foreach($_POST['BphpWilayahKerja']['id_provinsi'] as $key => $value){
					$mod = new BphpWilayahKerja;
					$mod->id_master_bphp = $model->id;
					$mod->id_provinsi = $value;
					if($mod->save()){
						foreach($mod->getErrors() as $key=>$val){
							$pesan['id_provinsi'] = $key . " : " . implode(", ", $val);
						}
					}
				}
			}else{
				$pesan[] = "Silahkan isi provinsi";
			}
			if(count($pesan) > 0){
				throw new Exception(implode("<br>", $pesan));
			}
			$transaction->commit();

			$message = Yii::t('app', 'Data berhasil disimpan.');
			Yii::app()->user->setFlash('success', $message);
			$this->redirect(array('index'));
		}catch (Exception $e){
			$transaction->rollback();
		}
	}

	$this->render('create',array(
		'model'=>$model,
		'wilayah'=>$wilayah,
	));
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id)
{
	$model = $this->loadModel($id);
	$wilayah = new BphpWilayahKerja;
	$_wilayah = BphpWilayahKerja::model()->findAllByAttributes(array(
		'id_master_bphp'=>$id
	));
	$wilayah_temp = array();
	foreach($_wilayah as $key => $value){
		$wilayah_temp[] = $value->id_provinsi;
	}
	$wilayah->id_provinsi = $wilayah_temp;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

	if(isset($_POST['MasterBphp']))
	{
		$pesan = array();
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$model->attributes = $_POST['MasterBphp'];
			if($model->save()){
				foreach($model->getErrors() as $key=>$val){
					$pesan[] = $key . " : " . implode(", ", $val);
				}
			}
			if(count($_POST['BphpWilayahKerja']['id_provinsi']) > 0){
				$deleteAll = BphpWilayahKerja::model()->deleteAllByAttributes(array(
					'id_master_bphp'=>$id
				));
				foreach($_POST['BphpWilayahKerja']['id_provinsi'] as $key => $value){
					$mod = new BphpWilayahKerja;
					$mod->id_master_bphp = $model->id;
					$mod->id_provinsi = $value;
					if($mod->save()){
						foreach($mod->getErrors() as $key=>$val){
							$pesan['id_provinsi'] = $key . " : " . implode(", ", $val);
						}
					}
				}
			}else{
				$pesan[] = "Silahkan isi provinsi";
			}
			if(count($pesan) > 0){
				throw new Exception(implode("<br>", $pesan));
			}
			$transaction->commit();

			$message = Yii::t('app', 'Data berhasil disimpan.');
			Yii::app()->user->setFlash('success', $message);
			$this->redirect(array('index'));
		}catch (Exception $e){
			$transaction->rollback();
		}
	}

	$this->render('update',array(
		'model'=>$model,
		'wilayah'=>$wilayah,
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
		$deleteAll = BphpWilayahKerja::model()->deleteAllByAttributes(array(
			'id_master_bphp'=>$id
		));
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

/**
* Manages all models.
*/
public function actionIndex()
{
$model=new MasterBphp('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['MasterBphp']))
$model->attributes=$_GET['MasterBphp'];

$this->render('index',array(
'model'=>$model,
));
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=MasterBphp::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='master-bphp-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
