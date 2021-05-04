<?php
$this->breadcrumbs=array(
	// 'Spasial Rkts'=>array($idRku),
	'Spasial RKT',
);

?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/data_perusahaan_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data SpasialRkt</h4>
    <a class="btn btn-success" href="<?php echo $this->createUrl('//perusahaan/spasialRku');?>">&laquo; Kembali</a>
    <a class="btn btn-primary" href="<?php echo $this->createUrl('create',array('id'=>$idRku));?>">Buat Data Baru</a>
    <?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
// 'filter'=>$model,
'template' => '{items}{summary}{pager}',
'columns'=>array(
		// 'id',
		// 'id_rkt',
    array(
        'name'=>'id_rkt',
        'value'=>'$data->idRkt->nomor_sk'
    ),
		// 'id_perusahaan',
    array(
        'class'=>'booster.widgets.TbButtonColumn',
        'template' => '{update}{delete}',
        'buttons' => array(
            'update'=>array(
                'url' => 'Yii::app()->createUrl("//perusahaan/spasialRkt/update",array("id"=>'.$idRku.',"id_spasial"=>$data->id))',
            ),
            'delete' => array(
                'url' => 'Yii::app()->createUrl("//perusahaan/spasialRkt/delete",array("id"=>'.$idRku.',"id_spasial"=>$data->id))',
            ),
        )
    ),
),
)); ?>
</div>