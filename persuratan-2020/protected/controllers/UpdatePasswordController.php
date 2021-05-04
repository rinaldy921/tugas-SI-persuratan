<?php

class UpdatePasswordController extends Controller
{

    public function filters() {
        return array(
            'accessControl',
        );
    }

	public function accessRules() {
        return array(
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array(
				'deny',
                'users' => array('*'),
            )
        );
    }

	public function actionIndex()
	{
	$model = AppUsers::model()->findByPk(Yii::app()->user->id);
        $model->scenario = 'updatePass';
		if (isset($_POST['AppUsers'])){
			$model->attributes = $_POST['AppUsers'];
			if($model->save()){
				$message = Yii::t('app', 'Data berhasil disimpan.');
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(array('index'));
			}
		}
		$this->render('index', array(
			'model'=>$model
		));
	}
}