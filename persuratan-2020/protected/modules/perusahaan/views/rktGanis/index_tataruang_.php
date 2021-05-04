<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createKawasanLindung'), array('class' => 'btn btn-primary'));?>
<?php //$this->widget('booster.widgets.TbGridView',array(
// 'id'=>'tata-ruang-grid',
// 'type' => 'bordered condensed striped',
// 'responsiveTable' => true,
// 'dataProvider'=>$model->search(), 
// 'enableSorting'=>false,
// 'filter'=>$model,
// 'template' => '{items}{summary}{pager}',
// 'columns'=>array(
//         'id',
//         'id_rkt',
//         'id_blok',
//         'jumlah',
//         'realisasi',
//         array(
//             'class'=>'booster.widgets.TbButtonColumn',
//             'buttons' => array(
//                 'update' => array(
//                     'url' => 'Yii::app()->createUrl("//perusahaan/rktGanis/updateKawasanLindung",array("id"=>$data->id))',
//                 ),
//                 'delete' => array(
//                     'url' => 'Yii::app()->createUrl("//perusahaan/rktGanis/delKawasanLindung",array("id"=>$data->id))',
//                 )
//             )
//         ),
// ),
// )); ?>
<?php //echo $this->renderPartial('_form_tataruang', array('model'=>$model, 'idRkt'=>$idRkt)); 

$blok = BlokSektor::model()->findAll(array('condition'=>'id_perusahaan = '. Yii::app()->user->idPerusahaan()));
?>


<h4 class="page-header">Kawasan Lindung</h4>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=> 'rkt-tata-ruang-form',
        'type'=>'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

<?php
    $tes = $model->isNewRecord ? 'ya' : 'tidak';
    echo $tes;die;
?>

<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldGroup($model,'id_rkt',array('groupOptions'=>array('class'=>'hidden'),'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$idRkt)))); ?>

    <?php foreach($blok as $key => $blk) : ?>
        <?php 
            $mstBlok = MasterBlok::model()->find(array('condition'=>'id = '. $blk->id_blok));
        ?>
        <?php //echo $form->textFieldGroup($model,'id_blok',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
        <div class="form-group">
            <div class="col-sm-6">
                <div class="row">
                    <label class="col-sm-3 control-label"><?php echo $mstBlok->nama_blok;?></label>
                    <div class="col-sm-9">
                        <input class="form-control" name="RktKawasanLindung[jumlah][<?php echo $key;?>]"/>
                        <input class="hidden" name="RktKawasanLindung[idBlok][<?php echo $key;?>]" value="<?php echo $mstBlok->id ;?>"/>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <?php echo $form->textFieldGroup($model,'realisasi['.$key.']',array('label'=>'Realisasi', 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','placeholder'=>'')))); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php //echo $form->textFieldGroup($model,'id_blok',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

    <?php //echo $form->textFieldGroup($model,'jumlah',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

    <?php //echo $form->textFieldGroup($model,'realisasi',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>



<h4 class="page-header">Areal Non Produktif</h4>
<?php //echo $form->textFieldGroup($model,'id_rkt',array('groupOptions'=>array('class'=>'hidden'),'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$idRkt)))); ?>

    <?php foreach($blok as $key => $blk) : ?>
        <?php 
            $mstBlok = MasterBlok::model()->find(array('condition'=>'id = '. $blk->id_blok));
        ?>
        <?php //echo $form->textFieldGroup($model,'id_blok',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
        <div class="form-group">
            <div class="col-sm-6">
                <div class="row">
                    <label class="col-sm-3 control-label"><?php echo $mstBlok->nama_blok;?></label>
                    <div class="col-sm-9">
                        <input class="form-control" name="RktKawasanLindung[blokArealNonProd][<?php echo $key;?>]"/>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <?php echo $form->textFieldGroup($model,'realisasiArealNonProd['.$key.']',array('label'=>'Realisasi', 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','placeholder'=>'')))); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

<h4 class="page-header">Areal Produktif</h4>
<?php //echo $form->textFieldGroup($model,'id_rkt',array('groupOptions'=>array('class'=>'hidden'),'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$idRkt)))); ?>

    <?php foreach($blok as $key => $blk) : ?>
        <?php 
            $mstBlok = MasterBlok::model()->find(array('condition'=>'id = '. $blk->id_blok));
            $mstJenisProduksi = MasterJenisProduksiLahan::model()->findAll();
        ?>
        <?php //echo $form->textFieldGroup($model,'id_blok',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
        <p><strong><?php echo $mstBlok->nama_blok;?></strong></p>
        <?php foreach($mstJenisProduksi as $keyz => $jp) : ?>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="row">
                        <label class="col-sm-3 control-label"><?php echo $jp->jenis_produksi;?></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="RktArealProduktif[jml][<?php echo $key;?>][<?php echo $keyz;?>]"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <?php echo $form->textFieldGroup($model_areal_produktif,'realisasi['.$key.']['.$keyz.']',array('label'=>'Realisasi', 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','placeholder'=>'')))); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

<div class="form-group">
    
    <div class="col-sm-12">
    <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>$model->isNewRecord ? 'Create' : 'Save',
        )); ?>
    </div>
</div>

<?php $this->endWidget(); ?>