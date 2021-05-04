<?php

class MessageController extends Controller {

    public $enableSearchbox = false;
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    protected function getIndexList($model) {
        $indexList = array(
            array(
                'name' => '',
                'header' => Yii::t('view', 'In/Out'),
                'type' => 'raw',
                'value' => '($data->hasNewChild($data->id) > 0) ? "<i class=\'fa fa-mail-reply-all\'></i>" : (($data->user_id == Yii::app()->user->id) ? "<i class=\'fa fa-mail-forward\'></i>" : "<i class=\'fa fa-mail-reply\'></i>")',
                'htmlOptions' => array('width' => 5),
            ),
            array(
                'name' => 'user_id',
                'header' => Yii::t('view', 'Dari/Untuk'),
                'type' => 'raw',
                'value' => '($data->hasNewChild($data->id) > 0) ? CHtml::link("<strong>".$data->user->siteProfiles->firstname."</strong>", array("view", "id"=>$data->id)) : ((($data->user_id == Yii::app()->user->id && $data->status == 1) || $data->messageStatus->status == 1) ? CHtml::link($data->user->siteProfiles->firstname, array("view", "id"=>$data->id)) : CHtml::link("<strong>".$data->user->siteProfiles->firstname."</strong>", array("view", "id"=>$data->id)))',
                'htmlOptions' => array('width' => 190),
            ), array(
                'name' => '',
                'header' => Yii::t('app', 'Judul/Pesan'),
                'type' => 'raw',
                'value' => '($data->hasNewChild($data->id) > 0) ? "<strong>".$data->judul."</strong> - ".$data->wp_trim(strip_tags($data->pesan), 120) : ((($data->user_id == Yii::app()->user->id && $data->status == 1) || $data->messageStatus->status == 1) ? $data->judul." - ".$data->wp_trim(strip_tags($data->pesan), 120) : "<strong>".$data->judul."</strong> - ".$data->wp_trim(strip_tags($data->pesan), 120))',
            ), array(
                'name' => 'tanggal',
                'header' => Yii::t('app', 'Tanggal'),
                'value' => '($data->tanggal) ? $data->getDateTime($data->tanggal) : "-"',
                'htmlOptions' => array('width' => 130),
            ), array(
                'htmlOptions' => array('nowrap' => 'nowrap', 'width' => 10),
                'class' => 'booster.widgets.TbButtonColumn',
                'buttons' => array(
                    'delete' => array(
                        'visible' => '($data->user_id == Yii::app()->user->id) ? true : false',
                    ),
                ),
                'template' => '{delete}',
            ),
        );
        return $indexList;
    }

    public function actionView($id) {
        Yii::app()->db->createCommand("UPDATE message_status SET status = 1 WHERE user_id = " . Yii::app()->user->id . " AND message_id = " . $id)->execute();
        $child = Message::model()->Child()->with('user.siteProfiles', 'messageStatus')->findAll(array('condition' => 'parent_id = ' . $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'child' => $child,
        ));
    }

