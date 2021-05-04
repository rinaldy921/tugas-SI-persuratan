<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
//		$this->render('index');
//        echo('here'); die;
        $this->layout = '//layouts/main';
        $this->render('index');
        // if (Yii::app()->user->isGuest) {
        //     $this->redirect(array('/site/login'));
        // } else {
        //     if (Yii::app()->user->isAdmin()) {
        //         $this->redirect(array('//admin/default/index'));
        //     } elseif (Yii::app()->user->isPerusahaan()) {
        //         $this->redirect(array('//perusahaan/default/index'));
        //     }
        // }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = '//layouts/main';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->baseUrl.'/');
        }
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $captcha = Yii::app()->getController()->createAction('captcha');
            $code = $captcha->verifyCode;
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $code === $model->verifyCode_) {
                if($model->login()) {
                    if (Yii::app()->user->isAdmin() || Yii::app()->user->isBPHP() || Yii::app()->user->isDishut()|| Yii::app()->user->isKphp()|| 
                            Yii::app()->user->isLvlk()|| Yii::app()->user->isUHP()|| Yii::app()->user->isPKUHT()) {
//                        if(Yii::app()->user->isDishut()){
//                            Yii::app()->session['id_propinsi'] = $rku->id_rku;
//                        }
                        $this->redirect(array('//admin/default/index'));
                    } elseif (Yii::app()->user->isPerusahaan() || Yii::app()->user->isPimpinanUM()) {
                        $condition='id_perusahaan='.Yii::app()->user->idPerusahaan().' AND edit_status=1';
                        $rku = Rku::model()->find(array(
                                'condition' =>$condition));
                        
//                         print_r("<pre>");
//                         print_r($rku); 
//                         print_r("</pre>");exit(1);
                        
                        
                        if($rku){
                                Yii::app()->session['rku_id'] = $rku->id_rku;
                                Yii::app()->session['rku_sk'] = $rku->nomor_sk;
                        }
                        
                        $this->redirect(array('//perusahaan/default/index'));
                    }
                    // $this->redirect(Yii::app()->user->returnUrl);
                }
            } else {
                if ($code !== $model->verifyCode_) {
                    Yii::app()->user->setFlash('error', 'Kode Verifikasi tidak benar.');
                } else {
                    Yii::app()->user->setFlash('error', 'Login Invalid!');
                }
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionEditorImageThumb() {
        $path = array_diff(scandir(Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . 'images'), array('.', '..', 'thumb'));
        $dir = Yii::app()->baseUrl . Yii::app()->params->uploadDir . 'images/';
        if ($path) {
            $exists = array();
            foreach ($path as $file) {
                $exists[] = array(
                    'thumb' => $dir . 'thumb/' . $file,
                    'image' => $dir . $file
                );
            }
            echo json_encode($exists);
        }
    }

    public function actionEditorImageUpload() {
        if (isset($_FILES) && $_FILES['file']['error'] === 0) {
            $src_image_path = Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $_FILES['file']['name'];
            $thumb_image_path = Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $src_image_path);
            if ($this->generate_image_thumbnail($src_image_path, $thumb_image_path)) {
                $array = array(
                    'filelink' => Yii::app()->baseUrl . Yii::app()->params->uploadDir . 'images/thumb/' . $_FILES['file']['name'],
                    'filename' => $_FILES['file']['name']
                );
                echo stripslashes(json_encode($array));
            }
        }
    }

   public function actionEditorFileUpload() {
        if (isset($_FILES) && $_FILES['file']['error'] === 0) {
            $src_image_path = Yii::app()->params->uploadPath . DIRECTORY_SEPARATOR . $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $src_image_path)) {
                $array = array(
                    'filelink' => Yii::app()->baseUrl . Yii::app()->params->uploadDir . $_FILES['file']['name'],
                    'filename' => $_FILES['file']['name']
                );
                echo stripslashes(json_encode($array));
            }
        }
    }

    protected function generate_image_thumbnail($source_image_path, $thumbnail_image_path, $thumb_width = 128, $thumb_height = 128) {
        list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_image_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_image_path);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_image_path);
                break;
        }
        if ($source_gd_image === false) {
            return false;
        }
        $source_aspect_ratio = $source_image_width / $source_image_height;
        $thumbnail_aspect_ratio = $thumb_width / $thumb_height;
        if ($source_image_width <= $thumb_width && $source_image_height <= $thumb_height) {
            $thumbnail_image_width = $source_image_width;
            $thumbnail_image_height = $source_image_height;
        } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
            $thumbnail_image_width = (int) ($thumb_height * $source_aspect_ratio);
            $thumbnail_image_height = $thumb_height;
        } else {
            $thumbnail_image_width = $thumb_width;
            $thumbnail_image_height = (int) ($thumb_width / $source_aspect_ratio);
        }
        $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
        imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
        imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 70);
        imagedestroy($source_gd_image);
        imagedestroy($thumbnail_gd_image);
        return true;
    }
}
