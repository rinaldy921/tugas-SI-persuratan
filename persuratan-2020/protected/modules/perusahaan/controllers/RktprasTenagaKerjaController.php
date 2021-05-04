<?php

class RktprasTenagaKerjaController extends Controller {

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

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array(Yii::app()->user->perusahaanRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'inputSerapanNaker',
                    'deleteNaker',                    
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

    public function actionIndex($rkt) {
        //debug($rkt);
        $model = new RktSerapanTenagaKerja();
        $model->Scenario='inputForm';
        $model->unsetAttributes();
        $model->attributes = array(
            'id_rkt' => $rkt
        );

        //$new_tata_batas = new RktTataBatas;
        //$new_tata_batas->id_rkt = $rkt;
        
        if (isset($_POST['RktSerapanTenagaKerja'])) {
            $model->attributes = $_POST['RktSerapanTenagaKerja'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Data telah berhasil disimpan'));
                    echo CJSON::encode(array('status' => 'success'));
                    Yii::app()->end();
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            }
        }
        
        $cs = Yii::app()->clientScript;
        $cs->reset();
        $cs->scriptMap = array(
            'jquery.js' => false, // prevent produce jquery.js in additional javascript data
            'jquery.min.js' => false,
        );
        
        $this->renderPartial('index', array(
            'model' => $model,
            'id_rkt' => $rkt
        ), false, true); // bagian ini biasanaya yang perlu di perhatikan saat render partial ajax
    }
    
    public function actionInputSerapanNaker() {
        Yii::import('booster.components.TbEditableSaver');
        $model = new TbEditableSaver('RktSerapanTenagaKerja');
        $model->update();
    }
    
    
    public function actionDeleteNaker($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            RktSerapanTenagaKerja::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
    

}

?>