    public function actionCreate() {
        $model = new Message;
        $returnUrl = array($this->defaultAction);
        if (isset($_POST['Message'])) {
            $model->attributes = $_POST['Message'];
            $model->tanggal = date("Y-m-d H:i:s");
            $model->user_id = Yii::app()->user->id;
            $model->status = 1;
            if ($model->save()) {
                $tujuan = explode(',', $model->user_tujuan);
                foreach ($tujuan as $to) {
                    $ms = new MessageStatus;
                    $ms->message_id = $model->id;
                    $ms->user_id = $to;
                    $ms->save();
                    unset($ms);
                }
                $this->redirectx('success', $returnUrl, array('redirect' => CHtml::normalizeurl($returnUrl)));
            } else {
                if (!$model->hasErrors()) {
                    $this->redirectx('error', $returnUrl, array('redirect' => CHtml::normalizeurl($returnUrl)));
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionGetUser($username = '', $page = 1) {
        $this->layout = false;
        $data = array();
        $offset = ($page - 1) * 20;
        $count = SiteUsers::model()->with(array('siteProfiles' => array('select' => 'firstname')))->count(array('select' => 'id, username', 'condition' => "username LIKE '%$username%' OR siteProfiles.firstname LIKE '%$username%'"));
        if ($count > 0) {
            $users = SiteUsers::model()->with(array('siteProfiles' => array('select' => 'firstname')))->findAll(array('select' => 'id, username', 'condition' => "username LIKE '%$username%' OR siteProfiles.firstname LIKE '%$username%'", 'limit' => 20, 'offset' => $offset));
            foreach ($users as $d) {
                $data[] = array('id' => $d->id, 'text' => $d->username . " <" . $d->siteProfiles->firstname . ">");
            }
        }
        header("Content-type: application/json");
        echo CJSON::encode($data);
    }

    public function actionKirim($user_id = null) {
        $this->layout = false;
        $model = new Message;
        $returnUrl = array('/site/admin');
        $this->performAjaxValidation($model);
        if (isset($_POST['Message'])) {
            $model->attributes = $_POST['Message'];
            $model->tanggal = date("Y-m-d H:i:s");
            $model->user_id = Yii::app()->user->id;
            $model->status = 1;
            if ($model->save()) {
                $ms = new MessageStatus;
                $ms->message_id = $model->id;
                $ms->user_id = $model->user_tujuan;
                $ms->save();
                Yii::app()->user->setFlash('success', Yii::t('app', 'Data berhasil disimpan.'));
                $this->redirect($returnUrl);
            } else {
                if (!$model->hasErrors()) {
                    Yii::app()->user->setFlash('error', Yii::t('app', 'Data tidak berhasil disimpan.'));
                    $this->redirect($returnUrl);
                }
            }
        }
        $username = '';
        if (isset($user_id) && !empty($user_id)) {
            $user = SiteUsers::model()->with(array('siteProfiles' => array('select' => 'firstname')))->find("id = $user_id");
            $model->user_tujuan = $user->id;
            $username = ($user->siteProfiles) ? $user->siteProfiles->firstname : '';
        }
        $this->render('kirim', array('model' => $model, 'username' => $username));
    }

    public function actionUpdateStatus() {
        $this->layout = false;
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $field = isset($_POST['field']) ? $_POST['field'] : 'status';
            $model = MessageStatus::model()->find("message_id = " . $_POST['id'] . " AND user_id = " . Yii::app()->user->id);
            $model->$field = intval($_POST['value']);
            $model->save();
        }
    }

    public function actionUpdateReply() {
        $this->layout = false;
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['pk'], $_POST['value']) && !empty($_POST['value'])) {
                $this->loadModel(intval($_POST['pk']))->updateByPk(intval($_POST['pk']), array('pesan' => trim($_POST['value'])));
            } else {
                echo Yii::t('view', 'Pesan tidak ditemukan.');
            }
        }
    }

    public function actionReply() {
        $this->layout = false;
        $model = new Message;
        $this->performAjaxValidation($model);
        if (isset($_POST['Message'])) {
            $returnUrl = array('view', 'id' => $_POST['Message']['parent_id']);
            $model->attributes = $_POST['Message'];
            $model->tanggal = date("Y-m-d H:i:s");
            $model->user_id = Yii::app()->user->id;
            $model->status = 1;
            $model->isthreaded = 1;
            if ($model->save()) {
                $tujuan = explode(',', $model->user_tujuan);
                foreach ($tujuan as $to) {
                    $ms = new MessageStatus;
                    $ms->message_id = $model->id;
                    $ms->user_id = $to;
                    $ms->save();
                    unset($ms);
                }
                $this->redirectx('success', $returnUrl, array('redirect' => CHtml::normalizeurl($returnUrl)));
            } else {
                if (!$model->hasErrors()) {
                    $this->redirectx('error', $returnUrl, array('redirect' => CHtml::normalizeurl($returnUrl)));
                }
            }
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
// $this->performAjaxValidation($model);
        $returnUrl = array($this->defaultAction);
        if (isset($_POST['Message'])) {
            $model->attributes = $_POST['Message'];
            if ($model->save()) {
                $this->redirectx('success', $returnUrl, array('redirect' => CHtml::normalizeurl($returnUrl)));
            } else {
                if (!$model->hasErrors()) {
                    $this->redirectx('error', $returnUrl, array('redirect' => CHtml::normalizeurl($returnUrl)));
                }
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
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
            Yii::app()->db->createCommand("DELETE FROM message WHERE id = " . $id)->execute();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array($this->defaultAction));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $model = new Message('search');
        $model->unsetAttributes();
        if (isset($_GET['Message']))
            $model->attributes = $_GET['Message'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionAdmin() {
        $messages = Message::model()->OwnerIndex()->with('user', 'user.siteProfiles', 'messageStatus:OwnerIndex')->findAll();
        $model = new CArrayDataProvider($messages, array(
            'id' => 'message-id',
            'keyField' => 'id',
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Message::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

}