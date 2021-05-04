<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=> Yii::app()->controller->id . '-form',
    'type'=>'horizontal',
    'action'=>Yii::app()->createUrl('//perusahaan/realisasiLingkunganDungtan/inputRealisasi', array('id'=>$modelRealisasi->id)),
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnsaveit' => true,
    ),
    'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($modelRealisasi); ?>
<div class="form-group">
    <div class="col-sm-12">
        <div id="<?=Yii::app()->controller->id . '-realisasi-grid'?>" class="grid-view">
            <table class="items table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th colspan="3">Realisasi</th>
                        <th rowspan="2">Persentase</th>
                    </tr>
                    <tr>
                        <th width="25%">sd Bulan Lalu</th>
                        <th>Bulan Sekarang</th>
                        <th width="25%">sd Bulan Sekarang</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center"><h4><?php echo $modelRealisasi->sd_bulan_lalu ?></h4></td>
                        <td><?php echo $form->textField($modelRealisasi,'realisasi',array(
                            'class'=>'form-control'
                        )); ?></td>
                        <td style="text-align:center"><h4><?php echo $modelRealisasi->sd_sekarang ?></h4></td>
                        <td style="text-align:center"><h4><?php echo $modelRealisasi->persentase ?></h4></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $form->textFieldGroup($modelRealisasi,'id_rkt',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','value'=>$model->id)))); ?>
<?php echo $form->textFieldGroup($modelRealisasi,'tahun',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
<?php echo $form->textFieldGroup($modelRealisasi,'id_bulan',array('groupOptions'=>array('class'=>'hidden'), 'widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
<?php $this->endWidget(); ?>