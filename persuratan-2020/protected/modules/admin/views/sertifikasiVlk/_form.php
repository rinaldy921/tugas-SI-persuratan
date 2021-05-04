<?php
/* @var $this SertifikasiVlkController */
/* @var $model SertifikasiVlk */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
    
   // print_r("<pre>");print_r($model);print_r("</pre>");exit(1);
    
        $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
                'id'=> Yii::app()->controller->id .  '-form',
            'type' => 'horizontal',
//                'enableAjaxValidation' => false,
//                'enableClientValidation' => true,
//                'clientOptions' => array(
//                    'validateOnSubmit' => true,
//                )
            ));
 ?>

    
	<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.

	<?php //echo $form->errorSummary($model); ?>
        
        
        <?php echo $form->textFieldGroup($model, 'id_perusahaan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
        
        <?php echo $form->textFieldGroup($model, 'nomor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
        
        
        <?php echo $form->textFieldGroup($model, 'berlaku', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
        
        
        <?php echo $form->textFieldGroup($model, 'berakhir', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
        
        <?php echo $form->textFieldGroup($model, 'penerbit'); ?>
      
        <?php echo $form->textFieldGroup($model, 'predikat'); ?>
      
        <?php echo $form->textFieldGroup($model, 'file_doc'); ?>
      
        <?php echo $form->textFieldGroup($model, 'is_verified'); ?>
        
        
        <?php   $status = ['0'=>'Belum Diverifikasi','1'=>'Telah Diverifikasi','2'=>'Dibekukan'];
                echo $form->select2Group($model, 'is_verified', array('widgetOptions' => array('data' => $status, 'htmlOptions' => array('empty'=>'Pilih Status Sertifikat...')))); ?>
      
        


	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Simpan')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->