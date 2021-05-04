<?php

class AksesibilitasController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'create', 'update', 'delete'),
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

	public function actionIndex() {
		// die("asd");
		$model = new Aksesibilitas('search');
		// if (empty($model))
		// 	$this->redirect(array('create'));
//            $model = array();
		$model->id_perusahaan = Yii::app()->user->idPerusahaan();
		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Aksesibilitas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Aksesibilitas']))
		{
			// $_POST['Aksesibilitas']['jml_rupiah'] = (double) str_replace(".", "", $_POST['Aksesibilitas']['jml_rupiah'] );
			// $_POST['Aksesibilitas']['jml_dollar'] = (double) str_replace(".", "", $_POST['Aksesibilitas']['jml_dollar'] );
			$model->attributes=$_POST['Aksesibilitas'];
			$model->id_perusahaan = Yii::app()->user->idPerusahaan();
			if($model->save())
				$this->redirect(array('index'));
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

		if(isset($_POST['Aksesibilitas']))
		{
			$model->attributes=$_POST['Aksesibilitas'];
			if($model->save())
				$this->redirect(array('index'));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all latest models.
	 */
	public function actionLatest()
	{
		$this->layout = false;
		$dataProvider=new CActiveDataProvider('Aksesibilitas');
		$dataProvider->criteria->order = 'id DESC';
		$dataProvider->criteria->limit = 4;
		$dataProvider->pagination = false;
		$this->render('latest',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all models.
	 */
	// public function actionIndex()
	// {
	// 	$model=new IuphhkLaporanKeuangan('search');
	// 	$model->unsetAttributes();  // clear any default values
	// 	if(isset($_GET['IuphhkLaporanKeuangan']))
	// 		$model->attributes=$_GET['IuphhkLaporanKeuangan'];
    //
	// 	$this->render('index',array(
	// 		'model'=>$model,
	// 	));
	// }

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('Aksesibilitas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Aksesibilitas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Aksesibilitas']))
			$model->attributes=$_GET['Aksesibilitas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return IuphhkLaporanKeuangan the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Aksesibilitas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param IuphhkLaporanKeuangan $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Aksesibilitas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
