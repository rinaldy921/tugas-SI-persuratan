<?php

class GeneralRekapController extends Controller
{
	public function actionIndex()
	{
		$model = new AppUsers;
		$this->render('index', array(
			'model'=>$model
		));
	}
	public function actionAmbilContent()
	{
		$this->layout = false;
		$nam_perusahaan = '-1';
		if (strlen($_POST['AppUsers']['nama_user']) > 0) {
			$nam_perusahaan = $_POST['AppUsers']['nama_user'];
		}
		$jenis_form = $_POST['AppUsers']['jenis_form'];
		$hasilnya = AppUsers::model()->findAll(array(
			'condition'=>'nama_user LIKE :nama_user',
			'params'=>array(
				':nama_user'=>'%' . $nam_perusahaan . '%'
			)
		));
		$rec = array();
		foreach($hasilnya as $key => $value) {
			$rec[] = $value->attributes;
		}
		echo CJSON::encode(array(
			'status'=>'OK',
			'jenis_form'=>$jenis_form,
			'result'=>$rec
		));
		Yii::app()->end();
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}