<?php

class PublikasiController extends Controller {

    public $enableSearchbox = false;
    public $layout = '//layouts/column2';

    protected function getIndexList($model) {
        $indexList = array(
            array(
                'name' => 'published',
                'type' => 'raw',
                'filter' => CHtml::dropDownList(get_class($model) . '[published]', $model->published, array(Yii::t("view", "Belum Dipublikasikan"), Yii::t("view", "Sudah Dipublikasikan")), array('class' => 'form-control')),
                'sortable' => false,
                'htmlOptions' => array('class' => 'status'),
                'value' => '($data->published) ? "<label class=\"label label-success\">".Yii::t("view", "Sudah Dipublikasikan")."</label>" : "<label class=\"label label-danger\">".Yii::t("view", "Belum Dipublikasikan")."</label>"',
            ),
            array(
                'name' => 'Judul',
                'value' => '($data->Judul) ? $data->Judul : "-"',
            ), array(
                'name' => 'Deskripsi',
                'type' => 'raw',
                'value' => '($data->Deskripsi) ? $data->wp_trim(strip_tags($data->Deskripsi), 80) : "-"',
            ), array(
                'name' => 'Cover',
                'type' => 'raw',
                'value' => '($data->Cover) ? CHtml::link($data->Cover, Yii::app()->baseUrl.Yii::app()->params->uploadDir."images/".$data->Cover, array("data-lightbox"=>"image-1", "title"=>$data->Judul, "class"=>"text-info")) : "-"',
            ), array(
                'htmlOptions' => array('nowrap' => 'nowrap', 'class' => 'button-column'),
                'class' => 'booster.widgets.TbButtonColumn',
                'buttons' => array(
                    'delete' => array(
                        'visible' => '(Yii::app()->userDetail->getIsAdminRole() || $data->created_by == Yii::app()->user->id) ? "1" : "0"',
                    ),
                    'update' => array(
                        'visible' => '(Yii::app()->userDetail->getIsAdminRole() || $data->created_by == Yii::app()->user->id) ? "1" : "0"',
                    ),
                ),
                'template' => '{view} {update} {delete}',
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
                'name' => 'Judul',
                'value' => ($model->Judul) ? $model->Judul : "-",
            ), array(
                'name' => 'Deskripsi',
                'type' => 'html',
                'value' => ($model->Deskripsi) ? $model->Deskripsi : "-",
            ), array(
                'name' => 'Cover',
                'type' => 'raw',
                'value' => ($model->Cover) ? CHtml::link($model->Cover, Yii::app()->baseUrl . Yii::app()->params->uploadDir . 'images/' . $model->Cover, array('data-lightbox' => 'image-1', 'title' => $model->Judul, "class" => "text-info")) : "-",
            ), array(
                'name' => 'Lampiran',
                'type' => 'raw',
                'value' => !empty($model->attachments) ? nl2br($model->listAttachment($model->attachments)) : '-',
            ), array(
                'name' => 'created_at',
                'value' => ($model->created_at) ? $model->created_at : "-",
                'visible' => false,
            ), array(
                'name' => 'modified_at',
                'value' => ($model->modified_at) ? $model->modified_at : "-",
                'visible' => false,
            ), array(
                'name' => 'created_by',
                'value' => ($model->created_by) ? $model->created_by : "-",
                'visible' => false,
            ), array(
                'name' => 'modified_by',
                'value' => ($model->modified_by) ? $model->modified_by : "-",
                'visible' => false,
            ),);
        return $viewList;
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function init() {
        parent::init();
        if(Yii::app()->user->checkAccess('Cms.Publikasi.Admin')) {
            $this->defaultAction = 'admin';
        }
    }

    public function actionRead($slug) {
        $model = Publikasi::model()->Hukum()->find("slug = '$slug'");
        $this->render('read', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        $model = new Publikasi;
        $returnUrl = array('admin');
        if (isset($_POST['Publikasi'])) {
            $model->attributes = $_POST['Publikasi'];
            $model->Kategori = 'Produk Hukum';
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
                $photos = CUploadedFile::getInstancesByName('File_Name');
                if (isset($photos[0])) {
                    foreach ($photos as $image => $pic) {
                        if ($pic->saveAs(Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . $pic->name)) {
                            $img_add = new Attachment;
                            $img_add->File_Name = $pic->name;
                            $img_add->File_Path = Yii::app()->params->uploadDir . $pic->name;
                            $img_add->File_Size = $pic->size;
                            $img_add->File_Type = $pic->type;
                            $img_add->Keterangan = $model->Judul;
                            $img_add->publikasi_id = $model->id;
                            $img_add->save();
                        } else {
                            echo 'Cannot upload!';
                        }
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
        $returnUrl = array('admin');
        if (isset($_POST['Publikasi'])) {
            $model->attributes = $_POST['Publikasi'];
            $model->Kategori = 'Produk Hukum';
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
                if (isset($_POST['del_file']) && !empty($_POST['del_file'])) {
                    $parentPath = Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR;
                    foreach ($_POST['del_file'] as $df) {
                        $att_ = Attachment::model()->findByPk($df);
                        $df_name = $att_->File_Name;
                        if ($att_->delete()) {
                            @unlink($parentPath . $df_name);
                        }
                    }
                }
                $photos = CUploadedFile::getInstancesByName('File_Name');
                if (isset($photos[0])) {
                    foreach ($photos as $image => $pic) {
                        if ($pic->saveAs(Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . $pic->name)) {
                            $img_add = new Attachment;
                            $img_add->File_Name = $pic->name;
                            $img_add->File_Path = Yii::app()->params->uploadDir . $pic->name;
                            $img_add->File_Size = $pic->size;
                            $img_add->File_Type = $pic->type;
                            $img_add->Keterangan = $model->Judul;
                            $img_add->publikasi_id = $model->id;
                            $img_add->save();
                        } else {
                            echo 'Cannot upload!';
                        }
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

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Publikasi', array(
            'criteria' => array(
                'scopes' => 'Hukum',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $this->render('index', array(
            'model' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Publikasi('search');
        $model->unsetAttributes();
        if (isset($_GET['Publikasi']))
            $model->attributes = $_GET['Publikasi'];

        $model->Kategori = 'Produk Hukum';
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Publikasi::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

}