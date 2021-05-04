<!-- <div class="container"> -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nipz-margin">
            <div class="page-header">
                <h4><?php echo Yii::t('view', 'Kontak'); ?></h4>
            </div>
            <div class="alamat">
                <h5><strong>Kementerian Lingkungan Hidup dan Kehutanan<br> Direktorat Bina Usaha Hutan Tanaman</strong></h5>
                <p>Gedung Manggala Wanabakti Blok I Lt. 6<br>Jl. Jend. Gatot Subroto, Jakarta 10270</p>

            </div>
            <div class="form nipz-form">
                <h4>Kontak Kami</h4>
                <?php if (Yii::app()->user->hasFlash('contact')): ?>
                    <?php echo Yii::app()->user->getFlash('contact'); ?>                
                <?php else: ?>
                    <?php
                    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                        'id' => 'contact-form',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'type' => 'vertical',
                    ));
                    ?>
                    <?php echo $form->errorSummary($model, null, null); ?>
                    <?php echo $form->textFieldGroup($model, 'name', array('widgetOptions' => array('htmlOptions' => array('class' => 'form-control')))); ?>
                    <?php echo $form->textFieldGroup($model, 'email', array('widgetOptions' => array('htmlOptions' => array('class' => 'form-control')))); ?>
                    <?php echo $form->textAreaGroup($model, 'body', array('widgetOptions' => array('htmlOptions' => array('class' => 'form-control')))); ?>
                    <?php if (CCaptcha::checkRequirements()): ?>
                        <div class="form-group">
                            <label></label>
                            <div>
                                <?php $this->widget('CCaptcha', array('clickableImage' => true, 'showRefreshButton' => false, 'imageOptions' => array('style' => 'cursor:pointer;padding-bottom:5px;margin-bottom:0;', 'class' => 'well well-sm'))); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldGroup($model, 'verifyCode', array('label' => false, 'widgetOptions' => array('htmlOptions' => array('class' => 'form-control', 'style' => 'margin:5px 0 10px;', 'placeholder' => Yii::t('view', 'Masukan kode yang tertera di atas'))))); ?>
                    <?php endif; ?>
                    <div class="form-group">
                        <?php
                        $this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'submit',
                            'context' => 'primary',
                            'label' => Yii::t('app', 'Kirim'),
                        ));
                        ?>
                    </div>
                    <?php $this->endWidget(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<!-- </div> -->
<?php (Yii::app()->booster) ? Yii::app()->booster->registerYiiCss() : null; ?>