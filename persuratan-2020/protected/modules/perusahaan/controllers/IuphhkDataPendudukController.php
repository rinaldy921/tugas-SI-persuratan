<?php

class IuphhkDataPendudukController extends Controller
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
                'actions' => array('index', 'create', 'update', 'delete','inputJumlahPenduduk'),
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
$model=new IuphhkDataPenduduk;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['IuphhkDataPenduduk']))
{
$model->attributes=$_POST['IuphhkDataPenduduk'];
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

if(isset($_POST['IuphhkDataPenduduk']))
{
$model->attributes=$_POST['IuphhkDataPenduduk'];
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
        $model = IuphhkDataPenduduk::model()->findAll(array(
            'condition' => 'id_iuphhk="' . Yii::app()->user->idIuphhk().'"'
        ));
        // var_dump($model);die;
        if ($model == null) {
            $kategori = MasterKategoriPenduduk::model()->findAll();
            $kelamin = MasterJenisKelamin::model()->findAll();
            foreach($kategori as $kt) {
                foreach($kelamin as $kel) {
                    $model2 = new IuphhkDataPenduduk;
                    $model2->id_iuphhk = Yii::app()->user->idIuphhk();
                    $model2->id_kategori_penduduk = $kt->id;
                    $model2->id_jenis_kelamin = $kel->id;
                    $model2->save();
                }
            }
        }

        $modelData = new IuphhkDataPenduduk('search');
        $modelData->unsetAttributes();
        if(isset($_GET['IuphhkDataPenduduk']))
            $modelData->attributes = $_GET['IuphhkDataPenduduk'];
        $modelData->id_iuphhk = Yii::app()->user->idIuphhk();
        
        $this->render('index', array(
            'model' => $modelData,
        ));
    }

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=IuphhkDataPenduduk::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}
    
    public function actionInputJumlahPenduduk() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('IuphhkDataPenduduk');
        $model->update();
    }

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='iuphhk-data-penduduk-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
