<?php

class NotifikasiController extends Controller {

    public $enableSearchbox = true;
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    protected function getIndexList($model) {
        $indexList = array(
            array(
                'name' => 'isi',
                'type' => 'raw',
                'value' => '($data->status == 1) ? $data->isi : "<strong>".$data->isi."</strong>"',
            ), array(
                'name' => 'tanggal',
                'value' => '($data->tanggal) ? $data->getDateTime($data->tanggal) : "-"',
                'htmlOptions' => array('width' => 130),
                'filter' => false,
            ), array(
                'htmlOptions' => array('nowrap' => 'nowrap', 'width' => 40),
                'class' => 'booster.widgets.TbButtonColumn',
                'buttons' => array(
                    'markRead' => array(
                        'label' => "<i class='fa fa-check-circle-o'></i>",
                        'options' => array('title' => Yii::t('view', 'Sudah Dibaca')),
                        'url' => 'Yii::app()->createUrl("/cms/notifikasi/updateStatus", array("id"=>$data->id))',
                        'click' => 'js:function(e){
                            e.preventDefault(); 
                            var url = $(this).attr("href");
                            var th = this, afterDelete = function(){};
                            $.ajax({
                                type: "GET",
                                url: url,
                                success: function(data) {
                                    var old = $("#notifikasi-count span.badge").text();
                                    if (old && old != "" && old != "undefined") {
                                        if ((old - 1) == 0) { 
                                            $("#notifikasi-count span.badge").remove(); 
                                        } else if ((old - 1) >= 1) {
                                            $("#notifikasi-count span.badge").text((old-1));
                                        }
                                    }                                
                                    jQuery("#notifikasi-grid").yiiGridView("update");
                                    afterDelete(th, true, data);
                                },
                                fail: function(XHR) {
                                    alert("' . Yii::t('view', 'Notifikasi tidak dapat diubah') . '");
                                    return afterDelete(th, false, XHR);
                                }
                            });
                            return false;
                        }',
                    ),
                ),
                'template' => '{delete}',
            ),
        );
        return $indexList;
    }

    protected function getViewList($model) {
        $viewList = array(
            array(
                'name' => 'id',
                'value' => ($model->id) ? $model->id : "-",
            ), array(
                'name' => 'user_id',
                'value' => ($model->user_id) ? $model->user_id : "-",
                'visible' => false,
            ), array(
                'name' => 'tanggal',
                'value' => ($model->tanggal) ? $model->tanggal : "-",
            ), array(
                'name' => 'isi',
                'type' => 'html',
                'value' => ($model->isi) ? $model->isi : "-",
            ), array(
                'name' => 'status',
                'value' => ($model->status) ? $model->status : "-",
                'visible' => false,
            ), array(
                'name' => 'created_at',
                'value' => ($model->created_at) ? $model->created_at : "-",
                'visible' => false,
            ), array(
                'name' => 'modified_at',
                'value' => ($model->modified_at) ? $model->modified_at : "-",
                'visible' => false,
            ),);
        return $viewList;
    }

    public function actionDeleteAll() {
        $this->layout = false;
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            if (!empty($_POST['params'])) {
                foreach ($_POST['params'] as $id) {
                    $this->loadModel($id)->delete();
                }
            }
        }
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionMarkAll() {
        $this->layout = false;
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            if (!empty($_POST['params'])) {
                foreach ($_POST['params'] as $id) {
                    $this->loadModel($id)->updateByPk($id, array('status' => 1));
                }
            }
        }
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array($this->defaultAction));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin() {
        $model = new Notifikasi('search');
        $model->unsetAttributes();
        $model->user_id = Yii::app()->user->id;
        $model->dbCriteria->order = 'tanggal DESC';
        if (isset($_GET['Notifikasi']))
            $model->attributes = $_GET['Notifikasi'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Notifikasi::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

}