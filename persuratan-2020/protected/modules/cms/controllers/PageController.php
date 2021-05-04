<?php

class PageController extends Controller {

    public $enableSearchbox = false;
    public $layout = '//layouts/column2';

    protected function getIndexList($model) {
        $indexList = array(
            array(
                'name' => 'Judul',
                'value' => '($data->Judul) ? $data->Judul : "-"',
            ), array(
                'name' => 'Isi',
                'type' => 'html',
                'value' => '($data->Isi) ? $data->wp_trim(strip_tags($data->Isi), 100) : "-"',
            ), array(
                'name' => 'Cover',
                'type' => 'raw',
                'visible' => false,
                'value' => '($data->Cover) ? CHtml::link($data->Cover, Yii::app()->baseUrl.Yii::app()->params->uploadDir."images/".$data->Cover, array("data-lightbox"=>"image-1", "title"=>$data->Judul, "class"=>"text-info")) : "-"',
            ), array(
                'htmlOptions' => array('nowrap' => 'nowrap', 'class' => 'button-column'),
                'class' => 'booster.widgets.TbButtonColumn',
                'buttons' => array(
                    'delete' => array(
                        'visible' => '($data->slug == "tentang") ? false : true',
                    ),
                ),
                'template' => '{view} {update} {delete}',
                'visible' => (Yii::app()->user->adminRole()) ? true : false,
            ),
        );
        return $indexList;
    }

    protected function getViewList($model) {
        $viewList = array(
            array(
                'name' => 'Judul',
                'value' => ($model->Judul) ? $model->Judul : "-",
            ), array(
                'name' => 'Isi',
                'type' => 'html',
                'value' => ($model->Isi) ? $model->Isi : "-",
            ), array(
                'name' => 'Cover',
                'type' => 'raw',
                'visible' => false,
                'value' => ($model->Cover) ? CHtml::link($model->Cover, Yii::app()->baseUrl . Yii::app()->params->uploadDir . 'images/' . $model->Cover, array('data-lightbox' => 'image-1', 'title' => $model->Judul, "class" => "text-info")) : "-",
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

    public function init() {
        parent::init();
        if (Yii::app()->user->adminRole()) {
            $this->defaultAction = 'admin';
        }
    }

    public function actionRead($slug) {
        Yii::app()->theme = 'public';
        $model = Post::model()->Page()->find("slug = '$slug'");
        $this->render('read', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Post;
        $returnUrl = array('admin');
        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
            $model->Kategori = 'page';
            $model->Deskripsi = $model->wp_trim($model->Isi, 250);
            $file1 = CUploadedFile::getInstance($model, 'Cover');
            if (is_object($file1) && get_class($file1) === 'CUploadedFile')
                $model->Cover = $file1;
            if ($model->save()) {
                $target = Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
                if (is_object($model->Cover)) {
                    if ($model->Cover->saveAs($target . $model->Cover->name)) {
                        $image = Yii::app()->image->load($target . $model->Cover->name);
                        $image->resize(250, 154)->quality(60)->sharpen(20);
                        $image->save($target . 'thumb' . DIRECTORY_SEPARATOR . $model->Cover->name);
                    }
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

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        //$this->performAjaxValidation($model);
        $returnUrl = array('admin');
        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
            $model->Kategori = 'page';
            $model->Deskripsi = $model->wp_trim($model->Isi, 250);
            $file1 = CUploadedFile::getInstance($model, 'Cover');
            if (is_object($file1) && get_class($file1) === 'CUploadedFile')
                $model->Cover = $file1;
            if ($model->save()) {
                $target = Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
                if (is_object($model->Cover)) {
                    if ($model->Cover->saveAs($target . $model->Cover->name)) {
                        $image = Yii::app()->image->load($target . $model->Cover->name);
                        $image->resize(250, 154)->quality(60)->sharpen(20);
                        $image->save($target . 'thumb' . DIRECTORY_SEPARATOR . $model->Cover->name);
                    }
                }
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
        $model = new Post('search');
        $model->unsetAttributes();
        $model->Kategori = 'page';
        if (isset($_GET['Post']))
            $model->attributes = $_GET['Post'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Post::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

}