<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

//$this->pageTitle=Yii::app()->name . ' - Login';
//$this->breadcrumbs=array(
//	'Login',
//);
?>
<div id="page-wrapper" class="col-md-4 col-sm-6 col-xs-12">
    <h4 class="page-header">Login</h4>
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <?php echo $form->textFieldGroup($model, 'username', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
    <?php echo $form->passwordFieldGroup($model, 'password', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>
    <?php if (CCaptcha::checkRequirements('gd')): ?>
        <div class="form-group">
            <div>
                <?php

                $this->widget('CCaptcha', array(
                    'clickableImage' => true,
                    'id' => 'verifyCode_',
                    'captchaAction' => 'site/captcha',
                    'showRefreshButton' => false,
                    'imageOptions' => array(
                        'title' => Yii::t('app', 'Klik untuk generate ulang'),
                        'data-toggle' => 'tooltip',
                        'style' => 'cursor:pointer;margin-bottom:5px;',
                )));
                $captcha = Yii::app()->getController()->createAction('captcha');
                $code = $captcha->verifyCode;
                $code = "";
                echo $form->textField($model, 'verifyCode_', array('class' => 'form-control', 'placeholder' => Yii::t('app', 'Kode Verifikasi'),'value'=>$code));
                echo $form->error($model, 'verifyCode_', array(), false, false);
                ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-actions">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => 'Login',
        ));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
